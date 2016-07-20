    @extends('web_admin.template.admin')
    @section('main_content')
    <style type="text/css">
  .error_msg .error_business_image{
    color:red;
  }
</style>
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
                <a href="{{ url('/').'/web_admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-list"></i>
                <a href="{{ url('/web_admin/business_listing') }}">Business  Listing</a>
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

        <form class="form-horizontal"
              id="validation-form"
              method="POST"
              action="{{ url('/web_admin/business_listing/store/') }}"
              enctype="multipart/form-data"
              onsubmit="return checkOpeningHours()"
              >

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
                <label class="col-sm-3 col-lg-2 control-label" for="user_id">Select User Unique Public Id<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <input class="form-control"
                           name="user_id"
                           id="user_id" 
                           data-rule-required="true"
                           placeholder="Enter User Public ID"
                           value="RNT"
                           />
                  <input type="hidden" data-rule-required="true" name="tmp_user_id" id="tmp_user_id">

                    <span class='help-block'>{{ $errors->first('user_id') }}</span>
                     <div class="alert alert-warning">Note: Auto Complete the User Public Id field by typing prefix RNT </div>
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
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('business_name') }}</span>
                </div>
            </div>
              <input type="hidden" name="business_public_id" id="business_public_id">
             <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="main_business_cat">Business Main Category <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls">
            <select class="form-control" data-rule-required="true" name="main_business_cat" id="main_business_cat"  onchange="getSubCategory(this)">
              <option> Select Business Main Categories</option>
             @if(isset($arr_category) && sizeof($arr_category)>0)
             @foreach($arr_category as $category)
              <option  name="sub_cat" id="sub_cat" value="{{ $category['cat_id'] }}" >
                             {{ $category['title'] }}
                              </option>
              @endforeach
               @endif
            </select>
            </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="main_business_cat">Business  Sub Category <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls" id="sub_category_div" name="sub_category_div" style="">
            <select class="form-control" id="example-getting-started" data-rule-required="true" name="business_cat[]" multiple="multiple">
            <option value="">Select Business Sub Category </option>
               <!--   <option value="tomatoes">Tomatoes</option>
                  <option value="mozarella">Mozzarella</option>
                  <option value="mushrooms">Mushrooms</option>
                  <option value="pepperoni">Pepperoni</option>
                  <option value="onions">Onions</option> -->
              </select>
              <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                <div class="alert alert-warning">Note: Firstly Select The Business Main category From Business Main Category Drop-down , Then Click ON None Selected Button  </div>

            </div>
            </div>
             <hr/>
                      <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" ></label>
                          <div class="col-sm-3 col-lg-3 controls">
                              <h4><b>Business Gallery </b></h4>
                          </div>
                      </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Business Main Banner Image <i class="red">*</i> </label>
                <div class="col-sm-9 col-lg-10 controls">
                   <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">

                      </div>
                      <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                         <span class="btn btn-default btn-file"><span class="fileupload-new" >Select image</span>

                         <span class="fileupload-exists">Change</span>
                         <input type="file" class="file-input" data-rule-required="true" name="main_image" id="ad_image"/></span>
                         <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

                         <span  >

                         </span>

                      </div>

                   </div>
                   <div class="col-sm-6 col-lg-4 controls alert alert-warning">Note: Attached Image Size With Width 517px and Height 361px upto only</div>
                    <span class='help-block'>{{ $errors->first('main_image') }}</span>
                     <!--<br/>
                     <button class="btn btn-warning" onclick="return show_more_images()" id="show_more_images_button">Do you want to add slider images ? </button>  -->
                </div>
             </div>
            <div class="form-group">
            <div class="col-sm-5 col-md-7" style="float:right;">
               <a href="javascript:void(0);" id='add-image'>
                   <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;" class="show-tooltip" title="Add More images"></span>
               </a>
              <span style="margin-left:05px;">
              <a href="javascript:void(0);" id='remove-image'>
                  <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;" class="show-tooltip" title="Remove last selected  images"></span>
              </a>
              </span>
             </div>

                <label class="col-sm-3 col-lg-2 control-label">Upload Business Gallery Images <i class="red">*</i> </label>
                <div class="col-sm-6 col-lg-4 controls">

                <input type="file" name="business_image[]" id="business_image" class="pimg" data-rule-required="true"  />
                <div class="error" id="error_business_image">{{ $errors->first('business_image') }}</div>

                <div class="clr"></div><br/>
                  <div class="error" id="error_set_default"></div>
                  <div class="clr"></div>

               <div id="append" class="class-add"></div>
                <div class="error_msg" id="error_business_image" ></div>
                <div class="error_msg" id="error_business_image1" ></div>
               <label class="col-sm-6 col-lg-12 controls alert alert-warning">Note: Attached Image Size With Width 517px and Height 361px upto only</label>

                </div>

                </div>

                 <hr/>
                      <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" ></label>
                          <div class="col-sm-3 col-lg-3 controls">
                              <h4><b>Business Location</b></h4>
                          </div>
                      </div>
                <div class="row">
                <div class="col-md-6 ">


                <div class="form-group">
                <label class="col-sm-3 col-lg-4 control-label" for="area">Area <i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                    <input class="form-control"
                           name="area"
                           id="area"
                           data-rule-required="true"
                           placeholder="Enter Area"
                           value=""

                           />
                    <span class='help-block'>{{ $errors->first('area') }}</span>
                </div>
                </div>




            <div class="geo-details">
             <div class="form-group">
                <label class="col-sm-3 col-lg-4 control-label" for="country">Country <i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                <input type="text" data-rule-required="true" data-geo="country" value="" id="country" name="country" class="form-control">
                   <span class='help-block'>{{ $errors->first('country') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-4 control-label" for="state">State <i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                <input type="text" data-rule-required="true" data-geo="administrative_area_level_1" value="" id="state" name="state" class="form-control">
                  <span class='help-block'>{{ $errors->first('state') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-4 control-label" for="city">City <i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                 <input type="text" data-rule-required="true" data-geo="administrative_area_level_2" value="" id="city" name="city" class="form-control">
                  <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>

            <div class="form-group" ><!-- style="display:none;" -->
                <label class="col-sm-3 col-lg-4 control-label" for="lat">Latitude <i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                 <input type="text" data-rule-required="true" data-geo="lat" value="" id="lat" name="lat" class="form-control">
                  <span class='help-block'>{{ $errors->first('lat') }}</span>
                </div>
            </div>
            <div class="form-group" ><!-- style="display:none;" -->
                <label class="col-sm-3 col-lg-4 control-label" for="lng">Longitude <i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                 <input type="text" data-rule-required="true" data-geo="lng" value="" id="lng" name="lng" class="form-control">
                  <span class='help-block'>{{ $errors->first('lng') }}</span>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-3 col-lg-4 control-label" for="postal_code">Pin-code <i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                 <input type="text" data-rule-required="true" data-geo="postal_code" value="" id="pincode" name="pincode" class="form-control">
                  <span class='help-block'>{{ $errors->first('postal code') }}</span>
                </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 ">
             <div class="form-group">
                <label class="col-md-3 col-lg-2 control-label" for="map_location">Map Location<i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                   <div id="business_location_map" style="height:400px"></div>

                    <label>Note: Click On the Map to Pick Nearby Custom Location </label>
                    <div>
                    <a id="reset" href="#" style="display:none;">Reset Marker</a></div>
                </div></div>
        </div>
        </div>

         <div class="form-group">
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="contact_person_name">Contact Person Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="contact_person_name"
                           id="contact_person_name"
                           data-rule-required="true"
                           placeholder="Enter Contact Person Name"
                           value=""
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
                           data-rule-number="true"   data-rule-minlength="10" maxlength="10"
                           placeholder="Enter Mobile Number"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('mobile_number') }}</span>
                </div>
            </div>
           <!--  <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="landline_number">Landline Number <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="landline_number"
                           id="landline_number"
                           data-rule-required=""
                           placeholder="Enter Landline Number"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('landline_number') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="fax_no">Fax No <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="fax_no"
                           id="fax_no"
                           data-rule-required=""
                           placeholder="Enter Fax No"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('fax_no') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="toll_free_number">Toll Free Number<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="toll_free_number"
                           id="toll_free_number"
                           data-rule-required=""
                           placeholder="Enter Toll Free Number"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('toll_free_number') }}</span>
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Email Id <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="email_id"
                           id="email_id"
                           data-rule-required=""
                           data-rule-email=""
                           placeholder="Enter Email Id"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('email_id') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="website">Website <i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="website"
                           id="website"
                           data-rule-required=""
                           placeholder="Enter Website"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('website') }}</span>
                </div>
            </div>
 -->




            <hr/>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Opening Hours</b></h4>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Monday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="mon_in" id="mon_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="mon_out" id="mon_out" type="text" data-rule-required="true">
                    </div>
                </div>
                    <span id="mon_span" style="display:none!important;color:red!important;">Please enter valid Opening hours for Monday</span> 

            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Tuesday<i class="red">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="tue_in" id="tue_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="tue_out" id="tue_out" type="text" data-rule-required="true">
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
                        <input class="form-control timepicker-default" name="wed_in" id="wed_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="wed_out" id="wed_out" type="text" data-rule-required="true">
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
                        <input class="form-control timepicker-default" name="thus_in" id="thus_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="thus_out" id="thus_out" type="text" data-rule-required="true">
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
                        <input class="form-control timepicker-default" name="fri_in" id="fri_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="fri_out" id="fri_out" type="text" data-rule-required="true">
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
                        <input class="form-control timepicker-default" name="sat_in" id="sat_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="sat_out" id="sat_out" type="text" data-rule-required="true">
                    </div>
                </div>

            </div>


            <div class="form-group" style="display:block;">
                 <label class="col-sm-3 col-lg-2 control-label" >Sunday<i class="red">*</i></label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio"  name="is_sunday" value="1" onclick="sunday_status('on');"  />
                  <label >On </label>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <input type="radio"  name="is_sunday" value="0"  onclick="sunday_status('off');" checked=""/>
                  <label  for="is_sunday">Off </label>
                  <br/>
            </div>

              <div class="form-group" id="sunday_section" style="display:none;">
               <label class="col-sm-3 col-lg-2 control-label" ></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control  " name="sun_in" id="sun_in" type="text"  >
                    </div>
                </div>

                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " name="sun_out" id="sun_out" type="text" >
                    </div>
                </div>

            </div>
             <hr/>
                      <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" ></label>
                          <div class="col-sm-3 col-lg-3 controls">
                              <h4><b>Business Services</b></h4>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" for="building">
                          <a href="" class="add_serc">Click Here To Add Services</a></label>
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
                              <div class="error_msg" id="error_business_service" ></div>
                              <!-- <div class="error_msg" id="error_business_image1" ></div> -->
                             <label class="col-sm-3 col-lg-2 control-label"></label>

                            </div>
                        </div>

            <hr/>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" ></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <h4><b>Payment Modes</b></h4>
                </div>
            </div>
              <div class="form-group">
               
                <div class="col-sm-3 col-lg-3 controls" style="margin-left: 51px;">
                    <input type="checkbox"  name="payment_mode[]" value="Cash"  />
                     <label class="control-label"> Cash </label>
                    <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
             
                <div class="col-sm-5 col-lg-3 controls">
                    <input type="checkbox"  name="payment_mode[]" value="Net Banking" />
                    <label class=" control-label"> Net Banking  </label>
                    <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
              </div>


              <div class="form-group">
                <div class="col-sm-3 col-lg-3 controls" style="margin-left: 51px;">
                 <input type="checkbox"  name="payment_mode[]" value="Cheque"/>
                  <label class=" control-label" > Cheque  </label>
                  <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
            
                <div class="col-sm-5 col-lg-3 controls">
                    <input type="checkbox"  name="payment_mode[]" value="Credit Card "/>
                      <label class="control-label"> Credit Card   </label>
                      <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
              </div>

              <div class="form-group">
               <div class="col-sm-3 col-lg-3 controls" style="margin-left: 51px;">
                    <input type="checkbox"  name="payment_mode[]" value="Debit Card"/>
                      <label class="control-label">Debit Card </label>
               <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
             
               <div class="col-sm-5 col-lg-3 controls">
                    <input type="checkbox"  name="payment_mode[]" value="Gift Card" />
                     <label class="control-label"> Gift Card  </label>
                  <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
              </div>

              <div class="form-group">
               <div class="col-sm-3 col-lg-3 controls" style="margin-left: 51px;">
                    <input type="checkbox"  name="payment_mode[]" value="Bank Transfer"/>
                     <label class="control-label"> Bank Transfer  </label>
                     <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
           
               <div class="col-sm-5 col-lg-3 controls">
                    <input type="checkbox"  name="payment_mode[]" value="Lay-by"/>
                    <label class="control-label"> Lay-by  </label>
                    <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                </div>
              </div>
              




          {{--   <div class="form-group">
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

                <input type="text" name="payment_mode[]" id="payment_mode" class="form-control" data-rule-required="true"  />
                <div class="error" id="error_payment_mode">{{ $errors->first('payment_mode') }}</div>

                <div class="clr"></div><br/>
                  <div class="error" id="error_set_default"></div>
                  <div class="clr"></div>

               <div id="append_payment" class="class-add"></div>
                <div class="error_msg" id="error_payment_mode" ></div>
                <div class="error_msg" id="error_payment_mode1" ></div>
               <label class="col-sm-3 col-lg-2 control-label"></label>

                </div>
                </div> --}}


                <hr/>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="company_info">About Company Info<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="company_info"
                           id="company_info"
                           data-rule-required="true"
                           placeholder="Enter Company Info"
                           value=""
                           ></textarea>
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
                           data-rule-maxlength="4"
                           placeholder="Enter Establish Year"
                          value=""/>
                    <span class='help-block'>{{ $errors->first('establish_year') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="keywords">Meta Keywords<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="keywords"
                           id="keywords"
                           data-rule-required="true"
                           placeholder="Enter Keywords"
                           value=""
                           ></textarea>
                    <span class='help-block'>{{ $errors->first('keywords') }}</span>
                </div>
            </div>
          <!--   <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="youtube_link">Youtube Link<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="youtube_link"
                           id="youtube_link"
                           data-rule-required=""
                           placeholder="Enter Youtube Link"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('youtube_link') }}</span>
                </div>
            </div> -->
                      




            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Submit" onclick="return setExtraData()">

            </div>
        </div>
      </form>

