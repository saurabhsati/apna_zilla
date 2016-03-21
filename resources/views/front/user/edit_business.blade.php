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
                    <div class="col-lg-3  label-text">City:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="city" 
                         value="{{ isset($city_name)?$city_name:'' }}" 
                                class="input_acct"
                                placeholder="Enter City's Name" readonly="true" />
                        </div>
                         </div>
                    </div>

                    <!--  <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Pincode:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="pincode" 
                                class="input_acct"
                                placeholder="Enter Pincode" />
                        </div>
                         </div>
                    </div> -->

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">State:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="state" 
                         value="{{ isset($state_name)?$state_name:'' }}" 
                                class="input_acct"
                                placeholder="Enter State" readonly="true" />
                        </div>                                                          
                         </div>                                                                 
                    </div>                                                                                                               

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Country:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="country" 
                         value="{{ isset($country_name)?$country_name:'' }}" 
                                class="input_acct"
                                placeholder="Enter COuntry" readonly="true" />
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

@stop