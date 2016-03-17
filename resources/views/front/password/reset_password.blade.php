
@section('main_content')
   <div class="container">
         <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
               <!--error sucess info messages start here-->
               @if(Session::has('success'))
               <div class="alert alert-success">
                  <strong>Success!</strong> {{ Session::get('success') }}
               </div>
               @elseif(Session::has('error'))
               <div class="alert alert-danger">
                  <strong>Error!</strong> {{ Session::get('error') }}
               </div>      
               @endif
               <!--error sucess info messages end here-->

               <form id="frm_reset_password" 
                     action="{{ url('/process_reset_password') }}"  
                     method="POST"
               >

               {{ csrf_field() }}

               <div class="row">
                  <div class="col-sm-0 col-md-2 col-lg-2">&nbsp;</div>
                  <div class="col-sm-12 col-md-8 col-lg-8">
                   <div class="head_area">
                     <div class="head_text_info">{{ trans('lang.reset_password') }}</div>
                     <div class="head_divider"></div>
                  </div>
                  <div class="login_cont_bx">
                     <div class="col-sm-2 col-md-2 col-lg-2">
                        
                     </div>

                     <div class="col-sm-8 col-md-8 col-lg-8">
                        
                        <input type="hidden" name="token" value="{{ $token }}" />

                        <input type="hidden" name="email" value="{{ $password_reset['email'] }}" />   

                        <div class="user_bx">
                           <div class="login-text-fild">{{ trans('lang.new_password') }}</div>
                           <div class="login-input">
                              <div class="login_input_icon"><img src="{{ url('/') }}/images/front/user_login.png" alt="user_login"/></div>
                              <div class="login_input_area"><input type="password" name="password" class="login_input_text" placeholder="{{ trans('lang.new_password') }}" id="password" data-rule-required="true" data-rule-minlength="6"/>

                              </div>
                              @if($errors->has('password'))
                                 <label class="err_front_js">{{ $errors->first('password') }}</label>
                              @endif
                              

                           </div>
                           <div class="clr"></div>
                        </div>

                        <div class="user_bx">
                           <div class="login-text-fild">{{ trans('lang.confirm_password') }}</div>
                           <div class="login-input">
                              <div class="login_input_icon"><img src="{{ url('/') }}/images/front/user_login.png" alt="user_login"/></div>
                              <div class="login_input_area"><input type="password" name="password_confirmation" class="login_input_text" placeholder="{{ trans('lang.confirm_password') }}" data-rule-required="true" data-rule-equalto="#password"/>

                              </div>
                              @if($errors->has('password_confirmation'))
                                 <label class="err_front_js">{{ $errors->first('password_confirmation') }}</label>
                              @endif
                              

                           </div>
                           <div class="clr"></div>
                        </div>
                        
                        <div class="bt_row">
                           <div class="bt_l">
                              <div class="login_btn"><input type="submit" class="sign-btn" value="{{ trans('lang.reset') }}" style="max-width: 101px !important;" /></div>
                              <div class="clr"></div>
                           </div>
                        </div>                       
                    
                     </div>

                     <div class="col-sm-2 col-md-2 col-lg-2">
                        
                     </div>

               </div>
            </div>
            </form>

         </div>
      </div>
   </div>
@endsection      
