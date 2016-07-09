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
                <a href="{{ url('/web_admin/dashboard') }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-bars"></i>
                <a href="{{ url('/web_admin/categories') }}">Category</a>
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
                <i class="fa fa-bars"></i>
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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/web_admin/categories/multi_action') }}">

            {{ csrf_field() }}

            <div class="col-md-10">


            <div id="ajax_op_status">

            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">
            <!--- Add new record - - - -->
                <div class="btn-group">
                <a href="{{ url('/web_admin/categories/create')}}" class="btn btn-primary btn-add-new-records">Add Category/Sub Category</a>
                </div>

                 <div class="btn-group">
                <a href="{{ url('/web_admin/categories/export/csv')}}" class="btn btn-warning btn-add-new-records" title="Click to Excel Export"><i class="fa fa-file-excel-o"></i>
</a>
                </div>
            <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - -->
            <div class="btn-group">
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                    title="Multiple Unblock"
                    href="javascript:void(0);"
                    onclick="javascript : return check_multi_action('frm_manage','activate');"
                    style="text-decoration:none;">

                    <i class="fa fa-unlock"></i>
                </a>
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Multiple Block"
                   href="javascript:void(0);"
                   onclick="javascript : return check_multi_action('frm_manage','block');"
                   style="text-decoration:none;">
                    <i class="fa fa-lock"></i>
                </a>
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Multiple Delete"
                   href="javascript:void(0);"
                   onclick="javascript : return check_multi_action('frm_manage','delete');"
                   style="text-decoration:none;">
                   <i class="fa fa-trash-o"></i>
                </a>
            </div>
            <div class="btn-group">
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Refresh"
                   href="{{ url('/web_admin/categories') }}"
                   style="text-decoration:none;">
                   <i class="fa fa-repeat"></i>
                </a>
            </div>
          </div>
          <br/>
          <div class="clearfix"></div>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="user_manage" >
              <thead>
                <tr>
                  <th style="width:5%"> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>
                  <th style="width:10%">Sr.No.</th>
                  <th style="width:30%">Category</th>
                  <th style="width:30%">Sort Order</th>
                  <th style="width:30%">Sub Categories</th>
                  <th style="width:15%">Status</th>
                  <th style="width:15%">Action</th>
                </tr>
              </thead>
              <tbody>

                  @if(isset($arr_category) && sizeof($arr_category)>0)
                  @foreach($arr_category as $key => $category)
                  <tr>
                    <td>
                  <input type="checkbox"
                         name="checked_record[]"
                         value="{{ base64_encode($category['cat_id']) }}" />
                    </td>


                    <td>{{  $key+1 }}</td>

                    <td> {{ $category['title'] }} </td>

                   <td> {{ $category['cat_order'] }} </td>

                     <td>
                        <a
                          class="btn btn-info"
                          href="{{ url('/').'/web_admin/categories/sub_categories/'.base64_encode($category['cat_id']).'' }}"  title="View Sub Category">
                          View
                        </a>
                        <a
                          class="btn btn-info"
                          href="{{ url('/').'/web_admin/categories/create/'.base64_encode($category['cat_id']).'?src='.base64_encode('/web_admin/categories') }}"  title="Add Sub Category">
                          Add
                        </a>
                      </td>

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
<!--
                 <a data-toggle="modal"
                 data-target="#show_category_title"
                 data-cat-id="{{ base64_encode($category['cat_id']) }}"

                 onclick="showEditCategory(this)"
                 >
                <i class="fa fa-edit" title="Edit Category"></i>
              </a> -->
              <a href="{{ url('/web_admin/categories/edit/').'/'.base64_encode($category['cat_id']) }}" class="show-tooltip" title="Edit" >
                
                <i class="fa fa-edit" ></i>
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
          </div>

          </form>
      </div>
  </div>
</div>
</div>




<!-- END Main Content -->

<script type="text/javascript" src="{{ url('/assets/data-tables/latest') }}/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ url('/assets/data-tables/latest') }}/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">

   $(document).ready(function()
    {
        $("#user_manage").DataTable();
    });

    function confirm_delete()
    {
       if(confirm('Are you sure ?'))
       {
        return true;
       }
       return false;
    }



    function check_multi_action(frm_id,action)
    {
      var frm_ref = jQuery("#"+frm_id);
      if(jQuery(frm_ref).length && action!=undefined && action!="")
      {
        /* Get hidden input reference */
        var input_multi_action = jQuery('input[name="multi_action"]');

        if(jQuery(input_multi_action).length)
        {
          /* Set Action in hidden input*/
          jQuery('input[name="multi_action"]').val(action);

          /*Submit the referenced form */
          jQuery(frm_ref)[0].submit();

        }
        else
        {
          console.warn("Required Hidden Input[name]: multi_action Missing in Form ")
        }
      }
      else
      {
          console.warn("Required Form[id]: "+frm_id+" Missing in Current Page ")
      }
    }
</script>

@stop


