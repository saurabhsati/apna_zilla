
  <!--Sens SMS OTP popup start here-->
        <a class="forgt" id="sms_otp_div_popup" data-toggle="modal" data-target="#sms_otp_popup"></a>
        <div id="sms_otp_popup" class="modal fade" role="dialog" style="overflow:auto;">

        <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action=""
                           enctype="multipart/form-data"
                           >

        {{ csrf_field() }}

         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close login_close1" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><img src="{{ url('/') }}/assets/front/images/logo_poup.png" alt="login logo"/></h4>
               </div>
               <div class="modal-body">

                <div class="alert alert-success alert-dismissible" id="otp_succ_div" style="display: none;">
                    <strong>Success!</strong>
                   Your SMS Send Successfully Activated.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible" id="otp_err_div" style="display: none;">
                    <strong>Error!</strong>
                   Incorrect OTP
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>

                 <div class="alert alert-danger alert-dismissible" id="otp_mobile_err_div" style="display: none;">
                    <strong>Error!</strong>
                   Incorrect Mobile No.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>

                  <div class="login_box">
                     <div class="title_login">Confirm SMS Sending OTP</div>

                     <div class="user_box">
                        <div class="label_form">OTP</div>
                        <input type="text" class="input_box" name="otp_no" id="otp_no" placeholder="Enter Your OTP"/>
                        <input type="hidden" class="input_box" name="mobile_no_otp" id="mobile_no_otp" value=""/>
                        <div id="otp_error" style="display: none;"><i style="color: red;">Please Fill Field</i></div>
                        <div id="otp_rule_error" style="display: none;"><i style="color: red;">Invalid OTP</i></div>
                     </div>

                     <div class="clr"></div>
                  </div>
               </div>
               <div class="clr"></div>
               <div class="modal-footer">
                  <div class="login_box">
                     <button type="button" onclick="SMS_OTP_check()" class="yellow1 ui button">Submit</button>
                   </div>
               </div>
               <div class="clr"></div>
            </div>
         </div>
         </form>
      </div>
    <!--Send Sms OTP poup end here-->
 <!--login popup start here-->
      <div id="login_poup" class="modal fade" role="dialog">

      <form class="form-horizontal"
                           id="login_form"
                           method="POST"
                           action="{{ url('/front_users/process_login') }}"
                           enctype="multipart/form-data"
                           >

        {{ csrf_field() }}

         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="login_close close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><img src="{{ url('/') }}/assets/front/images/logo_poup.png" alt="login logo"/></h4>
               </div>
               <div class="modal-body">

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
                      <span id="display_msg"> </span>
                  </div>
                @endif

                <div class="alert alert-danger alert-dismissible" id="error_div" style="display: none;">

                    <strong>Error!</strong>
                    Incorrect Login Credentials
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <!-- <span aria-hidden="true">&times;</span> -->
                      </button>
                </div>

                <div class="alert alert-danger alert-dismissible" id="mobile_error_div" style="display: none;">
                    <strong>Error!</strong>
                    Incorrect Mobile No.
                </div>

                <div class="alert alert-danger alert-dismissible" id="Acc_activation_err_div" style="display: none;">
                    <strong>Error!</strong>
                    Your Account Not Activate Yet.
                </div>

                  <div class="login_box">
                     <div class="title_login">Login with your email and password</div>

                     <div class="user_box">
                        <div class="label_form">Email/Mobile No.</div>
                        <input type="text" name="email" id="email_login" class="input_box" data-rule-required="true" placeholder="Enter Email Address/ Mobile No."/>
                        <div id="email_login_err" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Password</div>
                        <input type="password" name="password"  id="password_login" data-rule-required="true" class="input_box" placeholder="Enter password"/>
                        <div id="password_login_err" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                     </div>
                      <div class="login_box">
                     <div class="left_bar">
                        <a class="forgt" data-toggle="modal" data-target="#forget_pwd">Forget your password?</a>
                        <a data-toggle="modal" id="open_register" data-target="#reg_poup" onclick="set_business_list_flag()" class="sign_up">Sign Up Now</a>
                     </div>
                     <button type="button"  id="login_submit" onclick="login_submit_form()" class="yellow ui button">Login</button>
                     <img src="{{ url('/') }}/assets/front/images/or1.png" alt="facebook login"/>
                  </div>

                     <div class="clr"></div>
                  </div>
               </div>

               <div class="clr"></div>
               <div class="modal-footer">
                <div class="login_social">
                        <div class="title_login"> Log in with social accounts</div>
                        <a href="javascript:void(0);" onclick="FBLogin()">
                           <img src="{{ url('/') }}/assets/front/images/fb_login.png" alt="facebook login"/>
                        </a>
                       <br/><br/>
                        <a href="javascript:void(0);" onclick="login()">
                           <img src="{{ url('/') }}/assets/front/images/google-plus.jpg" alt="facebook login"/>
                        </a>
                     </div>

               </div>
               <div class="clr"></div>

            </div>
         </div>
         </form>
      </div>
      <!--login popup end here-->
    <!--forget password popup start here-->

        <div id="forget_pwd" class="modal fade" role="dialog" style="overflow:auto;">

        <form class="form-horizontal"
                           id="recover_password"
                           method="POST"
                           action="{{ url('/forgot_password') }}"
                           enctype="multipart/form-data"
                           >

        {{ csrf_field() }}


         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close login_close1" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><img src="{{ url('/') }}/assets/front/images/logo_poup.png" alt="login logo"/></h4>
               <div style="position:fixed;
                top: 0;
                bottom: 0;
                left:0;
                right:0;
                background-color:#ccc;
                opacity:0.5;
                display:none;"
                 id="subscribr_loader">
                <img src="{{ url('/') }}/assets/front/images/ajax-loader.gif" style="height:100px; width:100px; position:absolute; top:35%;left:45%" />
               </div>
               </div>

               <div class="modal-body">

                  <div class="login_box">
                     <div class="title_login">Forget Password</div>
                     <div class="alert alert-success fade in " id = "rec_pwd_succ" style="display:none;">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Success!</strong> We have sent you an email with a confirmation link. Please click on the link to confirm your recover password ! ..
                      </div>
                       <div class="alert alert-danger" style="display:none;" id = "rec_pwd_err">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Error!</strong>While Sending Enquiry .
                      </div>
                     <div class="user_box">
                        <div class="label_form">Email</div>
                        <input type="text" name="recover_email" id="recover_email" class="input_box" placeholder="Enter Email Address"/>
                          <div class="error_msg" id="err_recover_email"></div>
                     </div>

                     <div class="clr"></div>
                  </div>
               </div>
               <div class="clr"></div>
               <div class="modal-footer">
                  <div class="login_box">
                     <button type="submit" id="forgot_submit" name="forgot_submit" class="yellow1 ui button">Submit</button>
                   </div>
               </div>
               <div class="clr"></div>
            </div>
         </div>
         </form>
      </div>
    <!--forget password poup end here-->



    <!--Registration OTP popup start here-->
        <a class="forgt" id="reg_otp_div_popup" data-toggle="modal" data-target="#reg_otp_popup"></a>
        <div id="reg_otp_popup" class="modal fade" role="dialog" style="overflow:auto;">

        <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action=""
                           enctype="multipart/form-data"
                           >

        {{ csrf_field() }}

        <input type="hidden" id="bus_listing" value="" />

         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close login_close1" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><img src="{{ url('/') }}/assets/front/images/logo_poup.png" alt="login logo"/></h4>
               </div>
               <div class="modal-body">

                <div class="alert alert-success alert-dismissible" id="otp_succ_div" style="display: none;">
                    <strong>Success!</strong>
                   Your Account Successfully Activated.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>

                <div class="alert alert-danger alert-dismissible" id="otp_err_div" style="display: none;">
                    <strong>Error!</strong>
                   Incorrect OTP
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>

                 <div class="alert alert-danger alert-dismissible" id="otp_mobile_err_div" style="display: none;">
                    <strong>Error!</strong>
                   Incorrect Mobile No.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>

                  <div class="login_box">
                     <div class="title_login">Confirm Registration OTP</div>

                     <div class="user_box">
                        <div class="label_form">OTP</div>
                        <input type="text" class="input_box" name="reg_otp_no" id="reg_otp_no" placeholder="Enter Your OTP"/>
                        <input type="hidden" class="input_box" name="reg_mobile_no_otp" id="reg_mobile_no_otp" value=""/>
                        <div id="otp_error" style="display: none;"><i style="color: red;">Please Fill Field</i></div>
                        <div id="otp_rule_error" style="display: none;"><i style="color: red;">Invalid OTP</i></div>
                     </div>

                     <div class="clr"></div>
                  </div>
               </div>
               <div class="clr"></div>
               <div class="modal-footer">
                  <div class="login_box">
                     <button type="button" onclick="OTP_check()" class="yellow1 ui button">Submit</button>
                   </div>
               </div>
               <div class="clr"></div>
            </div>
         </div>
         </form>
      </div>
    <!--forget password poup end here-->



      <!--registration popup start here-->
      <div id="reg_poup" class="modal fade" role="dialog" style="overflow:auto;">


                     <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/store') }}"
                           enctype="multipart/form-data"
                           >

      {{ csrf_field() }}



         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close login_close" id="reg_close1" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"><img src="{{ url('/') }}/assets/front/images/logo_poup.png" alt="login logo"/></h4>
               </div>
               <div class="modal-body">

               <div id="reg_err_div">

               </div>

                  <div class="login_box">

                     <div class="title_login">New account sign up</div>

                       <!-- <a class="forgt" id="otp_div_popup" data-toggle="modal" data-target="#otp_popup">Check</a> -->

                     <div class="user_box">
                        <div class="label_form">First Name</div>
                        <input type="text" name="first_name" id="first_name" class="input_box" placeholder="Enter First Name"/>
                        <div id="f_name_error" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Last Name</div>
                        <input type="text" name="last_name" id="last_name" class="input_box" placeholder="Enter Last Name"/>
                        <div id="l_name_error" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Email</div>
                        <input type="text" name="email" id="emailid" class="input_box" placeholder="Enter Email Address"/>
                        <div id="e_error" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                        <div id="email_error" style="display: none;"><i style="color: red;margin-left: -200px;">Invalid Email Id</i></div>
                     </div>

                     <div class="user_box">
                        <div class="label_form">Mobile</div>
                        <input type="text" name="mobile" id="mobile" class="input_box" placeholder="Enter mobile No."/>
                        <div id="m_error" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                         <div id="mobile_no_error" style="display: none;"><i style="color: red;margin-left: -200px;">Invalid Mobile No</i></div>
                     </div>

                     <div class="user_box">
                        <div class="label_form">Password</div>
                        <input type="password" name="password" id="password" class="input_box" placeholder="Enter Password"/>
                        <div id="p_error" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                        <div id="p_len_error" style="display: none;"><i style="color: red;margin-left: -200px;">Password length Atleast 6</i></div>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Confirm Password</div>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="input_box" placeholder="Enter Confirm Password"/>
                        <div id="c_pass_error" style="display: none;"><i style="color: red;margin-left: -200px;">Please Fill Field</i></div>
                        <div id="confirm_pass_error" style="display: none;"><i style="color: red;margin-left: -170px;">Password Missmatched</i></div>
                     </div>
                     <div class="terms_service"><input type="checkbox" id="terms_to_agree" class="chk_bx"/> Yes, I agree with Terms of services</div>
                     <div class="clr"></div>
                  </div>
               </div>
               <div class="clr"></div>
               <div class="modal-footer">
                  <div class="login_box">
                     <button type="button" id="register_acount" onclick="register_new_account()" class="yellow1 ui button">Create An Account</button>
                     <div class="other_valida">Already have an account? <a class="reg-popup" data-toggle="modal" data-target="#login_poup">Sign in</a></div>
                  </div>
               </div>
               <div class="clr"></div>
            </div>
         </div>
         </form>
      </div>
      <!--registration popup end here-->


