@extends('front.template.master')

@section('main_section')

<style type="text/css">
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
                  <li class="active">Profile</li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>
<div class="container">
         <div class="row">

           @include('front.user.profile_left')

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


    


    @if(count($arr_user_info)>0)

      @foreach($arr_user_info as $user)

        <input type="hidden" name="user_id" value="{{ $user['id'] }}"></input>

             <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="profile_box">
                    <div class="ig_profile" id="dvPreview">

                   <!--  {{$profile_pic_public_path.'/'.$user['profile_pic'] }}
                   {{ get_resized_image_path($user['profile_pic'],$profile_pic_public_path,200,200) }}-->
                      <img src="{{ get_resized_image_path($user['profile_pic'],'uploads/users/profile_pic',200,200) }}" width="200" height="200" id="preview_profile_pic"  />


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
                                 placeholder="Enter name"
                                 data-rule-required="true"
                                 />
                                 </div></div>

                           <div class="error_msg" id="err_fn">  </div>

                        </div>
                         </div>
                    </div>

                   <!--  <div class="user_box_sub">
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
                         <input type="text" name="last_name" id="last_name"
                                class="input_acct"
                                value="{{ isset($user['last_name'])?$user['last_name']:'' }}"
                                placeholder="Enter Last Name "
                                data-rule-required=""
                                />
                               
                                <div class="error_msg" id="err_ln">  </div>
                        </div>
                         </div>
                    </div>
 -->
                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">DOB :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="row">

                     <div class="col-sm-3 col-md-3 col-lg-2">
                     <?php //echo $user['d_o_b'];
                       $date_explode=explode('-',$user['d_o_b']);
                     // print_r($date_explode) ;?>
                       <select class="input_acct" name="dd">
                       <option value="">Day</option>
                            @for($i=1;$i<=31;$i++)
                              <option value="<?php echo $i;?>" <?php  if(isset($date_explode[2])  &&  $date_explode[2] ==  $i ) { echo "selected=selected";}?>>{{ $i }}</option>
                            @endfor
                        </select>
                         </div>

                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct" name="mm">
                           <option value="">Month</option>
                                 <option value="01" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '01' ) { echo "selected=selected";}?>>January</option>
                                 <option value="02" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '02' ) { echo "selected=selected";}?>>February</option>
                                 <option value="03" <?php  if(isset($$date_explode[1])  &&  $date_explode[1] ==  '03' ) { echo "selected=selected";}?>>March</option>
                                 <option value="04" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '04' ) { echo "selected=selected";}?>>April</option>
                                 <option value="05" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '05' ) { echo "selected=selected";}?>>May</option>
                                 <option value="06" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '06' ) { echo "selected=selected";}?>>June</option>
                                 <option value="07" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '07' ) { echo "selected=selected";}?>>July</option>
                                 <option value="08" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '08' ) { echo "selected=selected";}?>>August</option>
                                 <option value="09" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '09' ) { echo "selected=selected";}?>>September</option>
                                 <option value="10" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '10' ) { echo "selected=selected";}?>>October</option>
                                 <option value="11" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '11' ) { echo "selected=selected";}?>>November</option>
                                 <option value="12" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '12' ) { echo "selected=selected";}?>>December</option>
                           </select>
                            </div>

                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <select class="input_acct" name="yy">
                                <option value="">Year</option>
                                @for($j=date('Y');$j>= 1950 ;$j--)
                                  <option value="<?php echo $j;?>" <?php  if(isset($date_explode[0])  &&  $date_explode[0] ==  $j ) { echo "selected=selected";}?> >{{ $j }}</option>
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
                                <input type="radio"  name="gender" id="gender" value="male" <?php  if(isset($user['gender'])  &&  $user['gender'] ==  "male" ) { echo "checked=checked";}?> >&nbsp;&nbsp;Male&nbsp;&nbsp;</input>
                                <input type="radio"  name="gender" id="gender" value="female" <?php  if(isset($user['gender'])  &&  $user['gender'] ==  "female" ) { echo "checked=checked";}?> >&nbsp;&nbsp;Female</input>
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
                                 name="marital_status" id="marital_status"
                                 data-rule-required="true"
                                 onchange="chkeck_marital_status(this);"
                                 >
                        <!-- <option value="{{-- isset($user['marital_status']) ? $user['marital_status']:'' --}}">{{-- $user['marital_status'] --}} </option> -->

                        <option value="">--Select--</option>
                        <option value="Married" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Married" ) {{ 'selected=selected' }} @endif >Married</option>
                        <option value="Un Married" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Un Married" ) {{ 'selected=selected' }} @endif>Un Married</option>
                      {{--   <option value="Divorced" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Divorced" ) {{ 'selected=selected' }} @endif>Divorced</option>
                        <option value="Widowed" @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Widowed" ) {{ 'selected=selected' }} @endif>Widowed</option> --}}
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
                    @if(isset($user['marital_status'])  &&  $user['marital_status'] =="Married" )
                     <div  id="div_married_date" name="div_married_date" >
                         <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Married Date:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="row">

                     <div class="col-sm-3 col-md-3 col-lg-2">
                     <?php //echo $user['d_o_b'];
                       $date_explode=explode('-',$user['married_date']);
                     // print_r($date_explode) ;?>
                       <select class="input_acct" name="married_date_dd">
                        <option value="">Select Day</option>
                                 
                            @for($i=1;$i<=31;$i++)
                              <option value="<?php echo $i;?>" <?php  if(isset($date_explode[2])  &&  $date_explode[2] ==  $i ) { echo "selected=selected";}?>>{{ $i }}</option>
                            @endfor
                        </select>
                         </div>

                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct" name="married_date_mm">
                                 <option value="">Select Month</option>
                                 <option value="01" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '01' ) { echo "selected=selected";}?>>January</option>
                                 <option value="02" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '02' ) { echo "selected=selected";}?>>February</option>
                                 <option value="03" <?php  if(isset($$date_explode[1])  &&  $date_explode[1] ==  '03' ) { echo "selected=selected";}?>>March</option>
                                 <option value="04" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '04' ) { echo "selected=selected";}?>>April</option>
                                 <option value="05" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '05' ) { echo "selected=selected";}?>>May</option>
                                 <option value="06" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '06' ) { echo "selected=selected";}?>>June</option>
                                 <option value="07" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '07' ) { echo "selected=selected";}?>>July</option>
                                 <option value="08" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '08' ) { echo "selected=selected";}?>>August</option>
                                 <option value="09" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '09' ) { echo "selected=selected";}?>>September</option>
                                 <option value="10" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '10' ) { echo "selected=selected";}?>>October</option>
                                 <option value="11" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '11' ) { echo "selected=selected";}?>>November</option>
                                 <option value="12" <?php  if(isset($date_explode[1])  &&  $date_explode[1] ==  '12' ) { echo "selected=selected";}?>>December</option>
                           </select>
                            </div>

                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <select class="input_acct" name="married_date_yy">
                                 <option value="">Select Year</option>
                                 
                                @for($j=date('Y');$j>= 1950 ;$j--)
                                  <option value="<?php echo $j;?>" <?php  if(isset($date_explode[0])  &&  $date_explode[0] ==  $j ) { echo "selected=selected";}?> >{{ $j }}</option>
                                @endfor
                               </select>
                            </div>

                        </div>
                        </div>
                         </div>
                    </div>
                    </div>
                    @endif
                   <!--  <div class="user_box_sub">
                        <div class="row">
                                <div class="col-lg-3  label-text">Work Experience</div>
                                <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                                <input type="text" name="work_experience" id="work_experience"
                                value="{{ isset($user['work_experience'])?$user['work_experience']:'' }}"
                                class="input_acct" placeholder="Enter Work Experience"
                                 data-rule-required=""
                                 data-rule-number=""
                                />
                                </div>
                        </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Occupation :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="occupation" id="occupation"
                                value="{{ isset($user['occupation'])?$user['occupation']:'' }}"
                                class="input_acct" placeholder="Enter Your Occupation"
                                 data-rule-required=""
                                />
                        </div>
                         </div>
                    </div>

                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email ID :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="email" name="email"
                                value="{{ isset($user['email'])?$user['email']:'' }}"
                               class="input_acct" placeholder="Enter Email ID" readonly="true"  data-rule-required="" />
                        </div>
                         </div>
                    </div> -->

                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile No.:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91</span>
                        <input type="text" name="mobile_no"
                               value="{{ isset($user['mobile_no'])?$user['mobile_no']:'' }}"
                               class="form-control" placeholder="Enter Mobile No:" data-rule-integer="true" data-rule-required="true"/>

                        </div>
                        </div>
                         </div>
                    </div>

                    <!-- <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Home Landline :</div>

                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                      <input type="text" name="std_home_landline"
                             value="{{ isset($user['std_home_landline'])?$user['std_home_landline']:'' }}"
                             class="std_cont_inpt"
                              data-rule-required=""
                             placeholder="STD">

                        <input type="text" name="home_landline"
                               value="{{ isset($user['home_landline'])?$user['home_landline']:'' }}"
                               class="input_acct half_2_input" data-rule-required=""  placeholder="Enter home landline"/>
                        </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Office Landline :</div>

                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                          <input type="text" name="std_office_landline" id="std_office_landline"
                                 value="{{ isset($user['std_office_landline'])?$user['std_office_landline']:'' }}"
                                 class="std_cont_inpt"
                                 data-rule-required=""
                                  placeholder="STD">

                        <input type="text" name="office_landline"
                               value="{{ isset($user['office_landline'])?$user['office_landline']:'' }}"
                              class="input_acct half_2_input" data-rule-required="" placeholder="Enter office landline"/>

                          <input type="text" name="extn_office_landline"
                                 value="{{ isset($user['extn_office_landline'])?$user['extn_office_landline']:'' }}"
                                 class="std_cont_inpt"
                                 placeholder="EXTN">
                        </div>
                         </div>
                    </div> -->

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

  </div></div>

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
      function chkeck_marital_status(ref)
    {
       var marital_status= $("select[name='marital_status']").val();
       console.log(marital_status);
       if(marital_status=='Married')
       {
         $("#div_married_date").css('display','block');
       }
       else
       {
        $("#div_married_date").css('display','none');
       }
    }

   /* function validate()
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
*/
</script>



<script type="text/javascript">
$(document ).ready(function (){

  $("#validation-form").validate({
    // Specify the validation rules
      rules: {
          fname: "required",
          mobile_no: {
                required: true,
                maxlength: 10
            },
          email_id: {
            required:true,
            email:true
          },
         /* last_name:"required",*/
          marital_status:"required"
        /*  work_experience:"required",
          occupation:"required",*/

      },
    // Specify the validation error messages
      messages: {
          fname: "Please enter First name.",
          last_name: "Please enter Last name.",
          email_id: "Please enter valid email id.",
          mobile_no: "Please enter valid Mobile number.",
          marital_status: "Please Select marital status.",
          work_experience: "Please enter work experience in years.",
          occupation:"Please enter occupation."
      },

  });
});
</script>



@stop