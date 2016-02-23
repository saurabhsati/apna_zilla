<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
</head>
<body>
 <form id="form-login" action="{{ url('web_admin/register_admin') }}" method="post">
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
                        <button type="submit" class="btn btn-primary form-control">Sign Up</button>
                    </div>
                </div>
               <!--  <hr/>
               <p class="clearfix">
                   <a href="#" class="goto-forgot pull-left">Forgot Password?</a>
               </p> -->
            </form>

</body>
</html>