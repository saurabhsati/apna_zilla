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


                <div class="user_box_sub">
                  <div class="row">
                    <div class="col-lg-2 label-text">Contact Person's Name<span>:</span></div>
                      <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                        <input type="text"  class="input_acct" id="contact_person_name" name="contact_person_name" placeholder="Enter Name"
                        value="{{ isset($business['contact_person_name'])?$business['contact_person_name']:'' }}"/>
                      <div class="error_msg"></div>
                      </div>
                  </div>
                </div>

                  <div class="user_box_sub">
                    <div class="row">
                      <div class="col-lg-2 label-text">Mobile No.<span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">+91</span>
                          <input type="text" class="form-control"  id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number"  aria-describedby="basic-addon1" value="{{ isset($business['mobile_number'])?$business['mobile_number']:'' }}"/>
                          </div>
                          <!-- <div class="hyper_link_more"><a href="#">Add more mobile number</a></div> -->
                          <div class="error_msg">{{ $errors->first('mobile_number') }} </div>
                        </div>
                    </div>
                  </div>

                   <div class="user_box_sub">
                      <div class="row">
                       <div class="col-lg-2 label-text">Landline No. <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="landline_number" name="landline_number" placeholder="Enter Landline Number"  value="{{ isset($business['landline_number'])?$business['landline_number']:'' }}"/>
                           <div class="error_msg">{{ $errors->first('landline_number') }} </div>
                        </div>
                     </div>
                  </div>




                    <div class="user_box_sub">
                         <div class="row">
                  <div class="col-lg-2 label-text">Fax No. <span>:</span></div>
                  <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                       <input type="text"  class="input_acct" id="fax_no" name="fax_no" placeholder="Enter Fax Number" value="{{ isset($business['fax_no'])?$business['fax_no']:'' }}"/>
                         <div class="error_msg"></div>
                      </div>
                       </div>
                  </div>

                    <div class="user_box_sub">
                         <div class="row">
                          <div class="col-lg-2 label-text">Toll free No. <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct" id="toll_free_number" name="toll_free_number" placeholder="Enter Toll free number "  value="{{ isset($business['toll_free_number'])?$business['toll_free_number']:'' }}"/>
                          <div class="error_msg">{{ $errors->first('toll_free_number') }} </div>
                          </div>
                          </div>
                  </div>


                 <div class="user_box_sub">
                      <div class="row">
                          <div class="col-lg-2 label-text">Email Id <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                          <input type="text"  class="input_acct"  id="email_id" name="email_id" placeholder="Enter Email Id "  value="{{ isset($business['email_id'])?$business['email_id']:'' }}"/>
                          <div class="error_msg">{{ $errors->first('email') }} </div>
                          </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                      <div class="row">
                        <div class="col-lg-2 label-text">website <span>:</span></div>
                        <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <input type="text"  class="input_acct" id="website" name="website" placeholder="Enter Website" value="{{ isset($business['website'])?$business['website']:'' }}"/>
                          <div class="error_msg">{{ $errors->first('website') }} </div>
                        </div>
                         </div>
                    </div>


                  <div class="button_save1">
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
@stop