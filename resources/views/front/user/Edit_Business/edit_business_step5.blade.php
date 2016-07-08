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
          <li class="active">Contact Information</li>

    </ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">
         @include('front.user.Edit_Business.edit_business_left_side_bar_menu')

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

                  @if(isset($business_data) && sizeof($business_data)>0)
                  @foreach($business_data as $business)
                  <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                            action="{{ url('/front_users/update_business_step5/'.$enc_id)}}"
                           enctype="multipart/form-data"
                           >

                {{ csrf_field() }}

               <div class="my_whit_bg">
              <div class="title_acc">Please Provide Other Information</div>
                <div class="row">


              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="box_profile">

<!-- 
                   <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Youtube Link <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="youtube_link" name="youtube_link"  placeholder="Enter Youtube Link" value="{{ isset($business['youtube_link'])?$business['youtube_link']:'' }}"  data-rule-required="true"/>
                           <div class="error_msg">{{ $errors->first('youtube_link') }} </div>
                        </div>
                    </div>
                  </div> -->
                  <div class="user_box_sub">
                            <div class="col-lg-2 label-text">Uploaded Business Gallery Images<span>:</span></div>
                            <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                               @if(isset($business['image_upload_details']) && sizeof($business['image_upload_details'])>0)
                                 @foreach($business['image_upload_details'] as $image)

                                  <div class="fileupload-new img-thumbnail main" style="width: 202px; height: 160px;" data-image="{{ $image['image_name'] }}">
                                     <img style="width:191px;height:132px"
                                      src={{ $business_public_img_path.$image['image_name']}} alt="" />
                                     <div class="caption">
                                     <p class="pull-left">
                                        <a href="javascript:void(0);"class="delete_image" data-image="{{ $image['image_name'] }}" onclick="javascript: return delete_gallery('<?php echo $image['id'] ;?>','<?php echo $image['image_name'];?>')">
                                         <span class="glyphicon glyphicon-minus-sign " style="font-size: 20px;"></span></a>
                                     </p>
                                    </div>
                                  </div>
                               @endforeach
                                @else
                                  <span class="col-lg-8 label-text">No Business Gallery Images Availbale</span>
                                  @endif
                               <div class="error" id="err_delete_image"></div>
                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>

                <div class="user_box_sub">
                         <div class="row">
                          <div class="col-lg-2 label-text"><a href="#" class="add_more">Add More Gallery Images </a> <span>:</span></div>
                </div></div>


             <div class="user_box_sub add_more_image" style="display: none;">
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
                    <div class="col-lg-2 label-text">Upload Business Gallery Images<span>:</span></div>
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

                 <div class="fouser_box_sub">
                            <div class="col-lg-2 label-text">Business Services<span>:</span></div>
                            <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                               @if(isset($business['service']) && sizeof($business['service'])>0)
                                 
                                 @foreach($business['service'] as $service)

                                  <div class="fileupload-new img-thumbnail main" style="width: 300px; height: 62px;" data-service="{{ $service['name'] }}">
                                     <input class="form-control" type="text" name="service" id="service" class="pimg"  value="{{ $service['name']}}" />
                                     <div class="caption">
                                     <p class="pull-left">
                                        <a href="javascript:void(0);"class="delete_service" data-service="{{ $service['name'] }}" onclick="javascript: return delete_service('<?php echo $service['id'] ;?>')">
                                         <span class="glyphicon glyphicon-minus-sign " style="font-size: 20px;"></span></a>
                                     </p>
                                    </div>
                                  </div>

                                  @endforeach
                                  @else
                                  <span class="col-lg-8 label-text">No Business Services Availbale</span>
                                  @endif
                                  <div class="error" id="err_delete_service"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
                <div class="user_box_sub">
                         <div class="row">
                          <div class="col-lg-2 label-text"><a href="#" class="add_serc">Add More Business Services </a> <span>:</span></div>
                </div></div>



                <div class="user_box_sub add_more_service" style="display: none;" >
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
                <a class="btn btn-post" href="{{ url('/front_users/edit_business_step4/'.Request::segment(3))}}" style="float: left; margin-right:194px; "> Back</a>
                    <button type="submit" class="btn btn-post" name="add_contacts" style="float: left; margin-left:125px; ">Save &amp; Finish</button>
                    <!-- <a class="btn btn-post pull-left" href="#">previous</a>
                    <a class="btn btn-post" href="#">Save &amp; exit</a>
                    <a class="btn btn-post pull-right" href="#">Next</a> -->
                 </div>
                </div>
                </form>
                @endforeach
                @endif
              </div>
            </div>
           </div>
         </div>
       </div>

      </div>

<script type="text/javascript">
function delete_gallery(id,image_name)
{
  var _token = $('input[name=_token]').val();
  var dataString = { id:id, image_name:image_name, _token: _token };
  var url_delete= site_url+'/front_users/delete_gallery';
  $.post( url_delete, dataString)
      .done(function( data ) {
        if(data=='done'){
             $('#err_delete_image').html('<div style="color:green">Image deleted successfully.</div>');
             var request_id=$('.delete_image').parents('.main').attr('data-image');
             $('div[data-image="'+request_id+'"]').remove();
        }
      });
}
function delete_service(id)
{
  var _token = $('input[name=_token]').val();
  var dataString = { id:id, _token: _token };
  var url_delete= site_url+'/front_users/delete_service';
   $.post( url_delete, dataString)
      .done(function( data ) {
        if(data=='done'){
             $('#err_delete_service').html('<div style="color:green">Service deleted successfully.</div>');
             var request_id=$('.delete_service').parents('.main').attr('data-service');
             $('div[data-service="'+request_id+'"]').remove();
        }
      });
}
$('.add_more').click(function(){
     $(".add_more_image").removeAttr("style");
     return false;
});

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
                       '<input type="text"  name="business_service[]" id="business_service" class="input_acct"  data-rule-required="true"  />'+
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


<script type="text/javascript">
$(document ).ready(function (){

  $("#validation-form").validate({
      
      rules: {
          youtube_link: "required",
      },
      
      messages: {
          youtube_link: "Please enter valid youtube link.",
      },

  });
});
</script>





@stop