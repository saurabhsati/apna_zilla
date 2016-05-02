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
                  <th style="width:10px"> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>
                  <th style="width:10px;">Sr.No</th>
                  <th width="" style="text-align:center">Business Image</th>
                  <th width="" style="text-align:center">Business Name</th>
                  <th width="" style="text-align:center">Business Public Id</th>
                  <th width="" style="text-align:center">Main Category</th>
                  <th width="" style="text-align:center">Sub Category</th>
                  <th width="" style="text-align:center">Seller First Name</th>
                  <th width="" style="text-align:center">Seller Public ID</th>
                 <!--  <th style="width:25px;">Mobile No</th> -->
                 <!--  <th>City</th> -->
                  <th width="" style="text-align:center">Reviews</th>
                  <th width="" style="text-align:center" >Deals</th>

                  <th width="" style="text-align:center">Verified Status</th>
                  <th width="" style="text-align:center">Action</th>
                  <th width="" style="text-align:center">Assign Membership</th>
                   <th width="" style="text-align:center">Validity Status</th>
                </tr>
              </thead>
              <tbody>

               @if(isset($business_listing) && sizeof($business_listing)>0)
                  @foreach($business_listing as $key => $business)
                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($business['id']) }}" />
                    </td>
                     <td >
                      {{ $key+1 }}
                    </td>
                    <td>
                    <img src="{{ $business_public_img_path.'/'.$business['main_image']}}" alt=""   style="width:30px; height:30px;" />   </td>
                    <td> {{ $business['business_name'] }} </td>
                     <td> {{ $business['busiess_ref_public_id'] }} </td>
                  <td>
                   <?php
                    $categoty=$subcategory=array();
                    if(isset($business['category']) && sizeof($business['category'])>0){
                    foreach ($business['category'] as $business_category) {
                    foreach ($arr_sub_category as $sub_category) {
                      if($business_category['category_id']==$sub_category['cat_id'])
                      {
                         foreach ($arr_main_category as $main_category) {

                          if($sub_category['parent']==$main_category['cat_id'])
                          {
                             $categoty[]=$main_category['title'];

                          }


                          }
                          $subcategory[]=$sub_category['title'];
                       }
                     }
                   }
                 }
                 if(sizeof($categoty)>0)
                   {
                     echo $categoty[0];
                   }

                  ?>
                  </td>
                   <td>
                       <?php
                       if(sizeof($subcategory)>0)
                       {
                        foreach ($subcategory as $key => $value) {

                           echo $value.' ,';
                        }

                       }
                      ?>
                  </td>

                 <!--    <td> {{ $business['user_details']['title'] }} </td> -->
                    <td> {{ $business['user_details']['first_name'] }} </td>
                    <td> {{ $business['user_details']['public_id'] }} </td>
                    <!--  <td> {{ $business['user_details']['city'] }} </td> -->


                      @if( sizeof($business['reviews'])>0)
                      <td><a href="{{ url('sales_user/reviews/'.base64_encode($business['id'])) }}"> ( {{ sizeof($business['reviews']) }} ) </a></td>
                      @else
                       <td><a href="#"> ( {{ sizeof($business['reviews']) }} ) </a></td>
                       @endif

                    <td>

                       <?php
                 foreach ($business['category'] as $business_category) {
                 foreach ($arr_sub_category as $sub_category) {
                      if($business_category['category_id']==$sub_category['cat_id'])
                      {
                         foreach ($arr_main_category as $main_category) {

                          if($sub_category['parent']==$main_category['cat_id'])
                          {
                            if($main_category['is_allow_to_add_deal']=='1')
                            {
                              //$check_allow='';
                              $check_allow=1;
                            }
                            else
                            {
                              // $check_allow='';
                              $check_allow=0;
                            }
                          }


                          }

                       }
                     }
                   }
                  ?>

                     <?php
                    if(sizeof($business['membership_plan_details']  )>0)
                    {
                      $date1 = date('Y-m-d',strtotime($business['membership_plan_details'][0]['expire_date']));
                       $date2 = date('Y-m-d h:m:s');

                       $diff = abs(strtotime($date1) - strtotime($date2));

                      $years = floor($diff / (365*60*60*24));
                      $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                      if($days>0)
                      {
                      ?>

                             @if($business['is_active']!="1" && $check_allow=='0')
                                 <a class="btn btn-info" href="#">
                                 View Deal
                                  </a>
                             @elseif($business['is_active']=="1" && $check_allow=='1')
                                 <a class="btn btn-warning" href="{{ url('/sales_user/deals/'.base64_encode($business['id'])) }}">
                                   View Deal
                                </a>
                             @endif
                       <?php
                      }

                    }
                     else
                        {?>
                         <a class="btn btn-error" href="javascript:void(0);">
                             No Feature
                          </a>
                        <?php
                        }
                       ?>

                    </td>
                     <td >
                         @if($business['is_verified']=="0")
                        <a class="btn btn-danger" href="{{ url('/sales_user/business_listing/toggle_verifired_status/').'/'.base64_encode($business['id']).'/verified' }}">
                            Un-Verified
                        </a>

                        @elseif($business['is_verified']=="1")
                        <a  class="btn btn-success" href="{{ url('/sales_user/business_listing/toggle_verifired_status/').'/'.base64_encode($business['id']).'/unverified' }}">
                           Verified
                        </a>
                        @endif
                    </td>

                    <td>
                     @if($business['is_active']=="0")
                        <a  href="{{ url('/sales_user/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}" class="show-tooltip" title="Block">
                           <i class="fa fa-lock" ></i>
                        </a>

                        @elseif($business['is_active']=="1")
                        <a  href="{{ url('/sales_user/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/block' }}" class="show-tooltip" title="Active">
                            <i class="fa fa-unlock" ></i>
                        </a>
                         @elseif($business['is_active']=="2")
                        <a   href="{{ url('/sales_user/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}" class="show-tooltip" title="Pending">
                             <i class="fa fa-unlock-alt" ></i>
                        </a>
                        @endif
                        &nbsp;
                      <a href="{{ url('/sales_user/business_listing/show/').'/'.base64_encode($business['id']) }}" class="show-tooltip" title="Show">
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
                    <td>
                      <?php
                         foreach ($business['category'] as $business_category)
                          {
                             foreach ($arr_sub_category as $sub_category)
                              {
                                if($business_category['category_id']==$sub_category['cat_id'])
                                {
                                   foreach ($arr_main_category as $main_category)
                                   {
                                      if($sub_category['parent']==$main_category['cat_id'])
                                      {
                                       $category_id=$sub_category['parent'];
                                      }
                                    }
                                }
                              }
                          }
                            $business_id=$business['id'];
                            $user_id=$business['user_details']['id'];

                      if(!sizeof($business['membership_plan_details'])>0)
                    {?>
                      <a href="{{ url('/sales_user/business_listing/assign_membership').'/'.base64_encode($business['id']).'/'.base64_encode($user_id).'/'.base64_encode($category_id) }}" class="show-tooltip" title="Assign Membership">
                          <i class="fa fa-euro" ></i>
                        </a>
                        <?php }
                        else
                          {?>
                              <div style="color: Green;">Assigned</div>
                           <?php }?>

                    </td>
                    <td>
                    <?php
                    if(sizeof($business['membership_plan_details']  )>0)
                    {
                      $date1 = date('Y-m-d',strtotime($business['membership_plan_details'][0]['expire_date']));
                       $date2 = date('Y-m-d h:m:s');

                       $diff = abs(strtotime($date1) - strtotime($date2));

                      $years = floor($diff / (365*60*60*24));
                      $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                      if($days>0)
                        {
                          echo "<div style='color: Green;'>".$days.' Days Remains To Expire</div>' ;
                        }
                        else
                        {
                          echo "<div style='color: red;'>Expired</div>";
                        }


                    }



                     ?>
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


