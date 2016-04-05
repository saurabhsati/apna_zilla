<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Right Next" />
      <meta name="keywords" content="Right Next" />
      <meta name="author" content="Right Next" />

      <!-- ======================================================================== -->
      <title> Right Next :: {{ isset($page_title)?$page_title:"" }}</title>

       {!!Meta::generate() !!}

      <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
      <!-- Bootstrap Core CSS -->
      <link href="{{ url('/') }}/assets/front/css/bootstrap.css" rel="stylesheet" type="text/css" />
      <!-- main CSS -->
      <link href="{{ url('/') }}/assets/front/css/rightnext.css" rel="stylesheet" type="text/css" />
      <!--menu css-->
      <link href="{{ url('/') }}/assets/front/css/menu.css" rel="stylesheet" type="text/css" media="screen" />
      <!-- <script type='text/javascript' src="{{ url('/') }}/assets/front/js/jquery-1.11.3.min.js"></script> -->
      <!-- <script type='text/javascript' src="{{ url('/') }}/assets/front/js/jquery-migrate-1.2.1.min.js"></script> -->
      <link rel="stylesheet" href="{{ url('/') }}/css/front/jquery.rating.css" type="text/css"/>



      <!--font-awesome-css-start-here-->
      <link href="{{ url('/') }}/assets/front/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <!--select autocomplete-->
      <!--select autocomplete-->
      <link rel="stylesheet" href="{{ url('/') }}/assets/front/css/jquery-ui.css" type="text/css"/>
      <!-- <script src="{{ url('/') }}/assets/front/js/jquery-1.10.2.js" type='text/javascript'></script> -->

      <!-- <link rel="stylesheet" href="{{ url('/') }}/assets/front/css/style.css" type="text/css"/>
 -->
      <script src="{{ url('/') }}/assets/front/js/google_ajax_jquery.min.js"></script>
      <script src="{{ url('/') }}/assets/front/js/bootstrap.min.js" type="text/javascript"></script>
      <script type="text/javascript" language="javascript" src="{{ url('/') }}/assets/front/js/flaunt.js"></script>
      <script type="text/javascript" src="{{url('/')}}/js/front/jquery.rating.js"></script>


       <!-- jQuery -->
      <!-- <script src="{{-- url('/') --}}/assets/front/js/jquery.js" type="text/javascript"></script> -->
      <!-- Bootstrap Core JavaScript -->


      <!--category droup doun mobile effect-->

       <script>
$(document).ready(function(){
    $(".spe_mobile").click(function(){
    $(".spe_submobile").slideToggle("slow");
      if($(this).find('a').hasClass('act'))
      {
           $(this).find('a').removeClass('act');

      }
      else
      {
         $(this).find('a').addClass('act');

      }
  });

    $(".spe_mobile1").click(function(){
    $(".spe_submobile1").slideToggle("slow");
      if($(this).find('a').hasClass('act'))
      {
           $(this).find('a').removeClass('act');

      }
      else
      {
         $(this).find('a').addClass('act');

      }
  });

     $(".spe_mobile2").click(function(){
    $(".spe_submobile2").slideToggle("slow");
      if($(this).find('a').hasClass('act'))
      {
           $(this).find('a').removeClass('act');

      }
      else
      {
         $(this).find('a').addClass('act');

      }
  });

     $(".spe_mobile3").click(function(){
    $(".spe_submobile3").slideToggle("slow");
      if($(this).find('a').hasClass('act'))
      {
           $(this).find('a').removeClass('act');

      }
      else
      {
         $(this).find('a').addClass('act');

      }
  });
 });
</script>
<!--category droup doun mobile effect-->
 <!--Photo Gallery-->
      <link href="{{ url('/') }}/assets/front/css/touchTouch.css" rel="stylesheet" type="text/css"/>
      <script src="{{ url('/') }}/assets/front/js/jquery.touchSwipe.min.js" type="text/javascript"></script>
      <script src="{{ url('/') }}/assets/front/js/touchTouch.jquery.js" type="text/javascript"></script>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
      //   $(function(){
         // Initialize the gallery
         $('.gallery a.gal').touchTouch();
         });

      </script>
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
       <script src="{{ url('/') }}/assets/front/js/jquery.validate.min.js"></script>

       <!-- jquery validation -->
      <script type="text/javascript" src="{{url('/')}}/assets/jquery-validation/dist/jquery.validate.min.js"></script>

         <!-- Share Location  -->

<script>
   var site_url = "{{url('/')}}";

   window.onload = function() {
   var city="{{Session::get('city')}}";
   if(city=='')
      {
          getLocation();
      }
   };

  function getLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout:10000});
      } else {
           window.location.reload();
      }
  }

  function positionError(error) {
      var errorCode = error.code;
      var message = error.message;

      console.log(message);
  }

  function savePosition(position) {
   var _token = $('input[name=_token]').val();
   console.log(position.coords.latitude);
    console.log(position.coords.longitude);
    var dataString = { lat:position.coords.latitude, lng:position.coords.longitude, _token: _token };
     var url= site_url+'/locate_location';
     $.post( url, dataString)
         .done(function( data ) {
         if(data=='done'){
           window.location.reload();
           }
         });

  }
  </script>
   </head>

   <body>
    {{ csrf_field() }}
