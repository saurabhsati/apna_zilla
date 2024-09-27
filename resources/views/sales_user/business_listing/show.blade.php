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
                <i class="fa fa-list"></i>
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

@if(isset($business_data) && sizeof($business_data)>0)
  @foreach($business_data as $business)
<form class="form-horizontal"
              id="validation-form"
              method="POST"
              action="#"
              enctype="multipart/form-data">


           {{ csrf_field() }}
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_added_by">Business Added By<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="business_added_by"
                           id="business_added_by"
                           data-rule-required="true"
                           placeholder="Enter Business Name"
                           value="{{ isset($business['business_added_by'])?$business['business_added_by']:'' }}"
                           readonly="true"
                           />
                    <span class='help-block'>{{ $errors->first('business_added_by') }}</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="user_id">Select User<i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="business_name">Business Name<i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="business_cat">Business Categories<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <?php
                $arr_selected=[];
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
                            <label class="col-sm-3 col-lg-2 control-label"> Image <i class="red"></i> </label>
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
                            <label class="col-sm-3 col-lg-2 control-label"> Uploded Image <i class="red"></i> </label>
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
             <hr/>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Business Location Details </b></h4>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="area">Area <i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="city">City <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['city'])?$business['city']:'' }}"
                           />
                  <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="pincode">Zipcode <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['pincode'])?$business['pincode']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">State <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['state'])?$business['state']:'' }}"
                           />
                 <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">Country <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           readonly="true"
                           value="{{ isset($business['country'])?$business['country']:'' }}"
                           />
               <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
              <hr/>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Business Contact Details </b></h4>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="contact_person_name">Contact Person Name<i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="mobile_number">Mobile Number <i class="red"></i></label>
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
           <!--  <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="landline_number">Landline Number <i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="fax_no">Fax No <i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="toll_free_number">Toll Free Number<i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Email Id <i class="red"></i></label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="website">Website <i class="red"></i></label>
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

 -->


           <hr/>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Business Opening Hours</b></h4>
                </div>
            </div>
             @foreach($business['business_times'] as $time)
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Monday<i class="red"></i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control  timepicker-default" readonly="true" name="mon_in" id="mon_in" type="text" data-rule-required="true" value="{{ isset($time['mon_open'])?$time['mon_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="mon_out" id="mon_out" type="text" data-rule-required="true" value="{{ isset($time['mon_close'])?$time['mon_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Tuesday<i class="red"></i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="tue_in" id="tue_in" type="text" data-rule-required="true" value="{{ isset($time['tue_open'])?$time['tue_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="tue_out" id="tue_out" type="text" data-rule-required="true" value="{{ isset($time['tue_close'])?$time['tue_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Wednesday<i class="red"></i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="wed_in" id="wed_in" type="text" data-rule-required="true" value="{{ isset($time['wed_open'])?$time['wed_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="wed_out" id="wed_out" type="text" data-rule-required="true" value="{{ isset($time['wed_close'])?$time['wed_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Thursday<i class="red"></i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="thus_in" id="thus_in" type="text" data-rule-required="true" value="{{ isset($time['thus_open'])?$time['thus_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="thus_out" id="thus_out" type="text" data-rule-required="true" value="{{ isset($time['thus_close'])?$time['thus_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Friday<i class="red"></i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="fri_in" id="fri_in" type="text" data-rule-required="true" value="{{ isset($time['fri_open'])?$time['fri_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="fri_out" id="fri_out" type="text" data-rule-required="true" value="{{ isset($time['fri_close'])?$time['fri_close']:'' }}">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Saturday<i class="red"></i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="sat_in" id="sat_in" type="text" data-rule-required="true" value="{{ isset($time['sat_open'])?$time['sat_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="sat_out" id="sat_out" type="text" data-rule-required="true" value="{{ isset($time['sat_close'])?$time['sat_close']:'' }}">
                    </div>
                </div>

            </div>


            <div class="form-group">

            <label class="col-sm-3 col-lg-2 control-label" >Sunday<i class="red"></i></label>
             @if(empty($time['sun_open']) && empty($time['sun_open'])) 
                        <label class="col-sm-3 col-lg-3 controls">Off</label>
                        @else
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="sun_in" id="sun_in" type="text" data-rule-required="true" value="{{ isset($time['sun_open'])?$time['sun_open']:'' }}">
                        
                       
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " readonly="true" name="sun_out" id="sun_out" type="text" data-rule-required="true" value="{{ isset($time['sun_close'])?$time['sun_close']:'00:00' }}">
                    </div>
                </div>
                 @endif
            </div>
            @endforeach
            <hr/>

             <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Payment Modes <i class="red"></i> </label>
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
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Business Company Details </b></h4>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="company_info">Company Info<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" readonly="true"
                           name="company_info"
                           id="company_info"
                           data-rule-required="true"
                           placeholder="Enter Company Info"
                           >{{ isset($business['company_info'])? strip_tags($business['company_info']):'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('company_info') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="keywords">Keywords<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="keywords" readonly="true"
                           id="keywords"
                           data-rule-required="true"
                           placeholder="Enter Keywords"
                           >{{ isset($business['keywords'])? strip_tags($business['keywords']):'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('keywords') }}</span>
                </div>
            </div>
           <!--  <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="youtube_link">Youtube Link<i class="red"></i></label>
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
            </div> -->
            <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Business Services  <i class="red"></i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                                @if(sizeof($business['service'])>0)
                                 @foreach($business['service'] as $service)

                                  <div class="fileupload-new img-thumbnail main" style="width: 300px; height: 45px;" data-service="{{ $service['name'] }}">
                                     <input class="form-control" type="text" name="service" id="service" class="pimg"  value="{{ $service['name']}}" readonly="true"/>
                                  </div>
                                   <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 100px; line-height: 20px;"></div>

                                  @endforeach
                                   @else
                                  <label>No Business Services Available</label>
                                  @endif
                    <div class="error" id="err_delete_service"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Business Membership Details </b></h4>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="youtube_link">Assign Membership <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
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
                    {?>
                      <a href="{{ url('/sales_user/business_listing/assign_membership').'/'.base64_encode($business['id']).'/'.base64_encode($user_id).'/'.base64_encode($category_id) }}" class="show-tooltip" title="Assign Membership">
                          <i class="fa fa-" > Click Here to Assign</i>
                        </a>
                        <?php }
                        else
                          {?>
                              <div style="color: Green;">Assigned</div>
                           <?php }?>
                </div>
                </div>
                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="youtube_link">Membership Status<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                   <?php

                  if(sizeof($business['membership_plan_details']  )>0)
                    {
                     // $date1 = date('Y-m-d',strtotime($business['membership_plan_details'][0]['expire_date']));

                      $expire_date = new \Carbon($business['membership_plan_details'][0]['expire_date']);
                        $now = Carbon::now();
                        $difference = ($expire_date->diff($now)->days < 1)
                            ? 'today'
                            : $expire_date->diffForHumans($now);
                           
                        if (strpos($difference, 'after') !== false || strpos($difference, 'today') !== false) 
                        {
                      
                          if($difference=='today')
                          {
                           echo "<div style='color: Green;'>Active only for ".$difference;
                          }
                          else
                          {
                            echo "<div style='color: Green;'>".$difference. "  Membership plan get expired";
                          }
                        }
                        else
                        {
                          echo "<div style='color: red;'>Expired</div>";
                        }


                    }
                     else
                    {
                      echo "<div >NA</div>";
                    }



                     ?>
                </div>
            </div>
              <hr/>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Business Reviews Details </b></h4>
                </div>
            </div>
          
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="youtube_link">Business Reviews <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    
                     @if( sizeof($business['reviews'])>0)
                      <a href="{{ url('sales_user/reviews/'.base64_encode($business['id'])) }}"> ( {{ sizeof($business['reviews']) }} ) </a>
                      @else
                       <a href="#"> ( {{ sizeof($business['reviews']) }} ) </a>
                       @endif
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