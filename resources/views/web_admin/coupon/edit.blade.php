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
                <i class="fa fa-cut"></i>
                <a href="{{ url('/').'/web_admin/coupons' }}">Coupon</a>
            </li>   
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-edit"></i> Edit</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-text-width"></i>
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

          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/coupons/update/'.$coupon_id) }}" enctype="multipart/form-data">

           {{ csrf_field() }}

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Code<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                     <input class="form-control" data-placeholder="Coupon Code" data-rule-required="true" tabindex="1"
                       name="coupon_code" value="{{ $arr_coupon['coupon_code'] }}" >

                    <span class='help-block'>{{ $errors->first('coupon_code') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Discount Type<i class="red">*</i></label>
                <div class="col-sm-3 col-lg-3 controls">
                     <select class="form-control" data-placeholder="Coupon Code" data-rule-required="true" tabindex="1"
                       name="discount_type" >
                       <option value="PERCENT" <?php if($arr_coupon['type'] == "PERCENT") { echo "selected"; } ?> >Percentage</option>
                       <option value="AMT" <?php if($arr_coupon['type'] == "AMT") { echo "selected"; } ?> >Amount</option>
                       </select>
                    <span class='help-block'>{{ $errors->first('discount_type') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Discount<i class="red">*</i></label>
                <div class="col-sm-2 col-lg-2 controls">
                     <input class="form-control" data-placeholder="Discount" data-rule-required="true" tabindex="1"
                       name="discount" value="{{ $arr_coupon['discount'] }}" >

                    <span class='help-block'>{{ $errors->first('discount') }}</span>
                </div>
            </div>


             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Start Date<i class="red">*</i></label>
                <div class="col-sm-2 col-lg-2 controls">
                     <input class="form-control start_date" data-placeholder="Start Date" data-rule-required="true" tabindex="1"
                       name="start_date" value="{{ date('m/d/Y',strtotime($arr_coupon['start_date']))   }}" readonly="readonly">

                    <span class='help-block'>{{ $errors->first('start_date') }}</span>
                </div>
            </div>



             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">End Date<i class="red">*</i></label>
                <div class="col-sm-2 col-lg-2 controls">
                     <input class="form-control end_date" data-placeholder="End Date" data-rule-required="true" tabindex="1" name="end_date" value="{{ date('m/d/Y',strtotime($arr_coupon['end_date']))   }}" readonly="readonly">

                    <span class='help-block'>{{ $errors->first('end_date') }}</span>
                </div>
            </div>


            <br/><br/>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update">
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>

<link rel="stylesheet" href="{{ url('/') }}/assets/PickMeUp/css/pickmeup.css" type="text/css" />
<script type="text/javascript" src="{{ url('/') }}/assets/PickMeUp/js/jquery.pickmeup.js"></script>

<script type="text/javascript">

var disabled_dates = [];
  $(document).ready(function()
  {
   
         $('input.start_date').pickmeup({
          position    : 'bottom',
          hide_on_select  : true,
          format:'d-m-Y',
          min: new Date(),
      
        });
     
        $('input.end_date').pickmeup({
          position    : 'bottom',
          hide_on_select  : true,
          format:'d-m-Y',
          min: new Date(),
         
        });
  });

  function getBetweenDates(start_date,end_date)
  {
    /*console.log(start_date);
    return;*/
    if(start_date.length>10 || start_date.length<10) return false;

    if(end_date.length>10 || end_date.length<10) return false;

    var arr_start_date = start_date.split('-');
    var arr_end_date = end_date.split('-');

    var tmp_yyyy;
    var tmp_mm;
    var tmp_dd;

    var obj_parse_start = parseDateString(arr_start_date);
    
    var dt_start_date = new Date(obj_parse_start.yyyy,obj_parse_start.mm,obj_parse_start.dd);

    var obj_parse_end = parseDateString(arr_end_date);
  
    var dt_end_date = new Date(obj_parse_end.yyyy,obj_parse_end.mm,obj_parse_end.dd);

    buildBetweenDates(dt_start_date,dt_end_date);
    
  }

  function parseDateString(arr_date)
  {
    var tmp = {};
    tmp.yyyy = parseInt(arr_date[2]);
    tmp.mm = parseInt(arr_date[1])-1;
    tmp.dd = parseInt(arr_date[0]);

    return tmp;
  }

  function buildBetweenDates(dt_start,dt_end)
  {
    if(dt_start instanceof Date ==false)
    {
      console.warn('Start Date not instance Date');
      return false;
    }

    if(dt_end instanceof Date ==false)
    {
      console.warn('End Date not instance Date');
      return false;
    }



    while (dt_start <= dt_end) 
    {
        disabled_dates.push(new Date(dt_start).getTime());
        dt_start.setDate(dt_start.getDate() + 1);
    }
  }
  
function initStartDate()
  {
    $('input.start_date').pickmeup({
      position    : 'bottom',
      hide_on_select  : true,
      format:'d-m-Y',
      render: function(date) {
              if ($.inArray(date.getTime(), disabled_dates) > -1){
                  return {
                      disabled   : true,
                      class_name : 'disabled'
                  }
              }
          },
      change:function(e)
      { 
        // reinitEndDatepicker(e);
      }
    });
  }

  function initEndDate()
  {
    $('input.end_date').pickmeup({
      position    : 'bottom',
      hide_on_select  : true,
      format:'d-m-Y',
      render: function(date) {
              if ($.inArray(date.getTime(), disabled_dates) > -1){
                  return {
                      disabled   : true,
                      class_name : 'disabled'
                  }
              }
          },
      change:function(e)
      { 
        // var start_date = $(this).parent('div').prev('div').find('input.start_date').val();
        var start_date = $('input.start_date').val();
        var end_date = e;

        getBetweenDates(start_date,end_date);

        
        
        $('input.start_date').pickmeup('destroy');
        $('input.end_date').pickmeup('destroy');

        initStartDate();  
        initEndDate();
      }
    });
  }

</script>
<!-- END Main Content -->
 
@stop                    



