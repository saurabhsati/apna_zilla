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
                           value=""

                        />
                    <span class='help-block'>{{ $errors->first('password') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="address">Street Address<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea name="address" id="address" data-rule-required="true" class="form-control" placeholder="Enter Street Address" onblur="codeAddress()">{{ isset($arr_user_data['address'])?$arr_user_data['address']:'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('address') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="mobile">Mobile No<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" 
                           name="mobile_no" 
                           id="mobile" 
                           data-rule-required="true" 
                           placeholder="Enter Mobile No"
                           value="{{ isset($arr_user_data['mobile_no'])?$arr_user_data['mobile_no']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('mobile') }}</span>
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