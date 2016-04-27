@if(isset($arr_business) && sizeof($arr_business)>0)
@foreach($arr_business as $restaurants)
<div class="product_list_view" id="more_business_list">
       <div class="row" >
      <div class="col-sm-3 col-md-3 col-lg-4">
        <div class="product_img">
            <img style="height: 100% !important;" class="over-img" src="{{ get_resized_image_path($restaurants['main_image'],$main_image_path,205,270) }}" alt="list product"/>
            @if($restaurants['is_verified']==1)<img class="product-like-icon" src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>@endif
        </div>
      </div>
      <div class="col-sm-9 col-md-9 col-lg-8">
          <div class="product_details">
            <div class="product_title">
              <?php
               $slug_business=str_slug($restaurants['business_name']);
               $slug_area=str_slug($restaurants['area']);
               $business_area=$slug_business.'@'.$slug_area;
              ?>
              <a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}">
                @if($restaurants['is_verified']==1)
                <img src="{{ url('/') }}/assets/front/images/verified-green.png" alt="write_review"/>
                @endif
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
                  <?php for($i=0;$i<round($restaurants['avg_rating']);$i++)
                        { ?><i class="fa fa-star star-acti"></i>
                  <?php }
                   for($i=0;$i<(5-round($restaurants['avg_rating']));$i++)
                        { ?>
                        <i class="fa fa-star"></i>
                  <?php }?>
                </div>
                 &nbsp;
                 @if(isset($tot_review)){{$tot_review}} @endif Ratings

                <span class=""> Estd.in {{ $restaurants['establish_year'] }} </span>
              </div>
              <div class="p_details"><i class="fa fa-phone"></i>
                 <span>
                 {{ $restaurants['landline_number'] }} &nbsp; {{ $restaurants['mobile_number'] }}
                 </span>
               </div>
              <div class="p_details">
              <i class="fa fa-map-marker"></i>
                <span>
                  {{ $restaurants['building'] }} &nbsp; {{ $restaurants['street'] }} <br/>
                  {{ $restaurants['landmark'] }} &nbsp; {{ $restaurants['area'] }} &nbsp;{{ '-'.$restaurants['pincode'] }}<br/>

                   @if(Session::has('distance'))
                   Away From {{Session::get('distance')}} km distance
                    @endif
                </span>
                </div>

              <input type="hidden"  id="business_id" value="{{ $restaurants['id'] }}"  />
              <div class="p_details" >
                    @if(Session::has('user_mail'))
                    <?php
                    if(isset($arr_fav_business) && count($arr_fav_business)>0 )
                    {
                        if(in_array($restaurants['id'], $arr_fav_business))
                        {
                          ?>  <span class="remo_fav" id="{{ 'show_fav_status_'.$restaurants['id'] }}" style="width: 175px;">
                          <a href="javascript:void(0);" class="active" onclick="add_to_favourite('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Remove favorite</span></a>
                          </span>
                          <?php
                        }
                        else
                        {
                          ?>
                          <span id="{{'show_fav_status_'.$restaurants['id'] }}" style="width: 175px;">
                          <a href="javascript:void(0);"  onclick="add_to_favourite('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add To favorite</span></a>
                          </span>
                         <?php
                        }
                    }
                    else
                    {
                          ?>
                             <span id="{{'show_fav_status_'.$restaurants['id'] }}" style="width: 175px;">
                            <a href="javascript:void(0);"  onclick="add_to_favourite('{{$restaurants['id']}}')"  style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add To favorite</span></a>
                            </span>
                          <?php
                    }
                    ?>
                      @else
                    <span>
                      <a href="javascript:void(0);" data-target="#login_poup" data-toggle="modal" style="border-right:0;display:inline-block;"><i class="fa fa-heart"></i><span> Add to favorites</span></a>
                      </span>
                    @endif

                    <ul>
                      <li><a data-toggle="modal" data-target="#sms-{{ $restaurants['id'] }}" href="#">SMS/Email</a></li>
                      <li><a href="{{url('/')}}/{{$city}}/{{$business_area}}/{{base64_encode($restaurants['id'])}}" class="lst">Rate This</a></li>
                    </ul>
                </div>
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
