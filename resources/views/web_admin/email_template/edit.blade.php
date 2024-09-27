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
                <i class="fa fa-envelope"></i>
                <a href="{{ url('/').'/web_admin/email_template' }}">Email Template</a>
            </li>   
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-edit"></i> Edit</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->





    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-edit"></i>
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
                action="{{ url('/web_admin/email_template/update/'.base64_encode($arr_email_template['id'])) }}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}



           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_template_name">Email Template Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="template_name" data-rule-required="true"
                        value="{{ isset($arr_email_template['template_name'])?$arr_email_template['template_name']:'' }}"
                     />
                    <span class='help-block'>{{ $errors->first('template_name') }}</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_from">Email Template From <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="template_from" data-rule-required="true" 
                        value="{{ isset($arr_email_template['template_from'])? $arr_email_template['template_from']:'' }}"
                    />
                    <span class='help-block'>{{ $errors->first('template_from') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_from_mail">Email Template From Email <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="template_from_mail" data-rule-required="true" 
                        value="{{ isset($arr_email_template['template_from_mail'])? $arr_email_template['template_from_mail']:'' }}"
                    />
                    <span class='help-block'>{{ $errors->first('template_from_mail') }}</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_subject">Email Template Subject <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="template_subject" data-rule-required="true" 
                        value="{{ isset($arr_email_template['template_subject'])? strtoupper($arr_email_template['template_subject']):'' }}"
                    />
                    <span class='help-block'>{{ $errors->first('template_subject') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="template_html">Email Template Body<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-7 controls">
                 <textarea class="form-control wysihtml5" name="template_html" rows="10" data-rule-required="true" >
                 {{ isset($arr_email_template['template_html'])?$arr_email_template['template_html']:'' }}
                 </textarea> 
                    <span class='help-block'>{{ $errors->first('template_html') }}</span>
                    <?php
                         $arr_variables = isset($arr_email_template['template_variables'])?explode("~",$arr_email_template['template_variables']):[];
                    ?> 
                    <span>Variables:</span>
                    @if(sizeof($arr_variables)>0)
                        @foreach($arr_variables as $variable)
                            <br><label>{{ $variable }}</label> 
                        @endforeach
                    @endif
                </div>

            </div> 
 
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_active">Status<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls"> 
                    <input type="checkbox" {{ ($arr_email_template['is_active']==1)?'checked':'' }} name="is_active"  
                    value="1" 
                      /> 
                    <span class='help-block'>{{ $errors->first('is_active') }}</span>
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


@stop                    
