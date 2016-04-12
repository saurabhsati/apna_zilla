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
                  <li class="brdr"><!-- <span class="steps">4</span> --><a href="{{ url('/').'/front_users/my_favourites' }}">Favorites</a></li>
                  <!-- <li class="brdr"><span class="process_done">5</span><a href="#">Completed</a></li> -->

               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
            </div>

            <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="my_whit_bg">
                 <div class="title_acc">Please provide Password Details</div>
                   <div class="row">

                      <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/update_password') }}"
                           enctype="multipart/form-data"
                           >

      {{ csrf_field() }}



                 <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">


               <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Current Password:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="password" name="current_password"
                                class="input_acct" placeholder="Enter Current Password  "/>
                          <div class="error_msg"> </div>
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">New Password :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="password" name="new_password"
                                class="input_acct" placeholder="Enter New Password: "/>
                        </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Confirm Password :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="password" name="confirm_password"
                                class="input_acct" placeholder="Confirm Password"/>
                        </div>
                         </div>
                    </div>

                   </div>

                    <button type="submit" class="yellow1 ui button">Save & Continue</button>


                    </form>

              </div>

                </div>

                 </div>

             </div>
         </div>
       </div>

      </div>



@stop