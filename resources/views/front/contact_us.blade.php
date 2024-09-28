@extends('front.template.master')

@section('main_section')
<!--search area start here-->
<div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
 <div class="container">
   <div class="row">
     <div class="col-sm-12 col-md-12 col-lg-12">
       <div class="title_bag">Contact us</div>
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
       <li class="active">Contact us</li>
     </ol>
   </div>
 </div>
</div>
<hr/>

<div class="container">
 <div class="row">
 <div class="col-sm-12 col-md-12 col-lg-12">
     <div class="row">
       <div class="col-sm-6 col-md-6 col-lg-6">
        <div style="position:fixed;
                top: 0;
                bottom: 0;
                left:0;
                right:0;
                background-color:#ccc;
                opacity:0.5;
                display:none;"
          id="subscribr_loader">
                <img src="{{ url('/') }}/assets/front/images/ajax-loader.gif" style="height:100px; width:100px; position:absolute; top:35%;left:45%" />
        </div>
         <div class="box_contact">
         <div class="alert alert-success fade in " id = "contact_succ" style="display:none;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> Thank You ,We will be responding shortly..
          </div>
           <div class="alert alert-danger" style="display:none;" id = "contact_err">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Error!</strong>While Sending Enquiry .
          </div>
         <form class="form-horizontal"
                           id="contact_form"
                           method="POST"
                           >
           {{ csrf_field() }}
           <div class="gren_bor_title">GET IN TOUCH</div>

           <?php
                $user = Sentinel::check();
           ?>
           @if($user)
               <div class="bor_grn">&nbsp;</div>
               <div class="user_box">
               <input class="input_acct " type="text" name="name" id="name" value="{{$user['first_name'] ?? ''}}" placeholder="Name">
               <div class="error_msg" id="err_name"></div>
               </div>
               <div class="user_box">
               <input class="input_acct" type="text" name="mobile_no" id="mobile_no" value="{{$user['mobile_no'] ?? ''}}" placeholder="Mobile No">
               <div class="error_msg" id="err_mobile_no"></div>
               </div>
               <div class="user_box">
               <input class="input_acct" type="text" name="email" id="email" value="{{$user['email'] ?? ''}}" placeholder="Email">
               <div class="error_msg" id="err_email"></div>
               </div>
               <div class="user_box">
                <textarea class="textarea_box" name="message" id="message" placeholder="Message" type=""></textarea>
                <div class="error_msg" id="err_message"></div></div>
               <br/>
               <button class="pull-left btn btn-post" id="contact_submit" type="submit" name="contact_submit">Submit now</button>
           @else
               <div class="bor_grn">&nbsp;</div>
               <div class="user_box">
               <input class="input_acct " type="text" name="name" id="name" value="" placeholder="Name">
               <div class="error_msg" id="err_name"></div>
               </div>
               <div class="user_box">
               <input class="input_acct" type="text" name="mobile_no" id="mobile_no" value="" placeholder="Mobile No">
               <div class="error_msg" id="err_mobile_no"></div>
               </div>
               <div class="user_box">
               <input class="input_acct" type="text" name="email" id="email" value="" placeholder="Email">
               <div class="error_msg" id="err_email"></div>
               </div>
               <div class="user_box">
                <textarea class="textarea_box" name="message" id="message" placeholder="Message" type=""></textarea>
                <div class="error_msg" id="err_message"></div></div>
               <br/>
               <button class="pull-left btn btn-post" id="contact_submit" type="submit" name="contact_submit">Submit now</button>
           @endif
           </form>
           <div class="clr"></div>
         </div>

       </div>
       <div class="col-sm-6 col-md-6 col-lg-6">
         <div class="box_contact">
           <div class="row">
             <div class="col-sm-12 col-md-12 col-lg-6">
              <div class="gren_bor_title">Locate us</div>
              <div class="bor_grn">&nbsp;</div>
              <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/map.png" alt="contcat us map"/></span>
               <div class="addrsss">@if($arr_site_setting['site_address']!=''){{$arr_site_setting['site_address']}}@endif</div>
             <input type="hidden" id="site_address" value="@if($arr_site_setting['site_address']!=''){{$arr_site_setting['site_address']}}@endif">             </div>
             <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/msg.png" alt="message"/></span>
               <div class="addrsss">@if($arr_site_setting['site_email_address']!=''){{$arr_site_setting['site_email_address']}}@endif</div>
             </div>

           </div>
           <div class="col-sm-12 col-md-12 col-lg-6">
             <div class="gren_bor_title">Contact Info</div>
             <div class="bor_grn">&nbsp;</div>
             <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/phone.png" alt="contcat us map"/></span>
               <div class="phone-number">@if($arr_site_setting['site_contact_number']!=''){{$arr_site_setting['site_contact_number']}}@endif</div>
             </div>

             <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/ph.png" alt="contcat us map"/></span>
               <div class="phone-number">@if($arr_site_setting['phone_number']!=''){{$arr_site_setting['phone_number']}}@endif</div>
             </div>
           </div>
         </div>

         <div class="whit_box">
           <div class="any_q">Have Any Question?</div>
           <div class="get_tuch">Getting in touch? If You have any more Question Not Listed in.</div>
           <div class="btn_gren"><a href="{{ url('/') }}/faqs">Any Question?</a></div>
         </div>
       </div>
     </div>

   </div>
   <div class="gren_bor_title">Map and Location</div>
   <div class="bor_grn">&nbsp;</div>
   <div class="map"><!-- @if($arr_site_setting['map_iframe']!=''){{$arr_site_setting['map_iframe']}}@endif -->
   <?php if($arr_site_setting['map_iframe']!=''){ echo $arr_site_setting['map_iframe']; }?>
   <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3749.453253030988!2d73.80146181487628!3d19.989482927817193!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddeae4e0245423%3A0xeb6a128eb0f552ae!2sWebwing+Technologies!5e0!3m2!1sen!2sin!4v1455886533191" width="100%" height="403" frameborder="0" style="border:0" allowfullscreen></iframe> -->
   </div>

 </div>

