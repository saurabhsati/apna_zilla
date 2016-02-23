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
            <li class="active">  {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
    </div>

    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->


    <div class="row">
        <div class="col-md-12">
            <div class="box ">
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
                        enctype="multipart/form-data"
                        id="validation-form"
                        method="POST"
                        action="{{ url('/web_admin/updateprofile')}}"
                        >
                            {{ csrf_field() }}
                        <div class="form-group">
                          <label class="col-sm-3 col-lg-2 control-label">Image Upload</label>
                          <div class="col-sm-9 col-md-10 controls">
                             <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">

                                   <img src="{{ url('/').config('app.project.img_path.user_profile_pic').'/'. $admin_arr['profile_pic'] }}" alt="" height="190px" width="190px" />
                                </div>
                                <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                   <span class="btn btn-file" ><span class="fileupload-new">Select image</span>
                                   <span class="fileupload-exists">Change</span>
                                   <input type="file" class="default" name="profile_pic" id="profile_pic"/>
                                   <input type="hidden" class="default" name="old_image" id="old_image" value="<?php //echo  $result[0]['admin_img'] ;?>"/>
                                   </span>
                                   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                             </div>
                             <span class="label label-important">NOTE!</span>
                             <span>Attached image img-thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only</span>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Email</label>
                            <div class="col-sm-9 col-lg-5 controls">
                                <input type="text"
                                 value="{{ $admin_arr['email'] }}"
                                 class="form-control"
                                 name="email"
                                 id="email"
                                 data-rule-required="true" disabled="true" />
                                <div class="error" id="error_admin_username" >{{ $errors->first('email') }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Phone</label>
                            <div class="col-sm-9 col-lg-5 controls">
                                <input type="text"
                                value="{{ $admin_arr['office_landline'] }}"
                                class="form-control"
                                name="office_landline"
                                id="office_landline"
                                data-rule-required="true" />
                                <div class="error" id="error_mobile_no" >{{ $errors->first('office_landline') }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Address</label>
                            <div class="col-sm-9 col-lg-5 controls">
                                <textarea  class="form-control"
                                name="street_address"
                                id="street_address"
                                data-rule-required="true" />{{ $admin_arr['street_address'] }}</textarea>
                                <div class="error" id="error_admin_address" ></div>
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