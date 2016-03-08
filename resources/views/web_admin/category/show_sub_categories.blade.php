 @extends('web_admin.template.admin')                


      @section('main_content')

      <link rel="stylesheet" type="text/css" href="{{ url('/assets/data-tables/latest/') }}/dataTables.bootstrap.min.css">

      <!-- BEGIN Page Title -->
      <div class="page-title">
        <div>

        </div>
      </div>
      <!-- END Page Title -->

      <!-- BEGIN Breadcrumb -->
      <div id="breadcrumbs">
        <ul class="breadcrumb">
          <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/').'/web-admin/dashboard' }}">Dashboard</a>
          </li>
          <span class="divider">
            <i class="fa fa-angle-right"></i>
          </span>
          <li>
            <i class="fa fa-tasks "></i>
            <a href="{{ url('/').'/web_admin/categories' }}">Category </a>
          </li>   
          <span class="divider">
            <i class="fa fa-angle-right"></i>
          </span>
          <li class="active">{{ isset($page_title)?$page_title:"" }}</li>
        </ul>
      </div>
      <!-- END Breadcrumb -->


      <!-- BEGIN Main Content -->
      <div class="row">
        <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-tasks "></i>
                {{ isset($page_title)?$page_title:"" }}
              </h3>
              <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
              </div>
            </div>
            <div class="box-content">
              @if(Session::has('success'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success') }}
              </div>
              @endif  

              @if(Session::has('error'))
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('error') }}
              </div>
              @endif

              <div class="col-md-10">

                <div id="ajax_op_status">
                </div>

                <div class="alert alert-danger" id="no_select" style="display:none;"></div>
                <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
              </div>
              <div class="clearfix"></div>

               <div class="btn-toolbar pull-left clearfix">
                <a class="btn btn-sm btn-primary" href="{{ url('/web_admin/categories') }}">
                  <i class='fa fa-arrow-left'></i> Back
                </a>
              </div>


              <div class="btn-toolbar pull-right clearfix">
              <!--- Add new record - - - -->
                    <div class="btn-group">
                    <a href="{{ url('/web_admin/categories/create/'.$enc_id.'?src='.base64_encode('/web_admin/categories/sub_categories/'.$enc_id))}}" class="btn btn-primary btn-add-new-records">Add Sub Category</a> 
                    </div>
                <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - -->
                      <div class="btn-group">
                        <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                        title="Multiple Unblock" 
                        href="javascript:void(0);" 
                        onclick="javascript : return check_multi_action('frm_category_manage','activate');" 
                        style="text-decoration:none;">

                        <i class="fa fa-unlock"></i>
                      </a> 
                      <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                      title="Multiple Block" 
                      href="javascript:void(0);" 
                      onclick="javascript : return check_multi_action('frm_category_manage','block');"  
                      style="text-decoration:none;">
                      <i class="fa fa-lock"></i>
                    </a> 

                  </div>
                  <div class="btn-group"> 
                    <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                    title="Refresh" 
                    href="{{ url('/').'/web_admin/categories' }}"
                    style="text-decoration:none;">
                    <i class="fa fa-repeat"></i>
                  </a> 
                </div>
              </div>
              <br/>
        <div class="clearfix"></div>
         <form class="form-horizontal" id="frm_category_manage" method="POST" action="{{ url('/').'/web_admin/categories/sub_categories/multi_action' }}">

         {{ csrf_field() }}
        <input type="hidden" name="multi_action" value="" />

        <table class="table table-advance" id="category_english">
          <thead>
            <tr>
              <th style="width:18px"> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>

              <th>Sub Category</th>
             <!--  <th>Attributes</th> -->
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
           @if(isset($arr_sub_category) && sizeof($arr_sub_category)>0)
              @foreach($arr_sub_category as $key => $category)

           <tr>
              <td> 
                <input type="checkbox" 
                       name="checked_record[]"  
                       value="{{ base64_encode($category['cat_id']) }}" /> 
              </td>

            <td>{{$category['title']}}</td>
            
          <!-- 
            <td>
                <a
                  class="btn btn-info" 
                  href="{{ url('/').'/web_admin/attribute/show/'.base64_encode($category['cat_id']) }}"  title="View Attribute">
                  View
              </a>
            </td>
          -->
           <td width="250">
                         @if($category['is_active']=="0")
                        <a class="btn btn-danger" href="{{ url('/web_admin/categories/toggle_status/').'/'.base64_encode($category['cat_id']).'/activate' }}">
                            Block
                        </a>    
                              
                        @elseif($category['is_active']=="1")
                        <a  class="btn btn-success" href="{{ url('/web_admin/categories/toggle_status/').'/'.base64_encode($category['cat_id']).'/block' }}">
                            Active
                        </a>   
                        @endif 
            </td>

            <td> 

              <a href="{{ url('/web_admin/categories/edit/').'/'.base64_encode($category['cat_id']) }}" class="show-tooltip" title="Edit">
                <i class="fa fa-edit " ></i>
              </a> 

              &nbsp;  
              <a href="{{ url('/web_admin/categories/delete/').'/'.base64_encode($category['cat_id']) }}" 
                 onclick="javascript:return confirm_delete()" class="show-tooltip" title="Delete">
                <i class="fa fa-trash" ></i>
              </a>   

            </td>

            </tr>
         
        @endforeach
        @endif

        </tbody>
      </table>  
      </form>
    </div>
  </div>
</div>
</div>



@stop  