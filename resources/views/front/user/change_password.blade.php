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
                  <li class="active">Change Password</li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>
<div class="container per-detl min-height">
         <div class="row">

            @include('front.user.profile_left')
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="my_whit_bg">
                 <div class="title_acc">Please provide Password Details</div>
                   <div class="row">
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

                      <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/update_password') }}"
                           enctype="multipart/form-data"
                           >

                    {{ csrf_field() }}


  <div class="col-sm-2 col-md-2 col-lg-2">&nbsp;</div>
                 <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">


               <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Current Password</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="password" name="current_password" id="current_password" 
                                class="input_acct" placeholder="Enter Current Password  "/>
                          <div class="error_msg"> </div>
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">New Password</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="password" name="new_password" id="new_password" 
                                class="input_acct" data-rule-minlength="6" placeholder="Enter New Password: "/>
                        </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Confirm Password</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="password" name="confirm_password" id="confirm_password" 
                                class="input_acct" data-rule-minlength="6" placeholder="Confirm Password"/>
                        </div>
                         </div>
                    </div>
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3 hidden-xs hidden-sm label-text">&nbsp;</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
 <button type="submit" class="btn-post" style="float:left">Save &amp; Continue</button>
                        </div>
                         </div>
                    </div>
                   </div>

                   


                    </form>

              </div>
  <div class="col-sm-2 col-md-2 col-lg-2">&nbsp;</div>
                </div>

                 </div>

             </div>
         </div>
       </div>

      </div>
</div>

<script type="text/javascript">
  jQuery( document ).ready(function () {
    jQuery('#validation-form').validate({

      rules:{
        current_password:'required',
        new_password:'required',
        confirm_password: {
          required: true,
          equalTo: "#new_password"
        },

      },
      messages:{
        current_password:"Please enter current password",
        new_password:"Please enter new password",
        confirm_password:"Please confirm password",
      },

    })
  });

</script>


@stop