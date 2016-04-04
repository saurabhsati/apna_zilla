@extends('front.template.master')

@section('main_section')

<!-- Timepicker css -->
<link rel="stylesheet" type="text/css" href="{{ url('/').'/assets/bootstrap-timepicker/compiled/timepicker.css' }}" />

<!-- Timepicker js  -->
<script type="text/javascript" src="{{ url('/').'/assets/bootstrap-timepicker/js/bootstrap-timepicker.js' }}"></script>
 
  

  <div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
         <span>You are here :</span>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li class="active">Contact Information</li>
  
</ol>
             </div>
          </div>
     </div>
     <hr/>
     
       <div class="container">
         <div class="row">
             
         <div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->
                   
                <div class="categories_sect sidebar-nav slide_m">
                <div class="sidebar-brand">Business Information</div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="">
                    <li class="brdr"><a href="{{-- url('/').'/front_users/add_business' --}}#">Business Information</a></li>
                    <li class="brdr"><a href="{{-- url('/').'/front_users/add_location' --}}#">Location Information</a></li>
                    <li class="brdr"><a href="{{-- url('/').'/front_users/add_contacts' --}}#">Contact Information</a></li>
                    <li class="brdr"><a href="{{-- url('/').'/front_users/other_details' --}}#">Other Information</a></li>
                    <li class="brdr"><a href="{{-- url('/').'/front_users/add_services' --}}#">Video/Pictures/Services</a></li>
                    <!-- <li class="brdr has-sub"><a href="#"><span>business keywords</span></a>
                    <ul class="make_list" style="display:none;">
                     <li><a href="#">view/remove keywords</a> </li>
                         <li><a href="#">add keywords</a></li> 
                       </ul>
                     </li>
                    <li class="brdr"><a href="#">upload video/logo/pictures</a></li> -->
                </ul>
               
                <div class="clearfix"></div>
              </div>
                
               <!--  <div class="categories_sect sidebar-nav slide_m">
                 <div class="sidebar-brand">Service Request</div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="">
                    <li class="brdr"><a href="#">ECS/CCSI Active/Pause</a></li>
                  <li class="brdr"><a href="#">Submit An online Request/Complaint</a></li>
                   </ul>
                   <div class="clearfix"></div>
                </div> -->
            </div>
             
         <div class="col-sm-12 col-md-9 col-lg-9">
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
                       action="{{ url('/front_users/add_other_details') }}" 
                       enctype="multipart/form-data"
                       >

            {{ csrf_field() }}

             <input type="hidden" name="business_id" value="{{ $business_id }}" >  </input>

             
            <div class="my_whit_bg">
              <div class="title_acc">Please Provide Other Information</div>
                <div class="row">

                       
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="box_profile">
                
                    <div class="user_box_sub">
                      <div class="row">
                        <div class="col-lg-2 label-text">Company Information <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                            <textarea  class="input_acct" id="company_info" name="company_info" style="width: 682px;" placeholder="Enter Company Information"  required=""  aria-describedby="basic-addon1" /></textarea>
                            <div class="error_msg">{{ $errors->first('company_info') }} </div>
                          </div>
                       </div>
                    </div>


                   <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Establishment Year <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="establish_year" name="establish_year"  placeholder="Enter Establishment Year"  required=""  aria-describedby="basic-addon1" />
                           <div class="error_msg">{{ $errors->first('establish_year') }} </div>
                        </div>
                    </div>
                  </div>
                 
                    <div class="user_box_sub">
                      <div class="row">
                        <div class="col-lg-2 label-text">Keywords <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                            <textarea  class="input_acct" id="keywords" name="keywords" style="width: 682px;" placeholder="Enter Keywords"
                            required=""  aria-describedby="basic-addon1"
                            /></textarea>
                            <div class="error_msg">{{ $errors->first('keywords') }} </div>
                          </div>
                       </div>
                  </div>

                <!--  <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Company Information <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <textarea  class="input_acct" id="company_info" name="company_info" style="width: 682px;" placeholder="Enter Company Information"/></textarea>
                          <div class="error_msg">{{-- $errors->first('company_info') --}} </div>
                        </div>
                     </div>
                  </div> -->
                 

              <div class="user_box_sub">
                <div class="col-sm-5 col-md-3" style="float:right;margin-right: -133px;">
                   <a href="javascript:void(0);" id='add-payment'>
                       <span class="glyphicon glyphicon-plus-sign" style="font-size: 22px;"></span>
                   </a>
                  <span style="margin-left:05px;">
                  <a href="javascript:void(0);" id='remove-payment'>
                      <span class="glyphicon glyphicon-minus-sign" style="font-size: 22px;"></span>
                  </a>
                  </span>
                 </div>
                  <div class="row">
                   <div class="col-lg-2 label-text">Payment Mode <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                    <input type="text" name="payment_mode[]" id="payment_mode" class="input_acct"  placeholder="Enter Payment Mode" data-rule-required="true"  />
                    <div class="error" id="error_payment_mode">{{ $errors->first('payment_mode') }}</div>
                    <div class="clr"></div><br/>
                      <div class="error" id="error_set_default"></div>
                      <div class="clr"></div>

                   <div id="append_payment" class="class-add"></div>

                    <div class="error_msg" style="color: red" id="error_payment_mode" ></div>
                    <div class="error_msg" style="color: red" id="error_payment_mode1" ></div>
                   <label class="col-lg-2 label-text"></label>

                    </div>
                    </div>
                </div>
            <!--   <hr/>

            <div class="title_acc">Opening Hours</div>
              <div class="row" style="margin-bottom: 15px;">

             <div class="user_box_sub">
              <div class="row" style=" margin-left: 10px;">
              <div class="col-lg-2 label-text">Monday<span>:</span></div>
               <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="mon_in" id="mon_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="mon_out" id="mon_out" type="text" data-rule-required="true">
                    </div>
                </div>
                </div>
            </div>

            <div class="user_box_sub">
              <div class="row" style=" margin-left: 10px;">
              <div class="col-lg-2 label-text">Tuesday<span>:</span></div>
               <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="tue_in" id="tue_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="tue_out" id="tue_out" type="text" data-rule-required="true">
                    </div>
                </div>
                </div>
            </div>

            <div class="user_box_sub">
              <div class="row" style=" margin-left: 10px;">
              <div class="col-lg-2 label-text">Wednesday<span>:</span></div>
               <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="wed_in" id="wed_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="wed_out" id="wed_out" type="text" data-rule-required="true">
                    </div>
                </div>
                </div>
            </div>

           <div class="user_box_sub">
              <div class="row" style=" margin-left: 10px;">
              <div class="col-lg-2 label-text">Thursday<span>:</span></div>
               <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="thu_in" id="thu_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="thu_out" id="thu_out" type="text" data-rule-required="true">
                    </div>
                </div>
                </div>
            </div>

            <div class="user_box_sub">
              <div class="row" style=" margin-left: 10px;">
              <div class="col-lg-2 label-text">Friday<span>:</span></div>
               <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="fri_in" id="fri_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="fri_out" id="fri_out" type="text" data-rule-required="true">
                    </div>
                </div>
                </div>
            </div>

            <div class="user_box_sub">
              <div class="row" style=" margin-left: 10px;">
              <div class="col-lg-2 label-text">Saturday<span>:</span></div>
               <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="sat_in" id="sat_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="sat_out" id="sat_out" type="text" data-rule-required="true">
                    </div>
                </div>
                </div>
            </div>

            <div class="user_box_sub">
              <div class="row" style=" margin-left: 10px;">
              <div class="col-lg-2 label-text ">Sunday<span>:</span></div>
               <div class="col-sm-3 col-md-3 col-lg-3 m_l controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="sun_in" id="sun_in" type="text" data-rule-required="true">
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control timepicker-default" name="sun_out" id="sun_out" type="text" data-rule-required="true">
                    </div>
                </div>
                </div>
            </div>

          </div>

            <hr/> -->

           <div class="button_save1">
                    <button type="submit" class="btn btn-post" name="add_contacts" style="float: left; margin-left:125px; ">Save &amp; continue</button>
                    <!-- <a class="btn btn-post pull-left" href="#">previous</a>
                    <a class="btn btn-post" href="#">Save &amp; exit</a>
                    <a class="btn btn-post pull-right" href="#">Next</a> -->
                 </div>
                </div>
                      
                </div>
                
                 </div>
               
            
                </form>
             </div>
         </div>
       </div>
       
      </div>      



