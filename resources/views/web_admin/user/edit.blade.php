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
                <a href="{{ url('/').'/web_admin/users' }}">Users</a>
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

          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/users/update/'.base64_encode($arr_user_data['id'])) }} ' " enctype="multipart/form-data">


           {{ csrf_field() }}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Profile Pic</label>
                <div class="col-sm-6 col-lg-4 controls">
                    @if($arr_user_data['profile_pic']=="default.jpg")
                      <img src="{{$profile_pic_public_path.'/'.$arr_user_data['profile_pic']}}" width="200" height="200" id="preview_profile_pic"  />
                    @else
                      <img src="{{$profile_pic_public_path.'/'.$arr_user_data['profile_pic']}}" width="200" height="200" id="preview_profile_pic"  />
                    @endif  

                    @if($arr_user_data['profile_pic']!="default.jpg")
                      <span class="btn btn-danger" id="removal_handle" onclick="clearPreviewImage()">X</span>
                    @else  
                      <span class="btn btn-danger" id="removal_handle" onclick="clearPreviewImage()" style="display:none;">X</span>
                    @endif  
                    
                    <input class="form-control" name="profile_pic" id="profile_pic" type="file" onchange="loadPreviewImage(this)"/>

                    <span class='help-block'>{{ $errors->first('profile_pic') }}</span>
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
                           value="{{ isset($arr_user_data['first_name'])?$arr_user_data['first_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('first_name') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="middle_name">Middle Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="middle_name" 
                           id="middle_name" 
                           data-rule-required="true"
                           placeholder="Enter Middle Name"
                           value="{{ isset($arr_user_data['middle_name'])?$arr_user_data['middle_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('middle_name') }}</span>
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
                           value="{{ isset($arr_user_data['last_name'])?$arr_user_data['last_name']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('last_name') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="gender">Gender<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="gender" 
                           id="gender" 
                           data-rule-required="true" 
                           placeholder="Enter Gender"
                           value="{{ isset($arr_user_data['gender'])?$arr_user_data['gender']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('gender') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="marital_status">Marital Status<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="marital_status" 
                           id="marital_status" 
                           data-rule-required="true" 
                           placeholder="Enter Marital Status"
                           value="{{ isset($arr_user_data['marital_status'])?$arr_user_data['marital_status']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('marital_status') }}</span>
                </div>
            </div>

                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="d_o_b">Date Of Birth<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="d_o_b" 
                           id="d_o_b" 
                           data-rule-required="true" 
                           placeholder="Enter Date of Birth"
                           value="{{ isset($arr_user_data['d_o_b'])?$arr_user_data['d_o_b']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('d_o_b') }}</span>
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
                           value="{{ isset($arr_user_data['email'])?$arr_user_data['email']:'' }}" />

                    <span class='help-block'>{{ $errors->first('email') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="password">Password<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="password" 
                           class="form-control" 
                           name="password" 
                           id="password" 
                           data-rule-minlength="6" 
                           value="" />
                    <span class='help-block'>{{ $errors->first('password') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street_address">Street Address<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea name="street_address" 
                              id="street_address" 
                              data-rule-required="true" 
                              class="form-control" 
                              placeholder="Enter Street Address" 
                              onblur="codeAddress()">{{ isset($arr_user_data['street_address'])?$arr_user_data['street_address']:'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('street_address') }}</span>
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
                           value="{{ isset($arr_user_data['city'])?$arr_user_data['city']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>


             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="area">Area<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="area" 
                           id="area" 
                           data-rule-required="true" 
                           placeholder="Enter Area"
                           value="{{ isset($arr_user_data['area'])?$arr_user_data['area']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('area') }}</span>
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
                           value="{{ isset($arr_user_data['mobile_no'])?$arr_user_data['mobile_no']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('mobile_no') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="home_landline">Home Landline<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="home_landline" 
                           id="home_landline" 
                           data-rule-required="true" 
                           placeholder="Enter Home Landline No"
                           value="{{ isset($arr_user_data['home_landline'])?$arr_user_data['home_landline']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('mobile_no') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="mobile">Office Landline<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="office_landline" 
                           id="office_landline" 
                           data-rule-required="true" 
                           placeholder="Enter Office landline No"
                           value="{{ isset($arr_user_data['office_landline'])?$arr_user_data['office_landline']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('office_landline') }}</span>
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