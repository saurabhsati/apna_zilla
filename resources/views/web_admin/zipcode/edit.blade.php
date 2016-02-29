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
                <i class="fa fa-desktop"></i>
                <a href="{{ url('/').'/web_admin/zipcode' }}">Zipcode</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-desktop"></i> Edit</li>
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
                action="{{ url('/web_admin/zipcode/update/'.base64_encode($arr_zipcode[0]['id'])) }}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}


             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="zipcode"> ZipCode<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                     name="zipcode"
                     data-rule-required="true"
                     value="{{ isset($arr_zipcode[0]['zipcode'])? strtoupper($arr_zipcode[0]['zipcode']):'' }}"

                    />
                    <span class='help-block'>{{ $errors->first('country_code') }}</span>
                </div>
            </div>

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="state">Country Code<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input
                     class="form-control"
                     name="country_code"
                     data-rule-required="true"
                     value="{{ isset($arr_zipcode[0]['country_code'])?$arr_zipcode[0]['country_code']:'' }}"
                     readonly
                     />
                    <span class='help-block'>{{ $errors->first('state') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="latitude">Latitude<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                     name="latitude"
                     data-rule-required="true"
                     value="{{ isset($arr_zipcode[0]['latitude'])? strtoupper($arr_zipcode[0]['latitude']):'' }}"

                    />
                    <span class='help-block'>{{ $errors->first('country_code') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="longitude">Longitude<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                     name="longitude"
                     data-rule-required="true"
                     value="{{ isset($arr_zipcode[0]['longitude'])? strtoupper($arr_zipcode[0]['longitude']):'' }}"

                    />
                    <span class='help-block'>{{ $errors->first('country_code') }}</span>
                </div>
            </div>
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
<!-- END Main Content -->


@stop
