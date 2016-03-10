 <!--login popup start here-->
      <div id="login_poup" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="login_close close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><img src="{{ url('/') }}/assets/front/images/logo_poup.png" alt="login logo"/></h4>
               </div>
               <div class="modal-body">
                  <div class="login_box">
                     <div class="title_login">Login with your email and password</div>
                     <div class="user_box">
                        <div class="label_form">Email</div>
                        <input type="text" class="input_box" placeholder="enter email address"/>
                     </div>
                     <div class="user_box">
                        <div class="label_form">Password</div>
                        <input type="password" class="input_box" placeholder="enter password"/>
                     </div>
                     <div class="login_social">
                        <div class="title_login"> Log in with social accounts</div>
                        <img src="{{ url('/') }}/assets/front/images/fb_login.png" alt="facebook login"/>
                        <img src="{{ url('/') }}/assets/front/images/twitter_login.png" alt="facebook login"/>
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
                     <button type="submit" class="yellow ui button">Login</button>
                  </div>
               </div>
               <div class="clr"></div>
            </div>
         </div>
      </div>
      <!--login popup end here-->
    <!--forget password popup start here-->

        <div id="forget_pwd" class="modal fade" role="dialog" style="overflow:auto;">
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
      </div>
    <!--forget password poup end here-->


      <!--registration popup start here-->
      <div id="reg_poup" class="modal fade" role="dialog" style="overflow:auto;">

                     <form id="validation-form" 
                           method="POST"
                           action="{{ url('/web_admin/front_users/store') }}" 
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
                        <input type="password" name="confirm_password" class="input_box" placeholder="Enter Confirm Password"/>
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
        <!-- Listing details Tabbing End -->
         <script src="{{ url('/') }}/assets/front/js/easyResponsiveTabs.js" type="text/javascript"></script>
            <link href="{{ url('/') }}/assets/front/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" />
   </body>
</html>