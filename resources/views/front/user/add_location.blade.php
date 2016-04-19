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
                     <div class="user_box_sub">
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
                    </div>

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


          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Country :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                  <select class="input_acct"  id="country" name="country" data-rule-required="true" >
                    <option value="">Select Country</option>
                    @if (isset($arr_country)&& (count($arr_country) > 0))
                      @foreach($arr_country as $country)
                          <option value="{{ $country['id'] }}">{{ $country['country_name'] }}</option>
                      @endforeach
                    @endif
                  </select>
                   <div class="error_msg">{{ $errors->first('country') }} </div>
                </div>
              </div>
            </div>

          <div class="user_box_sub">
           <div class="row">
            <div class="col-lg-3  label-text">State :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l" >
                <select class="input_acct" name="state" id="state" data-rule-required="true">
                  <option id="show_state" value="" >--Select--</option>
                </select>
              </div>
            </div>
          </div>


          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">City :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
               <select class="input_acct"  name="city" id="city" data-rule-required="true" onchange="setAddress()">
                  <option value="" >--Select--</option>
                 </select>
                </div>
              </div>
            </div>

            <div class="user_box_sub">
              <div class="row">
                <div class="col-lg-3  label-text">Zipcode :</div>
                  <div class="col-sm-9 col-md-9 col-lg-9 m_l">
                    <select class="input_acct"  id="zipcode"  name="zipcode" data-rule-required="true" >
                      <option value="">--Select--</option>
                    </select>
                    <div class="error_msg">{{ $errors->first('zipcode') }} </div>
                </div>
              </div>
            </div>

            {{-- @if (isset($arr_zipcode)&& (count($arr_zipcode) > 0))
                            @foreach($arr_zipcode as $code)
                              <option value="{{ $code['id'] }}">{{ $code['zipcode'] }}</option>
                            @endforeach
                          @endif --}}


             <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Map :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                    <input type="hidden" name="lat" value="" id="lat" />
                    <input type="hidden" name="lng" value="" id="lng"/>
                     <div id="location_map" style="height:400px"></div>
                    <label>Note: Click On the Map to Pick Nearby Custom Location </label>
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

    var  map;
    var ref_input_lat = $('#lat');
    var ref_input_lng = $('#lng');

    function setMapLocation(addr)
    {
      console.log(addr);
        geocoder.geocode({'address': addr}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {

                map.setCenter(results[0].geometry.location);

                $(ref_input_lat).val(results[0].geometry.location.lat().toFixed(6));
                $(ref_input_lng).val(results[0].geometry.location.lng().toFixed(6));

                var latlong = "(" + results[0].geometry.location.lat().toFixed(6) + ", " +
                        +results[0].geometry.location.lng().toFixed(6)+ ")";
                console.log(latlong);


                marker.setPosition(results[0].geometry.location);
                map.setZoom(16);
                infowindow.setContent(results[0].formatted_address);

                if (infowindow) {
                    infowindow.close();
                }

               /* google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });*/

                infowindow.open(map, marker);

            } else {
                alert("Lat and long cannot be found.");
            }
        });
    }
    function initializeMap()
    {
         var latlng = new google.maps.LatLng(1.10, 1.10);
         var myOptions = {
             zoom: 5,
             center: latlng,
             panControl: true,
             scrollwheel: true,
             scaleControl: true,
             overviewMapControl: true,
             disableDoubleClickZoom: false,
             overviewMapControlOptions: {
                 opened: true
             },
             mapTypeId: google.maps.MapTypeId.HYBRID
         };
         map = new google.maps.Map(document.getElementById("location_map"),
             myOptions);
         geocoder = new google.maps.Geocoder();
         marker = new google.maps.Marker({
             position: latlng,
             map: map
         });

         map.streetViewControl = false;
         infowindow = new google.maps.InfoWindow({
             content: "(1.10, 1.10)"
         });

      /*   google.maps.event.addListener(map, 'click', function(event) {
             marker.setPosition(event.latLng);

             var yeri = event.latLng;

             var latlongi = "(" + yeri.lat().toFixed(6) + ", " + yeri.lng().toFixed(6) + ")";

             infowindow.setContent(latlongi);

             $(ref_input_lat).val(yeri.lat().toFixed(6));
             $(ref_input_lng).val(yeri.lng().toFixed(6));

         });*/

         google.maps.event.addListener(map, 'mousewheel', function(event, delta) {

             console.log(delta);
         });


     }

    function loadScript()
    {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&' +
                    'callback=initializeMap';
            document.body.appendChild(script);
    }

    window.onload = loadScript;

    /* Autcomplete Code */

    function setMarkerTo(lat,lon,place)
    {
        var location = new google.maps.LatLng(lat,lng)
        map.setCenter(location);
        $(ref_input_lat).val = lat;
        $(ref_input_lng).val = lng;
        marker.setPosition(location);
        map.setZoom(16);
    }

    /*function setAddress(ref)
    {

        var addr = $("#city option:selected").text();

        // var addr = $(ref).text();
        alert(addr);
        setMapLocation(addr);
    }*/

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
jQuery(document).ready(function () {
 token   = jQuery("input[name=_token]").val();
  jQuery('#country').on('change', function() {

/*    var addr = $("#city option:selected").text();
    setMapLocation(addr);
*/
    var country_id = jQuery(this).val();
    jQuery.ajax({
       url      : site_url+"/front_users/get_state?_token="+token,
       method   : 'POST',
       dataType : 'json',
       data     : { country_id:country_id },
       success: function(responce){

          if(responce.length > 0)
          {
            var state ;
            for (var i = 0; i < responce.length; i++)
            {
              state  += '<option value="'+responce[i].id+'" >'+responce[i].state_title+'</option>';
            }
          }else{
              var state  = '<option value="" >State</option>';
          }

          $('#state').html("<option  value='' >--Select--</option>"+state);

       }
    });
  });

    jQuery('#state').on('change', function() {
    var state_id = jQuery(this).val();
    jQuery.ajax({
       url      : site_url+"/front_users/get_city?_token="+token,
       method   : 'POST',
       dataType : 'json',
       data     : { state_id:state_id },
       success: function(responce){
        console.log(responce);
          if(responce.length > 0)
          {
            var city ;
            for (var i = 0; i < responce.length; i++)
            {
              city  += '<option value="'+responce[i].city_id+'" >'+responce[i].city_title+'</option>';
            }
          }else{
              var city  = '<option value="" >--Select--</option>';
          }

          $('#city').html("<option  value='' >--Select--</option>"+city);

       }
    });
  });


   jQuery('#city').on('change', function() {

    var city_id = jQuery(this).val();
    jQuery.ajax({
       url      : site_url+"/front_users/get_zip?_token="+token,
       method   : 'POST',
       dataType : 'json',
       data     : { city_id:city_id },
       success: function(responce){
        console.log(responce);
          if(responce.length > 0)
          {
            var zipcode ;
            for (var i = 0; i < responce.length; i++)
            {
              zipcode  += '<option value="'+responce[i].zip_id+'" >'+responce[i].postal_code+'</option>';
            }
          }else{
              var zipcode  = '<option value="" >--Select--</option>';
          }

          $('#zipcode').html("<option  value='' >--Select--</option>"+zipcode);

       }
    });
  });

// test
 /* jQuery('#city').on('change',function() {
    var addr = jQuery('#city').text();
    setMapLocation(addr);
  });*/

});

 function setAddress()
    {
         var street = $('#street').val();
         var area = $('#area').val();
         var city = $('#city option:selected').text();
         var state = $('#state option:selected').text();
         var country = $('#country option:selected').text();

        var addr = street+", "+area+", "+city+", "+state+", "+country;

        setMapLocation(addr);
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