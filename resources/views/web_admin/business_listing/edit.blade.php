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
                <i class="fa fa-user"></i>
                <a href="{{ url('/').'/web_admin/business_listing' }}">Business Listing</a>
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
                <i class="fa fa-user"></i>
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

@if(isset($business_data) && sizeof($business_data)>0)
                  @foreach($business_data as $business)
        <form class="form-horizontal"
              id="validation-form"
              method="POST"
              action="{{ url('/web_admin/business_listing/update/'.base64_encode($business['id'])) }} ' "
              enctype="multipart/form-data">

           {{ csrf_field() }}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_name">Business Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="business_name"
                           id="business_name"
                           data-rule-required="true"
                           placeholder="Enter First Name"
                           value="{{ isset($business['business_name'])?$business['business_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('business_name') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_cat">Business Category<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <select class="form-control"
                           name="business_cat"
                           id="business_cat"
                           >
                            @if(isset($arr_category) && sizeof($arr_category)>0)
                            @foreach($arr_category as $category)
                             <option value="{{ $category['cat_id'] }}" {{ $category['cat_id']==$business['business_cat']?'selected="selected"':'' }}> {{  $category['cat_meta_keyword'] }}</option>
                            @endforeach
                            @endif
                           </select>
                    <span class='help-block'>{{ $errors->first('business_cat') }}</span>
                </div>
            </div>

            <input type="hidden" name="user_id" value="{{ isset($business['user_id'])?$business['user_id']:'' }}">
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">title<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="title"
                           id="title"
                           data-rule-required="true"
                           placeholder="Enter First Name"
                           value="{{ isset($business['user_details']['title'])?$business['user_details']['title']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('title') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="first_name">First Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="first_name"
                           id="first_name"
                           data-rule-required="true"
                           placeholder="Enter First Name"
                           value="{{ isset($business['user_details']['first_name'])?$business['user_details']['first_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('first_name') }}</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="last_name">Last Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="last_name"
                           id="last_name"
                           data-rule-required="true"
                           placeholder="Enter Last Name"
                           value="{{ isset($business['user_details']['last_name'])?$business['user_details']['last_name']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('last_name') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email">Email<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="email"
                           id="email"
                           data-rule-required="true"
                           data-rule-email="true"
                           placeholder="Enter Email"
                           value="{{ isset($business['user_details']['email'])?$business['user_details']['email']:'' }}" />

                    <span class='help-block'>{{ $errors->first('email') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">City<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="city"
                           id="city"
                           data-rule-required="true"
                           placeholder="Enter City"
                           value="{{ isset($business['user_details']['city'])?$business['user_details']['city']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="mobile_no">Mobile No<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="mobile_no"
                           id="mobile_no"
                           data-rule-required="true"
                           placeholder="Enter Mobile No"
                           value="{{ isset($business['user_details']['mobile_no'])?$business['user_details']['mobile_no']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('mobile_no') }}</span>
                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update">

            </div>
        </div>
      </form>
      @endforeach
@endif
</div>
</div>
</div>
</div>
<!-- END Main Content -->

<script type="text/javascript">
    var site_url = "{{url('/')}}";

    function loadPreviewImage(ref)
    {
        var file = $(ref)[0].files[0];

        var img = document.createElement("img");
        reader = new FileReader();
        reader.onload = (function (theImg) {
            return function (evt) {
                theImg.src = evt.target.result;
                $('#preview_profile_pic').attr('src', evt.target.result);
            };
        }(img));
        reader.readAsDataURL(file);
        $("#removal_handle").show();
    }

    function clearPreviewImage()
    {
        $('#preview_profile_pic').attr('src',site_url+'/images/front/avatar.jpg');
        $("#removal_handle").hide();
    }

</script>
@stop