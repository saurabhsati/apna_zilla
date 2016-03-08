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
                <a href="{{ url('/').'/web_admin/categories' }}">Category</a>
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
                action="{{ url('/web_admin/categories/store') }}" 
                enctype="multipart/form-data"
                >                                               

           {{ csrf_field() }}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="category">Main Category/Sub Category<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">

                    <select name="category" id="category" data-rule-required="true" class="form-control" >
                        <option value="0" onclick="enableLogo()">Main Category </option>
                        @if(sizeof($arr_category)>0)
                            @foreach($arr_category as $category)
                        <option value="{{$category['cat_id']}}" onclick="disableLogo()" >{{$category['title']}}
                        </option>
                            @endforeach
                        @endif
                    </select>


                    <span class='help-block'>{{ $errors->first('category') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">Title<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" id="title" name="title" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('title') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="cat_meta_keyword">Meta Keyword<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" id="cat_meta_keyword" name="cat_meta_keyword" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('cat_meta_keyword') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="cat_meta_description">Meta Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" id="cat_meta_description" name="cat_meta_description" data-rule-required="true" /></textarea>
                    <span class='help-block'>{{ $errors->first('cat_meta_description') }}</span>
                </div>
            </div>

              <div class="form-group" id="cat_img_field">
                <label class="col-sm-3 col-lg-2 control-label" for="cat_img">Logo</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <img src="{{url('/')}}/images/front/default_category.png" width="100" height="100" id="preview_cat_img"  />
                    <span class="btn btn-danger" id="removal_handle" style="display:none;" onclick="clearPreviewImage()">X</span>
                    <input class="form-control" name="cat_img" id="cat_img" type="file" onchange="loadPreviewImage(this)"/>

                    <span class='help-block'>{{ $errors->first('cat_img') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_priceable">Priceable<i class="red">*</i></label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_priceable"  type="checkbox" name="is_priceable" value="1" />
                    <span class='help-block'>{{ $errors->first('is_priceable') }}</span>
                </div>
            </div>
            
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_popular">Popular<i class="red">*</i></label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_popular"  type="checkbox" name="is_popular" value="1" />
                    <span class='help-block'>{{ $errors->first('is_popular') }}</span>
                </div>
            </div>
                
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Create">


                <a class="btn btn-primary" href="{{ url('/web_admin/categories') }}">Back</a>


            </div>

            <input type="hidden" name="preload_category" disabled="disabled" value="{{ $enc_cat_id }}" />

        </div>
    </form>
</div>
</div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
    var site_url = "{{url('/')}}";

    $(document).ready(function()
    {
       preSelectCategory();
    });


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
        $('#preview_cat_img').attr('src',site_url+'/images/front/default_category.png');
        $("#removal_handle").hide();
    }

    function enableLogo()
    {
        $("#cat_img_field").show();
        $("#cat_img").removeAttr("disabled");
    }
    function disableLogo()
    {
        $("#cat_img_field").hide();
        $("#cat_img").attr("disabled","disabled");
    }

    function preSelectCategory()
    {
         /* Set Pre Selected Value */
        var preselected_category = $("input[name='preload_category']");
        if($(preselected_category).val().length)
        {
            $("#category option[value='"+atob($(preselected_category).val())+"']").attr("selected","selected");
            $("<input type='hidden' name='category' value='"+atob($(preselected_category).val())+"' />").insertAfter("#category");
            $("#category").attr("disabled","disabled");
        }
    }
</script>    
@stop                    