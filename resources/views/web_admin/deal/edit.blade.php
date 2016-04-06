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
                @if(isset($deal_arr['business_info']) && $deal_arr['business_info'] !='')
                    <a href="{{ url('/').'/web_admin/deals/'.base64_encode($deal_arr['business_info']['id']) }}">Deal</a>
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

        @if(isset($deal_arr) && sizeof($deal_arr)>0)
            <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/deals/update/'.base64_encode($deal_arr['id'])) }}" enctype="multipart/form-data">


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
                <label class="col-sm-3 col-lg-2 control-label" for="name">Deal Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="name" id="name" value="{{ $deal_arr['name'] }}" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('name') }}</span>
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
                <label class="col-sm-3 col-lg-2 control-label" for="description">Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="description" id="description" data-rule-required="true" rows="5">{{ $deal_arr['description'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('description') }}</span>
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


                           <input type="file" name="deal_image"  id="deal_image" class="file-input" data-rule-required=""/></span>


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
                        <input name="start_day" id="start_day" class="form-control" value="{{ date('m-d-Y',strtotime($deal_arr['start_day'])) }}" type="text"  size="16" data-rule-required="true"/>
                         <span class='help-block'>{{ $errors->first('start_day') }}</span>
                    </div>
                </div>

                <label class="col-sm-3 col-lg-2 control-label">End Day</label>
                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input name="end_day" id="end_day" class="form-control" type="text" value="{{ date('m-d-Y',strtotime($deal_arr['end_day'] ))}}"  size="16" data-rule-required="true" readonly="" />
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






            <hr/>
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
                <input type="submit"  class="btn btn-primary" value="Update">

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



            function newCategoryDishes(ref)
              {
                var field= "";

                //for multiple images
                //console.log(elements);
                //alert(elements);
                var parent_ref = jQuery(ref).parent('div.dish_deal');

                var field = field + '<div class="form-group dish_deal" id="new_div">'+
                                   '<label class="col-sm-3 col-lg-2 control-label deal_category_section" for="deal_category">Category<i class="red">*</i></label>' +
                                    '<div class="col-sm-6 col-lg-2 controls">'+
                                        '<select class="form-control deal_category" name="deal_category[]" id="deal_category" data-rule-required="">'+
                                               $("#deal_category").html()+
                                        '</select>'+
                                    '</div>'+
                                    '<label class="col-sm-1 col-lg-1 control-label" for="deal_dish">Dish<i class="red">*</i></label>'+
                                    '<div class="col-sm-4 col-lg-2 controls category_dish_section">'+
                                        '<select class="form-control category_dish" name="deal_dish[]" id="deal_dish" data-rule-required="" data-selected-category="">'+
                                                '<option value="NA">Select Dish</option>'+
                                        '</select>'+
                                        '<span class="help-block">{{ $errors->first("deal_dish") }}</span>'+
                                    '</div>'+

                                    '<label class="col-sm-1 col-lg-1 control-label" for="deal_quantity">Quantity<i class="red">*</i></label>'+
                                    '<div class="col-sm-6 col-lg-1 controls dish_quantity_section">'+
                                        '<input type="text" class="form-control dish_quantity" name="deal_quantity[]" id="deal_quantity" data-rule-required="">'+

                                        '<span class="help-block">{{ $errors->first("deal_quantity") }}</span>'+
                                    '</div>'+
                                    '<i class="fa fa-minus-square-o fa-2x" onclick="removeImage(this)"></i>'+
                                    '</div>';


                  //jQuery(field).insertAfter(parent_ref);
                 // jQuery(field).insertAfter("#new_div");
                 jQuery("#new_div").append(field);
                 bindDynamicDealCategory();
              }

              function removeImage(ref)
              {
                var parent_ref = jQuery(ref).parent('div.dish_deal');
                jQuery(parent_ref).remove();
              }
        </script>

<script type="text/javascript">

    var dt_start_day;
    var dt_end_day;

    var tp_start_time;
    var tp_end_time;

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

    $(document).ready(function()
    {

        bindDynamicDealCategory();

        dt_start_day = $('#start_day').datepicker();
        dt_end_day = $('#end_day').datepicker();

        tp_start_time = $("#start_time").timepicker();
        tp_end_time = $("#end_time").timepicker();

        /* Init Default Start and End Date */
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
        var cat_id = $(ref_cat_select).val();
        var restaurant_id = $('#restaurant_id').val();
        var token = $('input[name="_token"]').val();
        var url = "{{ url('/web_admin/deals/get_dishes/')}}/"+cat_id+"?_token="+token+"&loaded_dishes="+arr_selected_category_dishes+"&restaurant_id="+restaurant_id;
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


@stop