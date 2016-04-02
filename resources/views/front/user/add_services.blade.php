@extends('front.template.master')

@section('main_section')

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
                    <!--  <li class="brdr has-sub"><a href="#"><span>business keywords</span></a>
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
                           action="{{ url('/front_users/add_services_details') }}" 
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
                      <div class="col-lg-2 label-text">Youtube Link <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="youtube_link" name="youtube_link"  placeholder="Enter Youtube Link" required=""  aria-describedby="basic-addon1"/>
                           <div class="error_msg">{{ $errors->first('youtube_link') }} </div>
                        </div>
                    </div>
                  </div>

                  
                <!--     <div class="user_box_sub">
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
                    <div class="error" id="error_payment_mode">{{-- $errors->first('payment_mode') --}}</div>
                    <div class="clr"></div><br/>
                      <div class="error" id="error_set_default"></div>
                      <div class="clr"></div>

                   <div id="append_payment" class="class-add"></div>

                    <div class="error_msg" style="color: red" id="error_payment_mode" ></div>
                    <div class="error_msg" style="color: red" id="error_payment_mode1" ></div>
                   <label class="col-sm-3 col-lg-2 control-label"></label>

                    </div>
                    </div>
                </div>
 -->




             <div class="user_box_sub">
                <div class="col-sm-5 col-md-2" style="float:right;margin-right:-50px;">
                   <a href="javascript:void(0);" id='add-image'>
                       <span class="glyphicon glyphicon-plus-sign" style="font-size: 22px;"></span>
                   </a>
                    <span style="margin-left:05px;">
                    <a href="javascript:void(0);" id='remove-image'>
                        <span class="glyphicon glyphicon-minus-sign" style="font-size: 22px;"></span>
                    </a>
                    </span>
                </div>
                  <div class="row">
                    <div class="col-lg-2 label-text">Business Images<span>:</span></div>
                       <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                        <input type="file" name="business_image[]" id="business_image" class="input_acct" data-rule-required="true"  />
                        <div class="error" id="error_business_image">{{ $errors->first('business_image') }}</div>

                        <div class="clr"></div><br/>
                          <div class="error" id="error_set_default"></div>
                          <div class="clr"></div>

                       <div id="append" class="class-add"></div>
                          <div class="error_msg" id="error_business_image" ></div>
                          <div class="error_msg" id="error_business_image1" ></div>
                       <label class="col-sm-3 col-lg-2 control-label"></label>
                    </div>
                </div>
                </div>


                <div class="user_box_sub add_more_service" >
                  <div class="col-sm-5 col-md-2" style="float:right;margin-right:-50px;" >
                     <a href="javascript:void(0);" id='add-service'>
                         <span class="glyphicon glyphicon-plus-sign" style="font-size: 22px;"></span>
                     </a>
                      <span style="margin-left:05px;">
                      <a href="javascript:void(0);" id='remove-service'>
                          <span class="glyphicon glyphicon-minus-sign" style="font-size: 22px;"></span>
                      </a>
                      </span>
                  </div>
                  <div class="row">
                    <div class="col-lg-2 label-text">Business Services<span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">

                        <input class="input_acct" type="text" name="business_service[]" id="business_service" class="pimg"   />
                        <div class="error" id="error_business_service">{{ $errors->first('business_service') }}</div>

                        <div class="clr"></div><br/>
                          <div class="error" id="error_set_default"></div>
                          <div class="clr"></div>

                       <div id="append_service" class="class-add"></div>
                        <div class="error_msg" id="error_business_service" ></div>
                        <!-- <div class="error_msg" id="error_business_image1" ></div> -->
                       <label class="col-sm-3 col-lg-2 control-label"></label>

                      </div>
                  </div>
                </div>





            {{--    <div class="user_box_sub">
                  <div class="row">
                    <label class="col-lg-3 label-text" style="float: left;" for="building">
                    <a href="" class="add_more">Add More Image</a></label>
                  </div>
                </div>
                
                 <div class="user_box_sub">
                  <div class="row">
                    <div class="col-sm-6 col-md-5 col-lg-6 m_l add_more_image" style="display: none;">
                      <div class="col-sm-6 col-md-5 col-lg-6 m_l" style="float:right;margin-right: -250px;">
                      <a href="javascript:void(0);" id='add-image'> 
                        <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></span>
                      </a>
                      <span style="margin-left:05px;">
                      <a href="javascript:void(0);" id='remove-image'>
                          <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
                      </a>
                      </span>
                    </div>

                     <div class="row">
                      <label class="col-lg-8 label-text">Add More Business Images </label>
                      
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l" style="float: right;margin-right: -150px;">
                          <input type="file" name="business_image[]" id="business_image" class="pimg"   />
                            <div class="error" id="error_business_image">{{ $errors->first('business_image') }}</div>
                              <div class="clr"></div><br/>
                               <div class="error" id="error_set_default"></div>
                              <div class="clr"></div>
                              <div id="append" class="class-add"></div>
                              <div class="error_msg" id="error_business_image" ></div>
                              <div class="error_msg" id="error_business_image1" ></div>
                             <label class="col-lg-8 label-text"  style="margin-left: 10px;" ></label>
                        </div>
                        </div>
                        </div>  
                    </div>
                    </div>

                    <div class="user_box_sub">
                     <div class="row">
                        <label class="col-lg-3 label-text" for="building">
                        <a href="" class="add_serc">Add Services</a></label>
                    </div>
                    </div>
                    <div class="col-sm-5 col-md-3 add_more_service" style="display: none;">
                        <div class="row">
                        <div class="col-sm-5 col-md-7" style="float:right;">
                          <a href="javascript:void(0);" id='add-service'>
                            <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></span>
                          </a>
                            <span style="margin-left:05px;">
                            <a href="javascript:void(0);" id='remove-service'>
                                <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
                            </a>
                          </span>
                         </div>
                         </div>
                        <label class="col-lg-2 label-text">Add More Business Services <i class="red">*</i> </label>
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input class="input_acct" type="text" name="business_service[]" id="business_service" class="pimg"  />
                            <div class="error" id="error_business_service">{{ $errors->first('business_service') }}</div>
                              <div class="clr"></div><br/>
                                <div class="error" id="error_set_default"></div>
                                  <div class="clr"></div>
                                  <div id="append_service" class="class-add"></div>
                                  <div class="error_msg" id="error_business_image" ></div>
                                  <div class="error_msg" id="error_business_image1" ></div>
                              <label class="col-lg-3 label-text"></label>
                        </div>
                      </div>
                    </div>
                    </div>

                    --}}

                </div>
                <div class="button_save1">
                    <button type="submit" class="btn btn-post" name="add_contacts" style="float: left; margin-left:125px; ">Save &amp; continue</button>
                    <!-- <a class="btn btn-post pull-left" href="#">previous</a>
                    <a class="btn btn-post" href="#">Save &amp; exit</a>
                    <a class="btn btn-post pull-right" href="#">Next</a> -->
                 </div>
                </div>
                </form>
              </div>
            </div>
           </div>
         </div>
       </div>
       
      </div>      

