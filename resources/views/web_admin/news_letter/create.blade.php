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
                <i class="fa fa-edit"></i>
                <a href="{{ url('/').'/web_admin/newsletter' }}">News Letter</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-desktop"></i> Create</li>
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
                action="{{ url('/web_admin/newsletter/store') }}"
                enctype="multipart/form-data"
          >


           {{ csrf_field() }}



           <!--  <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="text" class="form-control" id="name" name="name" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('name') }}</span>
                </div>
            </div> -->


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_address">Email Address<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="email" name="email_address" id="email_address" class="form-control" data-rule-required="true" data-rule-email="true">
                   <span class='help-block'>{{ $errors->first('email_address') }}</span>
               </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_active">Status </label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="checkbox"  name="is_active" value="1"
                      />
                    <span class='help-block'>{{ $errors->first('is_active') }}</span>
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

@stop