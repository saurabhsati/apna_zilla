<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplateModel;
use App\Models\NewsLetterModel;
use App\Models\SiteSettingModel;
use Illuminate\Http\Request;
use Mail;
use Session;
use Validator;

class NewsLetterController extends Controller
{
    /*
    | Constructor : creates instances of model class
    |               & handles the admin authantication
    | auther : Danish
    | Date : 12/12/2015
    | @return \Illuminate\Http\Response
    */

    private $NewsLetterModel;

    public function __construct()
    {
        $arr_except_auth_methods = [];
        $this->middleware('\App\Http\Middleware\SentinelCheck', ['except' => $arr_except_auth_methods]);
    }

    /*
    | Index : Display listing of NewsLetter
    | auther : Danish
    | Date : 24/02/2016
    | @return \Illuminate\Http\Response
    */

    public function index()
    {
        $page_title = 'Manage NewsLetter';
        $arr_data = [];
        $res = NewsLetterModel::orderBy('news_letter_id', 'DESC')->get();

        if ($res != false) {
            $arr_data = $res->toArray();
        }

        return view('web_admin.news_letter.index', compact('page_title', 'arr_data'));
    }

    /*
    | Show() : Display detail information regarding specific City.
    | auther : Danish
    | Date : 25/02/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    public function show($enc_id)
    {
        $page_title = 'Show NewsLetter';
        $id = base64_decode($enc_id);

        $arr_newsletter = NewsLetterModel::where('news_letter_id', $id)->first()->toArray();

        return view('web_admin.news_letter.show', compact('page_title', 'arr_newsletter'));
    }

    /*
    | Show() : Show the form for editing the specified page.
    | auther : Danish
    | Date : 25/02/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $page_title = 'Edit NewsLetter';

        $arr_newsletter = NewsLetterModel::where('news_letter_id', $id)->first()->toArray();

        return view('web_admin.news_letter.edit', compact('page_title', 'arr_newsletter'));
    }

    /*
    | update() : Update the specified resource/record
    | auther : Danish
    | Date : 25/02/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_rules = [];
        $arr_rules['email_address'] = 'email|required';
        // $arr_rules['name'] = "required";

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect('/web_admin/newsletter/edit/'.$enc_id)->withErrors($validator)->withInput();
        }

        $form_data = [];
        $form_data = $request->all();
        $arr_data['email_address'] = strtolower($form_data['email_address']);
        $arr_data['is_active'] = $request->input('is_active', '0');

        if (NewsLetterModel::where('news_letter_id', $id)->update($arr_data)) {
            Session::flash('success', 'NewsLetter Updated Successfully');
        } else {
            Session::flash('error', 'Problem Occured, While Updating NewsLetter');
        }

        return redirect('/web_admin/newsletter/edit/'.$enc_id);
    }

    /*
    | toggle_status() : Activate,Deactive or delete specified resource/record
    | auther : Danish
    | Date : 25/02/2016
    | @param  int  $enc_id, string $action
    | @return \Illuminate\Http\Response
    */

    public function toggle_status($enc_id, $action)
    {
        if ($action == 'delete') {
            $this->_delete($enc_id);

            Session::flash('success', 'NewsLetter(s) Deleted Successfully');
        } elseif ($action == 'activate') {
            $this->_activate($enc_id);

            Session::flash('success', 'NewsLetter(s) Activated Successfully');
        } elseif ($action == 'deactivate') {
            $this->_block($enc_id);

            Session::flash('success', 'NewsLetter(s) Deactivate/Blocked Successfully');
        }

        return redirect('/web_admin/newsletter');
    }

    /*
    | _activate() : Change record status to active
    | auther : Danish
    | Date : 25/02/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */

    protected function _activate($enc_id)
    {
        $id = base64_decode($enc_id);

        return NewsLetterModel::where('news_letter_id', $id)
            ->update(['is_active' => '1']);
    }

    /*
    | _block() : Change record status to deactive/inactive/block
    | auther : Danish
    | Date : 25/02/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */
    protected function _block($enc_id)
    {
        $id = base64_decode($enc_id);

        return NewsLetterModel::where('news_letter_id', $id)
            ->update(['is_active' => '0']);
    }

    /*
    | _delete() : Delete country record
    | auther : Danish
    | Date : 25/02/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */
    protected function _delete($enc_id)
    {
        $id = base64_decode($enc_id);

        return NewsLetterModel::where('news_letter_id', $id)->delete();
    }