</div>
</div>
</div>
</div>
<!-- END Main Content -->

<script type="text/javascript">
function sunday_status(status)
{
  if(status=='on')
  {
    $("#sunday_section").css('display','block');

    $("#sun_in").timepicker();
    $("#sun_out").timepicker();
   }
  else if(status=='off')
  {
    $("#sunday_section").css('display','none');
    $("#sun_in").css('hideWidget');
    $("#sun_out").timepicker('hideWidget');
  }
}

$(document).ready(function()
{

 $('#validation-form').submit(function(){
    tinyMCE.triggerSave();
 }); 
 var site_url="{{url('/')}}";
 var csrf_token = "{{ csrf_token() }}";
 $("#user_id").autocomplete(
          {
            minLength:3,
            source:site_url+"/web_admin/common/get_public_id",
            search: function( event, ui )
            {
             /* if(category==false)
              {
                  alert("Select Category First");
                  event.preventDefault();
                  return false;
              }*/
            },
            select:function(event,ui)
            {
               //$("input[name=user_id]").attr('value',ui.item.user_id);
              $("#user_id").attr('value',ui.item.user_id);
              $("#tmp_user_id").attr('value',ui.item.user_id);

              // $("#user_id").val(ui.item.user_id);
             },
            response: function (event, ui)
            {

            }
            }).data("ui-autocomplete")._renderItem = function (ul, item)
            {
                 return $("<li></li>")
                 .data("item.autocomplete", item)
                 .append( item.label +'<span style="color:#7b7b7b"> '+item.span+'</span>')
                 .appendTo(ul);
           };

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

    //Payment
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

});
</script>
<script type="text/javascript">
 var url = "{{ url('/') }}";
