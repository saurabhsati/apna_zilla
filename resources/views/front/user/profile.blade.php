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
                           action="{{ url('/front_users/store_personal_details') }}" 
                           enctype="multipart/form-data"
                           >



      @foreach($arr_user_info as $user)

        <div class="col-sm-3 col-md-3 col-lg-3">
          <div class="profile_box">
              <div class="ig_profile" id="dvPreview"> 
              <img src="{{url('/')}}/images/front/avatar.jpg" width="200" height="200" id="preview_profile_pic"  /></div>
              <div class="button_shpglst">
                  <div class="remove_b" onclick="clearPreviewImage()"><a href="#"><i class="fa fa-times"></i> Remove</a></div>                               
                <div class="clr"></div>
                   <div class="line">&nbsp;</div>
             </div>
          <input class="form-control" name="profile_pic" id="profile_pic" type="file" onchange="loadPreviewImage(this)"/>
       </div>
       </div>         

                 <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">              

               
                      <div class="user_box_sub">
                    <div class="row">
                    <div class="col-lg-3  label-text">First Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                      <div class="row">
                         <div class="col-sm-3 col-md-3 col-lg-3">
                           <select name="title" class="input_acct">
                           <option value="{{ isset($user['title'])?$user['title']:'' }}">
                                 <option value="Mr">Mr.</option>
                             <option value="Miss">Miss.</option>
                            
                        </select>  
                            </div>

                          <div class="col-sm-9 col-md-9 col-lg-9"> 
                          <input type="text" name="first_name"
                                 value="{{ isset($user['first_name'])?$user['first_name']:'' }}" 
                                 class="input_acct" 
                                 placeholder="Enter name"/>
                                 </div></div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Middle Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="middle_name" 
                         value="{{ isset($user['middle_name'])?$user['middle_name']:'' }}" 
                                class="input_acct"
                                placeholder="Enter Middle Name"/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Last Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="last_name"
                                class="input_acct"
                                value="{{ isset($user['last_name'])?$user['last_name']:'' }}"
                                placeholder="Enter Last Name "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>


                    <?php
                    $string = $user['d_o_b'];
                    $timestamp = strtotime($string);
                    $dd = date("d", $timestamp);
                    $mm = date("m", $timestamp);
                    $yy = date("Y", $timestamp);
                    ?>


                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">DOB :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="row">
                         <div class="col-sm-3 col-md-3 col-lg-2">
                           <select class="input_acct" name="d_o_b">
                                 <option value="{{$dd}}">{{$dd}}</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                             <option value="4">4</option>
                        </select>  
                            </div>
                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct" name="d_o_b">
                             <option value="{{$mm}}">{{$mm}}</option>
                             <option value="January">January</option>
                                 <option value="February">February</option>
                                 <option value="March">March</option>
                                 <option value="April">April</option>
                                 <option value="May">May</option>
                        </select>  
                            </div>
                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct" name="d_o_b">
                             <option value="{{$yy}}">{{$yy}}</option>
                             <option value="2016">2016</option>
                                 <option value="2017">2017</option>
                                 <option value="2018">2018</option>
                                  <option value="2019">2019</option>
                        </select>  
                            </div>
                        </div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div> 

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Marital Status :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <select class="input_acct" 
                                 name="marital_status"
                                 >
                        <option value="{{ isset($user['marital_status'])?$user['marital_status']:'' }}">$user['marital_status']</option>
                        <option value="Married">Married</option>
                        <option value="Un Married">Un Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>                        
                        </select>
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
                    <div class="col-lg-3  label-text">Occupation :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="occupation" 
                                value="{{ isset($user['occupation'])?$user['occupation']:'' }}"
                                class="input_acct" placeholder="Enter Your Occupation  "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>

                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email ID :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="email" name="email" 
                                value="{{ isset($user['email'])?$user['email']:'' }}"
                               class="input_acct" placeholder="Enter Email ID  "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile No.:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91</span>
                        <input type="text" name="mobile_no"
                               value="{{ isset($user['mobile_no'])?$user['mobile_no']:'' }}"
                               class="form-control" placeholder="Enter Mobile No:" aria-describedby="basic-addon1" required/>
                            
                        </div>  
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                     
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Home Landline :</div>

                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                      <input type="text" name="std_home_landline"
                             value="{{ isset($user['std_home_landline'])?$user['std_home_landline']:'' }}"
                             class="std_cont_inpt"
                             placeholder="STD">

                        <input type="text" name="home_landline" 
                               value="{{ isset($user['home_landline'])?$user['home_landline']:'' }}"
                               class="input_acct half_2_input" placeholder="Enter home landline"/>
                         <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Office Landline :</div>

                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                          <input type="text" name="std_office_landline" 
                                 value="{{ isset($user['std_home_landline'])?$user['std_home_landline']:'' }}" 
                                 class="std_cont_inpt" 
                                  placeholder="STD">

                        <input type="text" name="office_landline" 
                               value="{{ isset($user['office_landline'])?$user['office_landline']:'' }}"
                              class="input_acct half_2_input" placeholder="Enter office landline"/>

                          <input type="text" name="extn_office_landline" 
                                 value="{{ isset($user['extn_office_landline'])?$user['extn_office_landline']:'' }}" 
                                 class="std_cont_inpt"
                                 placeholder="EXTN">
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