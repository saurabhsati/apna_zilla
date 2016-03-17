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
                           action="{{ url('/listing/store_business_details') }}" 
                           enctype="multipart/form-data"
                           >

      {{ csrf_field() }}

      @foreach($arr_business_details as $business)
     

                 <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">              


              <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Business Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="business_name" 
                         value="{{ $business['business_name']." ".$business['business_name']}}" 
                                class="input_acct"
                                placeholder="Enter Business Name" readonly />
                          <div class="error_msg"> </div>
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Building:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="building" 
                         value="{{ $business['building']." ".$business['building']}}" 
                                class="input_acct"
                                placeholder="Enter Building's Name" readonly />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Landmark:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="landmark" 
                         value="{{ $business['landmark']." ".$business['landmark']}}" 
                                class="input_acct"
                                placeholder="Enter Landmark's Name" readonly />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Area:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="area" 
                         value="{{ $business['area']." ".$business['area']}}" 
                                class="input_acct"
                                placeholder="Enter Area's Name" readonly />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">City:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="city" 
                         value="{{ $business['city']." ".$business['city']}}" 
                                class="input_acct"
                                placeholder="Enter City's Name" readonly />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Pincode:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="pincode" 
                         value="{{ $business['pincode']." ".$business['pincode']}}" 
                                class="input_acct"
                                placeholder="Enter Pincode" readonly />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">State:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="state" 
                         value="{{ $business['state']." ".$business['state']}}" 
                                class="input_acct"
                                placeholder="Enter State" readonly />
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Country:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="country" 
                         value="{{ $business['country']." ".$business['country']}}" 
                                class="input_acct"
                                placeholder="Enter COuntry" readonly />
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