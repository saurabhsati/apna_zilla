 @if(isset($arr_business) && sizeof($arr_business)>0)
      @foreach($arr_business as $restaurants)
  <div class="col-sm-6 col-md-6 col-lg-6">
                         <div class="product_grid_view" id="more_business_list">
                  <div class="p_images">
                     <div class="grid_product">
                       <?php
                       $slug_business=str_slug($restaurants['business_name']);
                       $slug_area=str_slug($restaurants['area']);
                       $business_area=$slug_business.'@'.$slug_area;
                      ?>
                      <div class="name-grid"><a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}">{{ $restaurants['business_name'] }}</a></div>
                        <?php $reviews=0; ?>
                        @if(isset($restaurants['reviews']) && sizeof($restaurants['reviews'])>0)
                        @foreach($restaurants['reviews'] as $review)
                        <?php  $reviews=$reviews+$review['ratings'] ?>
                        @endforeach
                        @endif
                        <?php
                        if(sizeof($restaurants['reviews']))
                        {
                          $tot_review=sizeof($restaurants['reviews']);
                          $avg_review=($reviews/$tot_review);
                        }
                        else
                        {
                          $avg_review= $tot_review=0;
                        }
                        ?>
                       <div class="rating_star"><img src="{{ url('/') }}/assets/front/images/rating-4.png" alt="rating" width="73"/>
                        <span> &nbsp;@if(isset($tot_review)){{$tot_review}} @endif Ratings</span>
                       </div>


                     @if(Session::has('user_mail'))
                    <?php
                    if(isset($arr_fav_business) && count($arr_fav_business)>0 )
                    {
                      if(in_array($restaurants['id'], $arr_fav_business))
                      {
                    ?>  <span class="remo_fav" id="{{ 'show_fav_status_grid_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite_grid('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"
                          data-toggle="tooltip" title="Remove favourite"
                        ><i class="fa fa-heart"><span style="width:19px height=10px;">Remove favorite</span></i></a>
                        </span>
                    <?php
                      }
                      else
                      {
                    ?>
                        <span id="{{'show_fav_status_grid_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite_grid('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"
                          data-toggle="tooltip" title="Add to favorites"
                        ><i class="fa fa-heart"><span style="width:19px height=10px;">Add to favorite</span></i></a>
                        </span>
                    <?php
                      }
                    }
                    else{
                      ?>
                         <span id="{{'show_fav_status_grid_'.$restaurants['id'] }}" style="width: 175px;">
                        <a href="javascript:void(0);"  onclick="add_to_favourite_grid('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"
                          data-toggle="tooltip" title="Add to favorites"
                        ><i class="fa fa-heart"><span style="width:19px height=10px;">Add to favorite</span></i></a>
                        </span>
                      <?php
                    }
                    ?>
                      <!-- <span id="{{-- 'show_fav_status_'.$restaurants['id'] --}}" style="width: 175px;">
                      <a href="javascript:void(0);"  onclick="add_to_favourite('{{--$restaurants['id']--}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add To favourite</span></a>
                      </span> -->

                    @else
                    <span>
                      <a href="javascript:void(0);" data-target="#login_poup" data-toggle="modal" style="border-right:0;display:inline-block;"
                      ><i class="fa fa-heart"></i><span> </span></a>
                      </span>
                    @endif



                       <!--  <a href="#" style="border-right:0;display:inline-block;" data-toggle="tooltip" title="Add to favorites"><i class="fa fa-heart"></i><span> </span>
                        </a> -->



                        </div>
                       <img src="{{get_resized_image_path($restaurants['main_image'],$main_image_path,205,270) }}" alt="product img" >
                        @if($restaurants['is_verified']==1)<img class="product-like-icon" src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>@endif
                    </div>


                <div class="p_list_details">
                   <div class="list-product"><i class="fa fa-phone"></i><span> {{ $restaurants['landline_number'] }} &nbsp; {{ $restaurants['mobile_number'] }}</span></div>
                       <div class="list-product"><i class="fa fa-map-marker"></i><span><!-- {{ $restaurants['building'] }} &nbsp; {{ $restaurants['street'] }} <br/>
                  {{ $restaurants['landmark'] }} &nbsp;  -->{{ $restaurants['area'] }} <!-- &nbsp;{{ '-'.$restaurants['pincode'] }} --></span>  </div>

                  <div class="p_details"><!--<a href="#" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>-->
                    <ul>
                    <li><a data-toggle="modal" data-target="#sms-{{ $restaurants['id'] }}" href="#">SMS/Email</a></li>
                   <!--  <li><a href="#" class="active">Edit</a></li>
                    <li><a href="#">Own This</a></li> -->
                    <li><a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}" class="lst">Rate This</a></li>
                    </ul>
                    </div>
                    </div>

                </div>
                </div>

@endforeach
@endif


 <!-- SEND SMS POPUP START-->
        @if(isset($arr_business) && sizeof($arr_business)>0)
        @foreach($arr_business as $restaurants)
        <div class="modal fade" id="sms-{{ $restaurants['id'] }}" role="dialog">
          <div class="modal-dialog">
           <!-- Modal content-->
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
             <div class="modal-body">
             <form class="form-horizontal"
                                    id="validation-form"
                                    method="POST"
                                    action="{{ url('/listing/send_sms/') }}"
                                    enctype="multipart/form-data"
                                    >
                {{ csrf_field() }}



                <b class="head-t">Get information by SMS/Email</b>
                 <p class="in-li">Enter the details below and click on SEND</p>
                  <div class="soc-menu-top">
                      <div class="col-lg-11">
                  <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">Name</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                               <input type="text" placeholder="Enter Name"   id="name-{{ $restaurants['id'] }}" name="name-{{ $restaurants['id'] }}" class="input_acct">
                                 <div class="error_msg" id="err_name-{{ $restaurants['id'] }}"></div>
                              </div>
                               </div>
                          </div>



                  <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">Mobile</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                              <div class="input-group">
                              <span id="basic-addon1" class="input-group-addon">+91</span>
                              <input type="text" required="" aria-describedby="basic-addon1" id="sms_mobile_no-{{ $restaurants['id'] }}" name="sms_mobile_no-{{ $restaurants['id'] }}" placeholder="Mobile" class="form-control">

                              </div>
                                <div class="error_msg" id="err_sms_mobile_no-{{ $restaurants['id'] }}"></div>
                              </div>
                               </div>
                          </div>


                      <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">Email</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                               <input type="text" placeholder="Enter Email" name="email-{{ $restaurants['id'] }}" id="email-{{ $restaurants['id'] }}" class="input_acct">
                                <div class="error_msg" id="err_email-{{ $restaurants['id'] }}"></div>
                              </div>
                               </div>
                          </div>
                          <div class="clr"></div>
                             <div class="user_box_sub">
                                 <div class="row">
                          <div class="col-lg-3  label-text">&nbsp;</div>
                          <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                          <div class="submit-btn">
                          <input type="hidden" id="business_id-{{ $restaurants['id'] }}" name="business_id-{{ $restaurants['id'] }}" value="{{ $restaurants['id'] }}">
                           <button type="button" name="send_sms" id="send_sms" onclick="Send_SMS({{ $restaurants['id'] }})">Send</button>
                            </div>
                          </div>
                                 </div>
                          </div>
                      </div>
                  </div>
                 <div class="clr"></div>
              </div>
              </form>
            </div>
          </div>
        </div>
          <!-- SEND SMS POPUP END -->
         @endforeach
        @endif
