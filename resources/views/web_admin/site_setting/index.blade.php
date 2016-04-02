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
                <i class="fa fa-wrench"></i>
                <a href="{{ url('/').'/web_admin/site_settings' }}">Site Setting</a>
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
                <i class="fa fa-wrench"></i>
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

          @if(sizeof($arr_site_setting)>0)
          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/site_settings/update/'.base64_encode($arr_site_setting['site_settting_id'])) }} ' " enctype="multipart/form-data">

           {{ csrf_field() }}

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="website_name">Website Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="website_name" id="website_name" data-rule-required="true" value="{{ $arr_site_setting['site_name'] }}" />
                    <span class='help-block'>{{ $errors->first('website_name') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="address">Address<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="address" id="address" rows="5" data-rule-required="true"  >{{ $arr_site_setting['site_address'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('address') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="contact_number">Mobile Number<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="contact_number" id="contact_number" data-rule-required="true" value="{{ $arr_site_setting['site_contact_number'] }}" />
                    <span class='help-block'>{{ $errors->first('contact_number') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="phone_number">Phone Number<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="phone_number" id="phone_number" data-rule-required="true" value="{{ $arr_site_setting['phone_number'] }}" />
                    <span class='help-block'>{{ $errors->first('phone_number') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email">Email Id<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="email" id="email" data-rule-required="true" data-rule-email="true" value="{{ $arr_site_setting['site_email_address'] }}" />
                    <span class='help-block'>{{ $errors->first('email') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="map_iframe">Map Iframe<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="map_iframe" id="map_iframe" data-rule-required="true" >{{ $arr_site_setting['map_iframe'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('map_iframe') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="meta_keyword">Meta KeyWords<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" rows="5" data-rule-required="true" value="{{ $arr_site_setting['meta_keyword'] }}" />
                    <span class='help-block'>{{ $errors->first('meta_keyword') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="meta_desc">Meta Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="meta_desc" id="meta_desc" rows="5" data-rule-required="true" >{{ $arr_site_setting['meta_desc'] }}</textarea>
                    <span class='help-block'>{{ $errors->first('meta_desc') }}</span>
                </div>
            </div>
            <div class="form-group">
                           <label class="col-sm-3 col-lg-2 control-label">Site Status</label>
                           <div class="col-sm-6 col-lg-4 controls">
                              <label class="radio"> <input type="radio" value="1" {{ $arr_site_setting['site_status']=='1' ? 'checked':'' }} name="site_status"> Online </label>
                              <label class="radio"> <input type="radio" value="0" {{ $arr_site_setting['site_status']=='0' ? 'checked':'' }} name="site_status"> Offline </label>
                           </div>
                        </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="facebook_url">Facebook url<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="facebook_url" id="facebook_url" data-rule-required="true" data-rule-url="true" value="{{ $arr_site_setting['fb_url'] }}" />
                    <span class='help-block'>{{ $errors->first('facebook_url') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="twitter_url">Twitter url<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="twitter_url" id="twitter_url" data-rule-required="true"  data-rule-url="true"   value="{{ $arr_site_setting['twitter_url'] }}" />
                    <span class='help-block'>{{ $errors->first('twitter_url') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="youtube_url">Google+ Url<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="youtube_url" id="youtube_url" data-rule-required="true"   data-rule-url="true"  value="{{ $arr_site_setting['youtube_url'] }}" />
                    <span class='help-block'>{{ $errors->first('youtube_url') }}</span>
                </div>
            </div>


            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update">

            </div>
        </div>
    </form>
    @else
        <h4>No Records Found</h4>
    @endif
</div>
</div>
</div>
</div>
<!-- END Main Content -->
@stop