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
            <li class="active"><i class="fa fa-plus"></i> Create</li>
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

          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/coupons/store') }}" enctype="multipart/form-data">

           {{ csrf_field() }}



           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Code<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                     <input class="form-control" data-placeholder="Coupon Code" data-rule-required="true" tabindex="1"
                       name="coupon_code" >

                    <span class='help-block'>{{ $errors->first('coupon_code') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Discount Type<i class="red">*</i></label>
                <div class="col-sm-3 col-lg-3 controls">
                     <select class="form-control" data-placeholder="Coupon Code" data-rule-required="true" tabindex="1"
                       name="discount_type" >
                       <option value="PERCENT">Percentage</option>
                       <option value="AMT">Amount (kn)</option>
                       </select>
                    <span class='help-block'>{{ $errors->first('discount_type') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Discount<i class="red">*</i></label>
                <div class="col-sm-2 col-lg-2 controls">
                     <input class="form-control" data-placeholder="Discount" data-rule-required="true" data-rule-digits="true" tabindex="1"
                       name="discount" >

                    <span class='help-block'>{{ $errors->first('discount') }}</span>
                </div>
            </div>


             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Start Date<i class="red">*</i></label>
                <div class="col-sm-2 col-lg-2 controls">
                     <input class="form-control start_date" data-placeholder="Start Date" data-rule-required="true" tabindex="1" name="start_date" readonly="readonly">

                    <span class='help-block'>{{ $errors->first('start_date') }}</span>
                </div>
            </div>



             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">End Date<i class="red">*</i></label>
                <div class="col-sm-2 col-lg-2 controls">
                     <input class="form-control end_date" data-placeholder="End Date" data-rule-required="true" tabindex="1" name="end_date" readonly="readonly">

                    <span class='help-block'>{{ $errors->first('end_date') }}</span>
                </div>
            </div>
             


            <br/><br/>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Add">
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

        $('input.start_date').datepicker();
     
        $('input.end_date').datepicker();

  });


    

</script>
<!-- END Main Content -->
 
@stop                    



