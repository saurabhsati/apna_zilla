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
                  <li class="active">Business Information</li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">
         @include('front.user.Edit_Business.edit_business_left_side_bar_menu')

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
                  @if(isset($business_data) && sizeof($business_data)>0)
                  @foreach($business_data as $business)
                  <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/update_business_step1/'.$enc_id)}}"
                           enctype="multipart/form-data"
                           >



                {{ csrf_field() }}

                  <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="profile_box">

                    <div class="ig_profile" id="dvPreview"  >
                     <!--  <img src="{{ $business_public_img_path.$business['main_image']}}" id="preview_profile_pic"/> -->
                      <img src="{{ get_resized_image_path($business['main_image'],'uploads/business/main_image',205,270) }}" id="preview_profile_pic"/>
                    </div>
                  <div class="button_shpglst">
                    <div style="" class="fileUpload or_btn">
                      <span>Upload Photo</span>
                      <input id="fileupload" type="file" name="business_image" class="upload change_pic" onchange="loadPreviewImage(this)">
                       <input type="hidden" class="file-input" name="business_image" id="business_image" value="{{$business['main_image']}}"/>
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
                     <div class="col-lg-3  label-text">Business Name :</div>
                      <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                       <input type="text" name="business_name" id="business_name"
                              class="input_acct"
                              placeholder="Enter Business Name"
                              data-rule-required="true"
                              value="{{ isset($business['business_name'])?$business['business_name']:'' }}"
                              />
                        <div class="error_msg">{{ $errors->first('business_name') }} </div>
                      </div>
                  </div>
                  </div>
                  <input type="hidden" name="business_public_id" id="business_public_id" value="{{ isset($business['busiess_ref_public_id'])?$business['busiess_ref_public_id']:'' }}">
           
                  <div class="user_box_sub">
                    <div class="row">
                  <div class="col-lg-3  label-text" for="old_business_cat">Selected Business Category </div>
                  <div class="col-sm-9 col-md-9 col-lg-9 m_l">
                  <select class="form-control input_acct" name="old_business_cat[]" id="old_business_cat" data-rule-required="true" disabled="true" multiple="">
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
                  </select>
                <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                 <div class="hyper_link_more"><a href="javascript:void(0);" class="add_new_subcategory">Add New Sub Category </a></div>
                  </div>
                  </div></div>

<!--                  <div class="user_box_sub">
                  <div class="row">
                  
                  </div>
                 </div>-->
            <div class="add_new_subcategory_div" id="add_new_subcategory_div" style="display:none;">
            <div class="user_box_sub ">
             <div class="row">

             <div class="col-lg-3  label-text">Business Main Category:</div>
                      <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <select class="form-control" name="main_business_cat" id="main_business_cat" onchange="getSubCategory(this)">
                          <option> Select Business Main Categories</option>
                         @if(isset($arr_parent_category) && sizeof($arr_parent_category)>0)
                         @foreach($arr_parent_category as $parent_category)
                          <option  name="sub_cat" id="sub_cat" value="{{ $parent_category['cat_id'] }}" >
                                         {{ $parent_category['title'] }}
                                          </option>
                          @endforeach
                           @endif
                        </select>
                        <div class="error_msg">{{ $errors->first('main_business_cat') }} </div>
                      </div>
             </div>
            </div>
           <div class="user_box_sub ">
             <div class="row">

             <div class="col-lg-3  label-text">Business Main Category:</div>
                      <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <select class="form-control"  id="example-getting-started" name="business_cat[]" multiple="multiple">
            <option value="">Select Business Sub category </option>
               
              </select>
              <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                <div class="alert alert-warning">Note: Firstly Select The Business Main category From Business Main Category Drop-down , Then Click ON None Selected Button  </div>
                
                
            </div>

            </div>
            </div>
             
            
</div>
                    <div class="user_box_sub ">
              
             <div class="row">
                   <div class="col-lg-3  label-text hidden-xs hidden-sm">&nbsp;</div>
                 <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                 <div class="button_save1">
                  <button type="submit" class="btn btn-post" name="add_business" style="float: left; ">Save &amp; continue</button>
                   </div>
                 </div>
                  </div>
                </div>
                    </div>
                  </div>
               </div>
             <div class="button_save1">
             <!--       <button type="submit" class="btn btn-post" name="add_business" style="float: left; margin-left:350px; ">Save &amp; continue</button>-->
                    <!-- <a href="#" class="btn btn-post pull-left">previous</a>
                    <a href="#" class="btn btn-post">Save &amp; exit</a>
                    <a href="#" class="btn btn-post pull-right">Next</a> -->
              </div>
              </form>
               @endforeach
@endif
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
        $('#preview_profile_pic').attr('src',site_url+'/images/front/avatar.jpg');
        $("#removal_handle").hide();
    }
    function getSubCategory(ref)
{
   var main_cat_id =$(ref).find("option:selected").val();
   var categCheck  = $('#example-getting-started').multiselect
                      ({
                         includeSelectAllOption: true,
                         enableFiltering : true
                      });
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
                                   var option = '';
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

</script>


<script type="text/javascript">
$('.add_new_subcategory').click(function(){
 $(".add_new_subcategory_div").css('display','block');
     return false;
});
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