
window.fbAsyncInit = function() {
    FB.init({
      appId      : '863909263715659',
      status     : true, 
      cookie     : true, 
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  

function FBLogin(redirect_url)
{
  // redirect_url = redirect_url ? redirect_url : false;

  FB.login(function(fb_response){
    if(fb_response.authResponse){
      FB.api('/me', 'get', {fields: 'email,first_name,last_name'}, function(profile_response) {
        var email = profile_response.email;
        var fname = profile_response.first_name;
        var lname = profile_response.last_name;
        var fb_token = FB.getAuthResponse()['accessToken'];
        var csrf_token = $('input[name="_token"]').val();

        // var datastr="email="+email+"&fname="+fname+"&lname=+"+lname+'&fb_token='+fb_token+"&_token="+csrf_token;
        var datastr="email="+email+"&fname="+fname+"&lname=+"+lname+'&fb_token='+fb_token+"&_token="+csrf_token;

        
        jQuery.ajax({
            url:url+'/facebook/register',
            type:'POST',
            data:datastr,
            dataType:'json',
            success:function(response)
            {
              console.log(response);
              if(response.status=="SUCCESS")
              {
                location.href= url+'/login';
                /*if(redirect_url != false)
                {
                  window.location.href =site_url+redirect_url;
                }
                else
                {
                  // window.location.href =site_url+'authorize_user/re_route';
                  alert('Logged In');
                }*/

              }
              else
              {
                /*jQuery(".top_login_status").html("<div class='alert alert-danger'>"+response.msg+"</div>");
                setTimeout(function()
                {
                   jQuery(".top_login_status").empty(); 
                },5000);*/
        
                alert("Error While Creating Account");   
              }

              return false;
            }
          });
        
          return false;
      });
    }
  }, 
  {scope: 'public_profile,email'});
}

(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
