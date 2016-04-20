@extends('front.template.master')

@section('main_section')
<!--search area start here-->
<div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
 <div class="container">
   <div class="row">
     <div class="col-sm-12 col-md-12 col-lg-12">
       <div class="title_bag">Membership Plan </div>
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
        <li><a href="{{ url('/').'/front_users/add_business' }}">My Business</a></li>
       <li >Membership Plan</li>
     </ol>
   </div>
 </div>
</div>
<hr/>
<div class="services_bx">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                   <form class="form-horizontal"
          id="payumoney_form"
          method="POST"
          action="{{ url('/payumoney')}}"
          >
           <input type="hidden" name="business_id" id="business_id" value="{{$enc_business_id}}">
           <input type="hidden" name="business_name" id="business_name" value="{{$enc_business_name}}">
           <input type="hidden" name="user_id" id="user_id" value="{{$enc_user_id}}">
            <input type="hidden" name="user_name" id="user_name" value="{{session('user_name')}}">
            <input type="hidden" name="user_mail" id="user_mail" value="{{session('user_mail')}}">
           <input type="hidden" name="category_id" id="category_id" value="{{$enc_category_id}}">

           <input type="hidden" name="validity" id="validity" value="">
           <input type="hidden" name="price"  id="price" value=""/>
           <input type="hidden" name="plan_id"  id="plan_id" value=""/>

                        <div data-animate-scroll='{"x": "-200","y": "0", "alpha": "0", "duration": "0.75"}'>
                           <h2 class="top_line_head">Business Packages</h2>
                           <div class="row">
                            @if(isset($arr_membership_plan) && sizeof($arr_membership_plan)>0)

                   <?php foreach($arr_membership_plan  as $key => $plan) {?>
                           <div class="col-sm-6 col-md-3 col-lg-4">
                              <div class="package_min">
                                 <div class="<?php if($key%2==0){ echo "package_basic_orange";}else { echo "package_basic_yellow";}?> ">{{ $plan['price'] }}<span>$</span> </div>
                                <!--  <div class="one_tome_text">One Time Charges</div> -->
                                 <div class="package_title">
                                    <h3> {{ $plan['title'] }}</h3>
                                    </div>
                                 <div class="package_text">{{ $plan['description'] }}</div>
                                 <div class="package_text">Add {{ $plan['no_normal_deals'] }} Business Deals </div>
                                 <div class="package_text">
                                    Validity {{ $plan['validity'] }} Days
                                   <!--  <div class="offer_bx"> FREE</div> -->
                                 </div>

                                  <div class="package_view">
                                  <input type="radio" class="package_view" name="mem_plan_id" id="mem_plan_id{{ $plan['plan_id'] }}" value="{{ $plan['plan_id'] }}" onclick="get_plan_cost(this);">
                                 <!--  <a href="javascript void(0);"  onclick="function submit_plan();">Purchase Plan</a> -->

                                  <button type="submit"  name="mem_plan_sumit"   onclick="return submit_plan();" >Purchase Plan</button>
                                 </div>
                                 <div class="clr"></div>
                              </div>
                           </div>
                           <?php } ?>
                         @endif

                        </div>
                     </div>
                    </form>
                  </div>
               </div>
            </div>
         </div>



<!-- <div class="container">
 <div class="row">
 <div class="col-sm-12 col-md-12 col-lg-6">
     <div class="row">
      <div class="box_contact">
      <form class="form-horizontal"
          id="validation-form"
          method="POST"
          action="{{ url('/payumoney')}}"
          >
           <input type="hidden" name="business_id" id="business_id" value="{{$enc_business_id}}">
           <input type="hidden" name="business_name" id="business_name" value="{{$enc_business_name}}">
           <input type="hidden" name="user_id" id="user_id" value="{{$enc_user_id}}">
            <input type="hidden" name="user_name" id="user_name" value="{{session('user_name')}}">
            <input type="hidden" name="user_mail" id="user_mail" value="{{session('user_mail')}}">
           <input type="hidden" name="category_id" id="category_id" value="{{$enc_category_id}}">
           <input type="hidden" name="validity" id="validity" value="">

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">Select Membership Plan</label>
                <div class="col-sm-6 col-lg-4 controls">
                   <select class="form-control" name="plan_id" id="plan_id" onchange="return get_plan_cost();">
                    <option value="" >Select Membership Plan</option>

                   @if(isset($arr_membership_plan) && sizeof($arr_membership_plan)>0)
                   @foreach($arr_membership_plan as $plan)
                     <option value="{{ $plan['plan_id'] }}" >
                      {{ $plan['title'] }}
                    </option>
                   @endforeach
                    @endif
                  </select>
                    <span class='help-block'>{{ $errors->first('plan_id') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Price<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="price"
                           id="price"
                           data-rule-required="true"
                           value=""
                           disabled=""
                           />
                    <span class='help-block'>{{ $errors->first('price') }}</span>
                </div>
            </div>




            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Pay Now">

            </div>
        </div>


    </form>
     </div>
   </div>
 </div>
</div>
</div> -->
</div>
<script type="text/javascript">
function submit_plan()
{
  var price = $('input[name=price]').val();
  var plan_id = $('input[name=plan_id]').val();
  var validity = $('input[name=validity]').val();
  if(plan_id!='' && price!='' && validity!='')
  {
    return true;
  }
  else
  {
    alert("Please Select Plan ");
    return false;
  }
}
var site_url = "{{url('/')}}";
function get_plan_cost(ref)
{

  var _token = $('input[name=_token]').val();
  var plan_id=$(ref).attr("value");
  var category_id=$("#category_id").val();
  if(plan_id!='' && category_id!='')
  {
  var dataString = { plan_id:plan_id, category_id:category_id, _token: _token };
  var url= site_url+'/front_users/get_plan_cost';
  $.post( url, dataString)
      .done(function( response ) {
                            if(response.status=="SUCCESS")
                            {
                                 var price_val = response.price;
                                  $('input[name="price"]').attr('value',price_val);
                                   var plan_id_val = response.plan_id;
                                  $('input[name="plan_id"]').attr('value',plan_id_val);
                                   var validity_val = response.validity;
                                  $('input[name="validity"]').attr('value',validity_val);
                                  //$("payumoney_form").submit();
                                  return true;
                            }
                            /*else if(response.status=="CategoryCostAbsent")
                            {
                                  var get_url=site_url+'/web_admin/business_listing';
                                  window.location.href = get_url;
                            }*/
      });

  }
  else
  {
    alert("Please select the Membership Plan");
  }
  return false;
}

</script>

@endsection