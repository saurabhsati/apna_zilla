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
                <a href="{{ url('/').'/web_admin/places' }}">Places</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-home"></i> Edit</li>
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
                action="{{ url('/web_admin/places/update/'.base64_encode($arr_place[0]['id'])) }}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}

           @if(sizeof($arr_place)>0)
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="country_code">Country Name <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="country_code" data-rule-required="true"
                        value="{{ isset($arr_place[0]['country_details']['country_name'])? strtoupper($arr_place[0]['country_details']['country_name']):'' }}" readonly
                    />
                    <span class='help-block'>{{ $errors->first('country_code') }}</span>
                </div>
            </div>

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="state_title">State name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="state_title" data-rule-required="true"
                        value="{{ isset($arr_place[0]['state_details']['state_title'])?$arr_place[0]['state_details']['state_title']:'' }}"  readonly
                     />
                    <span class='help-block'>{{ $errors->first('state_title') }}</span>
                </div>
            </div>


           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city_title">City name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="city_title" data-rule-required="true"
                        value="{{ isset($arr_place[0]['city_details']['city_title'])?$arr_place[0]['city_details']['city_title']:'' }}" readonly
                     />
                    <span class='help-block'>{{ $errors->first('city_title') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="place_name">Place name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="place_name" data-rule-required="true"
                        value="{{ isset($arr_place[0]['place_name'])?$arr_place[0]['place_name']:'' }}"
                     />
                    <span class='help-block'>{{ $errors->first('city_title') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="state">Postal Code<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="postal_code" data-rule-required="true"
                        value="{{ isset($arr_place[0]['postal_code'])?$arr_place[0]['postal_code']:'' }}"
                     />
                    <span class='help-block'>{{ $errors->first('postal_code') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="state">Latitude <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="latitude" data-rule-required="true"
                        value="{{ isset($arr_place[0]['latitude'])?$arr_place[0]['latitude']:'' }}"
                     />
                    <span class='help-block'>{{ $errors->first('latitude') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="longitude">longitude <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="longitude" data-rule-required="true"
                        value="{{ isset($arr_place[0]['longitude'])?$arr_place[0]['longitude']:'' }}"
                     />
                    <span class='help-block'>{{ $errors->first('longitude') }}</span>
                </div>
            </div>






            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update">

            </div>
        </div>
        @endif

    </form>
</div>
</div>
</div>
</div>
<!-- END Main Content -->


@stop
