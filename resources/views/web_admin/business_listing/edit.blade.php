    @extends('web_admin.template.admin')


    @section('main_content')
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>

        </div>
    </div>
    <!-- END Page Title -->

{{-- dd($arr_category) --}}
    <!-- BEGIN Breadcrumb -->
    <div id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/').'/web_admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-user"></i>
                <a href="{{ url('/').'/web_admin/business_listing' }}">Business Listing</a>
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
              action="{{ url('/web_admin/business_listing/update/'.base64_encode($business['id'])) }} "
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
                           value="admin"
                           readonly="true"
                           />
                    <span class='help-block'>{{ $errors->first('business_added_by') }}</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="user_id">Select User<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <select class="form-control"  name="user_id" id="user_id">
                <option value="">Select User</option>
                 @if(isset($arr_user) && sizeof($arr_user)>0)
                 @foreach($arr_user as $user)
                 <option value="{{ isset($user['id'])?$user['id']:'' }}" {{ $user['id']==$business['user_id']?'selected=selected':'' }}>{{ isset($user['email'] )?$user['email']:'' }}
                 </option>
                  @endforeach
                  @endif
                  </select>
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
                           value="{{ isset($business['business_name'])?$business['business_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('business_name') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_cat">Business Category <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <select class="form-control" name="business_cat[]" id="business_cat" onchange="updateCategoryOptGroup(this)" multiple="">
                     <option> Select Business Category</option>
                      @if(isset($arr_category) && sizeof($arr_category)>0)
                        @foreach($arr_category as $category)
                          @if($category['parent'] =='0')
                            <optgroup label="{{ $category['title'] }}" >

                                  @foreach($arr_category as $subcategory)
                                    @if( $subcategory['parent']==$category['cat_id'])
                                  <?php
                                    $arr_selected=array();
                                    foreach($business['category'] as $sel_category)
                                    {
                                       array_push($arr_selected,$sel_category['category_id']);
                                    }
                                  ?>
                                  <option  name="sub_cat" id="sub_cat" value="{{ $subcategory['cat_id'] }}"
                                    <?php if(in_array($subcategory['cat_id'],$arr_selected)){ echo 'selected="selected"'; }?> >
                                    <!--  <input type="checkbox" name="main_cat" id="main_cat" value="{{-- $subcategory['cat_id'] --}}"> -->
                                    {{ $subcategory['title'] }}
                                    </option>
                                  <!-- </option  name="sub_cat" id="sub_cat"> -->
                                    @endif
                                 @endforeach

                            </optgroup>
                          @endif
                        @endforeach
                      @endif
                  </select><a href="javascript:void(0);" onclick="clearCategoryOptGroup(this)">Clear Selected Option</a>
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
                                  <div>
                                     <span class="btn btn-default btn-file"><span class="fileupload-new" >Select image</span>
                                     <span class="fileupload-exists">Change</span>
                                     <input type="file" class="file-input" name="main_image" id="main_image"/>
                                      <input type="hidden" class="file-input" name="old_image" id="main_image" value="{{$business['main_image']}}"/>
                                      </span>
                                     <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

                                     <span  >

                                     </span>

                                  </div>
                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                                 <!--<br/>
                                 <button class="btn btn-warning" onclick="return show_more_images()" id="show_more_images_button">Do you want to add slider images ? </button>  -->
                            </div>
                         </div>
                          <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Uploded Image <i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                                 @foreach($business['image_upload_details'] as $image)

                                  <div class="fileupload-new img-thumbnail main" style="width: 200px; height: 150px;" data-image="{{ $image['image_name'] }}">
                                     <img style="width:150px;height:122px"
                                      src={{ $business_base_upload_img_path.$image['image_name']}} alt="" />
                                     <div class="caption">
                                     <p class="pull-left">
                                        <a href="javascript:void(0);"class="delete_image" data-image="{{ $image['image_name'] }}" onclick="javascript: return delete_gallery('<?php echo $image['id'] ;?>','<?php echo $image['image_name'];?>')">
                                         <span class="glyphicon glyphicon-minus-sign " style="font-size: 20px;"></span></a>
                                     </p>
                                    </div>
                                  </div>
                              <!--     <a href="javascript:void(0);" onclick="javascript: return delete_gallery($image['business_id'],$image['image_name'],$business['id'])">
                                     <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span></a> -->
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                  @endforeach
                    <div class="error" id="err_delete_image"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
                         <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" for="building">
                           <a href="" class="add_more">Add More Image</a></label>
                         </div>
                          <div class="form-group add_more_image" style="display: none;">
                          <div class="col-sm-5 col-md-7" style="float:right;">
                             <a href="javascript:void(0);" id='add-image'>
                                 <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></span>
                             </a>
                            <span style="margin-left:05px;">
                            <a href="javascript:void(0);" id='remove-image'>
                                <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
                            </a>
                            </span>
                           </div>
                              <label class="col-sm-3 col-lg-2 control-label">Add More Business Images <i class="red">*</i> </label>
                              <div class="col-sm-6 col-lg-4 controls">

                              <input type="file" name="business_image[]" id="business_image" class="pimg"   />
                              <div class="error" id="error_business_image">{{ $errors->first('business_image') }}</div>

                              <div class="clr"></div><br/>
                                <div class="error" id="error_set_default"></div>
                                <div class="clr"></div>

                             <div id="append" class="class-add"></div>
                              <div class="error_msg" id="error_business_image" ></div>
                              <div class="error_msg" id="error_business_image1" ></div>
                             <label class="col-sm-3 col-lg-2 control-label"></label>

                              </div>
                              </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="building">Building<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
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
                    <input class="form-control"
                           name="street"
                           id="street"
                           data-rule-required="true"
                           placeholder="Enter Street"
                           value="{{ isset($business['street'])?$business['street']:'' }}"
                           onchange="setAddress()" />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="landmark">landmark <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
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
                    <input class="form-control"
                           name="area"
                           id="area"
                           data-rule-required="true"
                           placeholder="Enter Area"
                           value="{{ isset($business['area'])?$business['area']:'' }}"
                          onchange="setAddress()"
                           />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">City <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control"  name="city" id="city" onchange="setAddress()">
                 @if(isset($arr_city) && sizeof($arr_city)>0)
                   @foreach($arr_city as $city)
                <option value="{{ isset($city['id'])?$city['id']:'' }}" {{ $business['city']==$city['id']?'selected="selected"':'' }}>{{ isset($city['city_title'])?$city['city_title']:'' }}
                </option>
                @endforeach
                @endif
                </select>
                  <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="pincode">Zipcode <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <select class="form-control"  name="pincode" id="pincode">
                 @if(isset($arr_zipcode) && sizeof($arr_zipcode)>0)
                   @foreach($arr_zipcode as $zipcode)
                <option value="{{ isset($zipcode['id'])?$zipcode['id']:'' }}" {{ $business['pincode']==$zipcode['id']?'selected="selected"':'' }}>{{ isset($zipcode['zipcode'])?$zipcode['zipcode']:'' }}
                </option>
                @endforeach
                @endif
                </select>
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">State <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control"  name="state" id="state" onchange="setAddress()">
                 @if(isset($arr_state) && sizeof($arr_state)>0)
                   @foreach($arr_state as $state)
                <option value="{{ isset($state['id'])?$state['id']:'' }}" {{ $business['state']==$state['id']?'selected="selected"':'' }}>{{ isset($state['state_title'])?$state['state_title']:'' }}
                </option>
                @endforeach
                @endif
                </select>
                 <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">Country <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <select class="form-control" name="country" id="country" onchange="setAddress()">
                 @if(isset($arr_country) && sizeof($arr_country)>0)
                   @foreach($arr_country as $country)
                <option value="{{ isset($country['id'])?$country['id']:'' }}" {{ $business['country']==$country['id']?'selected="selected"':'' }}>{{ isset($country['country_name'])?$country['country_name']:'' }}
                </option>
                @endforeach
                 @endif
                </select>
                   <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="contact_person_name">Contact Person Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
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
                    <input class="form-control"
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
                    <input class="form-control"
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
                    <input class="form-control"
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
                    <input class="form-control"
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
                    <input class="form-control"
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
                    <input class="form-control"
                           name="website"
                           id="website"
                           data-rule-required="true"
                           placeholder="Enter Website"
                           value="{{ isset($business['website'])?$business['website']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('website') }}</span>
                </div>
            </div>




            <!-- <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="hours_of_operation">Hours Of Operation<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="hours_of_operation"
                           id="hours_of_operation"
                           data-rule-required="true"
                           placeholder="Enter Hours Of Operation"
                            >{{ isset($business['hours_of_operation'])?$business['hours_of_operation']:'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('hours_of_operation') }}</span>
                </div>
            </div> -->

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="map_location">Map Location<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="hidden" name="lat" value="{{ isset($business['lat'])?$business['lat']:'' }}" id="lat" />
                    <input type="hidden" name="lng" value="{{ isset($business['lng'])?$business['lng']:'' }}" id="lng"/>

                    <div id="business_location_map" style="height:400px"></div>
                    <label>Note: Click On the Map to Pick Nearby Custom Location </label>
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
                        <input class="form-control timepicker-default" name="mon_in" id="mon_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['mon_open'])?$business['business_times']['mon_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="mon_out" id="mon_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['mon_close'])?$business['business_times']['mon_close']:'' }}">
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
                        <input class="form-control timepicker-default" name="tue_in" id="tue_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['tue_open'])?$business['business_times']['tue_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="tue_out" id="tue_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['tue_close'])?$business['business_times']['tue_close']:'' }}">
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
                        <input class="form-control timepicker-default" name="wed_in" id="wed_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['wed_open'])?$business['business_times']['wed_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="wed_out" id="wed_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['wed_close'])?$business['business_times']['wed_close']:'' }}">
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
                        <input class="form-control timepicker-default" name="thus_in" id="thus_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['thus_open'])?$business['business_times']['thus_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="thus_out" id="thus_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['thus_close'])?$business['business_times']['thus_close']:'' }}">
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
                        <input class="form-control timepicker-default" name="fri_in" id="fri_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['fri_open'])?$business['business_times']['fri_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="fri_out" id="fri_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['fri_close'])?$business['business_times']['fri_close']:'' }}">
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
                        <input class="form-control timepicker-default" name="sat_in" id="sat_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sat_open'])?$business['business_times']['sat_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="sat_out" id="sat_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sat_close'])?$business['business_times']['sat_close']:'' }}">
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
                        <input class="form-control timepicker-default" name="sun_in" id="sun_in" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sun_open'])?$business['business_times']['sun_open']:'' }}">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="sun_out" id="sun_out" type="text" data-rule-required="true" value="{{ isset($business['business_times']['sun_close'])?$business['business_times']['sun_close']:'' }}">
                    </div>
                </div>

            </div>

            <hr/>
            <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Payment Mode  <i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                                 @foreach($business['payment_mode'] as $payment_mode)

                                  <div class="fileupload-new img-thumbnail main" style="width: 300px; height: 62px;" data-payment-mode="{{ $payment_mode['title'] }}">
                                     <input class="form-control" type="text" name="payment_mode" id="payment_mode" class="pimg"  value="{{ $payment_mode['title']}}" />
                                     <div class="caption">
                                     <p class="pull-left">
                                        <a href="javascript:void(0);"class="delete_payment_mode" data-payment-mode="{{ $payment_mode['title'] }}" onclick="javascript: return delete_payment_mode('<?php echo $payment_mode['id'] ;?>')">
                                         <span class="glyphicon glyphicon-minus-sign " style="font-size: 20px;"></span></a>
                                     </p>
                                    </div>
                                  </div>
                              <!--     <a href="javascript:void(0);" onclick="javascript: return delete_gallery($image['business_id'],$image['image_name'],$business['id'])">
                                     <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span></a> -->
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                  @endforeach
                    <div class="error" id="err_delete_payment_mode"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
                         <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" for="building">
                           <a href="" class="add_payment_mode">Add More Payment Mode</a></label>
                         </div>
                         <div class="form-group add_more_payment_mode" style="display: none;">
                          <div class="col-sm-5 col-md-7" style="float:right;">
                             <a href="javascript:void(0);" id='add-payment'>
                                 <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></span>
                             </a>
                            <span style="margin-left:05px;">
                            <a href="javascript:void(0);" id='remove-payment'>
                                <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
                            </a>
                            </span>
                           </div>
                              <label class="col-sm-3 col-lg-2 control-label"> Payment Mode <i class="red">*</i> </label>
                              <div class="col-sm-6 col-lg-4 controls">

                              <input type="text" name="payment_mode[]" id="payment_mode" class="form-control"  />
                              <div class="error" id="error_payment_mode">{{ $errors->first('payment_mode') }}</div>

                              <div class="clr"></div><br/>
                                <div class="error" id="error_set_default"></div>
                                <div class="clr"></div>

                             <div id="append_payment" class="class-add"></div>
                              <div class="error_msg" id="error_payment_mode" ></div>
                              <div class="error_msg" id="error_payment_mode1" ></div>
                             <label class="col-sm-3 col-lg-2 control-label"></label>

                              </div>
                              </div>
           <hr/>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="company_info">Company Info<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="company_info"
                           id="company_info"
                           data-rule-required="true"
                           placeholder="Enter Company Info"
                           >{{ isset($business['company_info'])?$business['company_info']:'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('company_info') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="establish_year">Establish Year<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="text" class="form-control"
                           name="establish_year"
                           id="establish_year"
                           data-rule-required="true"
                           data-rule-number="true"
                           data-rule-minlength="0"
                           placeholder="Enter Establish Year"
                          value="{{ isset($business['establish_year'])?$business['establish_year']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('establish_year') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="keywords">Keywords<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="keywords"
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
                    <input class="form-control"
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

                                  <div class="fileupload-new img-thumbnail main" style="width: 300px; height: 62px;" data-service="{{ $service['name'] }}">
                                     <input class="form-control" type="text" name="service" id="service" class="pimg"  value="{{ $service['name']}}" />
                                     <div class="caption">
                                     <p class="pull-left">
                                        <a href="javascript:void(0);"class="delete_service" data-service="{{ $service['name'] }}" onclick="javascript: return delete_service('<?php echo $service['id'] ;?>')">
                                         <span class="glyphicon glyphicon-minus-sign " style="font-size: 20px;"></span></a>
                                     </p>
                                    </div>
                                  </div>
                              <!--     <a href="javascript:void(0);" onclick="javascript: return delete_gallery($image['business_id'],$image['image_name'],$business['id'])">
                                     <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span></a> -->
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                  @endforeach
                    <div class="error" id="err_delete_service"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
            <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" for="building">
                           <a href="" class="add_serc">Add Services</a></label>
                         </div>
                          <div class="form-group add_more_service" style="display: none;">
                          <div class="col-sm-5 col-md-7" style="float:right;">
                             <a href="javascript:void(0);" id='add-service'>
                                 <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></span>
                             </a>
                            <span style="margin-left:05px;">
                            <a href="javascript:void(0);" id='remove-service'>
                                <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
                            </a>
                            </span>
                           </div>
                              <label class="col-sm-3 col-lg-2 control-label">Add More Business Services <i class="red">*</i> </label>
                              <div class="col-sm-6 col-lg-4 controls">

                              <input class="form-control" type="text" name="business_service[]" id="business_service" class="pimg"   />
                              <div class="error" id="error_business_service">{{ $errors->first('business_service') }}</div>

                              <div class="clr"></div><br/>
                                <div class="error" id="error_set_default"></div>
                                <div class="clr"></div>

                             <div id="append_service" class="class-add"></div>
                              <div class="error_msg" id="error_business_image" ></div>
                              <div class="error_msg" id="error_business_image1" ></div>
                             <label class="col-sm-3 col-lg-2 control-label"></label>

                              </div>
                              </div>



            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update">

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


function delete_gallery(id,image_name)
{
  var _token = $('input[name=_token]').val();
  var dataString = { id:id, image_name:image_name, _token: _token };
  var url_delete= site_url+'/web_admin/business_listing/delete_gallery';
  $.post( url_delete, dataString)
      .done(function( data ) {
        if(data=='done'){
             $('#err_delete_image').html('<div style="color:green">Product deleted successfully.</div>');
             var request_id=$('.delete_image').parents('.main').attr('data-image');
             $('div[data-image="'+request_id+'"]').remove();
        }
      });
}
function delete_service(id)
{
  var _token = $('input[name=_token]').val();
  var dataString = { id:id, _token: _token };
  var url_delete= site_url+'/web_admin/business_listing/delete_service';
  $.post( url_delete, dataString)
      .done(function( data ) {
        if(data=='done'){
             $('#err_delete_service').html('<div style="color:green">Service deleted successfully.</div>');
             var request_id=$('.delete_service').parents('.main').attr('data-service');
             $('div[data-service="'+request_id+'"]').remove();
        }
      });
}
function delete_payment_mode(id)
{
  var _token = $('input[name=_token]').val();
  var dataString = { id:id, _token: _token };
  var url_delete= site_url+'/web_admin/business_listing/delete_payment_mode';
  $.post( url_delete, dataString)
      .done(function( data ) {
        if(data=='done'){
             $('#err_delete_payment_mode').html('<div style="color:green">Payment Mode deleted successfully.</div>');
             var request_id=$('.delete_payment_mode').parents('.main').attr('data-payment-mode');
             $('div[data-payment-mode="'+request_id+'"]').remove();
        }
      });
}

$('#add-image').click(function()
{
   flag=1;

            var img_val = jQuery("input[name='business_image[]']:last").val();

            var img_length = jQuery("input[name='business_image[]']").length;

            if(img_val == "")
            {
                  $('#error_business_image').css('margin-left','120px');
                  $('#error_business_image').show();
                  $('#error_business_image').fadeIn(3000);
                  document.getElementById('error_business_image').innerHTML="The Image uploaded is required.";
                  setTimeout(function(){
                  $('#error_business_image').fadeOut(4000);
                  },3000);

                 flag=0;
                 return false;
            }
            var chkimg = img_val.split(".");
             var extension = chkimg[1];

               if(extension!='jpg' && extension!='JPG' && extension!='png' && extension!='PNG' && extension!='jpeg' && extension!='JPEG'
                 && extension!='gif' && extension!='GIF')
               {
                 $('#error_business_image1').css('margin-left','230px')
                 $('#error_business_image1').show();
                 $('#error_business_image1').fadeIn(3000);
                 document.getElementById('error_business_image1').innerHTML="The file type you are attempting to upload is not allowed.";
                 setTimeout(function(){
                  $('#business_image').css('border-color','#dddfe0');
                  $('#error_business_image1').fadeOut(4000);
               },3000);
               flag=0;
                return false;
              }
              var html='<div>'+
                       '<input type="file" name="business_image[]" id="business_image" class="pimg" data-rule-required="true"  />'+
                       '<div class="error" id="error_business_image">{{ $errors->first("business_image") }}</div>'+
                       '</div>'+
                       '<div class="clr"></div><br/>'+
                       '<div class="error" id="error_set_default"></div>'+
                       '<div class="clr"></div>';
                  jQuery("#append").append(html);

});
$('#remove-image').click(function()
{
     var html= $("#append").find("input[name='business_image[]']:last");
     html.remove();
            });
     $('.add_more').click(function(){
     $(".add_more_image").removeAttr("style");
     return false;
});

function updateCategoryOptGroup(ref)
{
  var arr_optgroup_ref = $(ref).find('optgroup');
  var current_option_grp =$(ref).find("option:selected").parent('optgroup');

  $.each(arr_optgroup_ref,function(index,optgroup)
  {
    if($(optgroup).attr('label')!=$(current_option_grp).attr('label'))
    {
      $(optgroup).attr('disabled','disabled');
    }
    else
    {
      $(optgroup).removeAttr('disabled');
    }


  });

}
function clearCategoryOptGroup()
{
  var arr_optgroup_ref = $('#business_cat').find('optgroup');
    $.each(arr_optgroup_ref,function(index,optgroup)
  {
          $(optgroup).removeAttr('disabled');

  });
}
//Services
$('.add_serc').click(function()
{
      $(".add_more_service").removeAttr("style");
      return false;
});
$('#add-service').click(function()
{
  flag=1;

            var img_val = jQuery("input[name='business_service[]']:last").val();

            var img_length = jQuery("input[name='business_service[]']").length;

            if(img_val == "")
            {
                  $('#error_business_service').css('margin-left','120px');
                  $('#error_business_service').show();
                  $('#error_business_service').fadeIn(3000);
                  document.getElementById('error_business_service').innerHTML="The Services is required.";
                  setTimeout(function(){
                  $('#error_business_service').fadeOut(4000);
                  },3000);

                 flag=0;
                 return false;
            }

              var service_html='<div>'+
                       '<input type="text" class="form-control" name="business_service[]" id="business_service" class="pimg" data-rule-required="true"  />'+
                       '<div class="error" id="error_business_image">{{ $errors->first("business_service") }}</div>'+
                       '</div>'+
                       '<div class="clr"></div><br/>'+
                       '<div class="error" id="error_set_default"></div>'+
                       '<div class="clr"></div>';
                  jQuery("#append_service").append(service_html);

});
$('#remove-service').click(function()
{
     var html= $("#append_service").find("input[name='business_service[]']:last");
     html.remove();
});
//Payment Modes
$('.add_payment_mode').click(function()
{
      $(".add_more_payment_mode").removeAttr("style");
      return false;
});
$('#add-payment').click(function()
{
  flag=1;

            var img_val = jQuery("input[name='payment_mode[]']:last").val();

            var img_length = jQuery("input[name='payment_mode[]']").length;

            if(img_val == "")
            {
                  $('#error_payment_mode').css('margin-left','120px');
                  $('#error_payment_mode').show();
                  $('#error_payment_mode').fadeIn(3000);
                  document.getElementById('error_payment_mode').innerHTML="The Payment Mode is required.";
                  setTimeout(function(){
                  $('#error_payment_mode').fadeOut(4000);
                  },3000);

                 flag=0;
                 return false;
            }

              var payment_html='<div>'+
                       '<input type="text" class="form-control" name="payment_mode[]" id="payment_mode" class="" data-rule-required="true"  />'+
                       '<div class="error" id="error_payment_mode">{{ $errors->first("payment_mode") }}</div>'+
                       '</div>'+
                       '<div class="clr"></div><br/>'+
                       '<div class="error" id="error_set_default"></div>'+
                       '<div class="clr"></div>';
                  jQuery("#append_payment").append(payment_html);

});
$('#remove-payment').click(function()
{
    var html= $("#append_payment").find("input[name='payment_mode[]']:last");
     html.remove();
});
</script>

<script type="text/javascript">

    var  map;
    var ref_input_lat = $('#lat');
    var ref_input_lng = $('#lng');

    function setMapLocation(address)
    {

        geocoder.geocode({'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {

                map.setCenter(results[0].geometry.location);

                $(ref_input_lat).val(results[0].geometry.location.lat().toFixed(6));
                $(ref_input_lng).val(results[0].geometry.location.lng().toFixed(6));

                var latlong = "(" + results[0].geometry.location.lat().toFixed(6) + ", " +
                        +results[0].geometry.location.lng().toFixed(6)+ ")";



                marker.setPosition(results[0].geometry.location);
                map.setZoom(16);
                infowindow.setContent(results[0].formatted_address);

                if (infowindow) {
                    infowindow.close();
                }

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });

                infowindow.open(map, marker);

            } else {
                alert("Lat and long cannot be found.");
            }
        });
    }
    function initializeMap()
    {
         var latlng = new google.maps.LatLng($(ref_input_lat).val(), $(ref_input_lng).val());
         var myOptions = {
             zoom: 18,
             center: latlng,
             panControl: true,
             scrollwheel: true,
             scaleControl: true,
             overviewMapControl: true,
             disableDoubleClickZoom: false,
             overviewMapControlOptions: {
                 opened: true
             },
             mapTypeId: google.maps.MapTypeId.HYBRID
         };
         map = new google.maps.Map(document.getElementById("business_location_map"),
             myOptions);
         geocoder = new google.maps.Geocoder();
         marker = new google.maps.Marker({
             position: latlng,
             map: map
         });

         map.streetViewControl = false;
         infowindow = new google.maps.InfoWindow({
             content: "("+$(ref_input_lat).val()+", "+$(ref_input_lng).val()+")"
         });

         google.maps.event.addListener(map, 'click', function(event) {
             marker.setPosition(event.latLng);

             var yeri = event.latLng;

             var latlongi = "(" + yeri.lat().toFixed(6) + ", " + yeri.lng().toFixed(6) + ")";

             infowindow.setContent(latlongi);

             $(ref_input_lat).val(yeri.lat().toFixed(6));
             $(ref_input_lng).val(yeri.lng().toFixed(6));

         });

         google.maps.event.addListener(map, 'mousewheel', function(event, delta) {

             console.log(delta);
         });


     }

    function loadScript()
    {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&' +
                    'callback=initializeMap';
            document.body.appendChild(script);
    }

    window.onload = loadScript;

    /* Autcomplete Code */

    function setMarkerTo(lat,lon,place)
    {
        var location = new google.maps.LatLng(lat,lng)
        map.setCenter(location);
        $(ref_input_lat).val = lat;
        $(ref_input_lng).val = lng;
        marker.setPosition(location);
        map.setZoom(16);
    }

    function setAddress()
    {
        var street = $('#street').val();
         var area = $('#area').val();
         var city = $('#city option:selected').text();
         var state = $('#state option:selected').text();
         var country = $('#country option:selected').text();

        var addr = street+", "+area+", "+city+", "+state+", "+country;

        setMapLocation(addr);
    }

 /*   $('#street').onchange(function (){
      setAddress()
    });*/

</script>
@stop