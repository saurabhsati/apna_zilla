    @extends('sales_user.template.sales')


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
                <a href="{{ url('sales_user/dashboard') }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-user"></i>
                <a href="{{ url('/').'/sales_user/users' }}">Users</a>
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
                action="{{ url('/sales_user/users/store_user') }}"
                enctype="multipart/form-data"
                >


           {{ csrf_field() }}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Profile Pic</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <img src="{{url('/')}}/images/admin/avatar/avatar.jpg" width="200" height="200" id="preview_profile_pic"  />
                    <span class="btn btn-danger" id="removal_handle" style="display:none;" onclick="clearPreviewImage()">X</span>
                    <input class="form-control" name="profile_pic" id="profile_pic" type="file" onchange="loadPreviewImage(this)"/>

                    <span class='help-block'>{{ $errors->first('profile_pic') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="first_name">First Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="first_name" id="first_name" placeholder="Enter First Name " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('first_name') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="middle_name">Middle Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="middle_name" id="middle_name" placeholder="Enter Middle Name " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('middle_name') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="last_name">Last Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="last_name" id="last_name"  placeholder="Enter Last Name" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('last_name') }}</span>
                </div>
            </div>

              <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Gender</label>
                  <div class="col-sm-9 col-lg-10 controls">
                     <label class="radio">
                        <input type="radio" name="gender" value="male" /> Male
                     </label>
                     <label class="radio">
                        <input type="radio" name="gender" value="female" /> Female
                     </label>
                  <span class='help-block'>{{ $errors->first('gender') }}</span>
                 </div>
               </div>

             <div class="box-content">
               <div class="form-group">
                  <label class="cdol-sm-3 col-lg-2 control-label">DOB</label>
                  <div class="col-sm-5 col-lg-3 controls">
                     <input class="form-control date-picker" id="d_o_b" name="d_o_b" size="16" type="text" value="02-12-2012" />
                  </div>
                 <span class='help-block'>{{ $errors->first('d_o_b') }}</span>
               </div>
               </div>

                <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Marital Status</label>
                  <div class="col-sm-6 col-lg-4 controls">
                     <select class="form-control" data-placeholder="Choose a Category" name="marital_status" tabindex="1">
                        <option value="">Select...</option>
                        <option value="Married">Married</option>
                        <option value="Un Married">Un Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                     </select>
                    <span class='help-block'>{{ $errors->first('marital_status') }}</span>
                  </div>
               </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email">Email<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="email" id="email" data-rule-required="true" placeholder="Enter Email" data-rule-email="true"/>
                    <span class='help-block'>{{ $errors->first('email') }}</span>
               </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="password">Password<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="password" class="form-control" name="password" id="password"  data-rule-required="true" data-rule-minlength="6"/>
                    <span class='help-block'>{{ $errors->first('password') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street_address">Street Address<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea name="street_address" id="street_address" data-rule-required="true" placeholder="Enter Street Address" class="form-control" ></textarea>
                    <span class='help-block'>{{ $errors->first('street_address') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">City<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="city" id="city" placeholder="Enter City " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="area">Area<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="area" id="area"  placeholder="Enter Area " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('area') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="occupation">Occupation<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="occupation" id="occupation"  placeholder="Enter Occupation " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('occupation') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="work_experience">Work Experience<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="work_experience" id="work_experience"  placeholder="Enter Work Experience " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('work_experience') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="mobile_no">Mobile No<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="mobile_no" id="mobile_no"  placeholder="Enter Mobile No " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('mobile_no') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="home_landline">Home Landline<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="home_landline" id="home_landline"  placeholder="Enter Home Landline No " data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('home_landline') }}</span>
                </div>
            </div>

            <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label" for="office_landline">Office Landline<i class="red">*</i></label>
            <div class="col-sm-6 col-lg-4 controls">
                <input class="form-control" name="office_landline" id="office_landline"  placeholder="Enter Office Landline No " data-rule-required="true" />
                <span class='help-block'>{{ $errors->first('office_landline') }}</span>
            </div>
           </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit" class="btn btn-primary" value="Save and Continue">
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
