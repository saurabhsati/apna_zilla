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
                 <div class="title_acc">Share With Friends</div>
                   <div class="row">

                      <form class="form-horizontal" 
                           id="validation-form" 
                           method="POST"
                           enctype="multipart/form-data"
                           >
      {{ csrf_field() }}

                 <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">              
                                                              
                   </div>                  
                    </form>
              
              </div>
               </div>
                </div>
                          
             </div>
         </div>
       </div>
       
      </div>

@stop