@extends('front.template.master')

@section('main_section')

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
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Building:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="building"
                                class="input_acct"
                                placeholder="Enter Building's Name"
                                data-rule-required="true"
                                required="" aria-describedby="basic-addon1"
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
                         <input type="text" name="street"
                                class="input_acct"
                                placeholder="Enter Street's Name"
                                value="{{ isset($business['street'])?$business['street']:'' }}"
                                required="" aria-describedby="basic-addon1"/>

                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Landmark:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="landmark"
                                class="input_acct"
                                placeholder="Enter Landmark's Name"
                                value="{{ isset($business['landmark'])?$business['landmark']:'' }}"
                                required="" aria-describedby="basic-addon1"/>
                        <div class="error_msg">{{ $errors->first('landmark') }} </div>
                        </div>
                         </div>
                    </div>

                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Area:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text" name="area"
                                class="input_acct"
                                placeholder="Enter Area's Name"
                                onchange="setAddress()"
                                value="{{ isset($business['area'])?$business['area']:'' }}"
                                required="" aria-describedby="basic-addon1" />
                        </div>
                         </div>
                    </div>


          <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Country :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                  <select class="input_acct"  id="country" name="country" required="" aria-describedby="basic-addon1" >
                    @if(isset($arr_country) && sizeof($arr_country)>0)
                         @foreach($arr_country as $country)
                      <option value="{{ isset($country['id'])?$country['id']:'' }}" {{ $business['country']==$country['id']?'selected="selected"':'' }}>{{ isset($country['country_name'])?$country['country_name']:'' }}
                      </option>
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
                <select class="input_acct" name="state" id="state" required="" aria-describedby="basic-addon1">
                   @if(isset($arr_state) && sizeof($arr_state)>0)
                   @foreach($arr_state as $state)
                    <option value="{{ isset($state['id'])?$state['id']:'' }}" {{ $business['state']==$state['id']?'selected="selected"':'' }}>{{ isset($state['state_title'])?$state['state_title']:'' }}
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
               <select class="input_acct"  name="city" id="city" required="" aria-describedby="basic-addon1">
                 @if(isset($arr_city) && sizeof($arr_city)>0)
                   @foreach($arr_city as $city)
                <option value="{{ isset($city['id'])?$city['id']:'' }}" {{ $business['city']==$city['id']?'selected="selected"':'' }}>{{ isset($city['city_title'])?$city['city_title']:'' }}
                </option>
                @endforeach
                @endif
                 </select>
                </div>
              </div>
            </div>

            <div class="user_box_sub">
              <div class="row">
                <div class="col-lg-3  label-text">Zipcode :</div>
                  <div class="col-sm-9 col-md-9 col-lg-9 m_l">
                    <select class="input_acct"  id="zipcode"  name="zipcode" required="" aria-describedby="basic-addon1">
                       <option value="{{ isset($arr_place[0]['id'])?$arr_place[0]['id']:'' }}" >{{ isset($arr_place[0]['postal_code'])?$arr_place[0]['postal_code']:'' }}
                </option>
                    </select>
                    <div class="error_msg">{{ $errors->first('zipcode') }} </div>
                </div>
              </div>
            </div>




             <div class="user_box_sub">
            <div class="row">
             <div class="col-lg-3  label-text">Map :</div>
              <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                    <input type="hidden" name="lat" value="{{ isset($business['lat'])?$business['lat']:'' }}" id="lat" />
                    <input type="hidden" name="lng" value="{{ isset($business['lng'])?$business['lng']:'' }}" id="lng"/>
                     <div id="location_map" style="height:400px"></div>
                    <label>Note: Click On the Map to Pick Nearby Custom Location </label>
                </div>
              </div>
            </div>




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
            @endforeach
@endif
          </div>
         </div>
       </div>
      </div>
<script type="text/javascript">

    var  map;
    var ref_input_lat = $('#lat');
    var ref_input_lng = $('#lng');

    function setMapLocation(address)
    {

        geocoder.geocode({'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {

                map.setCenter(results[0].geometry.location);

                $(ref_input_lat).val(results[0].geometry.location.lat().toFixed(6));
                $(ref_input_lng).val(results[0].geometry.location.lng().toFixed(6));

                var latlong = "(" + results[0].geometry.location.lat().toFixed(6) + ", " +
                        +results[0].geometry.location.lng().toFixed(6)+ ")";



                marker.setPosition(results[0].geometry.location);
                map.setZoom(16);
                infowindow.setContent(results[0].formatted_address);

                if (infowindow) {
                    infowindow.close();
                }

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map, marker);
                });

                infowindow.open(map, marker);

            } else {
                alert("Lat and long cannot be found.");
            }
        });
    }
    function initializeMap()
    {
         var latlng = new google.maps.LatLng($(ref_input_lat).val(), $(ref_input_lng).val());
         var myOptions = {
             zoom: 18,
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
             content: "("+$(ref_input_lat).val()+", "+$(ref_input_lng).val()+")"
         });

         google.maps.event.addListener(map, 'click', function(event) {
             marker.setPosition(event.latLng);

             var yeri = event.latLng;

             var latlongi = "(" + yeri.lat().toFixed(6) + ", " + yeri.lng().toFixed(6) + ")";

             infowindow.setContent(latlongi);

             $(ref_input_lat).val(yeri.lat().toFixed(6));
             $(ref_input_lng).val(yeri.lng().toFixed(6));

         });

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

 /*   $('#street').onchange(function (){
      setAddress()
    });*/

</script>
<script type="text/javascript">

    var site_url = "{{url('/')}}";
</script>

<script type="text/javascript">
jQuery(document).ready(function () {
 token   = jQuery("input[name=_token]").val();
  jQuery('#country').on('change', function() {


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



});




</script>


@stop