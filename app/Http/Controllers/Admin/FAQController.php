<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqModel;
use Illuminate\Http\Request;
use Session;
use Validator;

class FAQController extends Controller
{
    //
    public function __construct()
    {
        $arr_except_auth_methods = [];
        $this->middleware(\App\Http\Middleware\SentinelCheck::class, ['except' => $arr_except_auth_methods]);

        $this->FaqModel = new FaqModel;
    }

    public function index()
    {
        $page_title = 'Manage Faq Pages';
        $faq_pages = $this->FaqModel->orderBy('id', 'DESC')->where('parent', 0)->get()->toArray();
        $sub_pages = $this->FaqModel->where('parent', '!=', 0)->get()->toArray();

        return view('web_admin.faq.index', compact('page_title', 'faq_pages', 'sub_pages'));
    }

    public function subpages($enc_id)
    {
        $id = base64_decode($enc_id);
        $faq_pages = $this->FaqModel->where('parent', $id)->get()->toArray();
        $page_title = 'Manage Faq Sub Pages';

        return view('web_admin.faq.subpages', compact('page_title', 'faq_pages'));
    }

    public function create()
    {
        $page_title = 'Create FAQ';

        return view('web_admin.faq.create', compact('page_title'));
    }

    public function store(Request $request)
    {
        $form_data = [];
        $form_data = $request->all();
        $this->FaqModel->parent = base64_decode($form_data['hidden_parent_id']);
        $arr_rules = [];
        $arr_rules['question'] = 'required';
        $arr_rules['answer'] = 'required';

        if ($this->FaqModel->parent == '') {
            $arr_rules['page_slug'] = 'required';
        }

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {

            if ($this->FaqModel->parent == '') {
                return redirect('/web_admin/faq/create')->withErrors($validator)->withInput();
            } else {
                return redirect('/web_admin/faq/create_sub_page/'.base64_encode($this->FaqModel->parent))->withErrors($validator)->withInput();
            }

        }
        //fetch Form data
        $this->FaqModel->question = $form_data['question'];
        $this->FaqModel->answer = $form_data['answer'];
        if ($this->FaqModel->parent) {
            //This is sub_page / dutch-multilingual page
            //$this->FaqModel->language_id_fk  = 2;
            $this->FaqModel->is_active = $this->_fetch_parent_record_status($this->FaqModel->parent);
        } else {
            //parent is 0, language is 1=english and page_slug is present
            // $this->FaqModel->language_id_fk  = 1;
            $this->FaqModel->page_slug = str_slug($form_data['page_slug'], '-');
            $this->FaqModel->is_active = $request->input('is_active', '0');
        }

        /* Duplication Check */
        if ($this->FaqModel->where('question', $this->FaqModel->question)->exists() == false) {

            if ($this->FaqModel->save()) {

                Session::flash('success', 'FAQ Page Created Successfully');
            } else {
                Session::flash('error', 'Problem occurred, While Creating FAQ Page');
            }
        } else {
            Session::flash('error', 'This FAQ Page record already exists');
        }

        if ($this->FaqModel->parent) {

            return redirect('/web_admin/faq/create_sub_page/'.base64_encode($this->FaqModel->parent));
        } else {

            return redirect('/web_admin/faq/create');
        }
    }

    public function _fetch_parent_record_status($id)
    {
        //fetch parent record status
        $parent_record = $this->FaqModel->select('is_active')->where('id', $id)->get();
        foreach ($parent_record as $record) {
            return $record['is_active'];
        }
    }

    public function create_sub_page($enc_id)
    {
        $page_title = 'Create FAQ Sub Page';
        $parent_id = base64_decode($enc_id);

        return view('web_admin.faq.create', compact('page_title', 'parent_id'));
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $page_title = 'Edit Faq Page';

        $arr_pages = $this->FaqModel->where('id', $id)->first()->toArray();
        $show_slug = ($arr_pages['parent'] == 0 ? '1' : '0');

        return view('web_admin.faq.edit', compact('page_title', 'arr_pages', 'show_slug'));
    }

    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_pages = $this->FaqModel->where('id', $id)->first()->toArray();
        $is_parent = ($arr_pages['parent'] == 0 ? '1' : '0');

        $arr_rules = [];
        $arr_rules['question'] = 'required';
        $arr_rules['answer'] = 'required';

        if ($is_parent) {
            $arr_rules['page_slug'] = 'required';
        }

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect('/web_admin/faq/edit/'.$enc_id)->withErrors($validator)->withInput();
        }

        $form_data = [];
        $form_data = $request->all();
        $arr_data['question'] = $form_data['question'];
        $arr_data['answer'] = $form_data['answer'];
        //$arr_data['is_active'] = $request->input('is_active','0');

        if ($is_parent) {
            $arr_data['page_slug'] = str_slug($form_data['page_slug'], '-');
            $arr_data['is_active'] = $request->input('is_active', '0');
        } else {
            $arr_data['is_active'] = $this->_fetch_parent_record_status($arr_pages['parent']);
        }

        if ($this->FaqModel->where('id', $id)->update($arr_data)) {
            Session::flash('success', 'Faq Page Updated Successfully');
        } else {
            Session::flash('error', 'Problem occurred, While Updating FAQ Page');
        }

        return redirect('/web_admin/faq/edit/'.$enc_id);

    }

    public function toggle_status($enc_id, $action)
    {
        if ($action == 'delete') {
            $this->_delete($enc_id);

            Session::flash('success', 'Faq Page(s) Deleted Successfully');
        } elseif ($action == 'activate') {
            $this->_activate($enc_id);

            Session::flash('success', 'Faq Page(s) Activated Successfully');
        } elseif ($action == 'deactivate') {
            $this->_block($enc_id);

            Session::flash('success', 'Faq Page(s) Deactivate/Blocked Successfully');
        }

        //return redirect('/web_admin/faq');
        return redirect()->back();
    }

    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);

        //delete corrosponding multilingual
        if ($this->FaqModel->where('id', $id)->delete()) {
            //delete corrosponding parent page as well
            $this->FaqModel->where('parent', $id)->delete();

            return true;
        } else {
            $this->FaqModel->where('parent', $id)->delete();

            return true;
        }
    }

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);
        if ($this->FaqModel->where('id', $id)->update(['is_active' => '1'])) {
            //activate corresponding multilingual page as well
            $this->FaqModel->where('parent', $id)->update(['is_active' => '1']);
        }
    }

    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);
        if ($this->FaqModel->where('id', $id)->update(['is_active' => '0'])) {
            //activate corresponding multilingual page as well
            $this->FaqModel->where('parent', $id)->update(['is_active' => '0']);
        }
    }

    public function multi_action(Request $request)
    {
        $arr_rules = [];
        $arr_rules['multi_action'] = 'required';
        $arr_rules['checked_record'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect('/web_admin/faq')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if (is_array($checked_record) && count($checked_record) <= 0) {
            Session::flash('error', 'Problem occurred, While Doing Multi Action');

            return redirect('/web_admin/faq');

        }

        foreach ($checked_record as $key => $record_id) {
            if ($multi_action == 'delete') {
                $this->_delete($record_id);
                Session::flash('success', 'Faq Page(s) Deleted Successfully');
            } elseif ($multi_action == 'activate') {
                $this->_activate($record_id);
                Session::flash('success', 'Faq Page(s) Activated Successfully');
            } elseif ($multi_action == 'block') {
                $this->_block($record_id);
                Session::flash('success', 'Faq Page(s) Blocked Successfully');
            }
        }

        return redirect('/web_admin/faq');
    }
}
