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
                <a href="{{ url('/').'/web_admin/countries' }}">Country</a>
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

          <form class="form-horizontal" id="validation-form" method="POST" action="{{ url('/web_admin/countries/store') }}" enctype="multipart/form-data"
          >


           {{ csrf_field() }}



             <div class="form-group">
                  <label class="col-sm-3 col-lg-2 control-label">Upload Excel file</label>
                  <div class="col-sm-9 col-lg-10 controls" style=" width: 50%;">
                     <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-group">
                           <div class="form-control uneditable-input">
                              <i class="fa fa-file fileupload-exists"></i> 
                              <span class="fileupload-preview"></span>
                           </div>
                           <div class="input-group-btn">
                               <a class="btn bun-default btn-file">
                                   <span class="fileupload-new">Select file</span>
                                   <span class="fileupload-exists">Change</span>
                                   <input type="file" class="file-input" name="excel_file" id="excel_file" data-rule-required="true" />

                               </a>
                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                           </div>

                        </div>
                        <span> Acceptable file formats: .xlsx, .xls, .csv</span>
                     </div>
                  </div>
             </div>

          <div class="form-group">
          <div class="col-sm-9 col-sm-offset-3 col-lg-4 col-lg-offset-2" style=" background-color: rgba(182, 209, 242, 0.44);">
          <br/>
           <p><strong>Note:</strong>
          <p> 1. Please enter same Column Titles as shown in following image.</p>
          <p> 2. Please Do not misplace column positions.  </p>
          </div>
          <br/>
              <div class="col-sm-3 col-sm-offset-3 col-lg-10 col-lg-offset-2" >
                <br/><br/>
                 <img src="{{ url('/') }}/images/admin/excel_format.png" alt="" style="width:275px; height:120px " />
            </div>
            </div>
            <br/><br/>

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
 
@stop                    