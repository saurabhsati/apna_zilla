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
                <a href="{{ url('/sales_user/dashboard') }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-list"></i>
                <a href="{{ url('/sales_user/business_listing') }}">Business Listing</a>
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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/sales_user/business_listing/multi_action') }}">

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
                <a href="{{ url('/sales_user/business_listing/create')}}" class="btn btn-primary btn-add-new-records">Add business</a>
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
                   href="{{ url('/sales_user/business_listing') }}"
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
                  <th style="width:40px;">Business Category::Sub Category</th>
                  <!-- <th style="width:25px;">Title</th> -->
                  <th style="width:50px;">Full Name</th>
                  <th style="width:25px;">Email</th>
                  <th style="width:25px;">Mobile No</th>
                 <!--  <th>City</th> -->
                  <th style="width:25px;">Reviews</th>
                  <th style="width:25px;">Deals</th>
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

                  <td>
                   <?php
                 foreach ($business['category'] as $business_category) {
                 foreach ($arr_sub_category as $sub_category) {
                      if($business_category['category_id']==$sub_category['cat_id'])
                      {
                         foreach ($arr_main_category as $main_category) {

                          if($sub_category['parent']==$main_category['cat_id'])
                          {
                            echo $main_category['title'].' :: ';
                          }


                          }
                          echo $sub_category['title'].' <br/>';
                       }
                     }
                   }
                  ?>
                  </td>


                 <!--    <td> {{ $business['user_details']['title'] }} </td> -->
                    <td> {{ $business['user_details']['first_name']." ".$business['user_details']['last_name'] }} </td>
                    <td> {{ $business['user_details']['email'] }} </td>
                    <td> {{ $business['user_details']['mobile_no'] }} </td>
                    <!--  <td> {{ $business['user_details']['city'] }} </td> -->


                      @if( sizeof($business['reviews'])>0)
                      <td><a href="{{ url('sales_user/reviews/'.base64_encode($business['id'])) }}"> ( {{ sizeof($business['reviews']) }} ) </a></td>
                      @else
                       <td><a href="#"> ( {{ sizeof($business['reviews']) }} ) </a></td>
                       @endif

                    <td>
                       @if($business['is_active']!="1")
                           <a class="btn btn-info" href="#">
                           Add Deal
                            </a>
                       @elseif($business['is_active']=="1")
                           <a class="btn btn-warning" href="{{ url('/sales_user/deals/'.base64_encode($business['id'])) }}">
                             Add Deal
                          </a>
                       @endif

                    </td>
                    <td width="" style="text-align:center">
                         @if($business['is_active']=="0")
                        <a class="btn btn-danger" href="{{ url('/sales_user/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}">
                            Block
                        </a>

                        @elseif($business['is_active']=="1")
                        <a  class="btn btn-success" href="{{ url('/sales_user/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/block' }}">
                            Active
                        </a>
                         @elseif($business['is_active']=="2")
                        <a  class="btn btn-info" href="{{ url('/sales_user/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}">
                            Pending
                        </a>
                        @endif
                    </td>

                    <td>
                      <a href="{{ url('/sales_user/business_listing/show/').'/'.base64_encode($business['id']) }}" class="show-tooltip" title="Edit">
                          <i class="fa fa-eye" ></i>
                        </a>
                         &nbsp;
                        <a href="{{ url('/sales_user/business_listing/edit/').'/'.base64_encode($business['id']) }}" class="show-tooltip" title="Edit">
                          <i class="fa fa-edit" ></i>
                        </a>

                        &nbsp;
                        <a href="{{ url('/sales_user/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/delete' }}"
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