</script>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script src="{{ url('/') }}/assets/front/js/jquery.geocomplete.min.js"></script>
<script>
$(function () {
var options = {
                types: ['(cities)'],
                componentRestrictions: {country: 'IN'},
                details: ".geo-details",
                detailsAttribute: "data-geo",
                map: "#business_location_map",
                types: ["geocode", "establishment"],
                markerOptions: {
                                    draggable: true
                               }
              }
  $("#area").geocomplete(options);

$("#area").bind("geocode:dragged", function(event, latLng){
          $("input[name=lat]").val(latLng.lat());
          $("input[name=lng]").val(latLng.lng());
          $("#reset").show();
        });


        $("#reset").click(function(){
          $("#area").geocomplete("resetMarker");
          $("#reset").hide();
          return false;
        });
});


$('html, body').animate({
              scrollTop: $("body").offset().top
          }, 1000);

function getSubCategory(ref)
{
   var main_cat_id =$(ref).find("option:selected").val();
   var categCheck  = $('#example-getting-started').multiselect
                      ({
                         includeSelectAllOption: true,
                         enableFiltering : true
                      });
      categCheck.html('');
    jQuery.ajax({
                        url:url+'/web_admin/common/get_subcategory/'+main_cat_id,
                        type:'GET',
                        data:'flag=true',
                        dataType:'json',
                        beforeSend:function()
                        {

                        },
                        success:function(response)
                        {
                           jQuery(response.arr_main_cat).each(function(index,arr_main_cat)
                                   {
                                          $("#business_public_id").attr('value',arr_main_cat.cat_ref_slug);
                                   });
                          var option = '';
                            if(response.status=="SUCCESS")
                            {
                              
                                if(typeof(response.arr_sub_cat) == "object")
                                {
                                  //$(".multiselect-container").css("display",'block');
                                  // var option = '';
                                   jQuery(response.arr_sub_cat).each(function(index,arr_sub_cat)
                                   {
                                    option+='<option value="'+arr_sub_cat.cat_id+'">'+arr_sub_cat.title+'</option>';

                                   });

                                  
                                   categCheck.html(option);
                                   categCheck.multiselect('rebuild');

                                }
                                
                            

                            }
                            else
                            {
                                //$(".multiselect-container").css("display",'none');
                                categCheck.html('<option value=""></option>');
                                $(".multiselect-selected-text").html("No Sub Category Available !");
                            }
                            return false;
                        }
        });

}

