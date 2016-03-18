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
                  <li class="brdr"><span class="steps">3</span><a href="{{url('/front_users/change_password')}}">Change Password</a></li>
                  <li class="brdr"><span class="steps">4</span><a href="#">Favorites</a></li>
                  <li class="brdr"><span class="process_done">5</span><a href="#">Completed</a></li>
                 
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
                            name="profile" 
                           id="validation-form" 
                           method="POST"
                           action="{{ url('/front_users/store_personal_details') }}" 
                           enctype="multipart/form-data"
                           >

                           {{ csrf_field() }}

      @foreach($arr_user_info as $user)

   
<!-- 
     <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Profile Pic</label>
        <div class="col-sm-3 col-md-3 col-lg-3">
         <div class="profile_box">
                    @if($user['profile_pic']=="default.jpg")
                      <img src="{{$profile_pic_public_path.'/'.$user['profile_pic']}}" width="200" height="200" id="preview_profile_pic"  />
                    @else
                      <img src="{{$profile_pic_public_path.'/'.$user['profile_pic']}}" width="200" height="200" id="preview_profile_pic"  />
                    @endif

                    @if($user['profile_pic']!="default.jpg")
                      <span class="btn btn-danger" id="removal_handle" onclick="clearPreviewImage()">X</span>
                    @else
                      <span class="btn btn-danger" id="removal_handle" onclick="clearPreviewImage()" style="display:none;">X</span>
                    @endif

                    <input class="form-control" name="profile_pic" id="profile_pic" type="file" onchange="loadPreviewImage(this)"/>

                    <span class='help-block'>{{ $errors->first('profile_pic') }}</span>
                </div>
            </div>  -->


        <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="profile_box">
                    <div class="ig_profile" id="dvPreview">  

                    @if($user['profile_pic']=="default.jpg")
                      <img src="{{$profile_pic_public_path.'/'.$user['profile_pic']}}" width="200" height="200" id="preview_profile_pic"  />
                    @else
                      <img src="{{$profile_pic_public_path.'/'.$user['profile_pic']}}" width="200" height="200" id="preview_profile_pic"  />
                    @endif
                    </div>
                        <div class="button_shpglst">
                        <div class="fileUpload or_btn">
                        <span>Upload Photo</span>
                        <input id="fileupload" name="profile_pic" type="file" class="upload change_pic" onchange="loadPreviewImage(this)"></div>
                       <div class="remove_b" onclick="clearPreviewImage()"><a href="#"><i class="fa fa-times"></i> Remove</a></div>                               
                     <div class="clr"></div>
                    <div class="line">&nbsp;</div>
                    </div>                  
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
                          <input type="text" name="first_name" id="fname"  
                                 onblur="validate()"
                                 value="{{ isset($user['first_name'])?$user['first_name']:'' }}" 
                                 class="input_acct" 
                                 placeholder="Enter name" required/>
                                 </div></div>

                           <div class="error_msg" id="err_fn">  </div>    

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
                                placeholder="Enter Last Name "
                                onblur="validate()" 
                                />

                                <div class="error_msg" id="err_ln">  </div> 
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
                             <option value="5">5</option>
                             <option value="6">6</option>
                             <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
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
                                 <option value="June">June</option>
                                 <option value="July">July</option>
                                 <option value="August">August</option>
                                 <option value="September">September</option>
                                 <option value="October">October</option>
                                 <option value="November">November</option>
                                 <option value="December">December</option>

                        </select>  
                            </div>
                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct" name="d_o_b">
                             <option value="{{$yy}}">{{$yy}}</option>
                              <option value="2016">2010</option>
                               <option value="2016">2011</option>
                                <option value="2016">2012</option>
                                 <option value="2016">2013</option>
                                  <option value="2016">2014</option>
                                   <option value="2016">2015</option>
                             <option value="2016">2016</option>
                                 <option value="2017">2017</option>
                                 <option value="2018">2018</option>
                                  <option value="2019">2019</option>
                        </select>  
                            </div>
                        </div>
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
                        </div>
                         </div>
                    </div>

                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email ID :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="email" name="email" 
                                value="{{ isset($user['email'])?$user['email']:'' }}"
                               class="input_acct" placeholder="Enter Email ID" readonly="true" />
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
                        </div>
                         </div>
                    </div>
                    
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Office Landline :</div>

                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                          <input type="text" name="std_office_landline" 
                                 value="{{ isset($user['std_office_landline'])?$user['std_office_landline']:'' }}" 
                                 class="std_cont_inpt" 
                                  placeholder="STD">

                        <input type="text" name="office_landline" 
                               value="{{ isset($user['office_landline'])?$user['office_landline']:'' }}"
                              class="input_acct half_2_input" placeholder="Enter office landline"/>

                          <input type="text" name="extn_office_landline" 
                                 value="{{ isset($user['extn_office_landline'])?$user['extn_office_landline']:'' }}" 
                                 class="std_cont_inpt"
                                 placeholder="EXTN">
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

    function validate()
      {

        if(profile.first_name.value=="")
        {
          document.getElementById('err_fn').innerHTML="This is invalid value";
        }

       else if(profile.last_name.value=="")
        {
          document.getElementById('err_ln').innerHTML="This is invalid value";
        }

        else
        {
          document.getElementById('err_msg').innerHTML="";
        }
    }

</script>


@stop