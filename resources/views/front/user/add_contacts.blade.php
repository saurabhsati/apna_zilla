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
          <li class="active">Add Your Contact Information</li>

</ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">
             @include('front.user.left_side_bar_user_business')

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

              <div class="my_whit_bg">
                <div class="title_acc">Please Provide Business Contact Information</div>
                 <div class="row">

                  <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/add_contacts_details') }}"
                           enctype="multipart/form-data"
                           >

                {{ csrf_field() }}

                 <input type="hidden" name="business_id" value="{{ $business_id }}" >  </input>



                  <!--  <div class="col-sm-12 col-md-9 col-lg-9">
                  <div class="my_whit_bg">
                    <div class="title_acc">Please Provide Contact Person's Information</div>
                      <div class="row"> -->


                <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="box_profile">

                  <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Contact Person <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <div class="row">
                            <div class="col-sm-2 col-md-2 col-lg-2">
                              <select class="input_acct" name="prefix_name" >
                                 <option value="0" >Mr.</option>
                                 <option value="1" >Ms.</option>
                                 <option value="2" >Mrs.</option>
                              </select>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 m_l"> <input type="text"  id="contact_name" name="contact_name"  data-rule-required="true" class="input_acct" placeholder="Enter name"></div>
                           <!--  <div class="col-sm-5 col-md-5 col-lg-4"> <input type="text"  id="designation" name="designation" class="input_acct" placeholder="Designation"></div> -->
                          </div>
                          <div class="error_msg">{{ $errors->first('contact_name') }} </div>
                        </div>
                    </div>
                  </div>

                <!-- <div class="user_box_sub">
                  <div class="row">
                    <div class="col-lg-2 label-text">Contact Person's Name<span>:</span></div>
                      <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                        <input type="text"  class="input_acct" id="contact_name" name="contact_name" placeholder="Enter Name" required/>
                      <div class="error_msg">please enter correct</div>
                      </div>
                  </div>
                </div> -->

                  <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Mobile No <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">+91</span>
                          <input type="text" class="form-control"  id="mobile_no" name="mobile_no" placeholder="Enter Mobile Number" data-rule-required="true" />
                          </div>
                          <!-- <div class="hyper_link_more"><a href="#">Add more mobile number</a></div> -->
                          <div class="error_msg">{{ $errors->first('mobile_no') }} </div>
                        </div>
                    </div>
                  </div>

                  <!--  <div class="user_box_sub">
                      <div class="row">
                       <div class="col-lg-2 label-text">Landline No. <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="landline_no" name="landline_no" data-rule-required="true" placeholder="Enter Landline Number"/>
                           <div class="error_msg">{{ $errors->first('landline_no') }} </div>
                        </div>
                     </div>
                  </div>

                    <div class="user_box_sub">
                        <div class="row">
                          <div class="col-lg-2 label-text">fax No. <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91-22</span>
                        <input type="text" class="form-control" id="fax_no" name="fax_no" data-rule-required="true" placeholder="Enter Fax Number"  />
                        </div>
                          <div class="error_msg">{{ $errors->first('fax_no') }} </div>
                        </div>
                         </div>
                    </div>




                    <div class="user_box_sub">
                         <div class="row">
                          <div class="col-lg-2 label-text">Toll free No. <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct" id="toll_free_no" name="toll_free_no" data-rule-required="true" placeholder="Enter Toll free number "/>
                          <div class="error_msg">{{ $errors->first('toll_free_no') }} </div>
                          </div>
                          </div>
                  </div>


                 <div class="user_box_sub">
                      <div class="row">
                          <div class="col-lg-2 label-text">Email Id <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="email" name="email" data-rule-required="true" data-rule-email="true" placeholder="Enter Email Id "/>
                          <div class="error_msg">{{ $errors->first('email') }} </div>
                          </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                      <div class="row">
                        <div class="col-lg-2 label-text">website <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <input type="text"  class="input_acct" id="website" name="website" data-rule-required="true" placeholder="Enter Website"/>
                          <div class="error_msg">{{ $errors->first('website') }} </div>
                        </div>
                         </div>
                    </div> -->


                  <div class="button_save1">
                    <button type="submit" class="btn btn-post" name="add_contacts" style="float: left; margin-left:125px; ">Save &amp; continue</button>
                   
                 </div>

               </div>
              </div>
              </form>
            </div>
             </div>
             <div class="clr"></div>


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
$(document ).ready(function (){

  $("#validation-form").validate({
    // Specify the validation rules
      rules: {
          contact_name: "required",
          mobile_no: {
                required: true,
                maxlength: 10
            },
          email: {
            required:true,
            email:true
          },
          landline_no:"required",
          fax_no:"required",
          toll_free_no:"required",
          website:{
            required:true,
           // url:true
          }

      },
    // Specify the validation error messages
      messages: {
          contact_name: "Please enter contact person's name.",
          mobile_no: "Please enter valid mobile number.",
          email: "Please enter valid email id.",
          landline_no: "Please enter Landline number.",
          fax_no: "Please enter fax number.",
          toll_free_no: "Please enter toll free number.",
          website:"Please enter valid url."
      },

  });
});
</script>


@stop