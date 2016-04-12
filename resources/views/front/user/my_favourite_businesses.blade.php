  @extends('front.template.master')

  @section('main_section')

<style>
    .fixed-height {
      padding: 1px;
      max-height: 200px;
      overflow: auto;
      position:fixed;
    }
  </style>

  <?php
  // echo "<pre>";
  // print_r($arr_business);
  // exit();
  ?>
  <div class="gry_container">

 <hr/>

 <div class="container">
  <div class="row">

    <!-- location popup end -->

      <div id="list_view">
    @if(isset($arr_fav) && sizeof($arr_fav)>0)
      @if(sizeof($arr_fav['favourite_businesses'])>0)
        @foreach($arr_fav['favourite_businesses'] as $restaurants)
      <div class="product_list_view" >
       <div class="row">
         <div class="col-sm-3 col-md-3 col-lg-4">
          <div class="product_img"><img src="{{ url('/') }}/uploads/business/main_image/{{ $restaurants['main_image'] }}" alt="list product"/></div>
        </div>

        <div class="col-sm-9 col-md-9 col-lg-8">
          <div class="product_details">
            <div class="product_title">
            <?php
             $slug_business=str_slug($restaurants['business_name']);
             $slug_area=str_slug($restaurants['area']);
             $business_area=$slug_business.'@'.$slug_area;
            ?>
              <a href="javascript:void(0);">
                {{ $restaurants['business_name'] }}
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
                </div>
              </div>
            </div>
          </div>
        </div>

            @endforeach
          @else
            <span><h4>No Records Available</h4></span>
          @endif
        @else
        <span>No Records Available</span>
      @endif
      </div>


<!--Product Lisiting End  -->


</div>
</div>
</div>

</div>


@endsection


