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
                <i class="fa fa-phone"></i>
                <a href="{{ url('/web_admin/business_listing/contact_info/'.base64_encode($business_contact['business_id'])) }}">Business Contact Information</a>
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
                <i class="fa fa-phone"></i>
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
@if(isset($business_contact) && sizeof($business_contact)>0)


        <form class="form-horizontal"
              id="validation-form"
              method="POST"
              action="{{ url('/web_admin/business_listing/update_contact/'.base64_encode($business_contact['id'])) }}"
              enctype="multipart/form-data">

           {{ csrf_field() }}

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="contact_person_name">Contact Person Name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="contact_person_name"
                           id="contact_person_name"
                           data-rule-required="true"
                           placeholder="Enter Contact Person Name"
                           value="{{ isset($business_contact['contact_person_name'])?$business_contact['contact_person_name']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('contact_person_name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="mobile_number">Mobile Number <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="mobile_number"
                           id="mobile_number"
                           data-rule-required="true"
                           placeholder="Enter Mobile Number"
                           value="{{ isset($business_contact['mobile_number'])?$business_contact['mobile_number']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('mobile_number') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="landline_number">Landline Number <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="landline_number"
                           id="landline_number"
                           data-rule-required="true"
                           placeholder="Enter Landline Number"
                           value="{{ isset($business_contact['landline_number'])?$business_contact['landline_number']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('landline_number') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="fax_no">Fax No <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="fax_no"
                           id="fax_no"
                           data-rule-required="true"
                           placeholder="Enter Fax No"
                           value="{{ isset($business_contact['fax_no'])?$business_contact['fax_no']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('fax_no') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="toll_free_number">Toll Free Number<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="toll_free_number"
                           id="toll_free_number"
                           data-rule-required="true"
                           placeholder="Enter Toll Free Number"
                           value="{{ isset($business_contact['toll_free_number'])?$business_contact['toll_free_number']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('toll_free_number') }}</span>
                </div>
            </div>
              <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Email Id <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="email_id"
                           id="email_id"
                           data-rule-required="true"
                           placeholder="Enter Email Id"
                           value="{{ isset($business_contact['email_id'])?$business_contact['email_id']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('email_id') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="website">Website <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="website"
                           id="website"
                           data-rule-required="true"
                           placeholder="Enter Website"
                           value="{{ isset($business_contact['website'])?$business_contact['website']:'' }}"
                           />
                    <span class='help-block'>{{ $errors->first('website') }}</span>
                </div>
            </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Update">
            </div>
        </div>
      </form>

@endif
</div>
</div>
</div>
</div>
<!-- END Main Content -->

<script type="text/javascript">


</script>
@stop