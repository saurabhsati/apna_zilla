<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{ config('app.project.name')}} Admin Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <!--base css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/assets/font-awesome/css/font-awesome.min.css">

        <!--page specific css styles-->
        <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/chosen-bootstrap/chosen.min.css">
        
        <!--flaty css styles-->
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty.css">
        <link rel="stylesheet" href="{{ url('/') }}/css/admin/flaty-responsive.css">

        <link rel="shortcut icon" href="{{ url('/') }}/img/favicon.png">

        <style type="text/css">
        .error
        {
            color: red;
        }
        </style>

    </head>
    <body class="login-page">      

        <!-- BEGIN Main Content -->
        <div class="login-wrapper">
            <!-- BEGIN Login Form -->
            <form id="form-login" action="{{ url('web_admin/process_login') }}" method="post">
                    @if (Session::has('error'))
                        <div class="alert alert-danger" id="success-error-message">{{ Session::get('error') }}</div>
                    @endif
            	 {{ csrf_field() }}
                 
                <h3>Login to your account</h3>
                <hr/>
                <div class="form-group ">
                    <div class="controls">
                        <input type="text" placeholder="Email" class="form-control" data-rule-required="true" name="email"/>
                        
                        <span class="error">{{ $errors->first('email') }} </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="password" placeholder="Password" class="form-control" data-rule-required="true" name="password"/>
                        <span class="error">{{ $errors->first('password') }} </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary form-control">Sign In</button>
                    </div>
                </div>
               <!--  <hr/>
               <p class="clearfix">
                   <a href="#" class="goto-forgot pull-left">Forgot Password?</a>
               </p> -->
            </form>
            <!-- END Login Form -->

            <!-- BEGIN Forgot Password Form -->
            <form id="form-forgot" action="{{ url('web_admin/forgot_password') }}" method="post" style="display:none">
            	 {{ csrf_field() }}

                @if (Session::has('message_success'))
                        <div class="alert alert-success" id="success-error-message">{{ Session::get('message_success') }}</div>
                @endif
                @if (Session::has('message'))
                        <div class="alert alert-danger" id="success-error-message">{{ Session::get('message') }}</div>
                @endif

                <h3>Get back your password</h3>
                <hr/>
                <div class="form-group">
                    <div class="controls">
                        <input type="text" placeholder="Email" class="form-control" data-rule-required="true" data-rule-email="true" name="email_id"/>
                        <span class="error">{{ $errors->first('email_id') }} </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary form-control">Recover</button>
                    </div>
                </div>
                <hr/>
                <p class="clearfix">
                    <a href="#" class="goto-login pull-left">← Back to login form</a>
                </p>
            </form>
            <!-- END Forgot Password Form -->
        </div>
        <!-- END Main Content -->


        <!--basic scripts-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ url('/') }}/assets/jquery/jquery-2.1.4.min.js"><\/script>')</script>
        <script src="{{ url('/') }}/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ url('/') }}/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="{{ url('/') }}/assets/jquery-cookie/jquery.cookie.js"></script>


        <script type="text/javascript" src="{{ url('/') }}/assets/jquery-validation/dist/jquery.validate.min.js"></script>
		<script type="text/javascript" src="{{ url('/') }}/assets/jquery-validation/dist/additional-methods.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/chosen-bootstrap/chosen.jquery.min.js"></script>
        

        <!--flaty scripts-->
        <script src="{{ url('/') }}/js/admin/flaty.js"></script>
        <script src="{{ url('/') }}/js/admin/flaty-demo-codes.js"></script>

        <script type="text/javascript">
            function goToForm(form)
            {
                $('.login-wrapper > form:visible').fadeOut(500, function(){
                    $('#form-' + form).fadeIn(500);
                });
            }
            $(function() {
                $('.goto-login').click(function(){
                    goToForm('login');
                });
                $('.goto-forgot').click(function(){
                    goToForm('forgot');
                });
                $('.goto-register').click(function(){
                    goToForm('register');
                });
            });
        </script>
        <script type="text/javascript">
		$("#form-login").validate();
		$("#form-forgot").validate();
		</script>
        <script type="text/javascript">
            /*$(document).ready(function(){
                @if (Session::has('message'))
                $('.success-error-message').html('<div class="alert alert-info" >{{ Session::get('message') }}</div>');
                @endif
            })*/

        setTimeout(function() {
            $('#success-error-message').fadeOut('fast');
            }, 3000);
        </script>
    </body>
</html>

