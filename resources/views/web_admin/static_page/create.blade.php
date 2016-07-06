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
                <i class="fa fa-desktop"></i>
                <a href="{{ url('/').'/web_admin/static_pages' }}">CMS</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-home"></i> Create</li>
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
                          action="{{ url('/web_admin/static_pages/store')}}"
                          enctype="multipart/form-data"
                          files="true"
                          >

                        {{ csrf_field() }}


                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="page_title">Page Title<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="page_title" id="page_title" data-rule-required="true"   /> <span class='help-block'>{{ $errors->first('page_title') }}</span>
                </div>
                </div>
                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="meta_keyword">Meta Title<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="meta_title" id="meta_title" data-rule-required="true"   />
                    <span class='help-block'>{{ $errors->first('meta_title') }}</span>
                </div>
               </div>
                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="meta_keyword">Meta Keyword<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="meta_keyword" id="meta_keyword" data-rule-required="true"   />
                    <span class='help-block'>{{ $errors->first('meta_keyword') }}</span>
                </div>
               </div>

                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="meta_desc">Meta Description<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="meta_desc" id="meta_desc" data-rule-required="true"   />
                    <span class='help-block'>{{ $errors->first('meta_desc') }}</span>
                </div>
                </div>

                <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="page_desc">Page Content<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea name="page_desc" id="page_desc" data-rule-required="true" class="form-control" ></textarea>
                    <span class='help-block'>{{ $errors->first('page_desc') }}</span>
                </div>
                </div>
                <div class="form-group">
                      <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                        <input type="submit"  class="btn btn-primary" value="Save">
                    </div>
                </div>
                 </form>


</div>
</div>
</div>
</div>  

<script type="text/javascript">
    tinymce.init({ selector:'textarea' });
    //tinymce.init('#page_desc');
</script>

<!-- END Main Content -->
@stop
