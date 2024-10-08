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
                <i class="fa fa-bars"></i>
                <a href="{{ url('/').'/web_admin/categories' }}">Category</a>
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
                <i class="fa fa-bars"></i>
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

          @if(isset($arr_data) && sizeof($arr_data)>0)

          <form class="form-horizontal"
                id="validation-form"
                method="POST"
                action="{{ url('/web_admin/categories/update/'.base64_encode($arr_data['cat_id']))}}"
                enctype="multipart/form-data">

           {{ csrf_field() }}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="name">Category Image</label>
                <div class="col-sm-6 col-lg-4 controls">
                    @if($arr_data['cat_img']=="avatar.jpg")
                      <img src="{{url('/')}}/images/admin/avatar/avatar.jpg" width="200" height="200" id="preview_cat_img"  />
                    @else
                      <img src="{{url('/')}}/uploads/category/{{$arr_data['cat_img']}}" width="200" height="200" id="preview_cat_img"  />
                    @endif

                    @if($arr_data['cat_img']!="avatar.jpg")
                      <span class="btn btn-danger" id="removal_handle" onclick="clearPreviewImage()">X</span>
                    @else
                      <span class="btn btn-danger" id="removal_handle" onclick="clearPreviewImage()" style="display:none;">X</span>
                    @endif

                    <input class="form-control" name="cat_img" id="cat_img" type="file" onchange="loadPreviewImage(this)"/>
                    
                   <i class="red">     
                        Please use 100 x 100 pixel image for best result ,
                        allowed only JPG, JPEG and PNG image   
                    </i>                     
                    <span class='help-block'>{{ $errors->first('cat_img') }}</span>
                </div>
            </div>

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="category">Category<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="category" id="category"  placeholder="Category Name" data-rule-required="true" value="{{ $arr_data['title'] }}" />
                    <span class='help-block'>{{ $errors->first('title') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="cat_meta_keyword">Meta Keyword<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" id="cat_meta_keyword" name="cat_meta_keyword" data-rule-required="true" value="{{ $arr_data['cat_meta_keyword'] }}" />
                    <span class='help-block'>{{ $errors->first('cat_meta_keyword') }}</span>
                </div>
            </div>


              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="cat_meta_description">Meta Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="cat_meta_description" id="cat_meta_description"  placeholder="Enter Meta Description" data-rule-required="true" value="{{ $arr_data['cat_meta_description'] }}" />
                    <span class='help-block'>{{ $errors->first('cat_meta_description') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="cat_ref_slug">Category Reference Name / Category Abrrivation<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" id="cat_ref_slug" name="cat_ref_slug" data-rule-required="true"  value="{{ $arr_data['cat_ref_slug'] }}"/>
                    <span class='help-block'>{{ $errors->first('cat_ref_slug') }}</span>
                </div>
            </div>

       {{--     <div class="form-group">
                              <label class="col-sm-3 col-lg-2 control-label" for="is_active">Is Active <i class="red">*</i></label>
                              <div class="col-sm-6 col-lg-1 controls">
                                  <select class="form-control" name="is_active" id="is_active">
                                          <option value="1" {{ $arr_data['is_active']=='1'?'selected="selected"':'' }}>Yes</option>
                                          <option value="0" {{ $arr_data['is_active']=='0'?'selected="selected"':'' }}>No</option>
                                  </select>
                                  <span class='help-block'>{{ $errors->first('is_active') }}</span>
                              </div>
                          </div>--}}


            @if($arr_data['is_popular']==1)

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_popular">Popular<i class="red">*</i></label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_popular"  type="checkbox" name="is_popular" checked="true" />
                    <span class='help-block'>{{ $errors->first('is_popular') }}</span>
                </div>
            </div>

            @elseif($arr_data['is_popular']==0)

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_popular">Popular</label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_popular"  type="checkbox" name="is_popular" />
                    <span class='help-block'>{{ $errors->first('is_popular') }}</span>
                </div>
            </div>

            @endif
            @if($arr_data['parent']==0)
             @if($arr_data['is_explore_directory']==1)

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_explore_directory">Explore Directory Category</label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_explore_directory"  type="checkbox" name="is_explore_directory" checked="true" />
                    <span class='help-block'>{{ $errors->first('is_explore_directory') }}</span>
                </div>
            </div>

            @elseif($arr_data['is_explore_directory']==0)

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_explore_directory">Explore Directory Category</label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_explore_directory"  type="checkbox" name="is_explore_directory" onclick="return check_explore_count();" />
                    <span class='help-block'>{{ $errors->first('is_explore_directory') }}</span>
                </div>
            </div>

            @endif
            <div class="error" id="err_delete_payment_mode"></div>
             @if($arr_data['is_allow_to_add_deal']==1)

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_allow_to_add_deal">Allow to Add Deals</label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_allow_to_add_deal"  type="checkbox" name="is_allow_to_add_deal" checked="true" />
                    <span class='help-block'>{{ $errors->first('is_allow_to_add_deal') }}</span>
                </div>
            </div>

            @elseif($arr_data['is_allow_to_add_deal']==0)

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_allow_to_add_deal">Allow to Add Deals</label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_allow_to_add_deal"  type="checkbox" name="is_allow_to_add_deal" />
                    <span class='help-block'>{{ $errors->first('is_allow_to_add_deal') }}</span>
                </div>
            </div>
            @endif
            @endif

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update">

            </div>
        </div>
    </form>
    @else
        <h5>No Records Found!</h5>
    @endif
</div>
</div>
</div>
</div>
<!-- END Main Content -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
var site_url = "{{url('/')}}";


 /*$('#validation-form').submit(function(){
    tinyMCE.triggerSave();
 }); */


function loadPreviewImage(ref)
    {
        var file = $(ref)[0].files[0];

        var img = document.createElement("img");
        reader = new FileReader();
        reader.onload = (function (theImg) {
            return function (evt) {
                theImg.src = evt.target.result;
                $('#preview_cat_img').attr('src', evt.target.result);
            };
        }(img));
        reader.readAsDataURL(file);
        $("#removal_handle").show();
    }

    function clearPreviewImage()
    {
        $('#preview_cat_img').attr('src',site_url+'/images/admin/avatar/avatar.jpg');
        $("#removal_handle").hide();
    }
     function check_explore_count()
    {
         var _token = $('input[name=_token]').val();
  var dataString = {  _token: _token };
        var url= site_url+'/web_admin/categories/check_explore_count';
        $.post( url,dataString)
      .done(function( data ) {
        if(data=='reached'){
             $('#err_delete_payment_mode').html('<div style="color:red">Maximum Explore Directory Category Count Reached .</div>');
             var request_id=$('.delete_payment_mode').parents('.main').attr('data-payment-mode');
             $('div[data-payment-mode="'+request_id+'"]').remove();
             $('#is_explore_directory').attr('disabled','disabled');
        }
        else
        {
            $('#err_delete_payment_mode').html('<div style="color:green">Allow to Add Explore Directory Category.</div>');
             var request_id=$('.delete_payment_mode').parents('.main').attr('data-payment-mode');
             $('div[data-payment-mode="'+request_id+'"]').remove();

        }
      });
    }
</script>
@stop