<script type="text/javascript">
$('#add-image').click(function()
 {
   flag=1;

            var img_val = jQuery("input[name='business_image[]']:last").val();

            var img_length = jQuery("input[name='business_image[]']").length;

            if(img_val == "")
            {
                  $('#error_business_image').css('margin-left','120px');
                  $('#error_business_image').show();
                  $('#error_business_image').css('color','red')
                  $('#error_business_image').fadeIn(3000);
                  document.getElementById('error_business_image').innerHTML="Business Image Field is required.";
                  setTimeout(function(){
                  $('#error_business_image').fadeOut(4000);
                  },3000);

                 flag=0;
                 return false;
            }
            var chkimg = img_val.split(".");
             var extension = chkimg[1];

               if(extension!='jpg' && extension!='JPG' && extension!='png' && extension!='PNG' && extension!='jpeg' && extension!='JPEG'
                 && extension!='gif' && extension!='GIF')
               {
                 $('#error_business_image1').css('margin-left','230px')
                 $('#error_business_image1').css('color','red')
                 $('#error_business_image1').show();
                 $('#error_business_image1').fadeIn(3000);
                 document.getElementById('error_business_image1').innerHTML="The file type you are attempting to upload is not allowed.";
                 setTimeout(function(){
                  $('#business_image').css('border-color','#dddfe0');
                  $('#error_business_image1').fadeOut(4000);
               },3000);
               flag=0;
                return false;
              }
              var html='<div>'+
                       '<input type="file" name="business_image[]" id="business_image" class="input_acct" data-rule-required="true"  />'+
                       '<div class="error" id="error_business_image">{{ $errors->first("business_image") }}</div>'+
                       '</div>'+
                       '<div class="clr"></div><br/>'+
                       '<div class="error" id="error_set_default"></div>'+
                       '<div class="clr"></div>';
                  jQuery("#append").append(html);

});
$('#remove-image').click(function()
{
     var html= $("#append").find("input[name='business_image[]']:last");
     html.remove();
});

//Services
$('.add_serc').click(function()
{
    $(".add_more_service").removeAttr("style");
    return false;
});
$('#add-service').click(function()
{
  flag=1;

            var img_val = jQuery("input[name='business_service[]']:last").val();

            var img_length = jQuery("input[name='business_service[]']").length;

            if(img_val == "")
            {
                  $('#error_business_service').css('margin-left','120px');
                  $('#error_business_service').css('color','red');
                  $('#error_business_service').show();
                  $('#error_business_service').fadeIn(3000);
                  document.getElementById('error_business_service').innerHTML="The Services is required.";
                  setTimeout(function(){
                  $('#error_business_service').fadeOut(4000);
                  },3000);

                 flag=0;
                 return false;
            }

              var service_html='<div>'+
                       '<input type="text" class="form-control" name="business_service[]" id="business_service" class="input_acct"  data-rule-required="true"  />'+
                       '<div class="error" id="error_business_image">{{ $errors->first("business_service") }}</div>'+
                       '</div>'+
                       '<div class="clr"></div><br/>'+
                       '<div class="error" id="error_set_default"></div>'+
                       '<div class="clr"></div>';
                  jQuery("#append_service").append(service_html);

});
$('#remove-service').click(function()
{
     var html= $("#append_service").find("input[name='business_service[]']:last");
     html.remove();
});

</script>



@stop