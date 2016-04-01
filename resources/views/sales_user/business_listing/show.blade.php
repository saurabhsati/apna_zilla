    @extends('sales_user.template.sales')


    @section('main_content')
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
                <a href="{{ url('/').'/sales_user/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-user"></i>
                <a href="{{ url('/').'/sales_user/business_listing' }}">Business Listing</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active">  {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->


    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-user"></i>
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

@if(isset($business_data) && sizeof($business_data)>0)
  @foreach($business_data as $business)
<form class="form-horizontal"
              id="validation-form"
              method="POST"
              action="#"
              enctype="multipart/form-data">


           {{ csrf_field() }}
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_added_by">Business Added By<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="business_added_by"
                           id="business_added_by"
                           data-rule-required="true"
                           placeholder="Enter Business Name"
                           value="Seller"
                           readonly="true"
                           />
                    <span class='help-block'>{{ $errors->first('business_added_by') }}</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="user_id">Select User<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['user_details']['first_name'])?$business['user_details']['first_name']:'' }}"
                           />

                    <span class='help-block'>{{ $errors->first('user_id') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_name">Business Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="business_name"
                           id="business_name"
                           data-rule-required="true"
                           placeholder="Enter Business Name"
                           readonly="true"
                           value="{{ isset($business['business_name'])?$business['business_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('business_name') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_cat">Business Categories<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <?php
                $arr_selected=array();
                 foreach($business['category'] as $sel_category){
                  array_push($arr_selected,$sel_category['category_id']);}

                   foreach ($arr_selected as $key => $value) {
                    foreach ($arr_sub_category as $sub_category) {
                      if($value==$sub_category['cat_id'])
                      {
                         foreach ($arr_main_category as $main_category) {
                          if($sub_category['parent']==$main_category['cat_id'])
                          {
                            ?>
                          <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="<?php echo $main_category['title'].' :: ';}}?><?php echo $sub_category['title'].'  ';?>"
                           />
                         <?php
                       }
                    }
                  }
                      ?>

                    <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                </div>
            </div>

            <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Image <i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src={{ $business_public_img_path.$business['main_image']}} alt="" />
                                  </div>
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>
                         </div>

                         <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Uploded Image <i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                 @foreach($business['image_upload_details'] as $business_data_img)

                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src={{ $business_base_upload_img_path.$business_data_img['image_name']}} alt="" />
                                  </div>
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                  @endforeach
                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="building">Building<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="building"
                           id="building"
                           data-rule-required="true"
                           placeholder="Enter Building"
                           value="{{ isset($business['building'])?$business['building']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('building') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">Street <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="street"
                           id="street"
                           data-rule-required="true"
                           placeholder="Enter Street"
                           value="{{ isset($business['street'])?$business['street']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="landmark">landmark <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="landmark"
                           id="landmark"
                           data-rule-required="true"
                           placeholder="Enter Landmark"
                           value="{{ isset($business['landmark'])?$business['landmark']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="area">Area <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="area"
                           id="area"
                           data-rule-required="true"
                           placeholder="Enter Area"
                           value="{{ isset($business['area'])?$business['area']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">City <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['city_details']['city_title'])?$business['city_details']['city_title']:'' }}"
                           />
                  <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="pincode">Zipcode <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($arr_place[0]['postal_code'])?$arr_place[0]['postal_code']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">State <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['state_details']['state_title'])?$business['state_details']['state_title']:'' }}"
                           />
                 <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">Country <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['country_details']['country_name'])?$business['country_details']['country_name']:'' }}"
                           />
               <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="contact_person_name">Contact Person Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="contact_person_name"
                           id="contact_person_name"
                           data-rule-required="true"
                           placeholder="Enter Contact Person Name"
                           value="{{ isset($business['contact_person_name'])?$business['contact_person_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('contact_person_name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="mobile_number">Mobile Number <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="mobile_number"
                           id="mobile_number"
                           data-rule-required="true"
                           placeholder="Enter Mobile Number"
                           value="{{ isset($business['mobile_number'])?$business['mobile_number']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('mobile_number') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="landline_number">Landline Number <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="landline_number"
                           id="landline_number"
                           data-rule-required="true"
                           placeholder="Enter Landline Number"
                           value="{{ isset($business['landline_number'])?$business['landline_number']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('landline_number') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="fax_no">Fax No <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="fax_no"
                           id="fax_no"
                           data-rule-required="true"
                           placeholder="Enter Fax No"
                           value="{{ isset($business['fax_no'])?$business['fax_no']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('fax_no') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="toll_free_number">Toll Free Number<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="toll_free_number"
                           id="toll_free_number"
                           data-rule-required="true"
                           placeholder="Enter Toll Free Number"
                           value="{{ isset($business['toll_free_number'])?$business['toll_free_number']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('toll_free_number') }}</span>
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Email Id <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="email_id"
                           id="email_id"
                           data-rule-required="true"
                           placeholder="Enter Email Id"
                           value="{{ isset($business['email_id'])?$business['email_id']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('email_id') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="website">Website <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="website"
                           id="website"
                           data-rule-required="true"
                           placeholder="Enter Website"
                           value="{{ isset($business['website'])?$business['website']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('website') }}</span>
                </div>
            </div>




           <hr/>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Business Opening Hours</b></h4>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Monday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control  timepicker-default" readonly="true" name="mon_in" id="mon_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['mon_open'])?$business['business_times']['mon_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="mon_out" id="mon_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['mon_close'])?$business['business_times']['mon_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Tuesday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="tue_in" id="tue_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['tue_open'])?$business['business_times']['tue_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="tue_out" id="tue_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['tue_close'])?$business['business_times']['tue_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Wednesday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="wed_in" id="wed_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['wed_open'])?$business['business_times']['wed_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="wed_out" id="wed_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['wed_close'])?$business['business_times']['wed_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Thursday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="thus_in" id="thus_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['thus_open'])?$business['business_times']['thus_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="thus_out" id="thus_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['thus_close'])?$business['business_times']['thus_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Friday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="fri_in" id="fri_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['fri_open'])?$business['business_times']['fri_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="fri_out" id="fri_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['fri_close'])?$business['business_times']['fri_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Saturday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="sat_in" id="sat_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sat_open'])?$business['business_times']['sat_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="sat_out" id="sat_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sat_close'])?$business['business_times']['sat_close']:'' }}">
                    </div>
                </div>

            </div>


            <div class="form-group">

            <label class="col-sm-3 col-lg-2 control-label" >Sunday<i class="red">*</i></label>

               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="sun_in" id="sun_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sun_open'])?$business['business_times']['sun_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" readonly="true" name="sun_out" id="sun_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sun_close'])?$business['business_times']['sun_close']:'' }}">
                    </div>
                </div>

            </div>

            <hr/>

             <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Payment Modes <i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                                 @foreach($business['payment_mode'] as $payment_mode)

                                  <div class="fileupload-new img-thumbnail main" style="width: 300px; height: 45px;" data-payment-mode="{{ $payment_mode['title'] }}">
                                     <input class="form-control" type="text" name="payment_mode" id="payment_mode" class="pimg"  value="{{ $payment_mode['title']}}" readonly="true"/>
                                  </div>
                                   <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 100px; line-height: 20px;"></div>

                                  @endforeach
                    <div class="error" id="err_delete_service"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                            </div>

                         </div>
              <hr/>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="company_info">Company Info<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" readonly="true"
                           name="company_info"
                           id="company_info"
                           data-rule-required="true"
                           placeholder="Enter Company Info"
                           >{{ isset($business['company_info'])?$business['company_info']:'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('company_info') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="keywords">Keywords<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="keywords" readonly="true"
                           id="keywords"
                           data-rule-required="true"
                           placeholder="Enter Keywords"
                           >{{ isset($business['keywords'])?$business['keywords']:'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('keywords') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="youtube_link">Youtube Link<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" readonly="true"
                           name="youtube_link"
                           id="youtube_link"
                           data-rule-required="true"
                           placeholder="Enter Youtube Link"
                           value="{{ isset($business['youtube_link'])?$business['youtube_link']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('youtube_link') }}</span>
                </div>
            </div>
            <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Business Services  <i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                                 @foreach($business['service'] as $service)

                                  <div class="fileupload-new img-thumbnail main" style="width: 300px; height: 45px;" data-service="{{ $service['name'] }}">
                                     <input class="form-control" type="text" name="service" id="service" class="pimg"  value="{{ $service['name']}}" readonly="true"/>
                                  </div>
                                   <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 100px; line-height: 20px;"></div>

                                  @endforeach
                    <div class="error" id="err_delete_service"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="hidden"  class="btn btn-primary" value="Update">

            </div>
        </div>
</form>
@endforeach
@endif
</div>
</div>
</div>
</div>
<!-- END Main Content -->

<script type="text/javascript">
    var site_url = "{{url('/')}}";

    function loadPreviewImage(ref)
    {
        var file = $(ref)[0].files[0];

        var img = document.createElement("img");
        reader = new FileReader();
        reader.onload = (function (theImg) {
            return function (evt) {
                theImg.src = evt.target.result;
                $('#preview_profile_pic').attr('src', evt.target.result);
            };
        }(img));
        reader.readAsDataURL(file);
        $("#removal_handle").show();
    }

    function clearPreviewImage()
    {
        $('#preview_profile_pic').attr('src',site_url+'/images/front/avatar.jpg');
        $("#removal_handle").hide();
    }

</script>
@stop