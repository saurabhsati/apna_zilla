  @extends('front.template.master')

  @section('main_section')

<style>
    .fixed-height {
      padding: 1px;
      max-height: 200px;
      overflow: auto;
      position:fixed;
    }
    .remo_fav span{
    color: #f9a820 !important;
  }
  .remo_fav i{
    color: #f9a820 !important;
  }
  </style>

  <?php
  // echo "<pre>";
  // print_r($arr_business);
  // exit();
  ?>
  <div class="gry_container">
 <div class="container">
         <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
               <ol class="breadcrumb">
                   <span>You are here :</span>
                  <li><a href="{{ url('/') }}">Home</a></li>
                  <li class="active">My Favorite</li>
                </ol>
             </div>
          </div>
     </div>
 <hr/>

 <div class="container">
  <div class="row">
 @include('front.user.my_business_left')
    <!-- location popup end -->
<div class="col-sm-12 col-md-9 col-lg-9">
      <div id="list_view">
    @if(isset($arr_fav) && sizeof($arr_fav)>0)
        @foreach($arr_fav['favourite_businesses'] as $restaurants)
      <div class="product_list_view" >
       <div class="row">
         <div class="col-sm-4 col-md-4 col-lg-4">
          <div class="product_img">
              <img style="height:100% !important;" src="{{ get_resized_image_path($restaurants['main_image'],$main_image_path,235,300) }}" alt="list product"/>
               @if($restaurants['is_verified']==1)
              <img class="first-cate-veri" src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>@endif
        </div>
        </div>

        <div class="col-sm-8 col-md-8 col-lg-8">
          <div class="product_details">
            <div class="product_title">
            <?php
             $slug_business=str_slug($restaurants['business_name']);
             $slug_area=str_slug($restaurants['area']);
             $business_area=$slug_business.'@'.$slug_area;
            ?>
              <a href="javascript:void(0);">
                @if($restaurants['is_verified']==1)
                            <img class="product-like-icon1" src="{{ url('/') }}/assets/front/images/verified-green.png" alt="write_review"/>
                            @endif
                {{ ucwords($restaurants['business_name'] )}}
              </a>
            </div>

            <div class="rating_star">

              <?php
              if(sizeof($restaurants['reviews']))
              {
                $tot_review=sizeof($restaurants['reviews']);

              }
              else
              {
                 $tot_review=0;
              }
              ?>
              <div class="resta-rating-block11">
              <?php for($i=0;$i<round($restaurants['avg_rating']);$i++){ ?>
              <i class="fa fa-star star-acti"></i>
              <?php }?>
              <?php for($i=0;$i<(5-round($restaurants['avg_rating']));$i++){ ?>
              <i class="fa fa-star"></i>
                <?php }?>
                </div>
               &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings
              <span class=""> Estd.in {{ $restaurants['establish_year'] }} </span></div>
              <div class="p_details"><i class="fa fa-phone"></i><span> {{ $restaurants['landline_number'] }} &nbsp; {{ $restaurants['mobile_number'] }}</span></div>
              <div class="p_details"><i class="fa fa-map-marker"></i>
                <span>{{ $restaurants['building'] }} &nbsp; {{ $restaurants['street'] }} <br/>
                {{ $restaurants['landmark'] }} &nbsp; {{ $restaurants['area'] }} &nbsp;{{ '-'.$restaurants['pincode'] }}<br/>

               @if(Session::has('distance'))
               Away From {{Session::get('distance')}} km distance
                @endif

                  </span>
                    @if(Session::has('user_mail'))
                     <span class="remo_fav" id="{{ 'show_fav_status_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);" class="active" onclick="add_to_favourite('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Remove favorite</span></a>
                        </span>
                    @else
                    <span>
                      <a href="javascript:void(0);" data-target="#login_poup" data-toggle="modal" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>
                      </span>
                    @endif
                </div>
              </div>
            </div>
          </div>
        </div>

            @endforeach

        @else
        <span>Sorry ,You Have Not Added Any Favorite Business !!</span>
      @endif
      </div>

</div>
<!--Product Lisiting End  -->


</div>
</div>
</div>

</div>

<script type="text/javascript">
  var site_url = "{{ url('/') }}";
  var csrf_token = "{{ csrf_token() }}";
   function add_to_favourite(ref)
        {
          var business_id = ref;
          var user_mail   = "{{ session::get('user_mail') }}";

          var data        = { business_id:business_id, user_mail:user_mail ,_token:csrf_token };
          jQuery.ajax({
            url:site_url+'/listing/add_to_favourite',
            type:'POST',
            dataType:'json',
            data: data,
            success:function(response){

              if(response.status == "favorites")
              {
                 jQuery('#show_fav_status_'+ref+'').addClass("remo_fav");
                var str = '<a href="javascript:void(0);"  onclick="add_to_favourite('+ref+')" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Remove favorite</span></a>';
                jQuery('#show_fav_status_'+ref+'').html(str);
              }

              if(response.status=="un_favorites")
              {
                 jQuery('#show_fav_status_'+ref+'').removeClass("remo_fav");
                 var str = '<a href="javascript:void(0);"  onclick="add_to_favourite('+ref+')" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span>Add To favorite</span></a>';
                jQuery('#show_fav_status_'+ref+'').html(str);
                 var current_url = $(location).attr('href');
                 window.location.href=current_url;
              }

            }
          });
        }
</script>
@endsection