<!--popup in detail page start here-->




<div class="modal fade" id="verifed" role="dialog">
    <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <div class="modal-body">
          <div class="img-verify"><img src="{{ url('/') }}/assets/front/images/process_done.png" alt=""/></div>
          <div class="center-section">
           <b class="head-t-center">What is RightNext Verified?</b>
           <p class="just-v">RightNext Verified(RightNext Verified) is an added service offering.</p>
          </div>

           <p class="sub-c"> RightNext verified means that the information of business establishments, professionals or service providers has been verified as existing and correct at the time of the advertiser's application to register with RightNext.  				</p>
            <div class="soc-menu-top" style="margin-top:20px; text-align:center;">
              <b class="head-t-center">What is RightNext Verified?</b>
                <p class="sub-c">Makes short-listing of business establishments, professionals or service providers fast & easy. Information verification time is saved. </p>
                 <p class="sub-c">(PS: There is no documentary evidence gathered for verification)
<br>
If you need any more details on RightNext Verified, please refer to
                <a href="#">terms &amp; conditions</a></p>
            </div>
           <div class="clr"></div>
        </div>
      </div>
    </div>
  </div>
<!--popup in detail page end here-->




 <!--Footer-->
      <footer>
         <div class="footer_links">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="row"><?php //print_r($about_us);exit;?>
                     @if(sizeof($about_us)>0)
                        <div class="col-sm-3 col-md-3 col-lg-3">
                         <div class="footer_heading">{{$about_us['page_title'] or ''}}</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name">
                            <?php echo isset($about_us['page_desc'])?str_limit($about_us['page_desc'],250):"";?>
                            <a href="{{ url('/') }}/page/aboutus" class="{{ Request::segment(2)=='aboutus'? 'act':'' }}">View More</a>
                           </div>
                        </div>

                       @endif
                        <div class="col-sm-3 col-md-3 col-lg-3">
                           <div class="footer_heading">Quick link</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name">
                              <ul>
                                 <li><a href="{{ url('/') }}/page/aboutus" class="{{ Request::segment(2)=='aboutus'? 'act':'' }}"><i class="fa fa-square"></i> About Us</a></li>
                                <!--  <li><a href="#"><i class="fa fa-square" class=""></i>Careers</a></li>
                                  --><li><a href="{{ url('/') }}/page/terms-of-use" class="{{ Request::segment(2)=='terms-of-use'? 'act':'' }}"><i class="fa fa-square"></i>Terms &amp; Conditions</a></li>
                                 <li><a href="{{ url('/') }}/page/privacy" class="{{ Request::segment(2)=='privacy'? 'act':'' }}"><i class="fa fa-square"></i>Privacy Policy </a></li>
                                 <li><a href="{{ url('/') }}/contact_us" class="{{ Request::segment(1)=='contact_us'? 'act':'' }}"><i class="fa fa-square"></i> Contact Us</a></li>
                                 <li><a href="{{ url('/') }}/faqs" class="{{ Request::segment(1)=='faqs'? 'act':'' }}"><i class="fa fa-square"></i> FAQs</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                           <div class="footer_heading">Popular Cities</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name">
                              <ul>
                               @if(sizeof($popular_cities)>0)
                                @foreach($popular_cities as $city)
                                 <li><a href="{{ url('/') }}/{{$city['city_title']}}/popular-city"><i class="fa fa-square"></i>{{$city['city_title']}}</a></li>
                                 @endforeach
                                 @endif
                                <!--  <li><a href="{{ url('/') }}/Delhi/popular-city"><i class="fa fa-square"></i>Delhi</a></li>
                                 <li><a href="{{ url('/') }}/kolkata/popular-city"><i class="fa fa-square"></i>kolkata</a></li>
                                 <li><a href="{{ url('/') }}/Bangalore/popular-city"><i class="fa fa-square"></i>Bangalore</a></li> -->
                              </ul>
                           </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                           <div class="footer_heading">Contact Info</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name contect-i">
                            <ul>
                                 <li><a href="javascript:void(0);"><i class="fa fa-envelope"></i>Email :  @if(isset($site_settings['site_email_address'])){{$site_settings['site_email_address']}}@endif</a></li>
                                 <li><a href="javascript:void(0);"><i class="fa fa-phone phone-i"></i>Phone :  @if(isset($site_settings['phone_number'])){{$site_settings['phone_number']}}@endif </a></li>
                                 <li><a href="javascript:void(0);"><i class="fa fa-map-marker phone-i"></i>Address :  @if(isset($site_settings['site_address'])){{$site_settings['site_address']}}@endif</a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
      </footer>
      <div class="footer_copyright">
         <div class="container">
            <div class="row">

               <div class="col-sm-8 col-md-8 col-lg-8 pull-left">
                  <div class="copyright_l pull-right"><span><a href="#">Copyright</a></span> &copy; 2016 by<span><a href="#"> rightnext.com</a></span> All rights reserved.</div>
               </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                  <div class="social-icon-block">
                     <div class="social-icon-footer">

                        <a title="" data-placement="top" data-toggle="tooltip" class="social-icon si-borderless si-facebook" href="{{isset($site_settings['fb_url'])?$site_settings['fb_url']:''}}" data-original-title="Facebook">
                        <i class="fa fa-facebook"></i>
                        <i class="fa fa-facebook"></i>
                        </a>
                        <div class="clearfix"></div>
                     </div>
                     <div class="social-icon-footer">
                        <a data-original-title="Twitter" href="{{isset($site_settings['twitter_url'])?$site_settings['twitter_url']:''}}" class="social-icon si-borderless si-twitter" data-toggle="tooltip" data-placement="top" title="">
                        <i class="fa fa-twitter"></i>
                        <i class="fa fa-twitter"></i>
                        </a>
                        <div class="clearfix"></div>
                     </div>
                     <div class="social-icon-footer">
                        <a data-original-title="Google Plus" href="{{isset($site_settings['youtube_url'])?$site_settings['youtube_url']:''}}" class="social-icon si-borderless si-gplus" data-toggle="tooltip" data-placement="top" title="">
                        <i class="fa fa-google-plus"></i>
                        <i class="fa fa-google-plus"></i>
                        </a>
                        <div class="clearfix"></div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
      </div>

      <!-- Home Page Popup for login & signup start -->

     <!--  <script type='text/javascript' src="{{ url('/') }}/assets/front/js/jquery-1.11.3.min.js"></script> -->




      <script type="text/javascript">
         jQuery(document).ready(function(){
           jQuery(".sign_up").click(function(){
         jQuery(".login_close").click();
           });
             
             jQuery(".forgt").click(function(){
         jQuery(".login_close").click();
           });
             
             jQuery("#log_in_popup").click(function(){
         jQuery("#reg_close").click();
           });
             
             
              jQuery(".reg-popup").click(function(){
         jQuery(".login_close").click();
           });
         });

      </script>




 <!-- Home Page Popup for login & signup end -->
  <!-- Listing details Tabbing Start -->

    <script type="text/javascript">
        $(document).ready(function(){
          $(".dropdown-toggle").dropdown();
        });
    </script>
      <script type="text/javascript">
         $(document).ready(function () {

             $('#dash_tab').easyResponsiveTabs({
                 type: 'default', //Types: default, vertical, accordion
                 width: 'auto', //auto or any width like 600px
                 fit: true,   // 100% fit in a container
                 closed: 'accordion', // Start closed if in accordion view
                 activate: function(event) { // Callback function if tab is switched
                     var $tab = $(this);
                     var $info = $('#tabInfo');
                     var $name = $('span', $info);

                     $name.text($tab.text());

                     $info.show();
                 }
             });

             $('#verticalTab').easyResponsiveTabs({
                 type: 'vertical',
                 width: 'auto',
                 fit: true
             });
         });
      </script>


