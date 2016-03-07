    @extends('sales_user.template.sales')


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
                <a href="{{ url('/web_admin/sales') }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-list"></i>
                <a href="{{ url('/web_admin/sales/business_listing') }}">Business Listing</a>
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
                <i class="fa fa-list"></i>
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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/web_admin/business_listing/multi_action_loc') }}">

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
                <a href="{{ url('/web_admin/sales/create_user')}}" class="btn btn-primary btn-add-new-records">Add User</a>
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
                   href="{{ url('/web_admin/business_listing') }}"
                   style="text-decoration:none;">
                   <i class="fa fa-repeat"></i>
                </a>
            </div>
          </div>
          <br/>
          <div class="clearfix"></div>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="business_manage" >
              <thead>
                <tr>
                  <th style="width:18px"> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>
                  <th style="width:25px;">Business Image</th>
                  <th style="width:25px;">Business Name</th>
                  <th style="width:25px;">Business Category Name</th>
                  <!-- <th style="width:25px;">Title</th> -->
                  <th style="width:50px;">Full Name</th>
                  <th style="width:25px;">Email</th>
                  <th style="width:25px;">Mobile No</th>
                 <!--  <th>City</th> -->
                  <th style="width:25px;">Reviews</th>
                  <th>Location</th>
                  <th>Contact Info</th>
                  <th width="" style="text-align:center">Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

               @if(isset($business_listing) && sizeof($business_listing)>0)
                  @foreach($business_listing as $business)
                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($business['id']) }}" />
                    </td>
                    <td>
                    <img src="{{ $business_public_img_path.'/'.$business['main_image']}}" alt=""  style="width:75px; height:50px;" />   </td>
                    <td> {{ $business['business_name'] }} </td>
                    <td> {{ $business['categoty_details']['title'] }} </td>
                 <!--    <td> {{ $business['user_details']['title'] }} </td> -->
                    <td> {{ $business['user_details']['first_name']." ".$business['user_details']['last_name'] }} </td>
                    <td> {{ $business['user_details']['email'] }} </td>
                    <td> {{ $business['user_details']['mobile_no'] }} </td>
                    <!--  <td> {{ $business['user_details']['city'] }} </td> -->


                      @if( sizeof($business['reviews'])>0)
                      <td><a href="{{ url('web_admin/reviews/'.base64_encode($business['id'])) }}"> ( {{ sizeof($business['reviews']) }} ) </a></td>
                      @else
                       <td><a href="#"> ( {{ sizeof($business['reviews']) }} ) </a></td>
                       @endif
                     <td>
                        <a
                          class="btn btn-info"
                          href="{{ url('/').'/web_admin/business_listing/location/'.base64_encode($business['id']) }}"  title="View Loaction">
                          View
                        </a>
                        <a
                          class="btn btn-info"
                          href="{{ url('/').'/web_admin/business_listing/create_location/'.base64_encode($business['id']) }}"  title="Add Loaction">
                          Add
                        </a>
                      </td>
                      <td>
                        <a
                          class="btn btn-info"
                          href="{{ url('/').'/web_admin/business_listing/contact_info/'.base64_encode($business['id']) }}"  title="View Conatct Info">
                          View
                        </a>
                        <a
                          class="btn btn-info"
                          href="{{ url('/').'/web_admin/business_listing/create_contact/'.base64_encode($business['id']) }}"  title="Add Conatct Info">
                          Add
                        </a>
                      </td>
                    <td width="" style="text-align:center">
                         @if($business['is_active']=="0")
                        <a class="btn btn-danger" href="{{ url('/web_admin/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}">
                            Block
                        </a>

                        @elseif($business['is_active']=="1")
                        <a  class="btn btn-success" href="{{ url('/web_admin/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/block' }}">
                            Active
                        </a>
                         @elseif($business['is_active']=="2")
                        <a  class="btn btn-info" href="{{ url('/web_admin/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}">
                            Pending
                        </a>
                        @endif
                    </td>

                    <td>

                        <a href="{{ url('/web_admin/business_listing/edit/').'/'.base64_encode($business['id']) }}" class="show-tooltip" title="Edit">
                          <i class="fa fa-edit" ></i>
                        </a>

                        &nbsp;
                        <a href="{{ url('/web_admin/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/delete' }}"
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
        $("#business_manage").DataTable();
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


