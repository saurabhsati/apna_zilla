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
                 <div class="title_acc">Please provide your address details</div>
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
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/store_address_details') }}"
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

    @if(count($arr_user_info)>0)

       @foreach($arr_user_info as $user)

            <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">
                <!--   <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="name"
                         value="{{-- $user['first_name']." ".$user['last_name'] --}}"
                                class="input_acct"
                                placeholder="Enter Name" readonly />
                          <div class="error_msg"> </div>
                        </div>
                         </div>
                    </div> -->

                    <input type="hidden"  name="user_id" value="{{isset($user['id'])?$user['id']:'' }}" > </input>

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
                    <div class="col-lg-3  label-text">Street Address :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="street_address"
                                value="{{ isset($user['street_address'])?$user['street_address']:'' }}"
                                class="input_acct" placeholder="Enter Street address  "/>
                        </div>
                         </div>
                    </div>

                   </div>
                    <button type="submit" style="float: left;margin-left: 142px;;" class="yellow1 ui button">Save & Continue</button>


                    @endforeach

                    @else
                      <span><h4>Please Fill Personal Details First</h4></span>
                    @endif
                    </form>

              </div>

                </div>

                 </div>

             </div>
         </div>
       </div>

      </div>



@stop