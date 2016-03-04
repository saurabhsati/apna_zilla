    @extends('web_admin.template.admin')


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
                 <option value="{{ isset($user['id'])?$user['id']:'' }}" {{ $user['id']==$business['user_id']?'selected=selected':'' }}>{{ isset($user['first_name'] )?$user['first_name']:'' }}
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
                <label class="col-sm-3 col-lg-2 control-label" for="business_cat">Business Category<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <select class="form-control"
                           name="business_cat"
                           id="business_cat"
                           >
                            @if(isset($arr_category) && sizeof($arr_category)>0)
                            @foreach($arr_category as $category)
                             <option value="{{ $category['cat_id'] }}" {{ $category['cat_id']==$business['business_cat']?'selected="selected"':'' }}> {{  $category['title'] }}</option>
                            @endforeach
                            @endif
                           </select>
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
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                 @foreach($business['image_upload_details'] as $image)

                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src={{ $business_base_upload_img_path.$image['image_name']}} alt="" />
                                  </div>
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                 <div>
                                     <span class="btn btn-default btn-file"><span class="fileupload-new" >Select image</span>
                                     <span class="fileupload-exists">Change</span>
                                     <input type="file" class="file-input" name="business_image" id="business_image"/>
                                      <input type="hidden" class="file-input" name="business_image" id="business_image" value="{{$image['image_name']}}"/>
                                      </span>
                                     <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

                                     <span  >

                                     </span>

                                  </div>
                                  @endforeach
                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
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
                           />
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
                           />
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">City <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control"  name="city" id="city">
                 @if(isset($arr_city) && sizeof($arr_city)>0)
                   @foreach($arr_city as $city)
                <option value="{{ isset($city['id'])?$city['id']:'' }}" {{ $business['pincode']==$city['id']?'selected="selected"':'' }}>{{ isset($city['city_title'])?$city['city_title']:'' }}
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
                 <select class="form-control"  name="state" id="state">
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
                <select class="form-control" name="country" id="country">
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




            <div class="form-group">
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
            </div>
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