@extends('front.template.master')

@section('main_section')
<style type="text/css">
  select.input_acct {
    color: #555;
    height: 150px !important;
    text-indent: 1px;
    padding: 5px 10px;
}
.form-control{}

.error{
    color: red;
    font-size: 12px;
    font-weight: lighter;
    text-transform: capitalize;
}
</style>
 <div class="gry_container">
      <div class="container">
         <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
               <ol class="breadcrumb">
                   <span>You are here :</span>
                  <li><a href="{{ url('/') }}">Home</a></li>
                  <li class="active">Add Your Business </li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">
         @include('front.user.left_side_bar_user_business')

             <div class="col-sm-12 col-md-9 col-lg-9">
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

              <div class="my_whit_bg">
                 <div class="title_acc">Please Provide Business Information</div>
                 <div class="row">

                  <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/add_business_details') }}"
                           enctype="multipart/form-data"
                           >



                {{ csrf_field() }}

                  <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="profile_box">

                    <div class="ig_profile" id="dvPreview"  >
                      <!-- <img src="{{ url('/') }}/assets/front/images/default_banner.jpg" id="preview_profile_pic" width="80px"/> -->
                      <img src="{{ get_resized_image_path('default_banner.jpg','assets/front/images',205,270) }}" id="preview_profile_pic" width=""/>
                    </div>
                  <div class="button_shpglst">
                    <div style="" class="fileUpload or_btn">
                      <span>Upload Business Main Image</span>
                      <input id="fileupload" type="file" name="business_image" class="upload change_pic" onchange="loadPreviewImage(this)">
                    </div>
                     <div class="remove_b" onclick="clearPreviewImage()"><a href="#" style=""><i class="fa fa-times"></i> Remove</a></div>
                     <div class="clr"></div>
                     <div class="line">&nbsp;</div>
                      <div class="error_msg">{{ $errors->first('business_image') }} </div>
                  </div>
              </div>
                   </div>


            <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">

                  <div class="user_box_sub">
                    <div class="row">
                  <div class="col-lg-3  label-text" for="business_cat">Business Category </div>
                  <div class="col-sm-9 col-md-9 col-lg-9 m_l">

                  <select class="input_acct" name="business_cat[]" id="business_cat" data-rule-required="true" onchange="updateCategoryOptGroup(this)" multiple="" height="200px">

                  <option> Select Business Categories</option>
                   @if(isset($arr_category) && sizeof($arr_category)>0)
                   @foreach($arr_category as $category)
                   @if($category['parent'] =='0')
                            <optgroup label="{{ $category['title'] }}" >
                                @foreach($arr_category as $subcategory)
                                  @if( $subcategory['parent']==$category['cat_id'])
                                    <option  name="sub_cat" id="sub_cat" value="{{ $subcategory['cat_id'] }}" >
                                   {{ $subcategory['title'] }}
                                    </option  name="sub_cat" id="sub_cat">
                                   @endif
                                   @endforeach

                          </optgroup>
                    @endif
                    @endforeach
                    @endif
                  </select><a href="javascript:void(0);" onclick="clearCategoryOptGroup(this)">Clear Selected Category</a>
                  <div class="alert alert-warning">Note: Press Ctrl To Select Multiple Sub-Category From Single Main Category</div>
                  <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                  </div>
                  </div></div>







                  <!--   <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-3  label-text">Category :</div>
                        <div class="col-sm-9 col-md-9 col-lg-9 m_l">
                          <select class="input_acct"  name="category" required="" aria-describedby="basic-addon1" >
                            <option value="">Select Category</option>
                                @if (isset($arr_category)&& (count($arr_category) > 0))
                                  @foreach($arr_category as $cat)
                                    <option value="{{ $cat['cat_id'] }}">{{ $cat['title'] }}</option>
                                  @endforeach
                                @endif
                          </select>
                          <div class="error_msg">{{ $errors->first('category') }} </div>
                      </div>
                    </div>
                  </div> -->


                  <div class="user_box_sub">
                    <div class="row">
                     <div class="col-lg-3  label-text">Business Name :</div>
                      <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                       <input type="text" name="business_name" id="business_name"
                              class="input_acct"
                              placeholder="Enter Business Name"
                              data-rule-required="true"
                              />
                        <div class="error_msg">{{ $errors->first('business_name') }} </div>
                      </div>
                  </div>
                  </div>
                    </div>
                  </div>
               </div>
             <div class="button_save1">
                    <button type="submit" class="btn btn-post" name="add_business" style="float: left; margin-left:350px; ">Save &amp; continue</button>
                    <!-- <a href="#" class="btn btn-post pull-left">previous</a>
                    <a href="#" class="btn btn-post">Save &amp; exit</a>
                    <a href="#" class="btn btn-post pull-right">Next</a> -->
              </div>
              <div class="clr"></div>

            </div>
          </div>
         </div>
       </div>
      </div>



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
        $('#preview_profile_pic').attr('src',site_url+'/assets/front/images/default_banner.jpg');
        $("#removal_handle").hide();
    }
</script>

<script type="text/javascript">
jQuery(document).ready(function () {
 token   = jQuery("input[name=_token]").val();
  jQuery('#city').on('change', function() {
    var city_id = jQuery(this).val();
    jQuery.ajax({
       url      : site_url+"/front_users/get_state_country?_token="+token,
       method   : 'POST',
       dataType : 'json',
       data     : { city_id:city_id },
       success: function(responce){
          if(responce.length == 0)
          {
            var  state   = "<option value='' >State</option>";
            var  country = "<option value='' >Country</option>";
          }else
          {
            var  state   = "<option value='"+responce.state_id+"' >"+responce.state_name+"</option>";
            var  country = "<option value='"+responce.country_id+"' >"+responce.country_name+"</option>";
          }
          $('#state').html(state);
          $('#country').html(country);
       }
    });
  });
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
</script>


<script type="text/javascript">
$(document ).ready(function (){
  $("#validation-form").validate({
    // Specify the validation rules
      rules: {
          business_cat: "required",
          business_name: "required",
      },
    // Specify the validation error messages
      messages: {
          business_cat: "Please Select Business Category.",
          business_name: "Please Enter Business Name.",
      },

  });
});
</script>


@stop