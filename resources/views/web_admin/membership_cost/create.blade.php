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
                <i class="fa fa-text-width"></i>
                <a href="{{ url('/').'/web_admin/membershipcost' }}">Membership Cost</a>
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

          <form class="form-horizontal"
          id="validation-form"
          method="POST"
          action="{{ url('/web_admin/membershipcost/store')}}"
          >
           {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">Category <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <select class="form-control" name="category_id" id="category_id" >
                    <option value="" >Select Category</option>

                   @if(isset($arr_category) && sizeof($arr_category)>0)
                   @foreach($arr_category as $category)
                     <option value="{{ $category['cat_id'] }}" >
                      {{ $category['title'] }}
                    </option>
                   @endforeach
                    @endif
                  </select>

                    <span class='help-block'>{{ $errors->first('title') }}</span>
                </div>
            </div>



             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="premium_cost">Premium Cost<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="premium_cost"
                           id="premium_cost"
                           data-rule-required="true"
                            data-rule-min="0"
                           value="" />

                    <span class='help-block'>{{ $errors->first('premium_cost') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="gold_cost">Gold Cost<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="gold_cost"
                           id="gold_cost"
                           data-rule-required="true"
                           data-rule-min="0"
                           value="" />

                    <span class='help-block'>{{ $errors->first('gold_cost') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="basic_cost">Basic Cost<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="basic_cost"
                           id="basic_cost"
                           data-rule-required="true"
                            data-rule-min="0"
                           value="" />

                    <span class='help-block'>{{ $errors->first('basic_cost') }}</span>
                </div>
            </div>


           <!--  <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Price<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="price"
                           id="price"
                           data-rule-required="true"
                           {{-- data-rule-min="1"  --}}
                           value="{{ isset($arr_plan_data['price'])?$arr_plan_data['price']:'' }}" />

                    <span class='help-block'>{{ $errors->first('price') }}</span>
                </div>
            </div> -->





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
<!-- END Main Content -->

<script type="text/javascript">
    var site_url = "{{url('/')}}";


</script>
@stop