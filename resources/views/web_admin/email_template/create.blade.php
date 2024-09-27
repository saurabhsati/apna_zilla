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
                <a href="{{ url('/').'/web_admin/email_template' }}">Email Template</a>
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

          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/email_template/store') }}" enctype="multipart/form-data"
          >


           {{ csrf_field() }}




            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_name">Email Template Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="template_name" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('template_name') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_subject">Email Template Subject<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="template_subject" data-rule-required="true" />
                    <span class='help-block'>{{ $errors->first('template_subject') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_html">Email Template Body<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-7 controls">
                 <textarea class="form-control wysihtml5" name="template_html" rows="10" data-rule-required="true" ></textarea>
                    <span class='help-block'>{{ $errors->first('template_html') }}</span>
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
                <label class="col-sm-3 col-lg-2 control-label" for="vaiables">Variables<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name='variables[]' data-rule-required="true" />
                </div>
                
                <a class="btn btn-primary" href="javascript:void(0)" onclick="add_text_field()"> <i class="fa fa-plus"></i> </a>
                <a class="btn btn-danger" href="javascript:void(0)" onclick="remove_text_field(this)"> <i class="fa fa-minus"></i> </a>
            </div>
            <div id="append_point"></div>

                
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
 
 <script type="text/javascript">

 function add_text_field() 
 {
     var html = "<div class='form-group appended' id='appended'><label class='col-sm-3 col-lg-2 control-label'></label><div class='col-sm-6 col-lg-4 controls'><input class='form-control' name='variables[]' data-rule-required='true' /></div><div id='append_point'></div></div>";
     jQuery("#append_point").append(html);
 }

 function remove_text_field(elem)
 {
    $( ".appended:last" ).remove();
 }

 </script>
@stop                    