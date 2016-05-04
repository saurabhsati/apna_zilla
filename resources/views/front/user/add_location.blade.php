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
                  <li class="active">Add Your Business Location Information</li>
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
                 <div class="title_acc">Please Provide Location Information</div>
                 <div class="row">

                  <form class="form-horizontal"
                           id="validation-form"
                           method="POST"
                           action="{{ url('/front_users/add_location_details') }}"
                           enctype="multipart/form-data"
                           >
                  <input type="hidden" name="business_id" value="{{ $business_id }}" >  </input>

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
                               data-rule-required="true"/>

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
                              data-rule-required="true"/>
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

                               data-rule-required="true" />
                        </div>
                         </div>
                    </div>

  <div class="geo-details">
          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Country :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                 <input type="text" data-geo="country" value="" id="country" name="country" class="input_acct">
                   <div class="error_msg">{{ $errors->first('country') }} </div>
                </div>
              </div>
            </div>

          <div class="user_box_sub">
           <div class="row">
            <div class="col-lg-3  label-text">State :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l" >
                <input type="text" data-geo="administrative_area_level_1" value="" id="state" name="state" class="input_acct">
                <div class="error_msg">{{ $errors->first('state') }} </div>
              </div>
            </div>
          </div>


          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">City :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                <input type="text" data-geo="administrative_area_level_2" value="" id="city" name="city" class="input_acct">
                <div class="error_msg">{{ $errors->first('city') }} </div>
                </div>
              </div>
            </div>
             <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Latitude :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
              <input type="text" data-geo="lat" value="" id="lat" name="lat" class="form-control">
                <div class="error_msg">{{ $errors->first('lat') }} </div>
                </div>
              </div>
            </div>
             <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Longitude :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                 <input type="text" data-geo="lng" value="" id="lng" name="lng" class="form-control">
                <div class="error_msg">{{ $errors->first('lng') }} </div>
                </div>
              </div>
            </div>

            <div class="user_box_sub">
              <div class="row">
                <div class="col-lg-3  label-text">Pin code :</div>
                  <div class="col-sm-9 col-md-9 col-lg-9 m_l">
                     <input type="text" data-geo="postal_code" value="" id="pincode" name="pincode" class="input_acct">
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
</div>

            <!--  <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" >Map<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="hidden" name="lat" value="" id="lat" />
                    <input type="hidden" name="lng" value="" id="lng"/>

                    <div id="restaurant_location_map" style="height:400px"></div>
                    <label>Note: Click On the Map to Pick Nearby Custom Location </label>
                </div>
            </div> -->

             <!--  <div class="user_box_sub">
                <div class="row">
                  <div class="col-lg-3  label-text">Mobile No:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                      <input type="text" name="mobile_number" class="input_acct" placeholder="Enter Mobile Number" />
                    </div>
                  </div>
              </div>

               <div class="user_box_sub">
                 <div class="row">
                    <div class="col-lg-3  label-text">Landline No:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="landline_number"  class="input_acct" placeholder="Enter Landline Number" />
                    </div>
                  </div>
                </div> -->

                    </div>
                  </div>
               </div>
             <div class="button_save1">
                    <button type="submit" class="btn btn-post" name="add_business" style="float: left; margin-left:194px; ">Save &amp; continue</button>
                    <!-- <a href="#" class="btn btn-post pull-left">previous</a>
                    <a href="#" class="btn btn-post">Save &amp; exit</a>
                    <a href="#" class="btn btn-post pull-right">Next</a> -->
              </div>
              <div class="clr"></div>

            </div>
            </form>
          </div>
         </div>
       </div>
      </div>
<script type="text/javascript">
 var url = "{{ url('/') }}";
</script>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script src="{{ url('/') }}/assets/front/js/jquery.geocomplete.min.js"></script>
<script>
$(function () {
var options = {
                types: ['(cities)'],
                componentRestrictions: {country: 'IN'},
                details: ".geo-details",
                detailsAttribute: "data-geo",
                map: "#business_location_map",
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


</script>


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
$(document ).ready(function (){
  $("#validation-form").validate({
    // Specify the validation rules
      rules: {
          building: "required",
          street: "required",
          landmark: "required",
          area: "required",
      },
    // Specify the validation error messages
      messages: {
          building: "Please enter building name.",
          street: "Please enter street.",
          landmark: "Please enter landmark.",
          area: "Please enter area.",

      },

  });
});
</script>


@stop