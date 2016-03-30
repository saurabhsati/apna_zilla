 <!--login popup start here-->
      <div id="login_poup" class="modal fade" role="dialog">

      <form class="form-horizontal" 
                           id="validation-form" 
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
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      {{ Session::get('error') }}
                  </div>
                @endif
                  <div class="login_box">
                     <div class="title_login">Login with your email and password</div>
                     <div class="user_box">
                        <div class="label_form">Email</div>
                        <input type="text" name="email" class="input_box" placeholder="enter email address"/>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Password</div>
                        <input type="password" name="password" class="input_box" placeholder="enter password"/>
                     </div>
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
                     <div class="clr"></div>
                  </div>
               </div>
               <div class="clr"></div>
               <div class="modal-footer">
                  <div class="login_box">
                     <div class="left_bar">
                        <a class="forgt" data-toggle="modal" data-target="#forget_pwd">Forget your password?</a><a data-toggle="modal" data-target="#reg_poup" class="sign_up">Sign Up Now</a>
                     </div>
                     <button type="submit"  id="login_submit" class="yellow ui button">Login</button>
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
                           id="validation-form" 
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
               </div>
               <div class="modal-body">
                  <div class="login_box">
                     <div class="title_login">Forget Password</div>

                     <div class="user_box">
                        <div class="label_form">Email</div>
                        <input type="text" class="input_box" placeholder="Enter Email Address"/>
                     </div>

                     <div class="clr"></div>
                  </div>
               </div>
               <div class="clr"></div>
               <div class="modal-footer">
                  <div class="login_box">
                     <button type="submit" class="yellow1 ui button">Submit</button>
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
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title"><img src="{{ url('/') }}/assets/front/images/logo_poup.png" alt="login logo"/></h4>
               </div>
               <div class="modal-body">
                  <div class="login_box">
                  
                     <div class="title_login">New account sign up</div>

                     <div class="user_box">
                        <div class="label_form">First Name</div>
                        <input type="text" name="first_name" class="input_box" placeholder="Enter First Name"/>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Last Name</div>
                        <input type="text" name="last_name" class="input_box" placeholder="Enter Last Name"/>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Email</div>
                        <input type="text" name="email" class="input_box" placeholder="Enter Email Address"/>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Password</div>
                        <input type="password" name="password" class="input_box" placeholder="Enter Password"/>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Confirm Password</div>
                        <input type="password" name="password_confirmation" class="input_box" placeholder="Enter Confirm Password"/>
                     </div>
                     <div class="terms_service"><input type="checkbox" class="chk_bx"/> Yes, I agree with Terms of services</div>
                     <div class="clr"></div>
                  </div>
               </div>
               <div class="clr"></div>
               <div class="modal-footer">
                  <div class="login_box">
                     <button type="submit" class="yellow1 ui button">Create An Account</button>
                     <div class="other_valida">Already have an account? <a href="#">Sign in</a></div>
                  </div>
               </div>
               <div class="clr"></div>
            </div>
         </div>
         </form>
      </div>
      <!--registration popup end here-->


