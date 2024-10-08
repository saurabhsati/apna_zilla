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
                  <li class="active">Business Information</li>
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
                 <div class="title_acc">Please Provide Location Information</div>
                 <div class="row">
                    @if(isset($business_data) && sizeof($business_data)>0)
                  @foreach($business_data as $business)
                  <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                          action="{{ url('/front_users/update_business_step2/'.$enc_id)}}"
                           enctype="multipart/form-data"
                           >


                {{ csrf_field() }}


            <div class="col-sm-9 col-md-9 col-lg-12">
                <div class="box_profile">
                    <!--  <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Building:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="building" id="building"
                                class="input_acct"
                                placeholder="Enter Building's Name"
                                data-rule-required="true"
                                
                                value="{{ isset($business['building'])?$business['building']:'' }}"
                                />
                          <div class="error_msg">{{ $errors->first('building') }} </div>
                        </div>
                         </div>
                    </div>

                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Street:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="street" id="street"
                                class="input_acct"
                                placeholder="Enter Street's Name"
                                value="{{ isset($business['street'])?$business['street']:'' }}"
                                data-rule-required="true"
                                />

                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Landmark:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="landmark" id="landmark"
                                class="input_acct"
                                placeholder="Enter Landmark's Name"
                                value="{{ isset($business['landmark'])?$business['landmark']:'' }}"
                                data-rule-required="true"
                                />
                        <div class="error_msg">{{ $errors->first('landmark') }} </div>
                        </div>
                         </div>
                    </div> -->

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Area:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="area" id="area"
                                class="input_acct"
                                placeholder="Enter Area's Name"
                                 value="{{ isset($business['area'])?$business['area']:'' }}"
                                data-rule-required="true"
                                />
                        </div>
                         </div>
                    </div>


           <div class="geo-details">
          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Country :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                 <input type="text" data-geo="country" value="{{ isset($business['country'])?$business['country']:'' }}" id="country" name="country" class="input_acct">
                   <div class="error_msg">{{ $errors->first('country') }} </div>
                </div>
              </div>
            </div>

          <div class="user_box_sub">
           <div class="row">
            <div class="col-lg-3  label-text">State :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l" >
                <input type="text" data-geo="administrative_area_level_1" value="{{ isset($business['state'])?$business['state']:'' }}" id="state" name="state" class="input_acct">
                <div class="error_msg">{{ $errors->first('state') }} </div>
              </div>
            </div>
          </div>


          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">City :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                <input type="text" data-geo="administrative_area_level_2" value="{{ isset($business['city'])?$business['city']:'' }}" id="city" name="city" class="input_acct">
                <div class="error_msg">{{ $errors->first('city') }} </div>
                </div>
              </div>
            </div>
             <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Latitude :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
              <input type="text" data-geo="lat" value="{{ isset($business['lat'])?$business['lat']:'' }}" id="lat" name="lat" class="form-control">
                <div class="error_msg">{{ $errors->first('lat') }} </div>
                </div>
              </div>
            </div>
             <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Longitude :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                 <input type="text" data-geo="lng" value="{{ isset($business['lng'])?$business['lng']:'' }}" id="lng" name="lng" class="form-control">
                <div class="error_msg">{{ $errors->first('lng') }} </div>
                </div>
              </div>
            </div>

            <div class="user_box_sub">
              <div class="row">
                <div class="col-lg-3  label-text">Pin code :</div>
                  <div class="col-sm-9 col-md-9 col-lg-9 m_l">
                     <input type="text" data-geo="postal_code" value="{{ isset($business['pincode'])?$business['pincode']:'' }}" id="pincode" name="pincode" class="input_acct" data-rule-number="true"   data-rule-minlength="6" maxlength="6">
                    <div class="error_msg">{{ $errors->first('zipcode') }} </div>
                </div>
              </div>
            </div>

          


             <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Map :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                    <div id="business_location_map" style="height:400px"></div>

                    <label>Note: Click On the Map to Pick Nearby Custom Location </label>
                    <div>
                    <a id="reset" href="#" style="display:none;">Reset Marker</a></div>
                </div>
              </div>
            </div>
            
                         <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3"><a class="btn btn-post" href="{{ url('/front_users/edit_business_step1/'.Request::segment(3))}}" style="float: left;margin-bottom:10px;"> Back</a></div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
  <button type="submit" class="btn btn-post" name="add_business" style="float: left;  ">Save &amp; continue</button>
                </div>
              </div>
            </div>
</div>

                    </div>
                  </div>
               </div>
             <div class="button_save1">
              
                  
                    <!-- <a href="#" class="btn btn-post pull-left">previous</a>
                    <a href="#" class="btn btn-post">Save &amp; exit</a>
                    <a href="#" class="btn btn-post pull-right">Next</a> -->
              </div>
              <div class="clr"></div>

            </div>
            </form>
            @endforeach
@endif
          </div>
         </div>
       </div>
      </div>
<script type="text/javascript">
 var url = "{{ url('/') }}";
</script>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAEKnsSxbtF8dK6u31DSrx3BR40TqBvRD4"></script>
<script src="{{ url('/') }}/assets/front/js/jquery.geocomplete.min.js"></script>
<script>
$(function () {

 var location =$("input[name=area]").val();
var options = {
                types: ['(cities)'],
                componentRestrictions: {country: 'IN'},
                details: ".geo-details",
                detailsAttribute: "data-geo",
                map: "#business_location_map",
                location: location,
                types: ["geocode", "establishment"],
                markerOptions: {
                                    draggable: true
                               }
              }
  $("#area").geocomplete(options);

$("#area").bind("geocode:dragged", function(event, latLng){
          $("input[name=lat]").val(latLng.lat());
          $("input[name=lng]").val(latLng.lng());
          $("#reset").show();
        });


        $("#reset").click(function(){
          $("#area").geocomplete("resetMarker");
          $("#reset").hide();
          return false;
        });
});
</script>
 

<script type="text/javascript">
$(document ).ready(function (){
  $("#validation-form").validate({
    // Specify the validation rules
      rules: {
         
          area: "required",
      },
    // Specify the validation error messages
      messages: {
         
          area: "Please enter area.",

      },

  });
});
</script>


@stop
