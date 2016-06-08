@extends('front.template.master')

@section('main_section')


<!-- Timepicker css -->
<link rel="stylesheet" type="text/css" href="{{ url('/').'/assets/bootstrap-timepicker/compiled/timepicker.css' }}" />


  
<style type="text/css">
  .error{
    color: red;
    font-size: 12px;
    font-weight: lighter;
    text-transform: capitalize;
  }
</style>

<!-- Timepicker js  -->
<script type="text/javascript" src="{{ url('/').'/assets/bootstrap-timepicker/js/bootstrap-timepicker.js' }}"></script>

  <div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                     <ol class="breadcrumb">
                         <span>You are here :</span>
                          <li><a href="{{ url('/') }}">Home</a></li>
                          <li class="active">Contact Information</li>

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
              @if(isset($business_data) && sizeof($business_data)>0)
                  @foreach($business_data as $business)

                  
              <form class="form-horizontal"
                       id="validation-form"
                       method="POST"
                      action="{{ url('/front_users/update_business_step4/'.$enc_id)}}"
                       enctype="multipart/form-data"
                       >

            {{ csrf_field() }}
             <div class="my_whit_bg">
            <div class="title_acc">Please Provide Other Information</div>
            <div class="row">


              <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="box_profile">
                    
                    <div class="user_box_sub">
                      <div class="row">
                        <div class="col-lg-2 label-text">Company Information <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                            <textarea  class="input_acct" id="company_info" name="company_info" style="width: 682px;" placeholder="Enter Company Information" data-rule-required="true" />{{ isset($business['company_info'])?strip_tags($business['company_info']):'' }}</textarea>
                            <div class="error_msg">{{ $errors->first('company_info') }} </div>
                          </div>
                       </div>
                    </div>


                     <div class="user_box_sub">
                        <div class="row">
                          <div class="col-lg-2 label-text">Establishment Year <span>:</span></div>
                            <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                              <input type="text"  class="input_acct"  id="establish_year" name="establish_year"  placeholder="Enter Establishment Year"  data-rule-required="true" data-rule-integer="true" value="{{ isset($business['establish_year'])?$business['establish_year']:'' }}" />
                               <div class="error_msg">{{ $errors->first('establish_year') }} </div>
                            </div>
                        </div>
                    </div>

                     <div class="user_box_sub">
                      <div class="row">
                        <div class="col-lg-2 label-text">Keywords <span>:</span></div>
                          <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                            <textarea  class="input_acct" id="keywords" name="keywords"  style="width: 682px;" placeholder="Enter Keywords" data-rule-required="true" />{{ isset($business['keywords'])?strip_tags($business['keywords']):'' }}</textarea>
                            <div class="error_msg">{{ $errors->first('keywords') }} </div>
                          </div>
                       </div>
                    </div>
                    <?php $selected_paymnt_arr=array();?>
                           @if(sizeof($business['payment_mode'])>0)
                             @foreach($business['payment_mode'] as $payment_mode)
                                <?php $selected_paymnt_arr[]=$payment_mode['title'];?>
                                @endforeach
                              @endif

                       <div class="user_box_sub">
                        <div class="row">
                          <div class="col-lg-2 label-text">Modes Of Payment <span>:</span></div>
                            <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                            <div class="form-group">

                               
                             
                             <div class="col-sm-3 col-lg-5 controls" >
                                  <input type="checkbox"  name="payment_mode[]" value="Cash" @if(search_array('Cash',$selected_paymnt_arr)) checked="checked" @endif  />
                                  <label class="label-text"> Cash </label>
                                  <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                              </div>
                             
                                <div class="col-sm-5 col-lg-4 controls">
                                    <input type="checkbox"  name="payment_mode[]" @if(search_array('Net Banking',$selected_paymnt_arr)) checked @endif value="Net Banking" />
                                    <label class=" label-text"> Net Banking  </label>
                                    <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                                </div>
                              </div>


                              <div class="form-group">
                                <div class="col-sm-3 col-lg-5 controls" >
                                 <input type="checkbox"  name="payment_mode[]" value="Cheque" @if(search_array('Cheque',$selected_paymnt_arr)) checked @endif/>
                                  <label class=" label-text" > Cheque  </label>
                                  <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                                </div>
                            
                                <div class="col-sm-5 col-lg-4 controls">
                                    <input type="checkbox"  name="payment_mode[]" value="Credit Card" @if(search_array('Credit Card',$selected_paymnt_arr)) checked @endif/>
                                      <label class="label-text"> Credit Card  </label>
                                      <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                                </div>
                              </div>

                              <div class="form-group">
                               <div class="col-sm-3 col-lg-5 controls" >
                                    <input type="checkbox"  name="payment_mode[]" value="Debit Card" @if(search_array('Debit Card',$selected_paymnt_arr)) checked @endif/>
                                      <label class="label-text">Debit Card </label>
                               <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                                </div>
                             
                               <div class="col-sm-5 col-lg-4 controls">
                                    <input type="checkbox"  name="payment_mode[]" value="Gift Card" @if(search_array('Gift Card',$selected_paymnt_arr)) checked @endif/>
                                     <label class="label-text"> Gift Card  </label>
                                  <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                                </div> 
                              </div>

                              <div class="form-group">
                               <div class="col-sm-3 col-lg-5 controls" >
                                    <input type="checkbox"  name="payment_mode[]" value="Bank Transfer" @if(search_array('Bank Transfer',$selected_paymnt_arr)) checked @endif/>
                                     <label class="label-text">Bank Transfer  </label>
                                     <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                                </div>
                           
                               <div class="col-sm-5 col-lg-4 controls">
                                    <input type="checkbox"  name="payment_mode[]" value="Lay-by" @if(search_array('Lay-by',$selected_paymnt_arr)) checked @endif/>
                                    <label class="label-text"> Lay-by  </label>
                                    <span class='help-block'>{{ $errors->first('payment_mode') }}</span>
                                </div>
                              </div>
                              <!--  <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                               @if(isset($business['payment_mode']) && sizeof($business['payment_mode'])>0)
                                 @foreach($business['payment_mode'] as $payment_mode)

                                  <div class="fileupload-new img-thumbnail main" style="width: 300px; height: 62px;" data-payment-mode="{{ $payment_mode['title'] }}">
                                     <input class="form-control" type="text" name="payment_mode" id="payment_mode" class="pimg"  value="{{ $payment_mode['title']}}" />
                                     <div class="caption">
                                     <p class="pull-left">
                                        <a href="javascript:void(0);"class="delete_payment_mode" data-payment-mode="{{ $payment_mode['title'] }}" onclick="javascript: return delete_payment_mode('<?php echo $payment_mode['id'] ;?>')">
                                         <span class="glyphicon glyphicon-minus-sign " style="font-size: 20px;"></span></a>
                                     </p>
                                    </div>
                                  </div>
                                  @endforeach

                                  @else
                                  <span class="col-lg-8 label-text">No Business Payment Mode Availbale</span>
                                  @endif
                                 <div class="error" id="err_delete_payment_mode"></div>
                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span> -->
                            </div>
                         </div>
                         </div>

                        <!--  <div class="user_box_sub">
                         <div class="row">
                          <div class="col-lg-2 label-text"><a href="javascript:void(0)" class="add_payment_mode">Add More Payment Mode</a> <span>:</span></div>
                         </div></div>

                        <div class="user_box_sub add_more_payment_mode" style="display: none;">
                              <div class="col-sm-5 col-md-3" style="float:right;margin-right: -133px;">
                                     <a href="javascript:void(0);" id='add-payment'>
                                         <span class="glyphicon glyphicon-plus-sign" style="font-size: 22px;"></span>
                                     </a>
                                    <span style="margin-left:05px;">
                                    <a href="javascript:void(0);" id='remove-payment'>
                                        <span class="glyphicon glyphicon-minus-sign" style="font-size: 22px;"></span>
                                    </a>
                                    </span>
                                   </div>
                                    <div class="row">
                                     <div class="col-lg-2 label-text">Payment Mode <span>:</span></div>
                                      <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                                      <input type="text" name="payment_mode[]" id="payment_mode" class="input_acct"  placeholder="Enter Payment Mode" data-rule-required="true"  />
                                      <div class="error" id="error_payment_mode">{{ $errors->first('payment_mode') }}</div>
                                      <div class="clr"></div><br/>
                                        <div class="error" id="error_set_default"></div>
                                        <div class="clr"></div>

                                     <div id="append_payment" class="class-add"></div>

                                      <div class="error_msg" style="color: red" id="error_payment_mode" ></div>
                                      <div class="error_msg" style="color: red" id="error_payment_mode1" ></div>
                                     <label class="col-lg-2 label-text"></label>

                                      </div>
                                  </div>
                              </div> -->

                            <hr/>

                      <!--       mon_open" => "11:15 AM"
    "mon_close" => "11:15 AM"
    "tue_open" => "11:15 AM"
    "tue_close" => "11:15 AM"
    "wed_open" => "11:15 AM"
    "wed_close" => "11:15 AM"
    "thus_open" => "11:15 AM"
    "thus_close" => "11:15 AM"
    "fri_open" => "11:15 AM"
    "fri_close" => "11:15 AM"
    "sat_open" => "11:15 AM"
    "sat_close" => "11:15 AM"
    "sun_open" => "11:15 AM"
    "sun_close" => "11:15 AM" -->



                            
                          <div class="title_acc">Opening Hours</div>
                            <div class="row" style="margin-bottom: 15px;">
                          @if(isset($business['business_times']) && sizeof($business['business_times'])>0)

                          @foreach($business['business_times'] as $time)   
                           <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Monday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="mon_in" id="mon_in"  
                                      value="{{ isset($time['mon_open'])?$time['mon_open']:'' }}" 
                                      type="text" data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="mon_out" id="mon_out"
                                      value="{{ isset($time['mon_close'])?$time['mon_close']:'' }}"
                                       type="text" data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Tuesday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="tue_in" id="tue_in" type="text" 
                                      value="{{ isset($time['tue_open'])?$time['tue_open']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="tue_out" id="tue_out" type="text" 
                                      value="{{ isset($time['tue_close'])?$time['tue_close']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Wednesday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="wed_in" id="wed_in" type="text" 
                                      value="{{ isset($time['wed_open'])?$time['wed_open']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="wed_out" id="wed_out" type="text" 
                                      value="{{ isset($time['wed_close'])?$time['wed_close']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                         <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Thursday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="thu_in" id="thu_in" type="text" 
                                      value="{{ isset($time['thus_open'])?$time['thus_open']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="thu_out" id="thu_out" type="text" 
                                      value="{{ isset($time['thus_close'])?$time['thus_close']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Friday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="fri_in" id="fri_in" type="text" 
                                      value="{{ isset($time['fri_open'])?$time['fri_open']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="fri_out" id="fri_out" type="text"
                                      value="{{ isset($time['fri_close'])?$time['fri_close']:'' }}"
                                       data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Saturday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sat_in" id="sat_in" type="text" 
                                        value="{{ isset($time['sat_open'])?$time['sat_open']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sat_out" id="sat_out" type="text" 
                                      value="{{ isset($time['sat_close'])?$time['sat_close']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text ">Sunday<span>:</span></div>

                             <div class="col-sm-3 col-md-3 col-lg-3 m_l controls">
                                    &nbsp &nbsp &nbsp &nbsp &nbsp
                                    <input type="radio"  name="is_sunday" value="1" onclick="sunday_status('on');" @if(($time['sun_open']!='') && ($time['sun_open']!='')) checked="true"  @endif/>
                                    <label >On </label>
                                     &nbsp &nbsp &nbsp &nbsp &nbsp
                                       <input type="radio"  name="is_sunday" value="0"  onclick="sunday_status('off');" @if( empty($time['sun_open']) && empty($time['sun_open'])) checked="true"  @endif/>
                                    <label  for="is_sunday">Off </label>
                              </div>
                              </div>
                              </div>
                            


                              <div class="user_box_sub" id="sunday_section"  @if(empty($time['sun_open']) && empty($time['sun_open'])) style="display:none;" @endif>
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text "><span></span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l controls">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sun_in" id="sun_in" type="text" 
                                      value="{{ isset($time['sun_open'])?$time['sun_open']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sun_out" id="sun_out" type="text" 
                                        value="{{ isset($time['sun_close'])?$time['sun_close']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                        </div>
                           @endforeach
                           @else
                            <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Monday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="mon_in" id="mon_in"  
                                      value="" 
                                      type="text" data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="mon_out" id="mon_out"
                                      value=""
                                       type="text" data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Tuesday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="tue_in" id="tue_in" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="tue_out" id="tue_out" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Wednesday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="wed_in" id="wed_in" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="wed_out" id="wed_out" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                         <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Thursday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="thu_in" id="thu_in" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="thu_out" id="thu_out" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Friday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="fri_in" id="fri_in" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="fri_out" id="fri_out" type="text"
                                      value=""
                                       data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text">Saturday<span>:</span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sat_in" id="sat_in" type="text" 
                                        value=""
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sat_out" id="sat_out" type="text" 
                                      value=""
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                          <div class="user_box_sub">
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text ">Sunday<span>:</span></div>

                             <div class="col-sm-3 col-md-3 col-lg-3 m_l controls">
                                    &nbsp &nbsp &nbsp &nbsp &nbsp
                                    <input type="radio"  name="is_sunday" value="1" onclick="sunday_status('on');" checked="true"  />
                                    <label >On </label>
                                     &nbsp &nbsp &nbsp &nbsp &nbsp
                                       <input type="radio"  name="is_sunday" value="0"  onclick="sunday_status('off');"/>
                                    <label  for="is_sunday">Off </label>
                              </div>
                              </div>
                              </div>
                            


                              <div class="user_box_sub" id="sunday_section"  >
                            <div class="row" style=" margin-left: 10px;">
                            <div class="col-lg-2 label-text "><span></span></div>
                             <div class="col-sm-3 col-md-3 col-lg-3 m_l controls">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sun_in" id="sun_in" type="text" 
                                      value="{{ isset($time['sun_open'])?$time['sun_open']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>

                              <div class="col-sm-3 col-md-3 col-lg-3 m_l">
                                  <div class="input-group">
                                      <a class="input-group-addon" href="javascript:void(0);">
                                          <i class="fa fa-clock-o"></i>
                                      </a>
                                      <input class="form-control timepicker-default" name="sun_out" id="sun_out" type="text" 
                                        value="{{ isset($time['sun_close'])?$time['sun_close']:'' }}"
                                      data-rule-required="true">
                                  </div>
                              </div>
                              </div>
                          </div>

                        </div>
                           @endif
                          <hr/>

                                <div class="button_save1">
                                <a class="btn btn-post" href="{{ url('/front_users/edit_business_step3/'.Request::segment(3))}}" style="float: left; margin-right:194px; "> Back</a>
                                  <button type="submit" class="btn btn-post" name="add_contacts" style="float: left; margin-left:125px; ">Save &amp; continue</button>
                                  <!-- <a class="btn btn-post pull-left" href="#">previous</a>
                                  <a class="btn btn-post" href="#">Save &amp; exit</a>
                                  <a class="btn btn-post pull-right" href="#">Next</a> -->
                               </div>
                 </div>
                 </div>
                 </div>
                 </div>
                </form>
                @endforeach
                @endif
             </div>
         </div>
       </div>
      </div>
