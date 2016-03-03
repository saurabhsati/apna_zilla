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
                <i class="fa fa-listing"></i>
                <a href="{{ url('/web_admin/business_listing') }}">Business Listing</a>
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
                <i class="fa fa-globe"></i>
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
                <a href="{{ url('/web_admin/business_listing/create_location/'.base64_encode($id))}}" class="btn btn-primary btn-add-new-records">Add Location</a>
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
                  <th >Building</th>
                  <th >Street</th>
                  <th >Landmark</th>
                  <th >Area</th>
                  <th >City</th>
                  <th >Zicode/ Pincode</th>
                  <th >State</th>
                  <th >Country</th>
                  <th width="" style="text-align:center">Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

               @if(isset($business_locations) && sizeof($business_locations)>0)
                  @foreach($business_locations as $location)
                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($location['id']) }}" />
                    </td>
                    <td> {{ $location['building'] }} </td>
                    <td> {{ $location['street'] }} </td>
                    <td> {{ $location['landmark'] }} </td>
                    <td> {{ $location['area'] }} </td>
                    <td> {{ $location['city_details']['city_title'] }} </td>
                    <td> {{ $location['zipcode_details']['zipcode'] }} </td>
                    <td> {{ $location['state_details']['state_title'] }} </td>
                    <td> {{ $location['country_details']['country_name'] }} </td>

                    <td width="" style="text-align:center">
                         @if($location['is_active']=="0")
                        <a class="btn btn-danger" href="{{ url('/web_admin/business_listing/location_toggle_status/').'/'.base64_encode($location['id']).'/activate' }}">
                            Block
                        </a>

                        @elseif($location['is_active']=="1")
                        <a  class="btn btn-success" href="{{ url('/web_admin/business_listing/location_toggle_status/').'/'.base64_encode($location['id']).'/block' }}">
                            Active
                        </a>
                         @elseif($location['is_active']=="2")
                        <a  class="btn btn-info" href="{{ url('/web_admin/business_listing/location_toggle_status/').'/'.base64_encode($location['id']).'/activate' }}">
                            Pending
                        </a>
                        @endif
                    </td>

                    <td>

                        <a href="{{ url('/web_admin/business_listing/edit_location/').'/'.base64_encode($location['id'].'/'.base64_encode($id)) }}" class="show-tooltip" title="Edit">
                          <i class="fa fa-edit" ></i>
                        </a>

                        &nbsp;
                        <a href="{{ url('/web_admin/business_listing/location_toggle_status/').'/'.base64_encode($location['id']).'/delete' }}"
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


