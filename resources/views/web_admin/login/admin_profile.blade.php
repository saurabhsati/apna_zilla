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
                <a href="{{ url().'/web-admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <!-- <li>
                <i class="fa fa-text-width"></i>
                <a href="{{ url().'/web-admin/faq' }}">FAQ</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span> -->
            <li class="active">  {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
    </div>

    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->


    <div class="row">
        <div class="col-md-12">
            <div class="box box-pink">
                <div class="box-title">
                    <h3><i class="fa fa-file"></i> Edit Profile</h3>
                    <div class="box-tool">
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
                        action="{{ url('/web-admin/update_profile')}}"
                        >
                            {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Username</label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="text" class="form-control" disabled  name="user_name"
                                value="{{ isset($arr_admin['user_name'])?$arr_admin['user_name']:'' }}"
                                 data-rule-required="true"
                                />
                                <span class='help-block'>{{ $errors->first('user_name') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">First Name</label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="text" class="form-control" name="first_name"
                                value="{{ isset($arr_admin['first_name'])?$arr_admin['first_name']:'' }}"
                                 data-rule-required="true"
                                />
                                <span class='help-block'>{{ $errors->first('first_name') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Last Name</label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="text" class="form-control" name="last_name"
                                value="{{ isset($arr_admin['last_name'])?$arr_admin['last_name']:'' }}"
                                 data-rule-required="true"
                                />
                                <span class='help-block'>{{ $errors->first('last_name') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Email</label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="text" class="form-control" name="email"
                                value="{{ isset($arr_admin['email'])?$arr_admin['email']:'' }}"
                                data-rule-required="true"
                                />
                                <span class='help-block'>{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Contact Number</label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="text" class="form-control" name="contact"
                                value="{{ isset($arr_admin['contact'])?$arr_admin['contact']:'' }}"
                                data-rule-required="true"
                                />
                                <span class='help-block'>{{ $errors->first('contact') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- END Main Content -->


@stop