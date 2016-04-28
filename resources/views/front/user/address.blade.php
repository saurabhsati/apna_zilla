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
                  <li class="active">Address Details</li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>
<div class="container">
 <div class="row">

   @include('front.user.profile_left')

   <div class="col-sm-12 col-md-9 col-lg-9">
    <div class="my_whit_bg">
      <div class="title_acc">Please provide your address details</div>
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
      <div class="col-sm-9 col-md-9 col-lg-9">
        <div class="box_profile">
        <form class="form-horizontal"
        id="validation-form"
        method="POST"
        action="{{ url('/front_users/store_address_details') }}"
        enctype="multipart/form-data"
        >

        {{ csrf_field() }}



        @if(count($arr_user_info)>0)

        @foreach($arr_user_info as $user)


                <!--   <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text"> Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="name"
                         value="{{-- $user['first_name']." ".$user['last_name'] --}}"
                                class="input_acct"
                                placeholder="Enter Name" readonly />
                          <div class="error_msg"> </div>
                        </div>
                         </div>
                       </div> -->
                        <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">State :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <select class="input_acct"
                                 name="state" id="state"
                                 data-rule-required="true"

                                 >
                                 @if(isset($arr_state) && sizeof($arr_state)>0)
                   @foreach($arr_state as $state)
                <option value="{{ isset($state['id'])?$state['id']:'' }}" {{ $user['state']==$state['id']?'selected="selected"':'' }}>{{ isset($state['state_title'])?$state['state_title']:'' }}
                </option>
                @endforeach
                @endif
                        </select>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">City :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <select class="input_acct"
                                 name="city" id="city"
                                 data-rule-required="true"

                                 >
                        <!-- <option value="{{-- isset($user['marital_status']) ? $user['marital_status']:'' --}}">{{-- $user['marital_status'] --}} </option> -->

                        @if(isset($arr_city) && sizeof($arr_city)>0)
                   @foreach($arr_city as $city)
                <option value="{{ isset($city['id'])?$city['id']:'' }}" {{ $user['city']==$city['id']?'selected="selected"':'' }}>{{ isset($city['city_title'])?$city['city_title']:'' }}
                </option>
                @endforeach
                @endif
                        </select>
                        </div>
                         </div>
                    </div>
                       <input type="hidden"  name="user_id" value="{{isset($user['id'])?$user['id']:'' }}" > </input>


                     <div class="user_box_sub">
                       <div class="row">
                        <div class="col-lg-3  label-text">Area :</div>
                        <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="area" id="area" data-rule-required="true"
                         value="{{ isset($user['area'])?$user['area']:'' }}"
                         class="input_acct" placeholder="Enter Area "/>
                       </div>
                     </div>
                   </div>

                   <div class="user_box_sub">
                     <div class="row">
                      <div class="col-lg-3  label-text">Pincode :</div>
                      <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                       <input type="text" name="pincode"  id="pincode" data-rule-required="true"
                       value="{{ isset($user['pincode'])?$user['pincode']:'' }}"
                       class="input_acct" placeholder="Enter Pincode  "/>
                     </div>
                   </div>
                 </div>

                 <div class="user_box_sub">
                   <div class="row">
                    <div class="col-lg-3  label-text">Street Address :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                     <input type="text" name="street_address" id="street_address" data-rule-required=""
                     value="{{ isset($user['street_address'])?$user['street_address']:'' }}"
                     class="input_acct" placeholder="Enter Street address  "/>
                   </div>
                 </div>
               </div>


             <button type="submit" style="float: left;margin-left: 142px;;" class="yellow1 ui button">Save & Continue</button>
             @endforeach

             @else
             <span><h4>Please Fill Personal Details First</h4></span>
             @endif
           </form>
           </div>
         </div>

       </div>
     </div>
     </div>

   </div>
 </div>
</div>


<script type="text/javascript">
  jQuery( document ).ready(function () {
    jQuery('#validation-form').validate({
      rules:{
        city:'required',
        area:'required',
        pincode:'required',
        state:'required',
      },
      messages:{
        city:"Please select city",
        state:"Please select state",
        area:"Please enter area",
        pincode:"Please enter pincode",

      },

    })
  });
</script>


@stop