<script type="text/javascript">

    var site_url = "{{url('/')}}";
    
    function loadPreviewImage(ref)
    {
        var file = $(ref)[0].files[0];

        var img = document.createElement("img");
        reader = new FileReader();
        reader.onload = (function (theImg) {
            return function (evt) {
                theImg.src = evt.target.result;
                $('#preview_profile_pic').attr('src', evt.target.result);
            };
        }(img));
        reader.readAsDataURL(file);
        $("#removal_handle").show();
    }

    function clearPreviewImage()
    {
        $('#preview_profile_pic').attr('src',site_url+'/images/front/avatar.jpg');
        $("#removal_handle").hide();
    }
</script>

<script type="text/javascript"> 
jQuery(document).ready(function () {
 token   = jQuery("input[name=_token]").val();
  jQuery('#city').on('change', function() {
    var city_id = jQuery(this).val();
    jQuery.ajax({
       url      : site_url+"/front_users/get_state_country?_token="+token,
       method   : 'POST',
       dataType : 'json',
       data     : { city_id:city_id },
       success: function(responce){
          if(responce.length == 0)
          {
            var  state   = "<option value='' >State</option>";
            var  country = "<option value='' >Country</option>";  
          }else
          {
            var  state   = "<option value='"+responce.state_id+"' >"+responce.state_name+"</option>";
            var  country = "<option value='"+responce.country_id+"' >"+responce.country_name+"</option>";
          }
          $('#state').html(state);
          $('#country').html(country);
       }  
    });
  });  
});
</script>

<script type="text/javascript">
        //Payment
$('#add-payment').click(function()
{
  flag=1;

  var img_val = jQuery("input[name='payment_mode[]']:last").val();

  var img_length = jQuery("input[name='payment_mode[]']").length;

  if(img_val == "")
  {
        $('#error_payment_mode').css('margin-left','120px');
        $('#error_payment_mode').css('color','red');
        $('#error_payment_mode').show();
        $('#error_payment_mode').fadeIn(3000);
        document.getElementById('error_payment_mode').innerHTML="The Payment Mode is required.";
        setTimeout(function(){
        $('#error_payment_mode').fadeOut(4000);
        },3000);

       flag=0;
       return false;
  }

    var payment_html='<div>'+
             '<input type="text" class="form-control" name="payment_mode[]" id="payment_mode" class="" data-rule-required="true"  />'+
             '<div class="error" id="error_payment_mode">{{ $errors->first("payment_mode") }}</div>'+
             '</div>'+
             '<div class="clr"></div><br/>'+
             '<div class="error" style="color:red" id="error_set_default"></div>'+
             '<div class="clr"></div>';
        jQuery("#append_payment").append(payment_html);

});


$('#remove-payment').click(function()
{
     var html= $("#append_payment").find("input[name='payment_mode[]']:last");
     html.remove();
});


</script>
<!--TimePicker-->
<script type="text/javascript">
   $('#timepicker5').timepicker({
                template: false,
                showInputs: false,
                minuteStep: 5
    });
</script>


@stop