    @extends('web_admin.template.admin')


    @section('main_content')
    <!-- BEGIN Page Title -->
    <div class="page-title">
        <div>

        </div>
    </div>
    <!-- END Page Title -->

    <!-- BEGIN Breadcrumb -->
    <div id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/').'/web_admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-money"></i>
                <a href="{{ url('/web_admin/deals_offers/') }}">Deal</a>
               
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active">  {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-money"></i>
                {{ isset($page_title)?$page_title:"" }}
            </h3>
            <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
            </div>
        </div>
        <div class="box-content">

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
        @if(isset($deal_arr) && sizeof($deal_arr)>0)
            <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/deals_offers/update/'.base64_encode($deal_arr['id'])) }}" enctype="multipart/form-data">


           {{ csrf_field() }}

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_id">Business Name</label>
                <div class="col-sm-6 col-lg-4 controls">

                    <select class="form-control" name="business_id" id="business_id" data-rule-required="true" readonly>
                       <option value="{{ isset($deal_arr['business_info']) && $deal_arr['business_info']?$deal_arr['business_info']['id']:'' }}">
                       {{ isset($deal_arr['business_info']) && $deal_arr['business_info']?$deal_arr['business_info']['business_name']:'' }}
                       </option>
                    </select>

                    <span class='help-block'>{{ $errors->first('business_id') }}</span>
                </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="old_main_business_cat">Deal Main Category <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls">
              <select class="form-control" name="old_main_business_cat" id="old_main_business_cat" disabled="">
               @if(isset($arr_main_category) && sizeof($arr_main_category)>0)
                 @foreach($arr_main_category as $main_category)
                   @foreach($deal_arr['category_info'] as $selected_category)
                      <option   value="{{ $main_category['cat_id'] }}"
                       <?php if($selected_category['main_cat_id']==$main_category['cat_id']){ echo 'selected="selected"'; }?> >
                       {{ $main_category['title'] }}
                      </option>
                    @endforeach               
                  @endforeach
                 @endif
                </select>
            </div>
           </div>
          <div class="form-group">
          <label class="col-sm-3 col-lg-2 control-label" for="sub_cat">Deal Sub Category <i class="red">*</i></label>
           <div class="col-sm-6 col-lg-4 controls">
           <?php 
              $arr_sub_selected=[];
              $arr_main_selected=[];
              ?>
           @if(isset($arr_category) && sizeof($arr_category)>0)
            @foreach($arr_category as $sub_category)
           @foreach($deal_arr['category_info'] as $selected_category)
           @if( $sub_category['parent']==$selected_category['main_cat_id'])
           <?php
              $arr_sub_selected=[];
              $arr_main_selected=[];
              foreach($deal_arr['category_info'] as $sel_category)
                {
                 array_push($arr_sub_selected,$sel_category['sub_cat_id']);
                 array_push($arr_main_selected,$sel_category['main_cat_id']);
                }
              ?>
             @endif
            @endforeach
             @endforeach
           @endif
            <select  class="form-control" name="sub_cat_id" id="sub_cat_id " multiple="">
               @if(isset($arr_category) && sizeof($arr_category)>0)
                 @foreach($arr_category as $sub_category)
                   @if(in_array($sub_category['parent'],$arr_main_selected))
                   <option  <?php if(in_array($sub_category['cat_id'],$arr_sub_selected)){ echo 'selected="selected"'; }?> value="{{ $sub_category['cat_id'] }}">
                     {{ $sub_category['title'] }}
                   </option>
                   @endif
                 @endforeach
               @endif
            </select>
            </div>
            </div>


             <div class="form-group">
             <label class="col-sm-3 col-lg-2 control-label" for="building">
                           <a href="javascript:void(0);" class="add_new_subcategory">Add New Sub Category </a></label>
            </div>
            <div class="add_new_subcategory_div" id="add_new_subcategory_div" style="display:none;">
            <div class="form-group ">
              <label class="col-sm-3 col-lg-2 control-label" for="main_business_cat">Deal Main Category <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls">
            <select class="form-control" name="main_business_cat" id="main_business_cat" onchange="getSubCategory(this)">
              <option> Select Deal Main Categories</option>
             @if(isset($arr_main_category) && sizeof($arr_main_category)>0)
             @foreach($arr_main_category as $main_category)
              <option  name="sub_cat" id="sub_cat" value="{{ $main_category['cat_id'] }}" >
                             {{ $main_category['title'] }}
                              </option>
              @endforeach
               @endif
            </select>
            </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="business_cat">Deal Sub Category <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls" id="sub_category_div" name="sub_category_div" style="">
            <select class="form-control"  id="example-getting-started" name="business_cat[]" multiple="multiple">
            <option value="">Select Deal Sub category </option>
                
              </select>
              <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                <div class="alert alert-warning">Note: Firstly Select The Business Main category From Business Main Category Drop-down , Then Click ON None Selected Button  </div>
            </div>

            </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_id">Business Public ID</label>
                <div class="col-sm-6 col-lg-4 controls">

                    <select class="form-control" name="busiess_ref_public_id" id="busiess_ref_public_id" data-rule-required="true" readonly>
                       <option value="{{ isset($deal_arr['business_info']) && $deal_arr['business_info']?$deal_arr['business_info']['busiess_ref_public_id']:'' }}">
                       {{ isset($deal_arr['business_info']) && $deal_arr['business_info']?$deal_arr['business_info']['busiess_ref_public_id']:'' }}
                       </option>
                    </select>

                    <span class='help-block'>{{ $errors->first('busiess_ref_public_id') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Deal Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="name" id="name" value="{{ $deal_arr['name'] }}" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">Deal Title<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="title" id="title" value="{{ $deal_arr['title'] }}" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('title') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Price<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="price" id="price" value="{{ $deal_arr['price'] }}" data-rule-required="true"  data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('price') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="discount_price">Discount<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="discount_price" id="discount_price" value="{{ $deal_arr['discount_price'] }}" data-rule-required="true"  data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('discount_price') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="deal_image">Deal Image</label>
                  <div class="col-sm-6 col-lg-5 controls">
                     <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                           <img src=" {{ $deal_public_img_path.'/'. $deal_arr['deal_image']}}" alt=""  height="150px" width="180px" />
                            <input type="hidden" value="{{ $deal_arr['deal_image']}}" name="old_image" id="old_image">
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                           <span class="btn btn-default btn-file"><span class="fileupload-new">Select Photo</span>
                           <span class="fileupload-exists">Change</span>


                           <input type="file" name="deal_main_image"  id="deal_main_image" class="file-input" data-rule-required=""/></span>


                           <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>


                            <span class='help-block'>{{ $errors->first('deal_main_image') }}</span>

                        </div>
                     </div>

                     <span class="label label-important">NOTE!</span>
                    <span>Attached image img-thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only</span>
                  </div>
                     <span id="image_err" style="color:red;margin-bottom:10px;font-size:12px;"></span>
            </div>
            <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Deal Slider Images<i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new business_upload_image_" data-provides="fileupload">
                                 @foreach($deal_arr['deals_slider_images'] as $image)

                                  <div class="fileupload-new img-thumbnail main" style="width: 200px; height: 150px;" data-image="{{ $image['image_name'] }}">
                                     <img style="width:150px;height:122px"
                                      src={{ $deal_base_upload_img_path.$image['image_name']}} alt="" />
                                     <div class="caption">
                                     <p class="pull-left">
                                        <a href="javascript:void(0);" class="delete_image" data-image="{{ $image['image_name'] }}" onclick="javascript: return delete_gallery('<?php echo $image['id'] ;?>','<?php echo $image['image_name'];?>')">
                                         <span class="glyphicon glyphicon-minus-sign " style="font-size: 20px;"></span></a>
                                     </p>
                                    </div>
                                  </div>
                           <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>

                                  @endforeach
                    <div class="error" id="err_delete_image"></div>

                               </div>
                                <span class='help-block'>{{ $errors->first('main_image') }}</span>
                            </div>

                         </div>
                         <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label" for="building">
                           <a href="" class="add_more">Add More Deal Slider Images</a></label>
                         </div>
                          <div class="form-group add_more_image" style="display: none;">
                          <div class="col-sm-5 col-md-7" style="float:right;">
                             <a href="javascript:void(0);" id='add-image' class="show-tooltip" title="Add More images">
                                 <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;"></span>
                             </a>
                            <span style="margin-left:05px;">
                            <a href="javascript:void(0);" id='remove-image' class="show-tooltip" title="Remove last selected  images">
                                <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;"></span>
                            </a>
                            </span>
                           </div>
                              <label class="col-sm-3 col-lg-2 control-label">Add More Deal Slider Images <i class="red">*</i> </label>
                              <div class="col-sm-6 col-lg-4 controls">

                              <input type="file" name="deal_image[]" id="deal_image" class="pimg"   />
                              <div class="error" id="error_deal_image" style="color:red;">{{ $errors->first('deal_image') }}</div>

                              <div class="clr"></div><br/>
                                <div class="error" id="error_set_default"></div>
                                <div class="clr"></div>

                             <div id="append" class="class-add"></div>
                              <div class="error_msg" id="error_deal_image" style="color:red;"></div>
                              <div class="error_msg" id="error_deal_image1" style="color:red;"></div>
                            <label class="col-sm-6 col-lg-12 controls alert alert-warning">Note: Attached Image Size With Width 517px and Height 361px for best result</label>

                              </div>
                              </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="deal_type">Deal Type<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-3 controls">
                    <select class="form-control" name="deal_type" id="deal_type" onchange="isInstantDeal(this)" data-rule-required="true">
                            <option value="">Select Deal</option>
                            <option value="1" @if($deal_arr['deal_type']=='1'){{'selected'}} @endif>Normal Deal</option>
                          <!--   <option value="2" @if($deal_arr['deal_type']=='2'){{'selected'}} @endif>Instant Deal</option>
                            <option value="3" @if($deal_arr['deal_type']=='3'){{'selected'}} @endif>Featured Deal</option> -->
                    </select>
                    <span class='help-block'>{{ $errors->first('deal_type') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Start Day<i style="color:red;">*</i></label>
                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input name="start_day" id="start_day" class="form-control" value="{{ date('m/d/Y',strtotime($deal_arr['start_day'])) }}" type="text"  size="16" data-rule-required="true"/>
                         <span class='help-block'>{{ $errors->first('start_day') }}</span>
                    </div>
                </div>

                <label class="col-sm-3 col-lg-2 control-label">End Day</label>
                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input name="end_day" id="end_day" class="form-control" type="text" value="{{ date('m/d/Y',strtotime($deal_arr['end_day'])) }}"  size="16" data-rule-required="true"         />
                        <span class='help-block'>{{ $errors->first('end_day') }}</span>
                    </div>
                </div>

            </div>

            <!-- <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Start Time<i style="color:red;">*</i></label>
                <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        <a class="input-group-addon" href="#">
                            <i class="fa fa-clock-o"></i>
                        </a>
                        <input class="form-control " name="start_time" id="start_time"  value="{{ $deal_arr['start_time'] }}" type="text" data-rule-required="true">
                       <span class='help-block'>{{ $errors->first('start_time') }}</span>
                    </div>
                </div>

                <label class="col-sm-3 col-lg-2 control-label">End Time<i style="color:red;">*</i></label>
               <div class="col-sm-3 col-lg-3 controls">
                    <div class="input-group">
                        @if($deal_arr['deal_type']=='2')
                            <a class="input-group-addon" id="end_time_id" href="#" style="display:none;">
                                <i class="fa fa-clock-o"></i>
                            </a>
                        @else
                            <a class="input-group-addon" id="end_time_id" href="#">
                                <i class="fa fa-clock-o"></i>
                            </a>
                        @endif
                        <input class="form-control " name="end_time" id="end_time" value="{{ $deal_arr['end_time'] }}"
                            @if($deal_arr['deal_type']=='2'){{'readonly'}} @endif
                         type="text" data-rule-required="true">

                        <span class='help-block'>{{ $errors->first('end_time') }}</span>
                    </div>
                        @if($deal_arr['deal_type']=='2')
                            <div class="instantDealNote" id="instantDealNote">
                                <span class="label label-important">NOTE!</span>
                                <span>Only 2 Hour Deal</span>
                            </div>
                        @else
                        @endif

                    <div class="instantDealNote" id="instantDealNote" style="display:none;">
                        <span class="label label-important">NOTE!</span>
                        <span>Only 2 Hour Deal</span>
                    </div>
                </div>
            </div> -->
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="description">Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="description" id="description" data-rule-required="true" rows="5">{{ $deal_arr['description'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('description') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="things_to_remember">Things to Remember<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="things_to_remember" id="things_to_remember" data-rule-required="true" rows="5">{{ $deal_arr['things_to_remember'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('things_to_remember') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="how_to_use">How to use the offer<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="how_to_use" id="how_to_use" data-rule-required="true" rows="5">{{ $deal_arr['how_to_use'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('how_to_use') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="about">About<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="about" id="about" data-rule-required="true" rows="5">{{ $deal_arr['about'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('about') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="facilities">Facilities<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="facilities" id="facilities" data-rule-required="true" rows="5">{{ $deal_arr['facilities'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('facilities') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="cancellation_policy">Cancellation Policy<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="cancellation_policy" id="cancellation_policy" data-rule-required="true" rows="5">{{ $deal_arr['cancellation_policy'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('cancellation_policy') }}</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="facilities">Area<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <input id="geocomplete" type="text" placeholder="Type in an address" size="90" class="form-control"/></div>
                </div>
               
    <div class="form-group">
                <label class="col-md-3 col-lg-2 control-label" for="map_location">Map Location<i class="red">*</i></label>
                <div class="col-sm-5 col-lg-8 controls">
                   <div id="business_location_map" style="height:400px"></div>

                    <label>Note: Click On the Map to Pick Nearby Custom Location </label>
                    <div>
                     <label class="col-sm-6 col-lg-12 controls alert alert-warning">Note: Click On Marker to After Auto Complete Location To Save The Location</label>

                </div>
                </div>
                </div>
            <input type="hidden" name="json_location_point" value='{!! $deal_arr['json_location_point'] !!}' /> 







            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_active">Is Active <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-1 controls">
                    <select class="form-control" name="is_active" id="is_active" data-rule-required="">
                            <option value="1" {{ $deal_arr['is_active']=='1'?'selected="selected"':'' }}>Yes</option>
                            <option value="0" {{ $deal_arr['is_active']=='0'?'selected="selected"':'' }}>No</option>
                    </select>
                    <span class='help-block'>{{ $errors->first('is_active') }}</span>
                </div>
            </div>


            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update"onclick="return setExtraData()">

            </div>
        </div>


    </form>

    @endif

</div>
</div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
    tinymce.init({ selector:'textarea' });
    //tinymce.init('#page_desc');
</script>




<script type="text/javascript">
 var site_url = "{{url('/')}}";
function delete_gallery(id,image_name)
{
 var _token = $('input[name=_token]').val();
  var dataString = { id:id, image_name:image_name, _token: _token };
  //console.log(dataString);
  //return false;
  var url_delete= site_url+'/web_admin/deals_offers/delete_gallery';
  $.post( url_delete, dataString)
      .done(function( data ) {
        if(data=='done'){
             $('#err_delete_image').html('<div style="color:green">Deals slider images deleted successfully.</div>');
//             var request_id=$('.delete_image').parents('.main').attr('data-image');
             var request_id=image_name;
             //console.log(request_id);
             $('div[data-image="'+request_id+'"]').remove();
        }
      });
}
        $(document).ready(function () {
            $('#validation-form').submit( function () {
              tinyMCE.triggerSave();
                var image =  jQuery('#deal_image').val();
                if(image != "")
                {
                    var ext = image.split('.').pop().toLowerCase();
                    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
                    {
                        $("#image_err").fadeIn();
                        $("#image_err" ).html("* Please Select Image File !" );
                        $("#image_err").fadeOut(5000);
                        return false;
                    }
                }

                return true;
             });



$('#add-image').click(function()
{
   flag=1;

            var img_val = jQuery("input[name='deal_image[]']:last").val();

            var img_length = jQuery("input[name='deal_image[]']").length;

            if(img_val == "")
            {
                  $('#error_deal_image').css('margin-left','120px');
                  $('#error_deal_image').show();
                  $('#error_deal_image').fadeIn(3000);
                  document.getElementById('error_deal_image').innerHTML="The Image uploaded is required.";
                  setTimeout(function(){
                  $('#error_deal_image').fadeOut(4000);
                  },3000);

                 flag=0;
                 return false;
            }
            var chkimg = img_val.split(".");
             var extension = chkimg[1];

               if(extension!='jpg' && extension!='JPG' && extension!='png' && extension!='PNG' && extension!='jpeg' && extension!='JPEG'
                 && extension!='gif' && extension!='GIF')
               {
                 $('#error_deal_image1').css('margin-left','230px')
                 $('#error_deal_image1').show();
                 $('#error_deal_image1').fadeIn(3000);
                 document.getElementById('error_deal_image1').innerHTML="The file type you are attempting to upload is not allowed.";
                 setTimeout(function(){
                  $('#deal_image').css('border-color','#dddfe0');
                  $('#error_deal_image1').fadeOut(4000);
               },3000);
               flag=0;
                return false;
              }
              $("#error_deal_image").remove();
              var html='<div>'+
                       '<input type="file" name="deal_image[]" id="deal_image" class="pimg" data-rule-required="true"  />'+
                       '<div class="error" id="error_deal_image" style="color:red;">{{ $errors->first("deal_image") }}</div>'+
                       '</div>'+
                       '<div class="clr"></div><br/>'+
                       '<div class="error" id="error_set_default"></div>'+
                       '<div class="clr"></div>';
                  jQuery("#append").append(html);

});

$('#remove-image').click(function()
{
     var html= $("#append").find("input[name='deal_image[]']:last");
     html.remove();
            });
     $('.add_more').click(function(){
     $(".add_more_image").removeAttr("style");
     return false;
});

 });
function getSubCategory(ref)
{
   var main_cat_id =$(ref).find("option:selected").val();
   var categCheck  = $('#example-getting-started').multiselect
                      ({
                         includeSelectAllOption: true,
                         enableFiltering : true
                      });
    jQuery.ajax({
                        url:site_url+'/web_admin/common/get_subcategory/'+main_cat_id,
                        type:'GET',
                        data:'flag=true',
                        dataType:'json',
                        beforeSend:function()
                        {

                        },
                        success:function(response)
                        {
                           jQuery(response.arr_main_cat).each(function(index,arr_main_cat)
                                   {
                                          $("#business_public_id").attr('value',arr_main_cat.cat_ref_slug);
                                   });
                          var option = '';
                            if(response.status=="SUCCESS")
                            {
                                if(typeof(response.arr_sub_cat) == "object")
                                {
                                   var option = '';
                                   jQuery(response.arr_sub_cat).each(function(index,arr_sub_cat)
                                   {
                                    option+='<option value="'+arr_sub_cat.cat_id+'">'+arr_sub_cat.title+'</option>';

                                   });
                                   categCheck.html(option);
                                   categCheck.multiselect('rebuild');

                                }
                            }
                             else
                            {
                                //$(".multiselect-container").css("display",'none');
                                categCheck.html('<option value=""></option>');
                                $(".multiselect-selected-text").html("No Sub Category Available !");
                            }
                            return false;
                        }
        });

}
 $('.add_new_subcategory').click(function(){
 $(".add_new_subcategory_div").css('display','block');
     return false;
});
</script>

<script type="text/javascript">

    var dt_start_day;
    var dt_end_day;

    var tp_start_time;
    var tp_end_time;

    var arr_selected_category_dishes = [];

   /* $(document).ready(function()
    {

        bindDynamicDealCategory();

        dt_start_day = $('#start_day').datepicker();
        dt_end_day = $('#end_day').datepicker();

        //tp_start_time = $("#start_time").timepicker();
       // tp_end_time = $("#end_time").timepicker();

       // initStartAndEndDate();

        $(dt_start_day).on('changeDate',function(evt)
        {
           // $(dt_end_day).datepicker('setDate',getLastDayofWeek(evt.date));
        });

        $(tp_start_time).on('changeTime.timepicker',checkForInstantDeal);

        $(".category_dish").bind('change',function()
        {
            get_selected_category_dishes();
        });

    });
*/
  $(document).ready(function()
    {
          dt_start_day = $('#start_day').datepicker({
          minDate:new Date(),
          onSelect: function (dateText, inst) {
              $('#end_day').val('');
              $('#end_day').datepicker("option", "minDate", dateText);
          }           
         });
           
        dt_end_day = $('#end_day').datepicker({
        minDate:new Date(),
       
        });

      
    });
    function bindDynamicDealCategory()
    {
        $(".deal_category").unbind('change');
        $(".category_dish").unbind('change');
        $(".deal_category").bind('change',loadDishes);
        $(".category_dish").bind('change',function()
        {
            get_selected_category_dishes();
        });
    }

    function removeCategoryDish(ref)
    {
        var deal_dish_id = $(ref).attr('data-deal-dish-id');
        var token  = $('input[name="_token"]').val();
        var url    = "{{ url('/web_admin/deals/delete_dish/') }}/"+deal_dish_id+"?_token="+token;
       /* var ref_dish_select  = $(ref).parent('div')
                                     .parent('div.existing_deal_dish_section');*/


        jQuery.ajax({
                      url:url,
                      method:"GET",
                      dataType:"json",
                      success:function(response)
                      {
                            window.location.reload();
                      }
        });

    }

    function loadDishes()
    {
        var ref_cat_select = $(this);
        var cat_id         = $(ref_cat_select).val();
        var restaurant_id  = $('#restaurant_id').val();
        var token          = $('input[name="_token"]').val();
        var url            = "{{ url('/web_admin/deals/get_dishes/')}}/"+cat_id+"?_token="+token+"&loaded_dishes="+arr_selected_category_dishes+"&restaurant_id="+restaurant_id;
        var ref_dish_select  = $(ref_cat_select).parent('div')
                                                .next('label')
                                                .next('div.category_dish_section')
                                                .find('select.category_dish');


        //console.log(url);
        /* Ajax Call*/
        jQuery.ajax({
                    url:url,
                    method:"GET",
                    dataType:'json',
                    success:function(response)
                    {
                         var option = '<option value="">Select Dish</option>';
                           $.each(response,function(index,value)
                           {

                              option += "<option value="+value.id+">"+value.name+"</option>";

                           });
                           /*console.log(sub_cat_records);*/
                           $(ref_dish_select).html(option);
                           $(ref_dish_select).attr('data-selected-category',cat_id);

                    }

        });





        /*var tmp_category = {};
        tmp_category.cat_id = cat_id;
        tmp_category.loaded_dishes = 0;

        push_category(tmp_category);*/
    }

/*  function push_category(arr_tmp)
    {
        if(arr_already_added_dishes.length>0)
        {
            arr_already_added_dishes.sort( function( a, b){ return a.cat_id - b.cat_id; } );

            var is_dup = false;

            $.each(arr_already_added_dishes,function(index,obj)
            {
                if(obj.cat_id==arr_tmp.cat_id)
                {
                    is_dup = true;
                    return false;
                }
            });

            if(!is_dup)
            {
                arr_already_added_dishes.push(arr_tmp);
            }
        }
        else
        {
            arr_already_added_dishes.push(arr_tmp);
        }

    }*/

    function get_selected_category_dishes()
    {
        var arr_category_dish = $("select.category_dish");

        if(arr_category_dish.length>0)
        {
            $.each(arr_category_dish,function(index,obj)
            {
                /*arr_selected_category_dishes.push($(obj).val());*/
                if($(obj).val()!="NA")
                {
                    if($.inArray($(obj).val(), arr_selected_category_dishes)==-1)
                    {
                        arr_selected_category_dishes.push($(obj).val());
                    }

                }
            });


        }


    }

   /* function initStartAndEndDate()
    {

        //$(dt_start_day).datepicker('setDate',new Date());
       // $(dt_end_day).datepicker('setDate',getLastDayofWeek(new Date()));
    }
*/
    /* ie Sunday */
    function getLastDayofWeek(current)
    {
        var weekstart = current.getDate() - current.getDay() +1;    // get weekstart date
        var weekend   = current.getDate();    // current date=0 == weekstart then weekend==weekstart
        if(current.getDay()!=0)
        {
            var weekend = weekstart + 6;       // end day is the first day + 6
        }
        var monday = new Date(current.setDate(weekstart));
        var sunday = new Date(current.setDate(weekend));
        return sunday;
    }

    function isInstantDeal(ref)
    {
        var deal_type = $('#deal_type').val();
        if(deal_type==2)
        {
            var endTimeReadyonly = $('#end_time').prop('readonly', true);
            $('#end_time_id').hide();
            setEndTimeForInstantDeal();
            $('#instantDealNote').show();
        }
        else
        {
            var endTimeReadyonly = $("#end_time").prop("readonly",false);
             $('#end_time_id').show();
             $('#instantDealNote').hide();
        }
    }


    function checkForInstantDeal(evt)
    {
        var deal_type = $('#deal_type').val();
        if(deal_type==2)
        {
            setEndTimeForInstantDeal();
        }


        // var dt_next_hour = convertTimestampToDate(current_timestamp);
        // console.log(dt_next_hour.getHours());
    }

    function convertTimestampToDate(timestamp)
    {
        return new Date(timestamp*1000);
    }

    function setEndTimeForInstantDeal()
    {
        var hr_24= convert_to_24h($("#start_time").val());
        var current_date = new Date();
        current_date.setHours(hr_24.hours+2);
        current_date.setMinutes(hr_24.minutes);

        var next_hour = current_date.getHours();
        var next_min = current_date.getMinutes();

        next_hour = pad('00',next_hour,true);
        next_min = pad('00',next_min,true);

        $("#end_time").timepicker('setTime',convert_to_12h(next_hour+":"+next_min));

    }

    function convert_to_24h(time_str)
    {
        // Convert a string like 10:05 PM to 24h format, returns like [22,5,23]
        var time = time_str.match(/(\d+):(\d+) (\w)/);
        var hours = Number(time[1]);
        var minutes = Number(time[2]);
        var meridian = time[3].toLowerCase();

        if (meridian == 'p' && hours < 12) {
          hours = hours + 12;
        }
        else if (meridian == 'a' && hours == 12) {
          hours = hours - 12;
        }
        return {'hours':hours, 'minutes':minutes };
    }

    function convert_to_12h(timeString)
    {
        var H = +timeString.substr(0, 2);
        var h = (H % 12) || 12;
        var ampm = H < 12 ? " AM" : " PM";
        timeString = h + timeString.substr(2, 3) + ampm;
        return timeString;
    }

    function pad(pad, str, padLeft)
    {
      if (typeof str === 'undefined')
        return pad;
      if (padLeft) {
        return (pad + str).slice(-pad.length);
      } else {
        return (str + pad).substring(0, pad.length);
      }
    }

</script>
<script type="text/javascript">
  var site_url = "{{ url('/') }}";

  var departure_point_map               = false;
  var departure_point_autocomplete      = false;
  var departure_point_autocomplete_elem = $("#geocomplete")[0];
  var current_marker                    = false;
  var glob_arr_marker                   = [];
  var existing_lat_lng                  = [];
  var glob_info_window                  = false;

  /* Departure Point Map */
  function loadScript() 
  {
      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCccvQtzVx4aAt05YnfzJDSWEzPiVnNVsY&libraries=places&callback=initializeMap';
      document.body.appendChild(script);
  }

  window.onload = loadScript;

  function initExistingLatLng()
  {
    var extra_marker_latlng =false;
    var last_index = existing_lat_lng.length-1;
    $.each(existing_lat_lng,function(index,location)
    {
      var latlng = new google.maps.LatLng(location.lat, location.lng);

      current_marker = createMarker(departure_point_map,latlng);

      current_marker.place = location.place;

      glob_arr_marker.push(current_marker);

      if(index==last_index)
      {
        extra_marker_latlng = latlng;
        departure_point_map.setCenter(latlng);
        departure_point_map.setZoom(9);
      }
    });

    current_marker = createMarker(departure_point_map,extra_marker_latlng);
    
  }

  function initializeAutocompleteMap()
  {

    departure_point_autocomplete = new google.maps.places.Autocomplete(departure_point_autocomplete_elem);
    departure_point_autocomplete.bindTo('bounds', departure_point_map);

    departure_point_autocomplete.addListener('place_changed', function() 
    {
      // current_marker.setVisible(false);
      var place = departure_point_autocomplete.getPlace();
      if (!place.geometry) 
      {
        window.alert("Autocomplete's returned place contains no geometry");
        return;
      }

      if(markerExists(place.geometry.location))
      {
        alert("Departure Point Already Added ");
        $("#departure_point_input").val("");
        return false;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) 
      {
        departure_point_map.fitBounds(place.geometry.viewport);
      } else {
        departure_point_map.setCenter(place.geometry.location);
        departure_point_map.setZoom(17);  // Why 17? Because it looks good.
      }
      
      if(!current_marker)
      {
        current_marker = createMarker(departure_point_map,place.geometry.location);
      }
      

      current_marker.setPosition(place.geometry.location);
      current_marker.setVisible(true);

      var address = '';
      if (place.address_components) 
      {
        address = [
          (place.address_components[0] && place.address_components[0].short_name || ''),
          (place.address_components[1] && place.address_components[1].short_name || ''),
          (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
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
          overviewMapControlOptions: { opened: true },
          mapTypeId: google.maps.MapTypeId.HYBRID
      };

      departure_point_map = new google.maps.Map(document.getElementById("business_location_map"),
              myOptions);
      geocoder = new google.maps.Geocoder();
      departure_point_map.streetViewControl = false;

      glob_info_window = new google.maps.InfoWindow({
          content: "(1.10, 1.10)"
      });


      initializeAutocompleteMap();

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

  function stackCurrentLocation(close_infowindow,ref)
  {
    close_infowindow = close_infowindow | false;

    if(close_infowindow)
    {
      glob_info_window.close();
    }

    var parent_div = $(ref).parent("div");
    current_marker.place = $(parent_div).find("input[name='place']").val();

    if( current_marker.place.place<=0)
    {
      alert("Departure Time and Place Cannot be Empty ");
      return false;
    }
    
    glob_arr_marker.push(current_marker);
    current_marker = createMarker(departure_point_map,current_marker.position);

    $("#departure_point_input").val("");

    serializeDeparturePoints();

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

        html = "<div><input type='text' name='place' value='"+data.place+"' placeholder='Enter Location / Place' class='form-control'/> <br>"+
                  "<button type='button' onclick='updateMarkerData("+current_marker.position.lat()+","+current_marker.position.lng()+",this)' class='btn btn-danger btn-sm'>Update Info</button>&nbsp;&nbsp;"+
                "<button type='button' onclick='removeMaker()' class='btn btn-danger btn-sm'>Remove</button></div>";

        glob_info_window.setContent(html);
        glob_info_window.open(departure_point_map,this);  

      }
      else
      {
        html = "<div><input type='text' name='place' value='' placeholder='Enter Location /  Place' class='form-control'/> <br>"+
                "<button type='button' onclick='stackCurrentLocation(true,this)' class='btn btn-primary btn-sm'>Add</button></div>";

        glob_info_window.setContent(html);
        glob_info_window.open(departure_point_map,this);   
      }
      
    });

    return marker;
  }

  function updateMarkerData(lat,lng,ref)
  {
    var parent_div = $(ref).parent("div");

    var place = $(parent_div).find("input[name='place']").val();     

    if(departure_time.length<=0 || departure_time.place<=0)
    {
      alert("Departure Time and Place Cannot be Empty ");
      return false;
    }

    marker_index = getGlobMarkerIndexByLatLng(lat,lng);
    if(marker_index!==false)
    {
      glob_arr_marker[marker_index].departure_time = departure_time;
      glob_arr_marker[marker_index].place = place;
      glob_info_window.close();
    }

    serializeDeparturePoints();


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

  function getTotalGlobMarkers()
  {
    return glob_arr_marker.length ;
  }

  function removeMaker()
  {
    if(getTotalGlobMarkers()>0)
    {
      if(getTotalGlobMarkers()==1)
      {
        alert('Atleast One Location Point is required ');
        return false;
      }

      marker_index = getGlobMarkerIndexByLatLng(current_marker.position.lat(),current_marker.position.lng());

      if(marker_index!==false)
      {
        glob_arr_marker.splice(marker_index,1);
        current_marker.setMap(null);
      }
      serializeDeparturePoints();
    }
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

  function serializeDeparturePoints()
  {
    var arr_tmp = [];

    if(glob_arr_marker.length>0)
    {
      $.each(glob_arr_marker,function(index)
      {
          arr_tmp.push({lat:this.position.lat(),lng:this.position.lng(),place:this.place});
      });

      $('input[name="json_location_point"]').val(JSON.stringify(arr_tmp));
      return true;
    }
    else
    {
      alert('Please Provide Atleast one Departure Point');
      return false;
    }  

  }

  function setExtraData()
  {
      return tinyMCE.triggerSave(); 
  }

$(document).ready(function()
  {
    $('input[type="file"]').change(function()
    {
      var fileUpload = document.getElementById("deal_main_image");
      //Check whether the file is valid Image.
      var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
      if (regex.test(fileUpload.value.toLowerCase())) 
      {
          //Check whether HTML5 is supported.
          if (typeof (fileUpload.files) != "undefined") 
          {
              //Initiate the FileReader object.
              var reader = new FileReader();
              //Read the contents of Image File.
              reader.readAsDataURL(fileUpload.files[0]);
              reader.onload = function (e) 
              {
                //Initiate the JavaScript Image object.
                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;

                //Validate the File Height and Width.
                image.onload = function () 
                {
                  var height = this.height;
                  var width = this.width;
                  if (height < 400 && width < 1000) 
                  {
                    alert("Height must be:400px and Width must be :1000px.");
                   document.getElementById("deal_main_image").value = '';
                    return false;
                  }
                 // alert("Uploaded image has valid Height and Width.");
                  //$('#btn_save').show();
                  return true;
                };
              }
            } 
      }
      else
      {
        alert('Image Format not supoorted.Please select valid image');
        document.getElementById("deal_main_image").value = '';
        return false;
      }
    });  
    });  
  </script>

@stop