 <style type="text/css">
.sidebar-nav li a .active {

color: #e6ab2a;
}
 </style>
 <div class="col-sm-12 col-md-3 col-lg-3">
               <div class="categories_sect sidebar-nav slide_m">

                <div class="sidebar-brand">Business Information</div>
                <div class="bor_head">&nbsp;</div>
                <ul class="add_business">
                   <li class="brdr"><a class="{{ Request::segment(2)=='edit_business_step1'? 'active':'' }} " href="{{ url('/front_users/edit_business_step1/'.Request::segment(3))}}" >Business Information</a></li>
                  <li class="brdr"><a class="{{ Request::segment(2)=='edit_business_step2'? 'active':'' }} " href="{{ url('/front_users/edit_business_step2/'.Request::segment(3))}}">Location Information</a></li>
                  <li class="brdr"><a class="{{ Request::segment(2)=='edit_business_step3'? 'active':'' }} " href="{{ url('/front_users/edit_business_step3/'.Request::segment(3))}}">Contact Information</a></li>
                  <li class="brdr"><a class="{{ Request::segment(2)=='edit_business_step4'? 'active':'' }} " href="{{ url('/front_users/edit_business_step4/'.Request::segment(3))}}">Other Information</a></li>
                  <li class="brdr"><a class="{{ Request::segment(2)=='edit_business_step5'? 'active':'' }} " href="{{ url('/front_users/edit_business_step5/'.Request::segment(3))}}">Pictures/Services</a></li>

                </ul>
                <div class="clearfix"></div>
               </div>

               <!--  <div class="categories_sect sidebar-nav slide_m">
                 <div class="sidebar-brand">Service Request</div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="">
                    <li class="brdr"><a href="#">ECS/CCSI Active/Pause</a></li>
                  <li class="brdr"><a href="#">Submit An online Request/Complaint</a></li>
                  </ul>
                <div class="clearfix"></div>
                </div> -->
            </div>
