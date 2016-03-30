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
                    <li class="brdr"><!-- <span class="steps">1</span> --><a href="{{url('/front_users/profile')}}">Personal Details</a></li>
                  <li class="brdr"><!-- <span class="steps">2</span> --><a href="{{url('/front_users/address')}}">Addresses</a></li>
                  <li class="brdr"><!-- <span class="steps">3</span> --><a href="{{url('/front_users/change_password')}}">Change Password</a></li>
                  <li class="brdr"><!-- <span class="steps">4</span> --><a href="#">Favorites</a></li>
                  <li class="brdr"><!-- <span class="process_done">5</span> --><a href="#">Completed</a></li>
                 
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
            </div>
             
            <div class="col-sm-12 col-md-9 col-lg-9">

             

            <div class="my_whit_bg">
                 <div class="title_acc">Please provide your personal Information</div>
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

                   <div class="row">
                      <form class="form-horizontal"
                            name="profile" 
                           id="validation-form" 
                           method="POST"
                           action="{{ url('/front_users/store_personal_details') }}" 
                           enctype="multipart/form-data"
                           >

                           {{ csrf_field() }}


    <?php 
        use App\Models\UserModel;
        if( (count($arr_user_info)==0) && (session('user_mail') !="") )  
        {
            $user_mail = session('user_mail');
            $obj_user_info = UserModel::where('email',$user_mail)->get();
            if($obj_user_info)
            {
                $arr_user_info = $obj_user_info->toArray();
            }
          
        }   
    ?>

    {{-- dd($arr_user_info) --}}

    @if(count($arr_user_info)>0)

      @foreach($arr_user_info as $user)
        
        <input type="hidden" name="user_id" value="{{ $user['id'] }}"></input>

             <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="profile_box">
                    <div class="ig_profile" id="dvPreview">  

                    @if($user['profile_pic']=="default.jpg" || $user['profile_pic']=="")
                      <img src="{{ url('/')."/images/front/no-profile.png" }}" width="200" height="200" id="preview_profile_pic"  />
                    @else
                      <img src="{{$profile_pic_public_path.'/'.$user['profile_pic'] }}" width="200" height="200" id="preview_profile_pic"  />
                    @endif
                    
                    </div>
                        <div class="button_shpglst">
                        <div class="fileUpload or_btn">
                        <span>Upload Photo</span>
                        <input id="fileupload" type="file" name="profile_pic" class="upload change_pic" onchange="loadPreviewImage(this)"></div>
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
                           <select name="title"  class="input_acct">
                                <option value="0" @if(isset($user['prefix_name'])  &&  $user['prefix_name'] == "0" ) {{ 'selected=selected' }} @endif> Mr.</option>
                                <option value="1" @if(isset($user['prefix_name'])  &&  $user['prefix_name'] == "1" ) {{ 'selected=selected' }} @endif> Ms.</option>
                                <option value="2" @if(isset($user['prefix_name'])  &&  $user['prefix_name'] == "2" ) {{ 'selected=selected' }} @endif> Mrs.</option>
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
                 
                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">DOB :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="row">

                     <div class="col-sm-3 col-md-3 col-lg-2">
                       <select class="input_acct" name="dd">
                            @for($i=1;$i<=31;$i++)
                              <option value="<?php echo $i;?>" <?php  if(isset($user['dd'])  &&  $user['dd'] ==  $i ) { echo "selected=selected";}?>>{{ $i }}</option>
                            @endfor
                        </select>  
                         </div>

                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct" name="mm">
