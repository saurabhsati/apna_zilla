@extends('front.template.master')

@section('main_section')
<!--search area start here-->
<div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
 <div class="container">
   <div class="row">
     <div class="col-sm-12 col-md-12 col-lg-12">
       <div class="title_bag">Recover Password</div>
     </div>

   </div>
 </div>
</div>
<!--search area end here-->
<div class="gry_container">
  <div class="container">
   <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
       <span>You are here :</span>
       <li><a href="{{ url('/') }}">Home</a></li>
       <li class="active">Recover Password</li>
     </ol>
   </div>
 </div>
</div>
<hr/>

<div class="container">
 <div class="row">
 <div class="col-sm-12 col-md-12 col-lg-6">
     <div class="row">
      <div class="box_contact">
      <form  name="frm_reset_password" id="frm_reset_password" action="{{ url('/') }}/front_users/reset_password" method="POST">
            {{ csrf_field() }}

                <div class="gren_bor_title">RECOVER PASSWORD</div>

                      <div class="bor_grn">&nbsp;</div>

                        <div class="alert_messages">

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
                        </div>
                         <div class="user_box">
                          <input class="input_acct col-sm-6 col-md-6 col-lg-6" id="password" type="password" name="password" placeholder="Password" data-rule-required="true"  data-rule-minlength="6"/>
                          <div class="error_msg" id="err_name"></div>
                        </div>
                         <div class="user_box">
                          <input class="input_acct col-sm-6 col-md-6 col-lg-6" type="password" name="password_confirmation" placeholder="Confirm Password" data-rule-required="true" data-rule-equalto="#password"/>
                          <div class="error_msg" id="err_name"></div>
                        </div>
                        <br/>
                           <input type="hidden" name="enc_id" value="{{ $enc_id ?? '' }}" />
                      <input type="hidden" name="enc_reminder_code"  value="{{ $enc_reminder_code ?? '' }}"/>
                       <br/>
                      <button class="pull-left btn btn-post" id="change_pwd_submit" type="submit" name="change_pwd_submit"> Reset Password</button>
                     <div class="clearfix"></div>
              </form>
     </div>
   </div>
 </div>
</div>
</div>
</div>
<script type="text/javascript">
  var url = "{{ url('/') }}";
  jQuery(document).ready(function()
  {
    jQuery("#frm_reset_password").validate();
  });


</script>

@endsection