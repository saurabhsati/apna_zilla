    @extends('web_admin.template.admin')


    @section('main_content')
    {{dd('i m here')}}
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
                @if(sizeof($arr_business)>0)
                    <a href="{{ url('/').'/web_admin/deals/'.base64_encode($arr_business['id']) }}">Deal</a>
                @endif
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



          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/deals/store') }}" enctype="multipart/form-data">


           {{ csrf_field() }}

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="restaurant_id">Business Name</label>
                <div class="col-sm-6 col-lg-4 controls">
                     @if(sizeof($arr_business)>0)
                    <select class="form-control" name="business_id" id="business_id" data-rule-required="true" disabled="disabled">
                       <option value="{{ $arr_business['id'] }}">{{ $arr_business['business_name'] }}</option>
                    </select>

                    <input type="hidden" name="business_hide_id" id="business_hide_id" value="{{ $arr_business['id'] }}" />
                     <input type="hidden" name="parent_category_id" id="parent_category_id" value="{{ $parent_category_id }}" />
                     @endif
                    <span class='help-block'>{{ $errors->first('restaurant_id') }}</span>
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
                <label class="col-sm-3 col-lg-2 control-label" for="description">Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="description" id="description" rows="5" data-rule-required="true"></textarea>
                    <span class='help-block'>{{ $errors->first('description') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="deal_image">Deal Image<i class="red">*</i></label>
                  <div class="col-sm-6 col-lg-5 controls">
                     <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                           <img src="{{ url('/') }}/images/front/default_category.png" alt=""  height="150px" width="180px" />
                        </div>
                        <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                           <span class="btn btn-default btn-file"><span class="fileupload-new">Select Photo</span>
                           <span class="fileupload-exists">Change</span>


                           <input type="file" name="deal_image"  id="deal_image" class="file-input" data-rule-required="true"/></span>


                           <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>


                            <span class='help-block'>{{ $errors->first('deal_image') }}</span>

                        </div>
                     </div>

                     <span class="label label-important">NOTE!</span>
                        <span>Attached image img-thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only</span>
                  </div>
                  <span id="image_err" style="color:red;margin-bottom:10px;font-size:12px;"></span>
            </div>
            <hr/>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="deal_type"></label>
                <div class="col-sm-6 col-lg-5 controls">
                    <h4><b>Deal Types</b></h4>
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
                        <input name="start_day" id="start_day" class="form-control" type="text"  size="16" data-rule-required="true" data-date-end-date="0d"/>
                         <span class='help-block'>{{ $errors->first('start_day') }}</span>
                    </div>
                </div>

                <label class="col-sm-3 col-lg-2 control-label">End Day</label>
                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input name="end_day" id="end_day" class="form-control" type="text"  size="16" data-rule-required="true" data-date-end-date="0d"  value="" />
                        <span class='help-block'>{{ $errors->first('end_day') }}</span>
                         <input type="hidden" name="expired_date" id="expired_date" value="{{date('m/d/Y',strtotime($expired_date))}}">
                    </div>
                </div>

            </div>

         

            <hr/>
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
        });



</script>
<script type="text/javascript">
    tinymce.init({ selector:'textarea' });
    //tinymce.init('#page_desc');
</script>

<script type="text/javascript">

    var dt_start_day;
    var dt_end_day;

   // var tp_start_time;
    //var tp_end_time;

    var arr_selected_category_dishes = [];

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

   /* $(document).ready(function()
    {

        bindDynamicDealCategory();

        dt_start_day = $('#start_day').datepicker({
                  dateFormat: "mm-dd-yyyy",
                  minDate: 0,
            });
        dt_end_day = $('#end_day').datepicker();

        //tp_start_time = $("#start_time").timepicker();
        //tp_end_time = $("#end_time").timepicker();

       
        initStartAndEndDate();

        $(dt_start_day).on('changeDate',function(evt)
        {
            $(dt_end_day).datepicker('setDate',getLastDayofWeek(evt.date));
        });

        $(tp_start_time).on('changeTime.timepicker',checkForInstantDeal);

        $(".category_dish").bind('change',function()
        {
            get_selected_category_dishes();
        });

    });*/

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

    function loadDishes()///Load dishes by ajax call
    {
        var ref_cat_select = $(this);
        var cat_id = $(ref_cat_select).val();
        var restaurant_id = $('#restaurant_hide_id').val();
        var token = $('input[name="_token"]').val();
        tmp_arr_selected_category_dishes = arr_selected_category_dishes;
        if(arr_selected_category_dishes.length<=0)
        {
            tmp_arr_selected_category_dishes = "NA";
        }
        var url = "{{ url('/web_admin/deals/get_dishes/')}}/"+cat_id+"?_token="+token+"&loaded_dishes="+tmp_arr_selected_category_dishes+"&restaurant_id="+restaurant_id;
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


    $( document ).ready( function () {
         $('#validation-form').submit(function() {
            if($('#deal_category').val() == 'NA')
            {
                alert('Please Select Category.');
            }

            if($('#deal_dish').val() == 'NA')
            {
                alert('Please Select Dish.')
            }

         });
    });


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

</script>



@stop