<!--popup in detail page start here-->
<!-- Modal -->
<div class="modal fade" id="share" role="dialog">
    <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <div class="modal-body">
          <p>Share With Friends</p>
            <div class="soc-menu-top">
            <ul>
            <li><a href="#"><img src="images/facebook-so.png" alt="facebook"/><span class="socail_name">Facebook</span></a></li>
              <li><a href="#"><img src="images/twitter-so.png" alt="twitter"/><span class="socail_name">Twitter</span></a></li>
              <li><a href="#"><img src="images/googlepls-soc.png" alt="googlepls"/><span class="socail_name">Google +</span></a></li>
              <li><a href="#"><img src="images/linkind-soc.png" alt="linkind"/><span class="socail_name">Linkedin</span></a></li>
              <li><a href="#"><img src="images/pins-soc.png" alt="pins"/><span class="socail_name">Pinterest</span></a></li>
              <li><a href="#"><img src="images/VKontakte-so.png" alt="VKontakte"/><span class="socail_name">VKontakte</span></a></li>    
              <li><a href="#"><img src="images/msg-so.png" alt="msg"/><span class="socail_name">SMS</span></a></li>
              <li><a href="#"><img src="images/email-soc.png" alt="email"/><span class="socail_name">Email</span></a></li>      
            </ul>
            </div>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="sms" role="dialog">
    <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <div class="modal-body">
          <b class="head-t">Get information by SMS/Email</b>
           <p class="in-li">Enter the details below and click on SEND</p>
            <div class="soc-menu-top">
                <div class="col-lg-11">
            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Name</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Name" class="input_acct">
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                
                
                
            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="input-group">
                        <span id="basic-addon1" class="input-group-addon">+91</span>
                        <input type="text" required="" aria-describedby="basic-addon1" placeholder="Mobile" class="form-control">
                            
                        </div>  
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
               
                
                <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Email" class="input_acct">
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    <div class="clr"></div>
                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">&nbsp;</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                    <div class="submit-btn">
<button>Send</button>
</div>
                    </div>
                           </div>
                    </div>
                </div>
            </div>
           <div class="clr"></div>
        </div>
      </div>
    </div>
  </div>  
<div class="modal fade" id="enquiry" role="dialog">
    <div class="modal-dialog modal-sm">
     <!-- Modal content-->
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <div class="modal-body">
          <b class="head-t">Send Enquiry By Email</b>
           
            <div class="soc-menu-top" style="margin-top:20px;">
                <div class="col-lg-11">
                     <div class="user_box1">
                           <div class="row">
                    <div class="col-lg-3  label-text1">To</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                       
                          <div class="label-text1">Classic Fine Dine</div>
                        </div>
                         </div>
                    </div>
            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Name<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Name" class="input_acct">
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                
                
                
            <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="input-group">
                        <span id="basic-addon1" class="input-group-addon">+91</span>
                        <input type="text" required="" aria-describedby="basic-addon1" placeholder="Mobile" class="form-control">
                            
                        </div>  
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
               
                
                <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Email" class="input_acct">
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Subject<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Subject" class="input_acct">
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Body<span style="color:red">*</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" placeholder="Enter Body" class="input_acct">
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    <div class="clr"></div>
                       <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">&nbsp;</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                    <div class="submit-btn"><button>Ok</button></div>
                      
                    </div>
                           </div>
                    </div>
                    
                     <span class="mandt"><span style="color:red">*</span>Denotes mandatory fields. </span> 
                </div>
            </div>
           <div class="clr"></div>
        </div>
      </div>
    </div>
  </div>      
<div class="modal fade" id="verifed" role="dialog">
    <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <div class="modal-body">
          <div class="img-verify"><img src="images/process_done.png" alt=""/></div>
          <div class="center-section">
           <b class="head-t-center">What is Just Dial Verified?</b>
           <p class="just-v">Just Dial Verified(JD Verified) is an added service offering.</p>
          </div>
           
           <p class="sub-c"> Justdial verified means that the information of business establishments, professionals or service providers has been verified as existing and correct at the time of the advertiser's application to register with Justdial.  				</p>
            <div class="soc-menu-top" style="margin-top:20px; text-align:center;">
              <b class="head-t-center">What is Just Dial Verified?</b>
                <p class="sub-c">Makes short-listing of business establishments, professionals or service providers fast & easy. Information verification time is saved. </p>
                 <p class="sub-c">(PS: There is no documentary evidence gathered for verification)