<?php
  function search_array($search_val, $arr)
  {
    $flag = 0; 
    //dd($arr);
    foreach ($arr as $key => $value) {
     
      if(trim($value) == trim($search_val))
       { $flag = 1;  break ;} 
    
    }
    
    return $flag;
  }

?>



<script type="text/javascript">
    var site_url = "{{url('/')}}";
function sunday_status(status)
{
  if(status=='on')
  {
    $("#sunday_section").css('display','block');

    $("#sun_in").timepicker();
    $("#sun_out").timepicker();
   }
  else if(status=='off')
  {
    $("#sunday_section").css('display','none');
    $("#sun_in").css('hideWidget');
    $("#sun_out").timepicker('hideWidget');
  }
}

</script>

<script type="text/javascript">
$('.add_payment_mode').click(function()
{
      $(".add_more_payment_mode").removeAttr("style");
});
function delete_payment_mode(id)
{
  var _token = $('input[name=_token]').val();
  var dataString = { id:id, _token: _token };
  var url_delete= site_url+'/front_users/delete_payment_mode';
  $.post( url_delete, dataString)
      .done(function( data ) {
        if(data=='done'){
             $('#err_delete_payment_mode').html('<div style="color:green">Payment Mode deleted successfully.</div>');
             var request_id=$('.delete_payment_mode').parents('.main').attr('data-payment-mode');
             $('div[data-payment-mode="'+request_id+'"]').remove();
        }
      });
}
</script>

