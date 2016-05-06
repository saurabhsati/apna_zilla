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
                  <a href="{{ url('/').'/web_admin/offers/'.base64_encode($arr_deal['id']) }}">Offer</a>
               
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



          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/offers/store') }}" enctype="multipart/form-data">


           {{ csrf_field() }}
            
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="deal_name">Deal Name</label>
                <div class="col-sm-6 col-lg-4 controls">

                    <input class="form-control" name="deal_name" id="deal_name" value="{{ $arr_deal['name'] }}" readonly="true" data-rule-required="true" />

                    <span class='help-block'>{{ $errors->first('business_id') }}</span>
                </div>
            </div>
            <input class="form-control" name="deal_id" id="deal_id" type="hidden" data-rule-required="true" value="{{$arr_deal['id']}}" />
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
                <label class="col-sm-3 col-lg-2 control-label" for="main_price">Actual Price<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="main_price" id="main_price" data-rule-required="true" data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('main_price') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="discount">Discount<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="discount" id="discount" data-rule-required="true" data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('discount') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="discounted_price">Discounted Price<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="discounted_price" id="discounted_price" data-rule-required="true" data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('discount_price') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="limit">Limit<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="limit" id="limit" data-rule-required="true" data-rule-price="true"/>
                    <span class='help-block'>{{ $errors->first('limit') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label">Valid From<i style="color:red;">*</i></label>
                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input name="valid_from" id="valid_from" class="form-control" type="text"  size="16" data-rule-required="true"/>
                         <span class='help-block'>{{ $errors->first('valid_from') }}</span>
                    </div>
                </div>

                <label class="col-sm-3 col-lg-2 control-label">Valid Until</label>
                <div class="col-sm-5 col-lg-3 controls">
                    <div class="input-group date ">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input name="valid_until" id="valid_until" class="form-control" type="text"  size="16" data-rule-required="true"  value="" />
                        <span class='help-block'>{{ $errors->first('valid_until') }}</span>
                         
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
    tinymce.init({ selector:'textarea' });
    //tinymce.init('#page_desc');

</script>
<script type="text/javascript">
  
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
    $(document).ready(function()
    {

        dt_start_day = $('#valid_from').datepicker();
        dt_end_day = $('#valid_until').datepicker();

        //tp_start_time = $("#start_time").timepicker();
        //tp_end_time = $("#end_time").timepicker();

        /* Init Default Start and End Date */
        initStartAndEndDate();

        $(dt_start_day).on('changeDate',function(evt)
        {
            $(dt_end_day).datepicker('setDate',getLastDayofWeek(evt.date));
        });
     });   
</script>


@stop