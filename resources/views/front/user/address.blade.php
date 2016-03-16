@extends('front.template.master')

@section('main_section')

<div class="container">
         <div class="row">
             
            <div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->
                   
                <div class="categories_sect sidebar-nav slide_m">
              
                 <div class="sidebar-brand">Fill Profile in Few Steps<span class="spe_mobile">&nbsp;<!--<a href="#"></a>--></span></div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="spe_submobile">
                    <li class="brdr"><span class="steps">1</span><a href="{{url('/front_users/profile')}}">Personal Details</a></li>
                  <li class="brdr"><span class="steps">2</span><a href="{{url('/front_users/address')}}">Addresses</a></li>
                  <li class="brdr"><span class="steps">3</span><a href="#">Family &amp; Friends</a></li>
                  <li class="brdr"><span class="steps">4</span><a href="#">4Credit / Debit Cards</a></li>
                     <li class="brdr has-sub"><span class="steps">5</span><a href="#"><span>Bills &amp; Recharge</span></a>
                    <ul class="make_list" style="display:none;">
                     <li><a href="#">Prepaid Mobile</a> </li>
                         <li><a href="#">Data Card</a></li> 
                         <li><a href="#">DTH</a> </li>
                         <li><a href="#">Electricity</a> </li>
                         <li><a href="#">Postpaid Mobile</a></li>
                         <li><a href="#">Gas Bills</a> </li>
                         <li><a href="#">Insurance Premiums</a> </li>
                         <li><a href="#">Landline</a></li>
                      </ul>
                     </li>
                  <li class="brdr"><span class="steps">6</span><a href="#">Grocery List</a></li>
                  <li class="brdr"><span class="steps">7</span><a href="#">Pharmacy List</a></li>
                     <li class="brdr has-sub"><span class="steps">8</span> <a href="#"><span>Insurance</span></a>
                       <ul class="make_list" style="display:none;">
                     <li><a href="#">Insurance Premiums</a></li>
                       <li><a href="#">Home</a></li>
                       <li><a href="#">Car</a></li>
                       <li><a href="#">Two Wheeler</a></li>
                      </ul>
                     </li>
                                                    
                  <li class="brdr"><span class="steps">9</span><a href="#">Service &amp; Repairs</a></li>
                  <li class="brdr"><span class="steps">10</span><a href="#">Documents</a></li>
                  <li class="brdr"><span class="steps">11</span><a href="#">Favorites</a></li>
                  <li class="brdr"><span class="process_done">12</span><a href="#">Completed</a></li>
                 
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
            </div>
             
            <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="my_whit_bg">
                 <div class="title_acc">Please provide home and office address</div>
                   <div class="row">

                      <form class="form-horizontal" 
                           id="validation-form" 
                           method="POST"
                           action="{{ url('/front_users/store_address_details') }}" 
                           enctype="multipart/form-data"
                           >

      {{ csrf_field() }}

      @foreach($arr_user_info as $user)
     

                 <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">              


              <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="name" 
                         value="{{ $user['first_name']." ".$user['last_name']}}" 
                                class="input_acct"
                                placeholder="Enter Name" readonly />
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                         


                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">City :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="city" 
                                value="{{ isset($user['city'])?$user['city']:'' }}"
                                class="input_acct"
                                placeholder="Enter City "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Area :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="area" 
                                value="{{ isset($user['area'])?$user['area']:'' }}"
                          class="input_acct" placeholder="Enter Area "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                   
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Pincode :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="pincode" 
                                value="{{ isset($user['pincode'])?$user['pincode']:'' }}" 
                                class="input_acct" placeholder="Enter Pincode  "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Street Address :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="street_address" 
                                value="{{ isset($user['street_address'])?$user['street_address']:'' }}" 
                                class="input_acct" placeholder="Enter Street address  "/>
                          <div class="error_msg">please enter correct</div>
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