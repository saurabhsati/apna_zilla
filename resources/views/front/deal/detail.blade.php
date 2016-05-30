@extends('front.template.master')

@section('main_section')
 @include('front.template._search_top_nav')


 <style type="text/css">
 
/* Related deals*/
.map {
    border: 1px solid #ddd;
    margin-top: 5px;
    padding: 3px;
}
/**/
 </style>

<div class="gry_container" style="padding: 7px 0 16px;">
 @include('front.deal.deal_top_bar')

<div class="container">
 <div class="row">
  <div class="col-sm-12 col-md-12 col-lg-12">
   <ol class="breadcrumb">
     <span>You are here :</span>
     <li><a href="{{ url('/') }}">Home</a></li>
      <?php if(Request::segment(1))
              {
                 $city=urldecode(Request::segment(1));
              }
              else
              {
                  $city="Mumbai";
              }?>
     @if(sizeof($deals_info)>0)
      @foreach($deals_info as $deal)
    
     <li><a href="{{ url('/') }}/{{$city}}/deals">Deals</a></li>
     <li class="active"><?php echo substr($deal['name'],0,120).'..';?></li>
     @endforeach
     @endif
   </ol>
 </div>
</div>
</div>
<hr/>

<div class="container">
  <div class="row">

 @if(sizeof($deals_info)>0)
      @foreach($deals_info as $deal)  
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="p_detail_view">
        <?php 
            $arr_departture_point = json_decode($deal['json_location_point'],TRUE);
             $arr_tmp_departure_point  = [];
        ?>
       <div class="col-sm-12 col-md-12 col-lg-12"><h3>{{ucfirst($deal['name'])}} {{ ',' }} @if(sizeof($arr_departture_point)>0){{ sizeof($arr_departture_point) }} @else {{ 0 }} @endif Locations </h3>
             <div class="title-onds">{{ucfirst($deal['title'])}}</div>
             </div>
             <div class="clearfix"></div>
          
            <div class="product_detail_bannergdd">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                  @if(isset($deal['deals_slider_images']) && sizeof($deal['deals_slider_images'])>0)
                   @foreach($deal['deals_slider_images'] as $key => $slider)
                  <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key;?>" class="<?php if($key==0){echo 'active';} ?>"></li>
                   @endforeach
                  @endif
                 {{--  <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2"></li> --}}
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                 @if(isset($deal['deals_slider_images']) && sizeof($deal['deals_slider_images'])>0)
                   @foreach($deal['deals_slider_images'] as $key => $slider)
                    <div class="item <?php if($key==0){echo 'active';} ?>">
                      <img src="{{get_resized_image_path($slider['image_name'],$deal_slider_upload_img_path,500,1140)}}" alt="...">
                    </div>
                  
                   @endforeach
                  @endif
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
                          
            </div>
            
              <div class="cont-draetview">
                  <div class="row">
                      <div class="col-sm-12 col-md-7 col-lg-7">
                       </div>
                         <div class="col-sm-12 col-md-5 col-lg-5">
                            <div class="matnshare">
                             <div class="sharetsdl">Share This Deal</div>
                         
                         <div class="shre-dls">
                           
                             <ul>
                                 <li class="fb-icv"><a href="https://www.facebook.com/sharer.php?<?php echo URL::current(); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                 <li class="emil-icv"><a href="https://plus.google.com/share?url=<?php echo URL::current(); ?>"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                                 <li class="emil-icv"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo URL::current(); ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                 <li class="twirt-icv"><a href="http://twitter.com/share?url=<?php echo URL::current(); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                             </ul>
                            
                         </div>
                          </div>
                         </div>
                         <div class="bordersk"></div>
                         <div class="col-sm-12 col-md-12 col-lg-12">
                          @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)
                              
                         <h4>What you get</h4>
                          <div class="bor_hefgsd"></div>
                         <div class="detls-pgj">
                             <ul>
                                @foreach($deal['offers_info'] as $offers)
                                 <li>
                                 <span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
                                {{$offers['title']}}
                                  </li>
                                @endforeach
                             </ul>
                        </div>
                        @endif
                       @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)
                         <div class="bordersk"></div>
                          <h4>Validity</h4>
                          <div class="bor_hefgsd"></div>
                           @foreach($deal['offers_info'] as $offers)

                             <div class="valid-txts">
                              <div class="tickt-esslw">{{$offers['title']}}</div> 
                                <div class="indners"> <span class="validsff">Valid from</span> <span>:</span> <span class="clr-dtald">{{ date('d-M-Y',strtotime($offers['valid_from'])) }}</span></div>
                                <div class="indners"> <span class="validsff">Valid until</span> <span>:</span> <span class="clr-dtald">{{ date('d-M-Y',strtotime($offers['valid_until'])) }}</span></div>
                                 {{-- <div class="tickt-esslw">Valid 7 days a week Weekdays: 10:00AM to 8:00PM Weekends: 9:30AM to 9:00PM </div> --}}
                             </div>

                              @endforeach
                           <div class="clearfix"></div>
                          <div class="bordersk"></div>
                          @endif

                          @if(isset($deal['things_to_remember']) && !empty($deal['things_to_remember']))
                          <h4>Things to Remember</h4>
                           <div class="bor_hefgsd"></div>
                          <div class="detls-pgj">
                             <ul>
                            {{strip_tags($deal['things_to_remember'])}}
                              </ul> 
                             
                         </div>
                          @endif
                      </div>
                        
                        
                         </div>
               </div>
             <div class="bordersk"></div>
            <div class=" col-xs-12 col-sm-12 col-md-12"><h4>Redemption locations</h4> <div class="bor_hefgsd"></div></div>
            
            <div class="clearfix"></div>
            @if(isset($deal['json_location_point']) && !empty($deal['json_location_point']))
            <div class=" col-xs-12 col-sm-12 col-md-12">
            <div class="map" id="map_for_deaprture_point" style="height:400px"></div>
                                  <input type="hidden" name="json_location_point" value='{!! $deal['json_location_point'] !!}' /> 
                                  <br/>
                                    <?php 
                                        $arr_departture_point = json_decode($deal['json_location_point'],TRUE);
                                        $arr_tmp_departure_point  = [];
                                    ?>

                                    @if(sizeof($arr_departture_point)>0)
                                        @foreach($arr_departture_point as $key =>$point)
                                          <?php 
                                          if(isset($point['place']))
                                          {
                                              $arr_tmp_departure_point[] = "markers=color:red|label:".$point['place']."|".$point['lat'].",".$point['lat']; 
                                          }
                                            
                                          ?>
                                        @endforeach
                                    @endif

                                    <iframe src="https://maps.googleapis.com/maps/api/staticmap?zoom=6&size=523x400&{{ implode(",", $arr_tmp_departure_point) }}&key=AIzaSyCccvQtzVx4aAt05YnfzJDSWEzPiVnNVsY" class="static_departure_point_map" style="display: none;"/></iframe>
                                     <div class="box-gare">
                
                                        <ul>
                                        @if(sizeof($arr_departture_point)>0)
                                           @foreach($arr_departture_point as $key =>$point)
                                           <li class="active-cs"><span><i class="fa fa-map-marker" aria-hidden="true"></i></span>  {{ isset($point['place'])?$point['place']:'NA'}} <a href="javascript:void(0)" data-lat='{{ $point['lat'] }}' data-lng='{{ $point['lng'] }}' onclick="pointInMap(this)" style="padding-left: 5px;">See On Map</a></li>
                                           @endforeach
                                        @endif
                                        </ul>
                                    </div>
                    </div>
                     @endif 



             @if(isset($deal['how_to_use']) && !empty($deal['how_to_use']))
               <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="bordersk"></div>
                          <h4>How to use the offer</h4>
                           <div class="bor_hefgsd"></div>
                          <div class="detls-pgj">
                             <ul>
                             {{strip_tags($deal['how_to_use'])}}
                              </ul>
                         </div>
                   
               </div>
                <div class="clearfix"></div>
                 @endif
            @if(isset($deal['about']) && !empty($deal['about']))
               <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="bordersk"></div>
                          <h4>About</h4>
                           <div class="bor_hefgsd"></div>
                          <div class="detls-pgj">
                             <ul>
                             {{strip_tags($deal['about'])}}
                              </ul>
                         </div>
                   
               </div>
                <div class="clearfix"></div>
           @endif
            @if(isset($deal['facilities']) && !empty($deal['facilities']))
                <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="bordersk"></div>
                          <h4>Facilities</h4>
                           <div class="bor_hefgsd"></div>
                          <div class="detls-pgj">
                             <ul>
                             {{strip_tags($deal['facilities'])}}
                               </ul>
                         </div>
                   
               </div>
                <div class="clearfix"></div>
            @endif
            @if(isset($deal['cancellation_policy']) && !empty($deal['cancellation_policy']))
                
                <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="bordersk"></div>
                          <h4>Cancellation policy</h4>
                           <div class="bor_hefgsd"></div>
                          <div class="detls-pgj">
                             <ul>
                             {{strip_tags($deal['cancellation_policy'])}}
                               </ul>
                         </div>
                   
               </div>
                <div class="clearfix"></div>
            @endif
            @if(isset($deal['description']) && !empty($deal['description']))
              
                <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="bordersk"></div>
                          <h4>Description</h4>
                           <div class="bor_hefgsd"></div>
                          <div class="detls-pgj">
                             <ul>
                             {{strip_tags($deal['description'])}}
                               </ul>
                         </div>
                   
               </div>
                <div class="clearfix"></div>
              @endif      
           <div class=" col-xs-12 col-sm-12 col-md-12">
           <div class="title_main mrtopls">Related Listing</div> <div class="bor_hefgsd"></div></div>
                @if(sizeof($arr_related_deals_info)>0 && isset($arr_related_deals_info))
                @foreach($arr_related_deals_info as $rel_deals)
                <?php $arr_departture_point = json_decode($rel_deals['json_location_point'],TRUE);
                 $arr_tmp_departure_point  = []; ?>
               <div class=" col-xs-12 col-sm-6 col-md-4">
                <a  href="{{url('/')}}/{{$city}}/deals/{{urlencode(str_replace(' ','-',$rel_deals['name']))}}/{{base64_encode($rel_deals['id'])}}">
                  <div class="product_info">
                      <div class="p_images">
                      <img src="{{get_resized_image_path($rel_deals['deal_image'],$deal_image_path,200,250) }}" alt="product img"/>
                      </div>
                      <h4>{{substr($rel_deals['title'],0,25).'...'}} </h4>
                      <div class="loction"> @if(sizeof($arr_departture_point)>0){{ sizeof($arr_departture_point) }} @else {{ 0 }} @endif Locations</div> 
                      <div class="cont-ds"> {{strip_tags(substr($rel_deals['description'],0,30))}}</div>
                      <div class="bordersk"></div>
                       <div class="valuesd"> <span> <i class="fa fa-inr"></i></span>    {{$rel_deals['price']}}</div>
                       <div class="valuesdfd"> <span><i aria-hidden="true" class="fa fa-user"></i></span> <span>{{$rel_deals['redeem_count']}} Boughts </span> </div>
                       <div class="valuesdf-right"><span> <i class="fa fa-inr"></i> <?php echo number_format(($rel_deals['price']-(($rel_deals['price'])*($rel_deals['discount_price']/100))),2);?></span></div>
                       <div class="clearfix"></div>
                  </div></a>
                </div>
              @endforeach
              @else
                  <span class="col-sm-3 col-md-3 col-lg-12">No Related Deals Available.</span>
              @endif
             <div class="clearfix"></div>
            </div>  
                    
                      
             </div>
              
             <div class="col-sm-12 col-md-3 col-lg-3 menus">
              <!-- Categories Start -->
                <div class="categories_sect sidebar-nav">
                 <div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/select-ur-offer.png" alt="Select offers"/>Select offers<span class="spe_mobile1"><a href="#"></a></span></div>
                 <div class="bor_head">&nbsp;</div>
                  <div class="insta_gram content-kgfd foreach_ul" id="insta_gram">
                 @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)
                    @foreach($deal['offers_info'] as $key =>$offers)
                        <div class="details-lst-vw sml-padng loop">
                          <div class="p-textd"> {{$offers['title']}}</div>
                             <div class="row">
                                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="sml-grasy"> Select Qty</div>
                                 </div>
                                 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                  <div class="sml-grasy-right"><i class="fa fa-inr"></i> {{$offers['main_price']}}</div>
                                 </div>
                                 <div class="col-xs-6 col-sm-6 col-md-12 col-lg-6">
                                 <div class="qty_frm li">
                                   <div class="quantity-wrapperds pull-left">
                                   <input type="hidden" class="sell_price" value="{{$offers['discounted_price']}}">
                                   <input type="hidden" name="offer_hidden" id="offer_hidden" data-dealid="{{base64_encode($deal['id'])}}"  data-dotdid="{{$offers['id']}}" data-original="{{$offers['discounted_price']}}" data-minimumpurchasequantity="0" data-maxcustomercap="{{$offers['limit']}}">
                                   <input type="hidden"  class="limit" name="limit" id="limit" value="{{$offers['limit']}}" />
                                   <br/>

                                   <div class=" add-up add-actionds add-actionds fa fa-minus dec button" style="  cursor: pointer;" ></div>
                                    {{-- <input type="text" class="quantitydf1" name="qty" id="1" value="0"  /> --}}
                                    <span type="text" class="quantitydf1" name="qty" id="1"  style="align:center;" />0</span>
                                    <div class=" add-down add-actionds add-actionds fa fa-plus inc button" style="  cursor: pointer;" ></div>
                                    </div>

                                 
                                 <input type="hidden" name="product_id">            
                                 </div>
                                 </div>
                                 <div class="col-xs-6 col-sm-6 col-md-12 col-lg-6">
                                      <div class="sml-grasy-right-g"><i class="fa fa-inr "></i> {{$offers['discounted_price']}}</div>

                                 </div>
                             </div>
                         </div>
                         <div class="clearfix"></div>
                        @endforeach
                        @else
                        <div class=" sml-padng ">
                          <h4> Sorry ,No Offers Present !! </h4>
                       </div>
                        @endif
              </div>
               @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)
               <div class="tolt-foles">
                <input type="hidden" id="amount" name="amount" value="">
                <div class="sml-grasy-right-black-lft">   Total :</div>
                   <div class="sml-grasy-right-black pull-right"><i class="fa fa-inr"></i><span id="total_price"> 0</span></div>
               </div>
               @endif
               <div class="buy-n-btnds">
               <span class="select-offer-notification noshow" style="display:none;color:#e6ab2a;font:14px;" id="offerSelectionError"><h4>Please select at least one offer</h4></span>
                   @if(isset($deal['offers_info']) && sizeof($deal['offers_info'])>0)

                 
                  <a type="button" class=" btn_buy btn btn-post btn-post-nods" href="javascript:void(0);">Buy Now</a>
                   
                   <!--  <a type="button" href="javascript:void(0);" data-target="#login_poup" data-toggle="modal" class="btn btn-post center-b " href="javascript:void(0);">Buy Now</a> -->
                   
                   
                 @endif
               <div class="clearfix"></div> 
               </div>
               
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
                    
                    <div class="categories_sect sidebar-nav">
                        
                    <?php
                     if($deal['end_day']!='')
                              {

                                $end_date = new \Carbon($deal['end_day']);
                                  $now = Carbon::now();
                                  $difference = ($end_date->diff($now)->days < 1)
                                      ? 'today'
                                      : $end_date->diffForHumans($now);
                                     
                                  if (strpos($difference, 'after') !== false || strpos($difference, 'today') !== false) 
                                  { ?>
                                   <div class="limitd-tmf"> Limited For <?php echo str_replace('after','', $difference).' Only'; ?></div> 
                                   <?php 
                                  }
                              }
                         ?>
                        <div class="limitd-btr"><span><i class="fa fa-user" aria-hidden="true"></i>
                            </span> <span>{{$deal['redeem_count']}} Boughts</span></div>
                        
                       <div class="buy-n-btnds">
                        <form method="post" action="{{url('/')}}/{{$city}}/bulk_booking_form" target="_blank" id="bulk-order-form">
                          {{ csrf_field() }}
                          <input type="hidden" name="vertical" value="local">
                          <input type="hidden" name="dealTitle" value="{{$deal['title']}}">
                          <input type="hidden" name="deal_id" value="{{$deal['id']}}">
                          <input type="hidden" name="dealUrl" id="dealUrlForBulk" value="{{url('/')}}/{{$city}}/deals/{{urlencode(str_replace(' ','-',$deal['name']))}}/{{base64_encode($deal['id'])}}">
                          <input type="hidden" name="divisionId" id="deal-url" value="{{$city}}">
                         
                           <a type="button" class="btn btn-post center-b " href="javascript:void(0);" onclick="javascript:document.getElementById('bulk-order-form').submit()">Buying in Bulk?</a>
                          </form>
                      <div class="clearfix"></div> 
               </div>
                    </div>
                    <div class="clearfix"></div> 
                 
                 
                 
            </div>
            @endforeach
            @endif