    /*
    | multi_action() : mutiple actions like active/deactive/delete for multiple slected records
    | auther : Danish
    | Date : 25/02/2016
    | @param  \Illuminate\Http\Request  $request
    */
    public function multi_action(Request $request)
    {
        $arr_rules = [];
        $arr_rules['multi_action'] = 'required';
        $arr_rules['checked_record'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return redirect('/web_admin/newsletter')->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if (is_array($checked_record) && count($checked_record) <= 0) {
            Session::flash('error', 'Problem Occured, While Doing Multi Action');

            return redirect('/web_admin/newsletter');

        }

        foreach ($checked_record as $key => $record_id) {
            if ($multi_action == 'delete') {
                $this->_delete($record_id);
                Session::flash('success', 'NewsLetter(s) Deleted Successfully');
            } elseif ($multi_action == 'activate') {
                $this->_activate($record_id);
                Session::flash('success', 'NewsLetter(s) Activated Successfully');
            } elseif ($multi_action == 'block') {
                $this->_block($record_id);
                Session::flash('success', 'NewsLetter(s) Blocked Successfully');
            }
        }

        return redirect('/web_admin/newsletter');
    }

    /*
    | create() : Show the form for creating a new resource.
    | auther : Danish
    | Date : 25/02/2015
    | @param  \Illuminate\Http\Request  $request
    */

    public function create()
    {
        $page_title = 'Create NewsLetter';

        return view('web_admin.news_letter.create', compact('page_title'));
    }

    /*
    | store() : Stores newly created country.
    | auther : Danish
    | Date : 25/02/2015
    | @param  \Illuminate\Http\Request  $request
    | @return \Illuminate\Http\Response
    */

    public function store(Request $request)
    {
        $arr_rules = [];
        //$arr_rules['name'] = "required";
        $arr_rules['email_address'] = 'email|required';
        $arr_rules['is_active'] = 'required';

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {

            return redirect('/web_admin/newsletter/create')->withErrors($validator)->withInput();
        }

        $arr_data = [];
        $arr_data = $request->all();

        if (NewsLetterModel::where('email_address', $arr_data['email_address'])->get()->count() > 0) {
            Session::flash('error', 'Record with this Email Already Exists');

            return redirect()->back();
        }

        $status = NewsLetterModel::create([
            'email_address' => $arr_data['email_address'],
            'is_active' => $arr_data['is_active'],
        ]);
        if ($status) {
            Session::flash('success', 'Record Created Successfully');
        } else {
            Session::flash('error', 'Problem Occured While Creating Record');
        }

        return redirect('web_admin/newsletter/create');
    }

    /*
    | store() : Compose email.
    | auther : Danish
    | Date : 25/02/2016
    | @param  \Illuminate\Http\Request  $request
    | @return \Illuminate\Http\Response
    */

    public function compose()
    {
        $page_title = 'Compose Email';

        $obj_arr_newsletter = NewsLetterModel::where('is_active', '1')->get();
        if ($obj_arr_newsletter) {
            $arr_newsletter = $obj_arr_newsletter->toArray();
        }

        return view('web_admin.news_letter.compose', compact('page_title', 'arr_newsletter'));
    }

    /*
    | store() : sends email to news-letter subscriber.
    | auther : Danish
    | Date : 25/02/2016
    | @param  \Illuminate\Http\Request  $request
    | @return \Illuminate\Http\Response
    */

    public function send_email(Request $request)
    {
        $form_data = [];
        $array_data = [];
        $form_data = $request->all();

        $to_address = $form_data['to_address'];
        $message = $form_data['message'];

        $arr_site_info = $this->__fetch_site_info();
        $array_data['site_email_address'] = $arr_site_info['site_email_address'];
        $array_data['site_name'] = $arr_site_info['site_name'];

        $email_str = trim($form_data['email_str']);

        if ($email_str == '') {//check emails availables or not
            Session::flash('error', 'Please Select Atleast one Email Id');

            return redirect()->back();
        }

        if ($message == '') {//check compose email not null
            Session::flash('error', 'Please enter your email');

            return redirect()->back();
        }

        if ($email_str) {
            $email_array = explode(' ', $email_str);
        }

        foreach ($email_array as $to_email_address) {
            if (trim($to_email_address)) {
                $array_data['to_address'] = $to_email_address;
                $array_data['content'] = $message;
                $this->_mail($array_data);
            }
        }

        return redirect('/web_admin/newsletter/compose');

    }

    public function _mail($array_data)
    {
        $mail_response = Mail::send('email.general', $array_data, function ($message) use ($array_data) {
            $message->from($array_data['site_email_address'], $array_data['site_name']);
            $message->to($array_data['to_address'])
                ->subject('RightNext :: Newsletter');
        });

        /* Mail Sent Successfully */
        if ($mail_response == 1) {
            Session::flash('success', 'Email Sent Successfully ');
        } else {
            Session::flash('error', 'Problem Occured, While Sending Email');
        }

    }

    public function __fetch_site_info()
    {
        $arr_site_settings = SiteSettingModel::first()->toArray();
        $arr_data = [];

        $arr_data['site_name'] = $arr_site_settings['site_name'];
        $arr_data['site_email_address'] = $arr_site_settings['site_email_address'];

        return $arr_site_settings; //$arr_data;

    }

    public function __fetch_template_info($template_id)
    {
        return $arr_email_template = EmailTemplateModel::where('email_template_id', $template_id)->first()->toArray();
    }
}