<script type="text/javascript">

  function set_flag()
  {
      $("#bus_listing").val("1");
  }

  function set_business_list_flag()
  {
     $("#bus_listing").val("0");
  }

  function OTP_check()
  {

    var site_url   = "{{ url('/') }}";
    var otp        = $('#reg_otp_no').val();
    var mobile_no  = $('#reg_mobile_no_otp').val();
    var token      = jQuery("input[name=_token]").val();
    console.log(mobile_no);
    console.log(otp);

    var bus_listing= jQuery("#bus_listing").val();

    var otp_filter = /^[0-9]{0,30}$/;

    $('#otp_no').keyup(function(){
       $('#otp_error').hide();
       $('#otp_rule_error').hide();
    });


    if(otp=="")
    {
      $('#otp_error').show();
    }
    else if(!otp_filter.test(otp))
    {
      $('#otp_rule_error').show();
    }
    else
    {
     jQuery.ajax({
         url      : site_url+"/front_users/otp_check?_token="+token,
         method   : 'POST',
         dataType : 'json',
         data     : 'otp='+otp+'&mobile_no='+mobile_no,
         success: function(response)
         {
          //console.log(response);
            if(response.status == "SUCCESS" )
            {
              //console.log(response.mobile_no);

             $('#reg_otp_no').val('');
             $('#reg_mobile_no_otp').val('');


              if(bus_listing == "1")
              {
                document.location.href = site_url+"/front_users/add_business";
              }

              if(bus_listing == "0")
              {
                document.location.href = site_url;
               /*$('#otp_no').val('');
               $('#mobile_no_otp').val('');

               $('#otp_succ_div').show();
               $('#otp_err_div').hide();
               $('#otp_mobile_err_div').hide();*/
             }
             //$('#reg_succ_div').show();
            }
            else if(response.status == "ERROR")
            {
                $('#otp_err_div').show();
                $('#otp_mobile_err_div').hide();
                $('#otp_succ_div').hide();
            }
            else if(response.status == "MOBILE_ERROR")
            {
                $('#otp_mobile_err_div').show();
                $('#otp_err_div').hide();
                $('#otp_succ_div').hide();
            }

         }
      });
    }
  }


  function register_new_account()
  {

    var site_url   = "{{ url('/') }}";
    var first_name = $('#first_name').val();
    var last_name  = $('#last_name').val();
    var email      = $('#emailid').val();
    var mobile     = $('#mobile').val();
    var password   = $('#password').val();
    var conf_password  = $('#password_confirmation').val();
    var filter = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
    var mob_filter = /^[0-9]{10}$/;
    var token      = jQuery("input[name=_token]").val();
    //var business_listing = $('#bus_listing').val();


    if(first_name=="")
    {
      $('#f_name_error').show();
    }
    else if(last_name=="")
    {
      $('#l_name_error').show();
    }
    /*else if(email=="")
    {
      $('#e_error').show();
    }
    else if(!filter.test(email))
    {
      $('#email_error').show();
    }*/
    else if(mobile=="")
    {
      $('#m_error').show();
    }
    else if(!mob_filter.test(mobile))
    {
      $('#mobile_no_error').show();
    }
    else if(password=="")
    {
      $('#p_error').show();
    }
    else if(conf_password=="")
    {
      $('#c_pass_error').show();
    }
    else if(conf_password!=password)
    {
      $('#confirm_pass_error').show();
    }
    else
    {
      jQuery.ajax({
           url      : site_url+"/front_users/store?_token="+token,
           method   : 'POST',
           dataType : 'json',
           data     : 'email='+email+'&password='+password+'&first_name='+first_name+'&last_name='+last_name+'&mobile='+mobile,
           success: function(response)
           {
            //console.log(response);
              if(response.status == "SUCCESS" )
              {
                //console.log(response.mobile_no);
                $('#first_name').val('');
                $('#last_name').val('');
                $('#email').val('');
                $('#mobile').val('');
                $('#password').val('');
                $('#password_confirmation').val('');
                $('#terms_to_agree').val('');

                $('#reg_otp_div_popup').click();
                $('#reg_mobile_no_otp').val(response.mobile_no);
                //$('#mobile_no_otp').val(response.mobile_no);
                $('#reg_poup').modal('hide');
                 //$('#reg_succ_div').show();
              }
              else if(response.status == "ERROR")
              {
                  $("#reg_err_div").empty();
                  $("#reg_err_div").fadeIn();
                  $("#reg_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                  return false;
              }
              else if(response.status == "OTP_ERROR")
              {
                 $("#reg_err_div").empty();
                 $("#reg_err_div").fadeIn();
                 $("#reg_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }
              else if(response.status == "MOBILE_ERROR")
              {
                 $("#reg_err_div").empty();
                 $("#reg_err_div").fadeIn();
                  $("#reg_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }
              else if(response.status == "EMAIL_EXIST_ERROR")
              {
                 $("#reg_err_div").empty();
                 $("#reg_err_div").fadeIn();
                  $("#reg_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }
              else if(response.status == "VALIDATION_ERROR")
              {
                 $("#reg_err_div").empty();
                 $("#reg_err_div").fadeIn();
                  $("#reg_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }
              else if(response.status == "MOBILE_EXIST_ERROR")
              {
                 $("#reg_err_div").empty();
                 $("#reg_err_div").fadeIn();
                 $("#reg_err_div").html("<div class='alert alert-danger'><strong>Error! </strong>"+response.msg+"</div>");
                 return false;
              }
              else
              {

              }

              setTimeout(function()
              {
                  $("#reg_err_div").fadeOut();
              },5000);

              return false;
           }
        });
    }
  }
  $(document).ready(function(){
    $('#first_name').keyup(function()
      {
        $('#f_name_error').hide();
      });
    $('#last_name').keyup(function()
      {
        $('#l_name_error').hide();
      });
    $('#emailid').keyup(function()
      {
        $('#email_error').hide();
        $('#e_error').hide();
      });
    $('#mobile').keyup(function()
      {

          $('#m_error').hide();
          $('#mobile_no_error').hide();
      });
    $('#password').keyup(function()
      {
        $('#p_error').hide();
        $('#p_len_error').hide();
      });
    $('#password_confirmation').keyup(function()
      {
        $('#c_pass_error').hide();
        $('#confirm_pass_error').hide();
      });
  });
</script>

<script type="text/javascript">
 var url = "{{ url('/') }}";

      (function() {
         var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
         po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
         var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();

      function onLoadCallback()
      {
          gapi.client.setApiKey('AIzaSyA0RjSTag9y7TEXq2mLM__ISj1X0pIonK0'); //set your API KEY
          gapi.client.load('plus', 'v1',function(){});//Load Google + API
      }

      function login()
      {
        var myParams = {
          'clientid' : '279126872962-83k1t2br3lseplje5lipejn1qp1n4khs.apps.googleusercontent.com', // You need to set client id
          'cookiepolicy' : 'single_host_origin',
          'callback' : 'loginCallback', //callback function
          'approvalprompt':'force',
          'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
        };
        gapi.auth.signIn(myParams);
      }

     /* function logout()
      {
          gapi.auth.signOut();
          location.reload();
      }*/

      function logout()
      {
        document.location.href = "https://accounts.google.com/Logout";



         window.location.reload();
      }

      function loginCallback(result)
      {
          if(result['status']['signed_in'])
          {
              var request = gapi.client.plus.people.get(
              {
                  'userId': 'me'
              });

          request.execute(function (resp)
          {
              var email = '';

              if(resp['emails'])
              {
                  for(i = 0; i < resp['emails'].length; i++)
                  {
                      if(resp['emails'][i]['type'] == 'account')
                      {
                          email = resp['emails'][i]['value'];
                      }
                  }
              }

              var token = $('input[name="_token"]').val();

              var name = resp['displayName'];
              var image = resp['image']['url'];

              jQuery.ajax({
                      url:url+'/google_plus/register',
                      type:'POST',
                      data:'email='+email+'&name='+name+'&image='+image+'&_token='+token,
                      dataType:'json',

                      success:function(response)
                      {
                          console.log(response);
                          if(response.status == "SUCCESS")
                          {
                            location.href= url+'/front_users/profile';
                            // location.href= url+'/myaccount/';
                          }
                          else
                          {
                            alert("Error While Creating Account");
                          }

                      },
                });
            });
          }

      }

      function SMS_OTP_check()
      {
          var site_url   = "{{ url('/') }}";
          var otp        = $('#otp_no').val();
          var mobile_no  = $('#mobile_no_otp').val();
          var token      = jQuery("input[name=_token]").val();

          var otp_filter = /^[0-9]{0,30}$/;

          $('#otp_no').keyup(function(){
             $('#otp_error').hide();
             $('#otp_rule_error').hide();
          });
          if(otp=="")
          {
            $('#otp_error').show();
          }
          else if(!otp_filter.test(otp))
          {
            $('#otp_rule_error').show();
          }
          else
          {
           jQuery.ajax({
               url      : site_url+"/listing/sms_otp_check?_token="+token,
               method   : 'POST',
               dataType : 'json',
               data     : 'otp='+otp+'&mobile_no='+mobile_no,
               success: function(response)
               {
                //console.log(response);
                  if(response.status == "SUCCESS" )
                  {
                    $('#otp_no').val('');
                    $('#mobile_no_otp').val('');
                    $('#otp_succ_div').show();
                    $('#otp_succ_div').html("SMS Send Successfully");

                  }
                  else if(response.status == "ERROR")
                  {
                    $('#otp_err_div').show();
                    $('#otp_mobile_err_div').hide();
                    $('#otp_succ_div').hide();
                  }
                  else if(response.status == "MOBILE_ERROR")
                  {
                    $('#otp_mobile_err_div').show();
                    $('#otp_err_div').hide();
                    $('#otp_succ_div').hide();
                  }

               }
            });
        }
      }
      </script>

  @if(!Auth::check())
  <script type="text/javascript" language="javascript" src="{{ url('/') }}/js/front/fb_auth.js"></script>
  @endif

<!-- BY nayan For login -->
<script type="text/javascript">

  function login_submit_form()
  {
    var site_url = "{{ url('/') }}";
    var token     = jQuery("input[name=_token]").val();
    var email     = jQuery("#email_login").val();
    var password  = jQuery("#password_login").val();

    $("#email_login").keyup(function(){
        $('#email_login_err').hide();
    });
     $("#password_login").keyup(function(){
       $('#password_login_err').hide();
    });

    if(email=="")
    {
      $('#email_login_err').show();
    }
    else if(password=="")
    {
      $('#password_login_err').show();
    }
    else
    {
      jQuery.ajax({
         url      : site_url+"/front_users/process_login_ajax?_token="+token,
         method   : 'POST',
         dataType : 'json',
         data     : { email:email,password:password },
         success: function(response){
            if(response == "SUCCESS" )
            {
               location.href= site_url+"/front_users/profile";
            }
            else if(response == "Invalid Credentials")
            {
                $('#error_div').show();
                $('#mobile_error_div').hide();
                $('#Acc_activation_err_div').hide();
            }
            else if(response == "Invalid Mobile_no")
            {
               $('#mobile_error_div').show();
               $('#error_div').hide();
               $('#Acc_activation_err_div').hide();
            }
            else if(response == "ACC_ACT_ERROR")
            {
              $('#Acc_activation_err_div').show();
              $('#error_div').hide();
              $('#mobile_error_div').hide();
            }
            else
            {

            }

         }
      });
    }
  }
</script>

<script type="text/javascript">
  $(document).ready(function(){

  $("#forgot_submit").click(function(e){
     e.preventDefault();
      var email=$('#recover_email').val();
       var filter = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
       if(email.trim()=='')
      {
        $('#err_recover_email').html('Enter Your Email ID.');
        $('#err_recover_email').show();
        $('#recover_email').focus();
        $('#recover_email').on('keyup', function(){
        $('#err_recover_email').hide();
          });


      }
      else if(!filter.test(email))
     {
        $('#err_recover_email').html('Enter Valid Email ID.');
        $('#err_recover_email').show();
        $('#recover_email').focus();
        $('#recover_email').on('keyup', function(){
        $('#err_recover_email').hide();
          });
       }
       else
      {
        $.ajax({
          type:"POST",
          url:site_url+'/front_users/recover_password',
          data:$("#recover_password").serialize(),
          beforeSend: function()
          {
            $("#subscribr_loader").show();
          },
          success:function(res)
          {
            if(res=="success")
            {
               $("#rec_pwd_succ").fadeIn(3000).fadeOut(3000);
               $("#recover_password").trigger('reset');
            }
            else if(res=="sending_error")
            {
               $("#rec_pwd_err").fadeIn(3000).fadeOut(3000);
               $("#recover_password").trigger('reset');
            }
            else
            {

              $("#rec_pwd_err").fadeIn(3000).fadeOut(3000);
            }
          },
          complete: function() {

          $("#subscribr_loader").hide();

          }
        });


      }

  });
});
</script>


<!-- jquery validation -->
<script type="text/javascript" src="{{url('/')}}/assets/jquery-validation/dist/jquery.validate.min.js"></script>

<!-- <input type="hidden" id="is_session_mail" value="<?php //echo $is_mail ;?>" > </input>
 -->


 <script type="text/javascript">
var supports = (function () {
    var a = document.documentElement,
        b = "ontouchstart" in window || navigator.msMaxTouchPoints;
    if(b) 
    {
        a.className += " touch";
        return {
            touch:false
        }
    }
    else
    {
        a.className += " no-touch";
        return {
            touch:true
        }
    }
});


if ($("html").hasClass("no-touch")) {


  $('.dropdown > a').removeAttr("data-toggle");


    (function (e, t, n) {
        if ("ontouchstart" in document) return;
        var r = e();
        e.fn.dropdownHover = function (n) {
            r = r.add(this.parent());
            return this.each(function () {
                var i = e(this),
                    s = i.parent(),
                    o = {
                        delay: 0,
                        instantlyCloseOthers: !0
                    }, u = {
                        delay: e(this).data("delay"),
                        instantlyCloseOthers: e(this).data("close-others")
                    }, a = e.extend(!0, {}, o, n, u),
                    f;
                s.hover(function (n) {
                    if (!s.hasClass("open") && !i.is(n.target)) return !0;
                    a.instantlyCloseOthers === !0 && r.removeClass("open");
                    t.clearTimeout(f);
                    s.addClass("open");
                    s.trigger(e.Event("show.bs.dropdown"))
                }, function () {
                    f = t.setTimeout(function () {
                        s.removeClass("open");
                        s.trigger("hide.bs.dropdown")
                    }, 1)
                });
                i.hover(function () {
                    a.instantlyCloseOthers === !0 && r.removeClass("open");
                    t.clearTimeout(f);
                    s.addClass("open");
                    s.trigger(e.Event("show.bs.dropdown"))
                });
                s.find(".dropdown-submenu").each(function () {
                    var n = e(this),
                        r;
                    n.hover(function () {
                        t.clearTimeout(r);
                        n.children(".dropdown-menu").show();
                        n.siblings().children(".dropdown-menu").hide()
                    }, function () {
                        var e = n.children(".dropdown-menu");
                        r = t.setTimeout(function () {
                            e.hide()
                        }, a.delay)
                    })
                })
            })
        };
        e(document).ready(function () {

            e('[data-hover="dropdown"]').dropdownHover()
        })
    })(jQuery, this);

 } //END IF no-touch for hover script & removeAttr for the links to work
</script>

      
 <script src="{{ url('/') }}/assets/front/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- Listing details Tabbing End -->
  <script src="{{ url('/') }}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
  <link href="{{ url('/') }}/assets/front/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" />
  <script src="{{ url('/') }}/assets/front/js/jquery-ui.js" type='text/javascript'></script>

   </body>
</html>