</div>
</div>
</div>
<script type="text/javascript">
var site_url="{{url('/')}}";
$("#contact_submit").click(function(e){
  e.preventDefault();
      var name=$('#name').val();
      var email=$('#email').val();
      var mobile_no=$('#mobile_no').val();
      var message=$("#message").val();
      var filter = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
      var filter_contact=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/i;

      if(name.trim()=='')
      {
        $('#err_name').html('Enter Your Name.');
        $('#err_name').show();
        $('#name').focus();
        $('#name').on('keyup', function(){
        $('#err_name').hide();
          });

      }
        else if(mobile_no.trim()=='')
      {
        $('#err_mobile_no').html('Enter Your Mobile Number.');
        $('#err_mobile_no').show();
        $('#mobile_no').focus();
        $('#mobile_no').on('keyup', function(){
        $('#err_mobile_no').hide();
          });
      }
      else if(!filter_contact.test(mobile_no))
      {
        $('#err_mobile_no').html('Enter Valid Mobile Number.');
        $('#err_mobile_no').show();
        $('#mobile_no').focus();
        $('#mobile_no').on('keyup', function(){
        $('#err_mobile_no').hide();
          });
      }
      else if(email.trim()=='')
      {
        $('#err_email').html('Enter Your Email ID.');
        $('#err_email').show();
        $('#email').focus();
        $('#email').on('keyup', function(){
        $('#err_email').hide();
          });

      }
      else if(!filter.test(email))
     {
        $('#err_email').html('Enter Valid Email ID.');
        $('#err_email').show();
        $('#email').focus();
        $('#email').on('keyup', function(){
        $('#err_email').hide();
          });
       }

      else if(message.trim()=='')
      {
         $('#err_message').html('Enter Your Message.');
        $('#err_message').show();
        $('#message').focus();
        $('#message').on('keyup', function(){
        $('#err_message').hide();
          });
      }

      else
      {
        $.ajax({
          type:"POST",
          url:site_url+'/contact_us/store',
          data:$("#contact_form").serialize(),
          beforeSend: function()
          {
            $("#subscribr_loader").show();
          },
          success:function(res)
          {
            var tmp="";
            if(res=="1")
            {
               $("#contact_succ").fadeIn(3000).fadeOut(3000);
              $("#contact_form").trigger('reset');
            }
            else
            {

              $("#contact_err").fadeIn(3000).fadeOut(3000);
            }
          },
          complete: function() {

          $("#subscribr_loader").hide();

          }
        });


      }

});
</script>
@endsection