
@extends('web_admin.template.admin')
@section('main_content')
<style type="text/css">

</style>
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
                <i class="fa fa-list"></i>
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
         
            <div class="row">
             <form class="form-horizontal" id="validation-form" name="frm_search"  action="{{ url('/web_admin/business_listing') }}" method="post">
           
           {{ csrf_field() }}
               <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="box box-magenta">   
                <div class="box-content">
                <!-- <table class="table">
                    <tr>
                      <td style="border-top:none;"> -->
                      <div class="form-group">
                        <label class="col-sm-3 col-lg-2 control-label">Location : </label>
                        <div class="col-sm-9 col-lg-5 controls">
                          <input type="text"
                             class="form-control"
                             name="search_name"
                             id="search_name"  
                             data-rule-required="true" 
                             placeholder="Search Business By Area, City ,State & Country" 
                             value="<?php if(isset($_POST['search_name'])){echo $_POST['search_name'];} ?>" 
                              />
                          <div class="error" id="err_search_name" ></div>
                        </div>
                        <div class="col-sm-9 col-lg-3 controls">
                          <input id="btn_cat_search" class="btn btn-primary" type="submit"  name="btn_search" value="Search">
                        </div>
                        </div>      
                      <!-- </td>
                    </tr>
                </table>   -->    
                </div>         
                </div>
            </div>
    
            </form>
             <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/web_admin/business_listing/multi_action') }}">
             <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
         

                        {{ csrf_field() }}
                        <div class="btn-toolbar pull-right clearfix">
                        <!--- Add new record - - - -->
                            <div class="btn-group">
                            <a href="{{ url('/web_admin/business_listing/create')}}" class="btn btn-primary btn-add-new-records">Add business</a>
                            </div>

                             <div class="btn-group">
                            <a href="{{ url('/web_admin/business_listing/export/csv')}}" class="btn btn-warning btn-add-new-records" title="Click to Excel Export"><i class="fa fa-file-excel-o"></i>
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
                               href="{{ url('/web_admin/business_listing') }}"
                               style="text-decoration:none;">
                               <i class="fa fa-repeat"></i>
                            </a>
                        </div>
                      </div>
                       </div>
                        
                        <div class="col-md-10">
                        <div id="ajax_op_status">
                        </div>
                        <div class="alert alert-danger" id="no_select" style="display:none;"></div>
                        <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
                      </div>
                      
                      <br/>
                      <div class="clearfix"></div>
                      <div class="col-md-12">
                      <div class="table-responsive" style="border:0">

                        <input type="hidden" name="multi_action" value="" />

                        <table class="table table-advance"  id="business_manage" >
                          <thead>
                            <tr>
                              <th style="width:1%"> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>
                              <th style="width:1%;">No</th>
                             <!--  <th width="width:10%;" style="text-align:center">Business Image</th> -->
                              <th width="width:10%;" style="text-align:center">Business Public Id</th>
                              <th width="width:10%;" style="text-align:center">Business Name</th>
                              <th width="width:3%;" style="text-align:center">Vender First Name</th>
                              <th width="width:5%;" style="text-align:center">Vender Public ID</th>
                              <th width="width:5%;" style="text-align:center">Main Category</th>
                              <th width="width:10%;" style="text-align:center">Sub Category</th>
                              <th width="width:3%;" style="text-align:center" >Deals</th>
                              <th width="width:52%;" style="text-align:center">Action</th>
                              
                            </tr>
                          </thead>
                          <tbody>
    
                           @if(isset($business_listing) && sizeof($business_listing)>0)
                              @foreach($business_listing as $key => $business)
                               <?php
                                $category_id='';
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
                                 $category_id;
                                 $business_id=$business['id'];
                                 $user_id=$business['user_details']['id'];

                                 if(!sizeof($business['membership_plan_details'])>0)
                                 {
                                   $style= " alert  alert red";
                                 }
                                 else
                                 {
                                   $style='';
                                   $style= 'style="color: Green;"';
                                 }
                                 ?>
                                
                                <tr>

                                <td width="width:1%;">
                                  <input type="checkbox"
                                         name="checked_record[]"
                                         value="{{ base64_encode($business['id']) }}" />
                                </td>
                                 <td width="width:1%;">
                                  {{ $key+1 }}
                                </td>
                              {{--  <td width="width:10%;">
                                <img src="{{ $business_public_img_path.'/'.$business['main_image']}}" alt=""  style="width:30px; height:30px;" />   </td> --}}
                                 <td width="width:10%;"> {{ $business['busiess_ref_public_id'] }} </td>
                               <td width="width:10%;"> {{ $business['business_name'] }} </td>
                                <td width="width:3%;"> {{ $business['user_details']['first_name']}} </td>
                                <td width="width:5%;"> {{ $business['user_details']['public_id'] }} </td>


                              <td width="width:5%;">
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
                              <td width="width:10%;">
                                   <?php
                                   
                                   if(sizeof($subcategory)>0)
                                   {
                                    foreach ($subcategory as $key => $value) {

                                       echo $value;
                                       if($key < sizeof($subcategory)-1)
                                        { echo ' , '; }
                                     }
                                    

                                   }
                                  ?>
                              </td>
                          <td width="width:3%;">
                                   <?php

                             $check_allow ='';      
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
                                           //$check_allow='';
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

                                    $expire_date = new \Carbon($business['membership_plan_details'][0]['expire_date']);
                                    $now = Carbon::now();
                                    $difference = ($expire_date->diff($now)->days < 1)
                                        ? 'today'
                                        : $expire_date->diffForHumans($now);
                                       
                                    if (strpos($difference, 'after') !== false || strpos($difference, 'today') !== false && $business['membership_plan_details']['transaction_status'] == "Active") 
                                    {
                                    ?>
                                    @if($check_allow=='0')
                                       <a class="btn btn-error" href="javascript:void(0);">
                                      No Feature
                                        </a>
                                   @elseif($business['is_active']=="1" && $check_allow=='1' )
                                       <a class="btn btn-success" href="{{ url('/web_admin/deals/'.base64_encode($business['id'])) }}">
                                         View Deals
                                      </a>
                                   @else
                                     <a class="btn btn-error" href="javascript:void(0);">
                                           Block Business
                                        </a>
                                   @endif

                                     <?php
                                      }
                                       else
                                      { ?>
                                       <a class="btn btn-error" href="javascript:void(0);">
                                           Plan Expired
                                        </a>
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


                           
                                <td width="width:52%;">
                                @if( sizeof($business['reviews'])>0)
                                 
                                   <a href="{{ url('web_admin/reviews/'.base64_encode($business['id'])) }}" class="show-tooltip" title="Ratings Available">  <i class="glyphicon glyphicon-star" ></i></a>
                                  @else
                                   
                                   <a href="#" class="show-tooltip" title="No Ratings Available"> <i class="glyphicon glyphicon-star-empty" ></i> </a>
                                   @endif
                                |
                                     @if($business['is_verified']=="0")
                                    <a href="{{ url('/web_admin/business_listing/toggle_verifired_status/').'/'.base64_encode($business['id']).'/verified' }}" class="show-tooltip" title="Un-Verifired">
                                         <i class="fa fa-thumbs-o-down" ></i>
                                    </a>

                                    @elseif($business['is_verified']=="1")
                                    <a   href="{{ url('/web_admin/business_listing/toggle_verifired_status/').'/'.base64_encode($business['id']).'/unverified' }}" class="show-tooltip" title="Verifired">
                                      <i class="fa fa-thumbs-up" ></i>
                                    </a>
                                    @endif
                                <!-- </td>
                                <td> -->
                                  |
                                 @if($business['is_active']=="0")
                                    <a  href="{{ url('/web_admin/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}" class="show-tooltip" title="Block">
                                        <i class="fa fa-lock" ></i>
                                    </a>

                                    @elseif($business['is_active']=="1")
                                    <a   href="{{ url('/web_admin/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/block' }}" class="show-tooltip" title="Active">
                                        <i class="fa fa-unlock" ></i>
                                    </a>
                                     @elseif($business['is_active']=="2")
                                    <a   href="{{ url('/web_admin/business_listing/toggle_status/').'/'.base64_encode($business['id']).'/activate' }}" class="show-tooltip" title="Pending">
                                        <i class="fa fa-unlock-alt" ></i>
                                    </a>
                                    @endif
                                   
                                      |
                                    <a href="{{ url('/web_admin/business_listing/edit/').'/'.base64_encode($business['id']) }}" class="show-tooltip" title="Edit">
                                      <i class="fa fa-edit" ></i>
                                    </a>
                                    |
                                     <a href="{{ url('/web_admin/business_listing/show/').'/'.base64_encode($business['id']) }}" class="show-tooltip" title="Show">
                                      <i class="fa fa-eye" ></i>
                                    </a>

                                    |
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


