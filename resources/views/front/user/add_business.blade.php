@extends('front.template.master')

@section('main_section')

 <div class="gry_container">
      <div class="container">
         <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
               <ol class="breadcrumb">
                   <span>You are here :</span>
                  <li><a href="#">Home</a></li>
                  <li class="active">location information</li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>
     
       <div class="container">


         <div class="row">
             
             <div class="col-sm-12 col-md-3 col-lg-3">
               <div class="categories_sect sidebar-nav slide_m">
              
                <div class="sidebar-brand">Business information</div>
                <div class="bor_head">&nbsp;</div>
                <ul class="">
                    <li class="brdr"><a href="{{ url('/').'/front_users/add_business' }}">Location Information</a></li>
                  <li class="brdr"><a href="{{-- url('/').'/front_users/contact_business' --}}#">contact information </a></li>
                  <li class="brdr"><a href="#">other information</a></li>
                    <li class="brdr has-sub"><a href="#"><span>business keywords</span></a>
                    <ul class="make_list" style="display:none;">
                     <li><a href="#">view/remove keywords</a> </li>
                         <li><a href="#">add keywords</a></li> 
                       </ul>
                     </li>
                  <li class="brdr"><a href="#">upload video/logo/pictures</a></li>
                </ul>
                <div class="clearfix"></div>
               </div>
                
                <div class="categories_sect sidebar-nav slide_m">
                 <div class="sidebar-brand">Service Request</div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="">
                    <li class="brdr"><a href="#">ECS/CCSI Active/Pause</a></li>
                  <li class="brdr"><a href="#">Submit An online Request/Complaint</a></li>
                  </ul>
                <div class="clearfix"></div>
                </div>
            </div> 

            {{-- view('front.user.business_sidebar') --}}
             
             
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
                 <div class="title_acc">Please provide home and office address</div>
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
                      <img src="{{ url('/') }}/images/front/no-profile.png" style=" " id="preview_profile_pic"  />
                    </div>
                  <div class="button_shpglst">
                    <div style="" class="fileUpload or_btn">
                      <span>Upload Photo</span>
                      <input id="fileupload" type="file" name="business_image" class="upload change_pic" onchange="loadPreviewImage(this)">
                    </div>
                     <div class="remove_b" onclick="clearPreviewImage()"><a href="#" style=""><i class="fa fa-times"></i> Remove</a></div>
                     <div class="clr"></div>
                     <div class="line">&nbsp;</div>
                  </div>                  
              </div>
                   </div>
                       
                       
            <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">
                    <div class="user_box_sub">
                    <div class="row">
                    <div class="col-lg-3  label-text">Category :</div>
                    <div class="col-sm-9 col-md-9 col-lg-9 m_l">

                    <select class="input_acct"  name="category" >
                      <option value="">Select Category</option>
                          @if (isset($arr_category)&& (count($arr_category) > 0))
                            @foreach($arr_category as $cat)
                              <option value="{{ $cat['cat_id'] }}">{{ $cat['title'] }}</option>
                            @endforeach  
                          @endif                       
                    </select>
                </div>
              </div>
            </div>


                    <div class="user_box_sub">
                      <div class="row">
                       <div class="col-lg-3  label-text">Business Name :</div>
                        <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="business_name" 
                                class="input_acct"
                                placeholder="Enter Business Name" />
                          <div class="error_msg"> </div>
                        </div>
                    </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Building:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="building" 
                                class="input_acct"
                                placeholder="Enter Building's Name" />
                        </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Street:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="street" 
                                class="input_acct"
                                placeholder="Enter Street's Name" />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Landmark:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="landmark" 
                                class="input_acct"
                                placeholder="Enter Landmark's Name" />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Area:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="area" 
                                class="input_acct"
                                placeholder="Enter Area's Name" />
                        </div>
                         </div>
                    </div>

          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">City :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                <select class="input_acct"  id="city" name="city">
                  <option value="">Select City</option>
                  @if (isset($arr_city)&& (count($arr_city) > 0))
                    @foreach($arr_city as $city)
                        <option value="{{ $city['id'] }}">{{ $city['city_title'] }}</option>
                    @endforeach  
                  @endif 
                  </select>
                </div>
              </div>
            </div>

          <div class="user_box_sub">
           <div class="row">
            <div class="col-lg-3  label-text">State :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                <select class="input_acct" name="state" id="state" >
                  <option id="show_state" value="" >State</option>
                </select>
              </div>
            </div>
          </div>                                                                                                    


          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Country :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
               <select class="input_acct"  name="country" id="country">
                  <option value="" id="show_country" >Country</option>
                 </select>
                </div>
              </div>
            </div>         


              <div class="user_box_sub">
                <div class="row">
                  <div class="col-lg-3  label-text">Mobile No:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                      <input type="text" name="mobile_number" class="input_acct" placeholder="Enter Mobile Number" />
                    </div>
                  </div>
              </div>

               <div class="user_box_sub">
                 <div class="row">
                    <div class="col-lg-3  label-text">Landline No:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="landline_number"  class="input_acct" placeholder="Enter Landline Number" />
                    </div>
                  </div>
                </div>
                  
                  
                    
                    </div>
                  </div>
               </div>
             <div class="button_save1">
                    <button type="submit" class="btn btn-post" name="add_business" style="float: left; margin-left:200px; ">Save &amp; continue</button>
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
        $('#preview_profile_pic').attr('src',site_url+'/images/front/avatar.jpg');
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
</script>


@stop