<<<<<<< HEAD
                                 <option value="01" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '1' ) { echo "selected=selected";}?>>January</option>
                                 <option value="02" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '2' ) { echo "selected=selected";}?>>February</option>
                                 <option value="03" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '5' ) { echo "selected=selected";}?>>March</option>
                                 <option value="04" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '4' ) { echo "selected=selected";}?>>April</option>
                                 <option value="05" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '5' ) { echo "selected=selected";}?>>May</option>
                                 <option value="06" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '6' ) { echo "selected=selected";}?>>June</option>
                                 <option value="07" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '7' ) { echo "selected=selected";}?>>July</option>
                                 <option value="08" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '8' ) { echo "selected=selected";}?>>August</option>
                                 <option value="09" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '9' ) { echo "selected=selected";}?>>September</option>
                                 <option value="10" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '10' ) { echo "selected=selected";}?>>October</option>
                                 <option value="11" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '11' ) { echo "selected=selected";}?>>November</option>
                                 <option value="12" <?php  if(isset($user['mm'])  &&  $user['mm'] ==  '12' ) { echo "selected=selected";}?>>December</option>
=======
                             <option value="{{ isset($user['mm'])?$user['mm']:'' }}">{{$user['mm']}}</option>
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
>>>>>>> bd39827011035e00995f98f8ffcf6e39576eb5bd
                           </select>  
                            </div>

                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <select class="input_acct" name="yy">
                                @for($j=date('Y');$j>= 1950 ;$j--)
                                  <option value="<?php echo $j;?>" <?php  if(isset($user['yy'])  &&  $user['yy'] ==  $j ) { echo "selected=selected";}?> >{{ $j }}</option>
                                @endfor 
                               </select>  
                            </div>

                        </div>
                        </div>
                         </div>
                    </div> 


                     <div class="user_box_sub">
                        <div class="row">
                            <div class="col-lg-3  label-text">Gender :</div>
                                <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                                <input type="radio" name="gender" value="male" <?php  if(isset($user['gender'])  &&  $user['gender'] ==  "male" ) { echo "checked=checked";}?> >&nbsp;&nbsp;Male&nbsp;&nbsp;</input>
                                <input type="radio" name="gender" value="female" <?php  if(isset($user['gender'])  &&  $user['gender'] ==  "female" ) { echo "checked=checked";}?> >&nbsp;&nbsp;Female</input>
                                <!-- <input type="text" name="occupation" 
                                value="{{-- isset($user['occupation'])?$user['occupation']:'' --}}"
                                class="input_acct" placeholder="Enter Your Occupation  "/> -->
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
                        <!-- <option value="{{-- isset($user['marital_status']) ? $user['marital_status']:'' --}}">{{-- $user['marital_status'] --}} </option> -->
                        
                        <option value="">--Select--</option>
                        <option value="Married" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Married" ) {{ 'selected=selected' }} @endif >Married</option>
                        <option value="Un Married" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Un Married" ) {{ 'selected=selected' }} @endif>Un Married</option>
                        <option value="Divorced" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Divorced" ) {{ 'selected=selected' }} @endif>Divorced</option>
                        <option value="Widowed" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Widowed" ) {{ 'selected=selected' }} @endif>Widowed</option>                        
                        </select>
                        </div>
                         </div>
                    </div>
                                     
                      <!-- <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">City :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="city" 
                                value="{{-- isset($user['city'])?$user['city']:'' --}}"
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
                                value="{{-- isset($user['area'])?$user['area']:'' --}}"
                          class="input_acct" placeholder="Enter Area "/>
                        </div>
                         </div>
                    </div> -->
                   
                  <!--   <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Pincode :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="pincode" 
                                value="{{-- isset($user['pincode'])?$user['pincode']:'' --}}" 
                                class="input_acct" placeholder="Enter Pincode  "/>
                        </div>
                         </div>
                    </div> -->
                    
                    <div class="user_box_sub">
                        <div class="row">
                                <div class="col-lg-3  label-text">Work Experience</div>
                                <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                                <input type="text" name="work_experience" 
                                value="{{ isset($user['work_experience'])?$user['work_experience']:'' }}"
                                class="input_acct" placeholder="Enter Work Experience "/>
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
                    @endif
                    </form>
                    </div>
                </div>
            </div>
         </div>
<!-- }
} -->
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