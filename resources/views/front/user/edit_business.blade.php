@extends('front.template.master')

@section('main_section')

<div class="container">
         <div class="row">
             
            <div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->              
            </div>
             
            <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="my_whit_bg">
                 <div class="title_acc">Whatever changes you make, will be taken live post verification!</div>
                   <div class="row">

                      <form class="form-horizontal" 
                           id="validation-form" 
                           method="POST"
                           action="{{ url('/front_users/update_business_details') }}/{{ $buss_id }}" 
                           enctype="multipart/form-data"
                           >

      {{ csrf_field() }}

      @foreach($arr_business_details as $business)

           <div class="col-sm-9 col-md-9 col-lg-9">
          <div class="box_profile">              

                  <div class="col-sm-3 col-md-3 col-lg-3">
                  <div class="profile_box">
                    <!-- <div class="ig_profile" id="dvPreview"  > -->
                          <div class="" id="dvPreview"  >
                          @if($business['main_image']=="default.jpg" || $business['main_image']=="" )
                            <img src="{{ url('/')."/images/front/no-profile.png" }}" style="height: 200px; width:200px; margin-bottom: 10px; " id="preview_profile_pic"  />
                          @else
                            <img src="{{ url('/') }}/uploads/business/main_image/{{ $business['main_image'] }}" style="height: 200px; width:200px;margin-bottom: 10px;"  id="preview_profile_pic"  />
                          @endif

                          </div>
                        <div class="button_shpglst">
                        <div style="margin-left: 40px;" class="fileUpload or_btn">
                          <span>Upload Photo</span>
                          <input id="fileupload" type="file" name="business_pic" class="upload change_pic" onchange="loadPreviewImage(this)">
                        </div>
                       <div class="remove_b" onclick="clearPreviewImage()"><a href="#" style="margin-left: 40px;"><i class="fa fa-times"></i> Remove</a></div>                               
                     <div class="clr"></div>
                    <div class="line">&nbsp;</div>
                    </div>                  
                       </div>
                      </div>

           <div class="user_box_sub">
                   <div class="row">
            <div class="col-lg-3  label-text">Category :</div>
            <div class="col-sm-12 col-md-12 col-lg-9 m_l">
          
             @foreach($arr_cat_details as $category)

             <?php
              $no_of_categories = count($arr_cat_full_details);

              ?>

            <select class="input_acct" 
                    name="category"
              >
             <option value="{{ $category['title'] }}">{{ $category['title'] }}</option>
             
              @for($cat_name=1;$cat_name<=$no_of_categories;$cat_name++)

                    @foreach($arr_cat_full_details as $cat)
                      <option value="{{ $cat['title'] }}">{{ $cat['title'] }}</option>

                        <?php
                        $no_of_categories--;
                        if($no_of_categories<1)
                        
                       ?>
                      @endforeach  
                        
              @endfor

             @endforeach                       
            
            </select>

                </div>
                 </div>
            </div>


              <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Business Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="business_name" 
                         value="{{ isset($business['business_name'])?$business['business_name']:'' }}"
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
                         value="{{ isset($business['building'])?$business['building']:'' }}" 
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
                         value="{{ isset($business['street'])?$business['street']:'' }}" 
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
                         value="{{ isset($business['landmark'])?$business['landmark']:'' }}" 
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
                         value="{{ isset($business['area'])?$business['area']:'' }}" 
                                class="input_acct"
                                placeholder="Enter Area's Name" />
                        </div>
                         </div>
                    </div>

           <div class="user_box_sub">
                   <div class="row">
            <div class="col-lg-3  label-text">City :</div>
            <div class="col-sm-12 col-md-12 col-lg-9 m_l">
          
           <!--   @foreach($arr_cat_details as $category) -->

             <?php
              $no_of_cities = count($arr_city_full_details);
              ?>

            <select class="input_acct" 
                    name="city"
              >
            <option value="{{ $city_name }}">{{ $city_name }}</option>
             
              @for($city_name=1;$city_name<=$no_of_cities;$city_name++)

                    @foreach($arr_city_full_details as $city)
                      <option value="{{ $city['city_title'] }}">{{ $city['city_title'] }}</option>

                      <?php
                        $no_of_cities--;
                        if($no_of_cities<1)
                        
                       ?>
                      @endforeach  
              @endfor

            <!--  @endforeach  -->                      
            </select>

                </div>
                 </div>
            </div>



            <div class="user_box_sub">
           <div class="row">
            <div class="col-lg-3  label-text">State :</div>
            <div class="col-sm-12 col-md-12 col-lg-9 m_l">
          
           <!--   @foreach($arr_cat_details as $category) -->

             <?php
              $no_of_states = count($arr_state_full_details);
              ?>

            <select class="input_acct" 
                    name="state"
              >
            <option value="{{ $state_name }}">{{ $state_name }}</option>
             
              @for($state_name=1;$state_name<=$no_of_states;$state_name++)

                    @foreach($arr_state_full_details as $state)
                      <option value="{{ $state['state_title'] }}">{{ $state['state_title'] }}</option>

                      <?php
                        $no_of_states--;
                        if($no_of_states<1)
                        
                       ?>
                      @endforeach  
              @endfor

            <!--  @endforeach  -->                      
            </select>

                </div>
                 </div>
            </div>                                                                                                    


            <div class="user_box_sub">
           <div class="row">
            <div class="col-lg-3  label-text">Country :</div>
            <div class="col-sm-12 col-md-12 col-lg-9 m_l">
          
           <!--   @foreach($arr_cat_details as $category) -->

             <?php
              $no_of_countries = count($arr_country_full_details);
              ?>

            <select class="input_acct" 
                    name="country"
              >
            <option value="{{ $country_name }}">{{ $country_name }}</option>
             
              @for($country_name=1;$country_name<=$no_of_countries;$country_name++)

                    @foreach($arr_country_full_details as $country)
                      <option value="{{ $country['country_name'] }}">{{ $country['country_name'] }}</option>

                      <?php
                        $no_of_countries--;
                        if($no_of_countries<1)
                        
                       ?>
                      @endforeach  
              @endfor

            <!--  @endforeach  -->                      
            </select>

                </div>
                 </div>
            </div>         

            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile No:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="mobile_number" 
                         value="{{ isset($business['mobile_number'])?$business['mobile_number']:'' }}" 
                                class="input_acct"
                                placeholder="Enter Mobile Number" />
                        </div>
                         </div>
                    </div>

                         <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Landline No:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="landline_number" 
                         value="{{ isset($business['landline_number'])?$business['landline_number']:'' }}" 
                                class="input_acct"
                                placeholder="Enter Landline Number" />
                        </div>
                         </div>
                    </div>


                   </div>                  
                    <button type="submit" class="yellow1 ui button">Save & Continue</button>

           @endforeach
                    </form>
              
              </div>
                      
                </div>
                
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
/*jQuery(document).ready(function () {
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
});*/
</script>



@stop