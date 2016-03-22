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