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
                <a href="{{ url('/').'/web_admin/sales_user' }}">Sales Executive</a>
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
              action="{{ url('/web_admin/sales_user/update/'.base64_encode($arr_user_data['id'])) }} ' "
              enctype="multipart/form-data">

           {{ csrf_field() }}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Profile Picture</label>
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
                <label class="col-sm-3 col-lg-2 control-label" for="last_name">Last Name<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="last_name"
                           id="last_name"
                           data-rule-required=""
                           placeholder="Enter Last Name"
                           value="{{ isset($arr_user_data['last_name'])?$arr_user_data['last_name']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('last_name') }}</span>
                </div>
            </div> 


             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="gender">Gender<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                <label class="radio">
                        <input type="radio" name="gender" {{ $arr_user_data['gender']=='male'?"checked":'' }} value="male" /> Male
                     </label>
                     <label class="radio">
                        <input type="radio" name="gender" {{ $arr_user_data['gender']=='female'?"checked":'' }} value="female" /> Female
                     </label>
                  <span class='help-block'>{{ $errors->first('gender') }}</span>
                </div>
            </div>

         

                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="d_o_b">Date Of Birth<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                  <input class="form-control date-picker"
                           name="d_o_b"
                           id="d_o_b"
                           data-rule-required="true"
                           placeholder="Enter Date of Birth"
                           data-date-format="dd-mm-yyyy"
                           value="{{ date('d-m-Y',strtotime($arr_user_data['d_o_b'])) }}"/>
                    <span class='help-block'>{{ $errors->first('d_o_b') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="marital_status">Marital Status<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">

                      <select class="form-control" data-placeholder="Choose a Category" name="marital_status" tabindex="1" onchange="chkeck_marital_status(this);">
                        <option value="" >Select...</option>
                        <option value="Married" {{ $arr_user_data['marital_status']=='Married'?"selected ='selected'":'' }}>Married</option>
                        <option value="Un Married" {{ $arr_user_data['marital_status']=='Un Married'?"selected='selected'":'' }}>UnMarried</option>
                       
                     </select>
                    <span class='help-block'>{{ $errors->first('marital_status') }}</span>
                </div>
            </div>
          @if($arr_user_data['marital_status']=='Married')
          <div class="form-group" style="" id="div_married_date" name="div_married_date">
                <label class="col-sm-3 col-lg-2 control-label" for="married_date">Married Date<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="married_date" id="married_date" data-rule-required="" placeholder="Enter Married  Date" value="{{ date('d-m-Y',strtotime($arr_user_data['married_date'])) }}"/>
                    <span class='help-block'>{{ $errors->first('married_date') }}</span>
               </div>
            </div>
            @endif
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
                <label class="col-sm-3 col-lg-2 control-label" for="password">Password<i class="red"></i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input type="text"
                           class="form-control"
                           name="password"
                           id="password"
                           data-rule-minlength="6"
                           value="" />
                    <span class='help-block'>{{ $errors->first('password') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="mobile_no">Mobile No<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="mobile_no"
                           id="mobile_no"
                           data-rule-required="true" data-rule-number="true"   data-rule-minlength="10" maxlength="10" 
                           placeholder="Enter Mobile No"
                           value="{{ isset($arr_user_data['mobile_no'])?$arr_user_data['mobile_no']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('mobile_no') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="street">State <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control"  name="state" id="state" tabindex="1" onchange="loadCity(this)">
                 @if(isset($arr_state) && sizeof($arr_state)>0)
                   @foreach($arr_state as $state)
                <option value="{{ isset($state['id'])?$state['id']:'' }}" {{ $arr_user_data['state']==$state['id']?'selected="selected"':'' }}>{{ isset($state['state_title'])?$state['state_title']:'' }}
                </option>
                @endforeach
                @endif
                </select>
                 <span class='help-block'>{{ $errors->first('street') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">City <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control"  name="city" id="city" onchange="loadpostalcode(this)">
                 @if(isset($arr_city) && sizeof($arr_city)>0)
                   @foreach($arr_city as $city)
                <option value="{{ isset($city['id'])?$city['id']:'' }}" {{ $arr_user_data['city']==$city['id']?'selected="selected"':'' }}>{{ isset($city['city_title'])?$city['city_title']:'' }}
                </option>
                @endforeach
                @endif
                </select>
                  <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="city">Zipcode<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="pincode"
                           id="pincode"
                           data-rule-required="true"
                           placeholder="Enter Zipcode"
                           value="{{ isset($arr_user_data['pincode'])?$arr_user_data['pincode']:'' }}"/>
                    <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>
       
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="area">Area<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control"
                           name="area"
                           id="area"
                           data-rule-required="true"
                           placeholder="Enter Area"
                           value="">{{ isset($arr_user_data['area'])?$arr_user_data['area']:'' }}</textarea>
                    <span class='help-block'>{{ $errors->first('area') }}</span>
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
<script type="text/javascript">
 window.onload = function() {

          loadStates();

   };
 var url = "{{ url('/') }}";
    function loadStates()
     {
        //var selected_country = jQuery(ref).val();

        jQuery.ajax({
                        url:url+'/web_admin/common/get_states/'+1,
                        type:'GET',
                        data:'flag=true',
                        dataType:'json',
                        beforeSend:function()
                        {
                           // jQuery('select[name="state"]').attr('disabled','disabled');
                        },
                        success:function(response)
                        {

                            if(response.status=="SUCCESS")
                            {
                                jQuery('select[name="state"]').removeAttr('disabled');
                                if(typeof(response.arr_state) == "object")
                                {
                                   //var option = '<option value="">Select</option>';
                                   jQuery(response.arr_state).each(function(index,states)
                                   {

                                        option+='<option value="'+states.id+'">'+states.state_title+'</option>';
                                   });

                                   jQuery('select[name="state"]').html(option);
                                }
                            }
                            return false;
                        }
        });
     }
     function loadCity(ref)
     {
        var selected_state = jQuery(ref).val();

        jQuery.ajax({
                        url:url+'/web_admin/common/get_cities/'+selected_state,
                        type:'GET',
                        data:'flag=true',
                        dataType:'json',
                        beforeSend:function()
                        {
                            jQuery('select[name="city"]').attr('disabled','disabled');
                        },
                        success:function(response)
                        {

                            if(response.status=="SUCCESS")
                            {
                                jQuery('select[name="city"]').removeAttr('disabled');
                                if(typeof(response.arr_city) == "object")
                                {
                                   var option = '<option value="">Select</option>';
                                   jQuery(response.arr_city).each(function(index,city)
                                   {

                                        option+='<option value="'+city.id+'">'+city.city_title+'</option>';
                                   });

                                   jQuery('select[name="city"]').html(option);
                                }
                            }
                            return false;
                        }
        });
     }
      function loadpostalcode(ref)
     {
        var selected_city = jQuery(ref).val();

        jQuery.ajax({
                        url:url+'/web_admin/common/get_postalcode/'+selected_city,
                        type:'GET',
                        data:'flag=true',
                        dataType:'json',
                        beforeSend:function()
                        {
                            jQuery('select[name="pincode"]').attr('disabled','disabled');
                        },
                        success:function(response)
                        {

                            if(response.status=="SUCCESS")
                            {
                                jQuery('select[name="pincode"]').removeAttr('disabled');
                                if(typeof(response.arr_postalcode) == "object")
                                {
                                   var option = '<option value="">Select</option>';
                                   jQuery(response.arr_postalcode).each(function(index,postalcode)
                                   {

                                        option+='<option value="'+postalcode.postal_code+'">'+postalcode.postal_code+'</option>';
                                   });

                                   jQuery('select[name="pincode"]').html(option);
                                }
                            }
                            return false;
                        }
        });
     }

    function chkeck_marital_status(ref)
    {
       var marital_status= $("select[name='marital_status']").val();
       if(marital_status=='Married')
       {
         $("#div_married_date").css('display','block');
       }
       else
       {
        $("#div_married_date").css('display','none');
       }
    }
</script>
@stop