</script>
<script type="text/javascript">


jQuery.validator.addMethod("check_date",function(value) {


        return parseInt($('#MOBILE').val());


}, "Please enter valid Mobile No!");

function checkOpeningHours()
{
    var mon_in =$("#mon_in").val();
    var mon_out =$("#mon_out").val();
    
    if( (mon_in.endsWith('AM') == mon_out.endsWith('AM') ) || (mon_in.endsWith('PM') == mon_out.endsWith('PM')) )
    {          
        var mon_res        = mon_in.substring(0,4);
        var mon_res1       = mon_out.substring(0,4);
        var mon_hour_start = mon_res.split(':');
        var mon_hours_end  = mon_res1.split(':');
        var  sec           = mon_hour_start[0]*3600+mon_hour_start[1]*60;
        var  sec1          = mon_hours_end[0]*3600+mon_hours_end[1]*60;
            
        if(sec > sec1)
        {
          $("#mon_in").focus();
          $("#mon_out").focus();
          $("#mon_span").css("display", "inline").fadeOut(15000);
          return false;
        }
        else
        {
            return true;
        }
    }
    else
    {
        return  true;
    }
}
  function setExtraData()
  {
    if(!($("#validation-form").valid()))
    {
        $('html, body').animate({
              scrollTop: $("body").offset().top
          }, 2000);
    }

    return tinymce.triggerSave();
  }

    tinymce.init({ selector:'textarea' });

</script>

@stop