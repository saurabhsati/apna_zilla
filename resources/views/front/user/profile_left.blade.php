<div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->

                <div class="categories_sect sidebar-nav slide_m">

                 <div class="sidebar-brand">Fill Profile in Few Steps<span class="spe_mobile">&nbsp;<!--<a href="#"></a>--></span></div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="spe_submobile add_business">
                    <li class="brdr"><a class="{{ Request::segment(2)=='profile'? 'active':'' }} " href="{{url('/front_users/profile')}}">Personal Details</a></li>
                  <li class="brdr"><a class="{{ Request::segment(2)=='address'? 'active':'' }} " href="{{url('/front_users/address')}}">Addresses</a></li>
                  <li class="brdr"><a class="{{ Request::segment(2)=='change_password'? 'active':'' }} " href="{{url('/front_users/change_password')}}">Change Password</a></li>

                  <!-- <li class="brdr"><span class="process_done">5</span><a href="#">Completed</a></li> -->

               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
            </div>