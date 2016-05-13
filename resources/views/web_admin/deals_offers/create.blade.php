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
                  <a href="{{ url('/web_admin/deals_offers/') }}">Deals</a>
               
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



          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/deals_offers/store') }}" enctype="multipart/form-data">


           {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="user_id">Select User Unique Public Id<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <input class="form-control"
                           name="user_id"
                           id="user_id"
                           data-rule-required="true"
                           placeholder="Enter User Public ID"

                           />
                  <input type="hidden" name="tmp_user_id" id="tmp_user_id">

                    <span class='help-block'>{{ $errors->first('user_id') }}</span>
                     <div class="alert alert-warning">Note: Auto Complete the User Public Id field by typing prefix RNT- </div>
                </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="main_business_cat">Select Business   <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls"  style="">
            <select class="form-control" id="business" name="business">
            <option value="">Select Business Public Id </option>
               </select>
              <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                <div class="alert alert-warning">Note:  Select The Business Public ID</div>

            </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="main_business_cat">Deal Main Category <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls">
            <select class="form-control" name="main_business_cat" id="main_business_cat" onchange="getSubCategory(this)">
              <option> Select Deal Main Categories</option>
             @if(isset($arr_main_category) && sizeof($arr_main_category)>0)
             @foreach($arr_main_category as $category)
              <option  name="sub_cat" id="sub_cat" value="{{ $category['cat_id'] }}" >
                             {{ $category['title'] }}
                              </option>
              @endforeach
               @endif
            </select>
            </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label" for="main_business_cat">Deal Sub Category <i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls" id="sub_category_div" name="sub_category_div" style="">
            <select class="form-control" id="example-getting-started" name="business_cat[]" multiple="multiple">
            <option value="">Select Deal Sub Category </option>
             </select>
              <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                <div class="alert alert-warning">Note: Firstly Select The Deal Main category From Deal Main Category Drop-down , Then Click ON None Selected Button  </div>

            </div>
            </div>
          <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="deal_main_image">Deal Image<i class="red">*</i></label>
                  <div class="col-sm-6 col-lg-5 controls">
                     <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                           <img src="{{ url('/') }}/images/front/default_category.png" alt=""  height="150px" width="180px" />
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                           <span class="btn btn-default btn-file"><span class="fileupload-new">Select Photo</span>
                           <span class="fileupload-exists">Change</span>


                           <input type="file" name="deal_main_image"  id="deal_main_image" class="file-input" data-rule-required="true"/></span>


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
            <div class="col-sm-5 col-md-7" style="float:right;">
               <a href="javascript:void(0);" id='add-image'>
                   <span class="glyphicon glyphicon-plus-sign" style="font-size: 20px;" class="show-tooltip" title="Add More images"></span>
               </a>
              <span style="margin-left:05px;">
              <a href="javascript:void(0);" id='remove-image'>
                  <span class="glyphicon glyphicon-minus-sign" style="font-size: 20px;" class="show-tooltip" title="Remove last selected  images"></span>
              </a>
              </span>
             </div>

                <label class="col-sm-3 col-lg-2 control-label">Upload Deal Slider Images <i class="red">*</i> </label>
                <div class="col-sm-6 col-lg-4 controls">

                <input type="file" name="deal_image[]" id="deal_image" class="pimg" data-rule-required="true"  />
                <div class="error" id="error_deal_image">{{ $errors->first('deal_image') }}</div>

                <div class="clr"></div><br/>
                  <div class="error" id="error_set_default"></div>
                  <div class="clr"></div>

               <div id="append" class="class-add"></div>
                <div class="error_msg" id="error_deal_image" ></div>
                <div class="error_msg" id="error_deal_image1" ></div>
               <label class="col-sm-6 col-lg-12 controls alert alert-warning">Note: Attached Image Size With Width 517px and Height 361px upto only</label>

                </div>

                </div>
            

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="name" id="name" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">Title<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="title" id="title" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('title') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Actual Price<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="price" id="price" data-rule-required="true" data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('price') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="discount_price">Discount<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="discount_price" id="discount_price" data-rule-required="true" data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('discount_price') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="deal_type">Deal Type<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-3 controls">
                    <select class="form-control" name="deal_type" id="deal_type" onchange="isInstantDeal(this)" data-rule-required="true">
                            <option value="">Select Deal</option>
                            <option value="1" selected="selected">Normal Deal</option>
                           <!--  <option value="2">Instant Deal</option>
                            <option value="3">Featured Deal</option> -->
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
                        <input name="start_day" id="start_day" class="form-control" type="text"  size="16" data-rule-required="true"/>
                         <span class='help-block'>{{ $errors->first('start_day') }}</span>
                    </div>
                </div>

                <label class="col-sm-3 col-lg-2 control-label">End Day</label>
                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input name="end_day" id="end_day" class="form-control" type="text"  size="16" data-rule-required="true"  value="" />
                        <span class='help-block'>{{ $errors->first('end_day') }}</span>
                         
                    </div>
                </div>

            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="description">Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="description" id="description" data-rule-required="true" rows="5"></textarea>
                    <span class='help-block'>{{ $errors->first('description') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="things_to_remember">Things to Remember<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="things_to_remember" id="things_to_remember" data-rule-required="true" rows="5"></textarea>
                    <span class='help-block'>{{ $errors->first('things_to_remember') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="how_to_use">How to use the offer<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="how_to_use" id="how_to_use" data-rule-required="true" rows="5"></textarea>
                    <span class='help-block'>{{ $errors->first('how_to_use') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="about">About<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="about" id="about" data-rule-required="true" rows="5"></textarea>
                    <span class='help-block'>{{ $errors->first('about') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="facilities">Facilities<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="facilities" id="facilities" data-rule-required="true" rows="5"></textarea>
                    <span class='help-block'>{{ $errors->first('facilities') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="cancellation_policy">Cancellation Policy<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="cancellation_policy" id="cancellation_policy" data-rule-required="true" rows="5"></textarea>
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
                     <label class="col-sm-6 col-lg-12 controls alert alert-warning">Note: Click On Marker to Create Auto Complte Location</label>

                </div>
                </div>

    </div>

<input type="hidden" name="json_location_point" value="" /> 

         
            
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_active">Is Active <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-1 controls">
                    <select class="form-control" name="is_active" id="is_active" data-rule-required="">
                            <option value="1" selected="selected">Yes</option>
                            <option value="0">No</option>
                    </select>
                    <span class='help-block'>{{ $errors->first('is_active') }}</span>
                </div>
            </div>


            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Create">

            </div>
        </div>


    </form>
</div>
</div>
</div>
</div>
<!-- END Main Content -->



<script type="text/javascript">

         $(document).ready(function () {
            $('#validation-form').submit( function () {
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
        });



        </script>
<script type="text/javascript">
    tinymce.init({ selector:'textarea' });
    //tinymce.init('#page_desc');
</script>
<script type="text/javascript">
 var url = "{{ url('/') }}";
</script>
<script type="text/javascript">

    var dt_start_day;
    var dt_end_day;

   var tp_start_time;
    var tp_end_time;

    
    function addMoreDeals(ref)
    {
        //var field= "";
        var elements = 1;
        //console.log(elements);
        //alert(elements);
        var parent_ref = jQuery(ref).parent('div.add_deals');
        alert('check');

        var field = field + '<input type="text"/>';


         jQuery(field).insertAfter(parent_ref);
    }

    $(document).ready(function()
    {
        dt_start_day = $('#start_day').datepicker();
        dt_end_day = $('#end_day').datepicker();

        //tp_start_time = $("#start_time").timepicker();
        //tp_end_time = $("#end_time").timepicker();

        /* Init Default Start and End Date */
        initStartAndEndDate();

        $(dt_start_day).on('changeDate',function(evt)
        {
            $(dt_end_day).datepicker('setDate',getLastDayofWeek(evt.date));
        });

        $(tp_start_time).on('changeTime.timepicker',checkForInstantDeal);

       

    });

   
    function initStartAndEndDate()
    {

        $(dt_start_day).datepicker('setDate',new Date());
        $(dt_end_day).datepicker('setDate',getLastDayofWeek(new Date()));
    }

    /* ie Sunday */
    function getLastDayofWeek(current)
    {
        var weekstart = current.getDate() - current.getDay() +1;    // get weekstart date
        var weekend = current.getDate();    // current date=0 == weekstart then weekend==weekstart
        if(current.getDay()!=0)
        {
            var weekend = weekstart + 6;       // end day is the first day + 6
        }
        var monday = new Date(current.setDate(weekstart));
        var sunday = new Date(current.setDate(weekend));
        return sunday;
    }

    function isInstantDeal(ref)///Instant deal hide end time
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
function getSubCategory(ref)
{
   var main_cat_id =$(ref).find("option:selected").val();
   var categCheck  = $('#example-getting-started').multiselect
                      ({
                         includeSelectAllOption: true,
                         enableFiltering : true
                      });
      categCheck.html('');
    jQuery.ajax({
                        url:url+'/web_admin/common/get_subcategory/'+main_cat_id,
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
                                  //$(".multiselect-container").css("display",'block');
                                  // var option = '';
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


$(document).ready(function()
{
 var site_url="{{url('/')}}";
 var csrf_token = "{{ csrf_token() }}";
 $("#user_id").autocomplete(
          {
            minLength:3,
            source:site_url+"/web_admin/common/get_public_id",
            search: function( event, ui )
            {
             /* if(category==false)
              {
                  alert("Select Category First");
                  event.preventDefault();
                  return false;
              }*/
            },
            select:function(event,ui)
            {
               $("#user_id").attr('value',ui.item.user_id);
               $("#tmp_user_id").attr('value',ui.item.user_id);
               var user_id=ui.item.user_id;
                 jQuery.ajax({
                                        url:site_url+'/web_admin/deals_offers/get_business_by_user/'+user_id,
                                        type:'GET',
                                        data:'flag=true',
                                        dataType:'json',
                                        beforeSend:function()
                                        {
                                            jQuery('select[name="business"]').attr('disabled','disabled');
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
                                              
                                                if(typeof(response.business_listing) == "object")
                                                {
                                                   jQuery('select[name="business"]').removeAttr('disabled');
                                                   jQuery(response.business_listing).each(function(index,business_listing)
                                                   {
                                                    option+='<option value="'+business_listing.id+'">'+business_listing.busiess_ref_public_id+'</option>';

                                                   });

                                                  
                                                   jQuery('select[name="business"]').html(option);
                                                 
                                                }
                                                
                                            

                                            }
                                            else
                                            {
                                                //$(".multiselect-container").css("display",'none');
                                                jQuery('select[name="business"]').html('<option value="">No Business Availabel</option>');
                                                //$(".multiselect-selected-text").html("No Sub Category Available !");
                                            }
                                            return false;
                                        }
                        });

               


             },
            response: function (event, ui)
            {
               // alert('response');
            }
            }).data("ui-autocomplete")._renderItem = function (ul, item)
            {
                 return $("<li></li>")
                 .data("item.autocomplete", item)
                 .append( item.label +'<span style="color:#7b7b7b"> '+item.span+'</span>')
                 .appendTo(ul);
                  
           };

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
              var html='<div>'+
                       '<input type="file" name="deal_image[]" id="deal_image" class="pimg" data-rule-required="true"  />'+
                       '<div class="error" id="error_deal_image">{{ $errors->first("deal_image") }}</div>'+
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


           
 });          
</script>
  

<script type="text/javascript">
  var site_url = "{{ url('/') }}";

  var departure_point_map = false;
  var departure_point_autocomplete = false;
  var departure_point_autocomplete_elem = $("#geocomplete")[0];
  var current_marker = false;
  var glob_arr_marker = [];
  var glob_info_window = false;



  /* Departure Point Map */
  function loadScript() 
  {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCccvQtzVx4aAt05YnfzJDSWEzPiVnNVsY&libraries=places&callback=initializeMap';
        document.body.appendChild(script);
    }

  window.onload = loadScript;

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
      var latlng = new google.maps.LatLng(20.5937, 78.9629);
      var myOptions = {
          zoom: 7,
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


      initializeAutocompleteMap();
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

    if(current_marker.place.place<=0)
    {
      alert("Place Cannot be Empty ");
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
        html = "<div><input type='text' name='place' value='' placeholder='Enter Location / Place' class='form-control'/> <br>"+
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

    var departure_time  = $(parent_div).find("input[name='departure_time']").val();
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
        alert('Atleast One Departure Point is required ');
        return false;
      }

      marker_index = getGlobMarkerIndexByLatLng(current_marker.position.lat(),current_marker.position.lng());

      if(marker_index)
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
  

</script>
@stop