</div>
</div>
</div>
</div>
<script type="text/javascript">
  var site_url = "{{ url('/') }}";
	$(function() {


		incrementVar = 0;
$('.inc.button').click(function(){
$("#offerSelectionError").css('display','none');
        var $this = $(this),

        $input = $this.prev('span'),

        $parent = $input.closest('div');
       // alert($parent.html());
        var limit=$(".limit").val();
        if(limit >  parseInt($input.html(), 10))
        {

         newValue = parseInt($input.html(), 10)+1;

		    $parent.find('.inc').addClass('a'+newValue);

		    $input.html(newValue);

		    incrementVar += newValue;

		    $offerprice=$parent.find('.sell_price').val();

		    var old_total = $('#total_price').html();
        
		    var finaltotal=Math.floor($offerprice)+Math.floor(old_total);
         $('#total_price').html(finaltotal);
		     $("#amount").attr('value',finaltotal);


         var offer_id=$parent.find('#offer_hidden').attr('data-dotdid');
         var offers_quantity=$parent.find('#offer_hidden').attr('data-minimumpurchasequantity',newValue);
         var deal_id=$parent.find('#offer_hidden').attr('data-dealid');
        }
	   
	     //alert($total);

});
$('.dec.button').click(function(){
        var $this = $(this),

        $input = $this.next('span');

        $parent = $input.closest('div');

        if($input.html() != '0')
        {
	        newValue = parseInt($input.html(), 10)-1;

		    $parent.find('.inc').addClass('a'+newValue);

		    $input.html(newValue);

		    incrementVar += newValue;

		    $offerprice=$parent.find('.sell_price').val();

		    var old_total = $('#total_price').html();

		    $finaltotal=parseInt(old_total, 10)-parseInt($offerprice, 10);
		   
		    $('#total_price').html($finaltotal);
		    $("#amount").attr('value',$finaltotal);
         var offer_id=$parent.find('#offer_hidden').attr('data-dotdid');
         var offers_quantity=$parent.find('#offer_hidden').attr('data-minimumpurchasequantity',newValue);
         var offers_quantity=$parent.find('#offer_hidden').attr('data-minimumpurchasequantity',newValue);
        }
	    
});
$('.btn_buy').click(function()
{
	var amount=$("#amount").val();

	if(amount=='')
	{
		$("#offerSelectionError").css('display','block');
		$("#offerSelectionError").html("Please select at least one offer");
		return false;
	}
	else
	{
   
    var string='offerid=';
     
		$(".foreach_ul").find('.loop').each( function(i){
       var current = $(this);
       current.find("#offer_hidden").attr('data-dotdid');
       var offer_id=current.find("#offer_hidden").attr('data-dotdid');
       var offer_selected_quantity=current.find("#offer_hidden").attr('data-minimumpurchasequantity');
       if(offer_selected_quantity!='0')
       {
         if (string.indexOf('_') == -1) 
         {
            string+=offer_id+'_'+offer_selected_quantity;
         }
         else
         {
            string+='-'+offer_id+'_'+offer_selected_quantity;
         }
       }
       

    });


   var deal_id=$('#offer_hidden').attr('data-dealid');
   if(deal_id!='')
   {
     string+='/'+deal_id;
   }
   var get_url=site_url+'/order/'+string;
  //alert(get_url);
  //return false;
  window.location.href = get_url;
    //alert(string);
  }
});

		

	});