<br>
If you need any more details on Justdial Verified, please refer to
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
                     <div class="row">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                           <div class="footer_heading">About US</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name">
                              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                           </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                           <div class="footer_heading">Quick link</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name">
                              <ul>
                                 <li><a href="{{ url('/') }}/page/aboutus" class="{{ Request::segment(2)=='aboutus'? 'act':'' }}"><i class="fa fa-square"></i> About Us</a></li>
                                 <li><a href="#"><i class="fa fa-square" class=""></i>Careers</a></li>
                                 <li><a href="{{ url('/') }}/page/terms-of-use" class="{{ Request::segment(2)=='terms-of-use'? 'act':'' }}"><i class="fa fa-square"></i>Terms &amp; Conditions</a></li>
                                 <li><a href="{{ url('/') }}/page/privacy" class="{{ Request::segment(2)=='privacy'? 'act':'' }}"><i class="fa fa-square"></i>Privacy Policy </a></li>
                                 <li><a href="{{ url('/') }}/contact_us" class="{{ Request::segment(1)=='contact_us'? 'act':'' }}"><i class="fa fa-square"></i> Contact Us</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                           <div class="footer_heading">Popular Cities</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name">
                              <ul>
                                 <li><a href="#"><i class="fa fa-square"></i>Mumbai</a></li>
                                 <li><a href="#"><i class="fa fa-square"></i>Delhi</a></li>
                                 <li><a href="#"><i class="fa fa-square"></i>kolkata</a></li>
                                 <li><a href="#"><i class="fa fa-square"></i>Bangalore</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                           <div class="footer_heading">Contact Info</div>
                           <div class="heading_bor"></div>
                           <div class="menu_name contect-i">
                              <ul>
                                 <li><a href="#"><i class="fa fa-envelope"></i>Email : info@rightnext.com</a></li>
                                 <li><a href="#"><i class="fa fa-phone phone-i"></i>Phone : +01-234-5789 </a></li>
                                 <li><a href="#"><i class="fa fa-map-marker phone-i"></i>Address : Rightnext Mall 39,
                                    M.G. Road Boulevard Ground Floor
                                    London</a>
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
                        <a title="" data-placement="top" data-toggle="tooltip" class="social-icon si-borderless si-facebook" href="#" data-original-title="Facebook">
                        <i class="fa fa-facebook"></i>
                        <i class="fa fa-facebook"></i>
                        </a>
                        <div class="clearfix"></div>
                     </div>
                     <div class="social-icon-footer">
                        <a data-original-title="Twitter" href="#" class="social-icon si-borderless si-twitter" data-toggle="tooltip" data-placement="top" title="">
                        <i class="fa fa-twitter"></i>
                        <i class="fa fa-twitter"></i>
                        </a>
                        <div class="clearfix"></div>
                     </div>
                     <div class="social-icon-footer">
                        <a data-original-title="Google Plus" href="#" class="social-icon si-borderless si-gplus" data-toggle="tooltip" data-placement="top" title="">                                        <i class="fa fa-google-plus"></i>
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
      <!-- jQuery -->
      <script src="{{ url('/') }}/assets/front/js/jquery.js" type="text/javascript"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="{{ url('/') }}/assets/front/js/bootstrap.min.js" type="text/javascript"></script>

      <!-- Home Page Popup for login & signup start -->
      <script type="text/javascript">
         $('.tag.example .ui.dropdown')
         .dropdown({
         allowAdditions: true
         })
         ;
      </script>
      <script type="text/javascript">
         jQuery(document).ready(function(){
           jQuery(".sign_up").click(function(){
         jQuery(".login_close").click();
           });
             jQuery(".forgt").click(function(){
         jQuery(".login_close").click();
           });

         });

      </script>
 <!-- Home Page Popup for login & signup end -->
  <!-- Listing details Tabbing Start -->
      <script type="text/javascript">
         $('.tag.example .ui.dropdown')
         .dropdown({
         allowAdditions: true
         })
         ;
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

      function logout()
      {
          gapi.auth.signOut();
          location.reload();
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

      </script>

      @if(!Auth::check())
      <script type="text/javascript" language="javascript" src="{{ url('/') }}/js/front/fb_auth.js"></script>
      @endif

<!-- BY nayan For login -->
<script type="text/javascript">
//jQuery( document ).ready()

</script>


        <!-- Listing details Tabbing End -->
         <script src="{{ url('/') }}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
            <link href="{{ url('/') }}/assets/front/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" />
             <script src="{{ url('/') }}/assets/front/js/jquery-ui.js" type='text/javascript'></script>
   </body>
</html>