<script type="text/javascript">
        //Payment
$('#add-payment').click(function()
{
  flag=1;

  var img_val = jQuery("input[name='payment_mode[]']:last").val();

  var img_length = jQuery("input[name='payment_mode[]']").length;

  if(img_val == "")
  {
        $('#error_payment_mode').css('margin-left','120px');
        $('#error_payment_mode').css('color','red');
        $('#error_payment_mode').show();
        $('#error_payment_mode').fadeIn(3000);
        document.getElementById('error_payment_mode').innerHTML="The Payment Mode is required.";
        setTimeout(function(){
        $('#error_payment_mode').fadeOut(4000);
        },3000);

       flag=0;
       return false;
  }

    var payment_html='<div>'+
             '<input type="text" class="input_acct" name="payment_mode[]" id="payment_mode" class="" data-rule-required="true"  />'+
             '<div class="error" id="error_payment_mode">{{ $errors->first("payment_mode") }}</div>'+
             '</div>'+
             '<div class="clr"></div><br/>'+
             '<div class="error" style="color:red" id="error_set_default"></div>'+
             '<div class="clr"></div>';
        jQuery("#append_payment").append(payment_html);

});


$('#remove-payment').click(function()
{
     var html= $("#append_payment").find("input[name='payment_mode[]']:last");
     html.remove();
});


</script>
<!--TimePicker-->
<script type="text/javascript">
$(document).ready(function (){
 $('.timepicker-default').timepicker();
});
</script>

<script type="text/javascript">
$(document ).ready(function (){

  $("#validation-form").validate({
      
      rules: {
          company_info: "required",
          establish_year: {
                required: true,
                maxlength: 4,
                minlength: 4
            },
          keywords:"required",
      },
      
      messages: {
          company_info: "Please enter company Information.",
          establish_year: "Please enter valid Year e.g. 2015.",
          keywords: "Please Enter keywords.",
      },

  });
});
</script>



@stop