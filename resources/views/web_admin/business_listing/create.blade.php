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
                <i class="fa fa-user"></i>
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

        <form class="form-horizontal"
              id="validation-form"
              method="POST"
              action="{{ url('/web_admin/business_listing/store/') }}"
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
                <label class="col-sm-3 col-lg-2 control-label" for="user_id">Select User Unique Email Id<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <select class="form-control"  name="user_id" id="user_id">
                <option>Select User Unique Email Id</option>
                 @if(isset($arr_user) && sizeof($arr_user)>0)
                 @foreach($arr_user as $user)
                 <option value="{{ isset($user['id'])?$user['id']:'' }}" >{{ isset($user['email'] )?$user['email']:'' }}
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
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('business_name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">Business Category <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                   <select class="form-control"
                           name="business_cat"
                           id="business_cat"
                           >
                            @if(isset($arr_category) && sizeof($arr_category)>0)
                            <option>Select Business Category</option>
                            @foreach($arr_category as $category)
                             <option value="{{ $category['cat_id'] }}" > {{  $category['title'] }}</option>
                            @endforeach
                            @endif
                           </select>
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"> Image <i class="red">*</i> </label>
                <div class="col-sm-9 col-lg-10 controls">
                   <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">

                      </div>
                      <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                         <span class="btn btn-default btn-file"><span class="fileupload-new" >Select image</span>
                         <span class="fileupload-exists">Change</span>
                         <input type="file" class="file-input" name="main_image" id="ad_image"/></span>
                         <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

                         <span  >

                         </span>

                      </div>
                   </div>
                    <span class='help-block'>{{ $errors->first('image') }}</span>
                     <!--<br/>
                     <button class="btn btn-warning" onclick="return show_more_images()" id="show_more_images_button">Do you want to add slider images ? </button>  -->
                </div>
             </div>
            <div class="form-group">
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
                <label class="col-sm-3 col-lg-2 control-label"> Business Images <i class="red">*</i> </label>
                <div class="col-sm-6 col-lg-4 controls">

                <input type="file" name="business_image[]" id="business_image" class="pimg" data-rule-required="true"  />
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
                           value=""
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
                           value=""
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
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('landmark') }}</span>
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
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('area') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">City <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control"  name="city" id="city">
                  <option>Select City</option>
                 @if(isset($arr_city) && sizeof($arr_city)>0)
                 @foreach($arr_city as $city)
                  <option value="{{ isset($city['id'])?$city['id']:'' }}" >{{ isset($city['city_title'])?$city['city_title']:'' }}
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
                <option>Select Zipcode</option>
                 @if(isset($arr_zipcode) && sizeof($arr_zipcode)>0)
                 @foreach($arr_zipcode as $zipcode)
                 <option value="{{ isset($zipcode['id'])?$zipcode['id']:'' }}" >{{ isset($zipcode['zipcode'])?$zipcode['zipcode']:'' }}
                 </option>
                  @endforeach
                  @endif
                  </select>
                  <span class='help-block'>{{ $errors->first('pincode') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">State <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control"  name="state" id="state">
                 <option>Select State</option>
                  @if(isset($arr_state) && sizeof($arr_state)>0)
                  @foreach($arr_state as $state)
                  <option value="{{ isset($state['id'])?$state['id']:'' }}" >{{ isset($state['state_title'])?$state['state_title']:'' }}
                  </option>
                  @endforeach
                  @endif
                  </select>
                  <span class='help-block'>{{ $errors->first('state') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">Country <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <select class="form-control" name="country" id="country">
                <option>Select Country</option>
                @if(isset($arr_country) && sizeof($arr_country)>0)
                @foreach($arr_country as $country)
                <option value="{{ isset($country['id'])?$country['id']:'' }}">{{ isset($country['country_name'])?$country['country_name']:'' }}
                </option>
                @endforeach
                 @endif
                </select>
                   <span class='help-block'>{{ $errors->first('country') }}</span>
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
                           placeholder="Enter Mobile Number"
                           value=""
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
                           value=""
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
                           value=""
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
                           value=""
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
                           value=""
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
                           value=""
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
                           value=""
                           ></textarea>
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
                           value=""
                           ></textarea>
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
                           value=""
                           ></textarea>
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
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('youtube_link') }}</span>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Add">

            </div>
        </div>
      </form>

</div>
</div>
</div>
</div>
<!-- END Main Content -->

<script type="text/javascript">
 $('#add-image').click(function(){
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
    $('#remove-image').click(function(){
     var html= $("#append").find("input[name='business_image[]']:last");
     html.remove();
            });
</script>
@stop