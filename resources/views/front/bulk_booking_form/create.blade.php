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
                  <li class="active">Group Booking Request Form</li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>
<div class="container">
         <div class="row">
           
         
            <div class="col-sm-12 col-md-12 col-lg-12">



            <div class="my_whit_bg">
                 <div class="title_acc"><h3>Group Booking Request Form<h3></div>
                 @if(isset($form_data) && sizeof($form_data)>0)
                 <h2>
                   {{$form_data['dealTitle']}}
                 </h2>
                 @endif
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

                   <div class="row">
                      <form class="form-horizontal"
                            name="profile"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/')}}/{{$city}}/booking_order"
                           enctype="multipart/form-data"
                           >

                           {{ csrf_field() }}

                

                 <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">
                @if(isset($form_data)&& sizeof($form_data)>0)
                <input type="hidden" name="deal_id" value="{{$form_data['deal_id']}}">
                <input type="hidden" name="city" value="{{$form_data['divisionId']}}">
                <input type="hidden" name="deal_url" value="{{$form_data['dealUrl']}}">
                @endif
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="name"
                         value="@if(Session::has('user_name')){{Session::get('user_name')}}@endif"
                                class="input_acct"
                                placeholder="Enter  Name"/>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Organization :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="organization"
                         value=""
                                class="input_acct"
                                placeholder="Enter Organization Name"/>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Email ID :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="email_id"
                         value="@if(Session::has('user_email')){{Session::get('user_email')}}@endif"
                                class="input_acct"
                                placeholder="Enter Email ID"/>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Phone Number :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="phone_no"
                         value="@if(Session::has('mobile_no')){{Session::get('mobile_no')}}@endif"
                                class="input_acct"
                                placeholder="Enter Phone Number"/>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Quantity :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="quantity"
                         value=""
                                class="input_acct"
                                placeholder="Enter Quantity"/>
                        </div>
                         </div>
                    </div>

                   <button type="submit" class="yellow1 ui button">Submit</button>

                    </div>

                   
                    </form>
                    </div>
                </div>
            </div>
         </div>

    </div>
</div>

  </div></div>


<script type="text/javascript">
$(document ).ready(function (){

  $("#validation-form").validate({
    // Specify the validation rules
      rules: {
          name: "required",
          quantity: "required",
          email_id: {
            required:true,
            email:true
          },
       

      },
    // Specify the validation error messages
      messages: {
          name: "Please enter name.",
          email_id: "Please enter valid email id.",
          quantity: "Please select quantity.",
          
      },

  });
});
</script>



@stop