/* Departure Point Map */
  function loadScript() 
  {
      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCccvQtzVx4aAt05YnfzJDSWEzPiVnNVsY&libraries=places&callback=initializeMap';
      document.body.appendChild(script);
  }

  window.onload = loadScript;

  function initializeMap() 
  {
      var latlng = new google.maps.LatLng(20.5937, 78.9629);
      var myOptions = {
          center:latlng,
          zoom:4,
          panControl: true,
          scrollwheel: true,
          scaleControl: true,
          overviewMapControl: true,
          disableDoubleClickZoom: false,
          overviewMapControlOptions: { opened: true },
          mapTypeId: google.maps.MapTypeId.HYBRID
      };

      departure_point_map = new google.maps.Map(document.getElementById("map_for_deaprture_point"),
              myOptions);
      geocoder = new google.maps.Geocoder();
      departure_point_map.streetViewControl = false;

      glob_info_window = new google.maps.InfoWindow({
          content: "(1.10, 1.10)"
      });


      

      if($('input[name="json_location_point"]').val().length>0)
      {
        existing_lat_lng = JSON.parse($('input[name="json_location_point"]').val());
        initExistingLatLng();
      }
      else
      {
        current_marker = createMarker(departure_point_map,latlng);

        google.maps.event.addListener(departure_point_map, 'click', function(event) 
        {
            current_marker.setPosition(event.latLng);
            var yeri = event.latLng;
            var latlongi = "(" + yeri.lat().toFixed(6) + ", " +yeri.lng().toFixed(6) + ")";
            glob_info_window.setContent(latlongi);

            // document.getElementById('lat').value = yeri.lat().toFixed(6);
            // document.getElementById('lon').value = yeri.lng().toFixed(6);
          
        });
      }
  }

  function initExistingLatLng()
  {
    var last_index = existing_lat_lng.length-1;

    $.each(existing_lat_lng,function(index,location)
    {
      var latlng = new google.maps.LatLng(location.lat, location.lng);

      current_marker = createMarker(departure_point_map,latlng);

      current_marker.departure_time = location.departure_time;
      current_marker.place = location.place;

      glob_arr_marker.push(current_marker);

      if(index==last_index)
      {
        departure_point_map.setCenter(latlng);
        departure_point_map.setZoom(17);
      }
    });
  }

  function createMarker(departure_point_map,position)
  {
    var marker = new google.maps.Marker({
          position: position,
          map: departure_point_map
      });

    marker.addListener('click', function() 
    {
      current_marker = this;

    });

    marker.addListener('mouseover', function() 
    {
      current_marker = this;
      if(markerExists(current_marker.position)!=false)
      {
        data = getMarkerData(current_marker.position);

        html = "<div><input type='text' name='place' value='"+data.place+"' placeholder='{{ trans('lang.placeholder_departure_place') }}' class='form-control' disabled/> <br>";

        glob_info_window.setContent(html);
        glob_info_window.open(departure_point_map,this);  

      }
      
    });

    return marker;
  }

  function getGlobMarkerIndexByLatLng(lat,lng)
  {
    var glob_marker_index = false;
    $.each(glob_arr_marker,function(index,marker)
    {
        tmp_lat = this.position.lat();
        tmp_lng = this.position.lng();

        if(tmp_lat == lat && tmp_lng == lng)
        {
          glob_marker_index = index
          return false;
        }
    });
    return glob_marker_index;
  }

  function markerExists(position)
  {
    marker_index = getGlobMarkerIndexByLatLng(position.lat(),position.lng());
    return (marker_index===false)?false:true;
  }

  function getMarkerData(position)
  {
    var return_data = false;

    marker_index = getGlobMarkerIndexByLatLng(position.lat(),position.lng());
    if(marker_index!==false)
    {
      return_data = glob_arr_marker[marker_index];
    }
    return return_data;
  }

  
  //price calendar window open
  function price_calendar(tour_id,package_id)
  {
    var calendar_url=url+'/calendar/'+tour_id+'/'+package_id;
    window.open(calendar_url,'voucherwindow','scrollbars=1,resizable=1,width=910,height=800');
  }


  function pointInMap(ref)
  {
    var lat,lng;
    lat = $(ref).attr("data-lat");
    lng = $(ref).attr("data-lng");

    var latlng = new google.maps.LatLng(lat,lng);
    departure_point_map.setCenter(latlng);
    departure_point_map.setZoom(18);
    current_marker = createMarker(departure_point_map,latlng);
  }


</script>
@endsection
