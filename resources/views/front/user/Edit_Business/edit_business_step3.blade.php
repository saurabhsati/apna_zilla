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

              <div class="my_whit_bg">
                <div class="title_acc">Please Provide Business Contact Information</div>
                 <div class="row">
                  @if(isset($business_data) && sizeof($business_data)>0)
                  @foreach($business_data as $business)
                  <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/update_business_step3/'.$enc_id)}}"
                           enctype="multipart/form-data"
                           >

                {{ csrf_field() }}
                <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="box_profile">

                <!-- <div class="user_box_sub">
                  <div class="row">
                    <div class="col-lg-2 label-text">Contact Person's Name<span>:</span></div>
                      <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                        <input type="text"  class="input_acct" id="contact_person_name" name="contact_person_name" placeholder="Enter Name"
                        value="{{-- isset($business['contact_person_name'])?$business['contact_person_name']:'' --}}"/>
                      <div class="error_msg"></div>
                      </div>
                  </div>
                </div> -->


                <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Contact Person's Name<span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <div class="row">
                            <div class="col-sm-2 col-md-2 col-lg-2">
                              <select class="input_acct" name="prefix_name" >
                                 <option value="0" <?php if(isset($business['prefix_name']) &&  $business['prefix_name']=='0'){ echo 'selected="selected"'; }?> >Mr.</option>
                                 <option value="1" <?php if(isset($business['prefix_name']) &&  $business['prefix_name']=='1'){ echo 'selected="selected"'; }?>>Ms.</option>
                                 <option value="2" <?php if(isset($business['prefix_name']) &&  $business['prefix_name']=='2'){ echo 'selected="selected"'; }?>>Mrs.</option>
                              </select>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 m_l"> <input type="text"  id="contact_person_name" 

                              data-rule-required="true"  name="contact_person_name" 
                              value="{{ isset($business['contact_person_name'])?$business['contact_person_name']:'' }}"
                            class="input_acct" placeholder="Enter name"></div>
                            <!-- <div class="col-sm-5 col-md-5 col-lg-4"> <input type="text"  id="designation" name="designation" class="input_acct" placeholder="Designation"></div> -->
                          </div>
                          <div class="error_msg">{{ $errors->first('contact_name') }} </div>
                        </div>
                    </div>
                  </div>


                  <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Mobile No.<span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">+91</span>
                          <input type="text" class="form-control"  id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number"  
                          data-rule-required="true" value="{{ isset($business['mobile_number'])?$business['mobile_number']:'' }}" data-rule-number="true"   data-rule-minlength="10" maxlength="10"/>
                          </div>
                          <!-- <div class="hyper_link_more"><a href="#">Add more mobile number</a></div> -->
                          <div class="error_msg">{{ $errors->first('mobile_number') }} </div>
                        </div>
                    </div>
                  </div>

                  <!--  <div class="user_box_sub">
                      <div class="row">
                       <div class="col-lg-2 label-text">Landline No. <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="landline_number" 
                            data-rule-required="true"
                             name="landline_number" placeholder="Enter Landline Number"  value="{{ isset($business['landline_number'])?$business['landline_number']:'' }}"/>
                           <div class="error_msg">{{ $errors->first('landline_number') }} </div>
                        </div>
                     </div>
                  </div>




                    <div class="user_box_sub">
                         <div class="row">
                  <div class="col-lg-2 label-text">Fax No. <span>:</span></div>
                  <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                       <input type="text"  class="input_acct" id="fax_no" name="fax_no" 
                       data-rule-required="true"
                       placeholder="Enter Fax Number" value="{{ isset($business['fax_no'])?$business['fax_no']:'' }}"/>
                         <div class="error_msg"></div>
                      </div>
                       </div>
                  </div>

                    <div class="user_box_sub">
                         <div class="row">
                          <div class="col-lg-2 label-text">Toll free No. <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct" id="toll_free_number" 
                          data-rule-required="true"
                           name="toll_free_number" placeholder="Enter Toll free number "  value="{{ isset($business['toll_free_number'])?$business['toll_free_number']:'' }}"/>
                          <div class="error_msg">{{ $errors->first('toll_free_number') }} </div>
                          </div>
                          </div>
                  </div>


                 <div class="user_box_sub">
                      <div class="row">
                          <div class="col-lg-2 label-text">Email Id <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="email_id" name="email_id" data-rule-required="true" data-rule-email="true" placeholder="Enter Email Id "  value="{{ isset($business['email_id'])?$business['email_id']:'' }}"/>
                          <div class="error_msg">{{ $errors->first('email') }} </div>
                          </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                      <div class="row">
                        <div class="col-lg-2 label-text">website <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <input type="text"  class="input_acct" id="website"
                          data-rule-required="true"
                          name="website" placeholder="Enter Website" value="{{ isset($business['website'])?$business['website']:'' }}"/>
                          <div class="error_msg">{{ $errors->first('website') }} </div>
                        </div>
                         </div>
                    </div> -->


                  <div class="button_save1">
                  <a class="btn btn-post" href="{{ url('/front_users/edit_business_step2/'.Request::segment(3))}}" style="float: left; margin-right:194px; "> Back</a>
                    <button type="submit" class="btn btn-post" name="add_contacts" style="float: left; margin-left:125px; ">Save &amp; continue</button>
                    <!-- <a class="btn btn-post pull-left" href="#">previous</a>
                    <a class="btn btn-post" href="#">Save &amp; exit</a>
                    <a class="btn btn-post pull-right" href="#">Next</a> -->
                 </div>

               </div>
              </div>
              </form>
              @endforeach
              @endif
            </div>
             </div>
             <div class="clr"></div>


         </div>
       </div>
      </div>
      </div>

<script type="text/javascript">
$(document ).ready(function (){

  $("#validation-form").validate({
    // Specify the validation rules
      rules: {
          contact_person_name: "required",
          mobile_number: {
                required: true,
                maxlength: 10
            },
          email_id: {
            required:true,
            email:true
          },
          landline_number:"required",
          fax_no:"required",
          toll_free_number:"required",
          website:{
            required:true,
           // url:true
          }
          
      },
    // Specify the validation error messages
      messages: {
          contact_person_name: "Please enter contact person's name.",
          mobile_number: "Please enter valid mobile number.",
          email_id: "Please enter valid email id.",
          landline_number: "Please enter Landline number.",
          fax_no: "Please enter fax number.",
          toll_free_number: "Please enter toll free number.",
          website:"Please enter valid url."
      },

  });
});
</script>




@stop