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
                <a href="{{ url('/web_admin/business_listing') }}">Business  Listing</a>
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

        <form class="form-horizontal"
              id="validation-form"
              method="POST"
              action="{{ url('/web_admin/business_listing/store/') }}"
              enctype="multipart/form-data">

           {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="user_id">Select User<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <select class="form-control"  name="user_id" id="user_id">
                <option>Select User</option>
                 @if(isset($arr_user) && sizeof($arr_user)>0)
                 @foreach($arr_user as $user)
                 <option value="{{ isset($user['id'])?$user['id']:'' }}" >{{ isset($user['first_name'] )?$user['first_name']:'' }}
                 </option>
                  @endforeach
                  @endif
                  </select>
                    <span class='help-block'>{{ $errors->first('user_id') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="business_name">Business Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="business_name"
                           id="business_name"
                           data-rule-required="true"
                           placeholder="Enter Business Name"
                           value=""
                           />
                    <span class='help-block'>{{ $errors->first('business_name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">Business Category <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                   <select class="form-control"
                           name="business_cat"
                           id="business_cat"
                           >
                            @if(isset($arr_category) && sizeof($arr_category)>0)
                            <option>Select Business Category</option>
                            @foreach($arr_category as $category)
                             <option value="{{ $category['cat_id'] }}" > {{  $category['title'] }}</option>
                            @endforeach
                            @endif
                           </select>
                    <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>

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


</script>
@stop