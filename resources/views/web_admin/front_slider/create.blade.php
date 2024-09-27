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
                <a href="{{ url('/').'/web_admin/front_slider' }}">Front Slider </a>
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
                                    action="{{ url('/web_admin/front_slider/store/')}}"
                                    enctype="multipart/form-data"
                                    files="true"
                                    >

                    {{ csrf_field() }}

                                <div class="form-group">
                                      <label class="col-sm-3 col-lg-2 control-label" for="state"> Title </label>
                                      <div class="col-sm-6 col-lg-4 controls">
                                          <input class="form-control" name="title" data-rule-required="true" />
                                    </div>
                                </div>

                                <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label" for="state"> Link To Title </label>
                                        <div class="col-sm-6 col-lg-4 controls">
                                          <input class="form-control" name="link"  data-rule-required="true" />
                                        </div>
                                </div>

                               <div class="form-group">
                                        <label class="col-sm-3 col-lg-2 control-label"> Image </label>
                                        <div class="col-sm-9 col-lg-10 controls">
                                           <div class="fileupload fileupload-new" data-provides="fileupload">
                                              <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">

                                              </div>
                                              <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                              <div>
                                                 <span class="btn btn-default btn-file"><span class="fileupload-new" >Select image</span>
                                                 <span class="fileupload-exists">Change</span>
                                                 <input type="file" class="file-input" data-rule-required="true" name="image" id="ad_image"/></span>
                                                 <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

                                                 <span  >

                                                 </span>

                                              </div>
                                           </div>
                                            <span class='help-block'>{{ $errors->first('image') }}</span>

                                        </div>
                                    </div>


                <br>
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
<!-- END Main Content -->


<script type="text/javascript">

    var url = "{{ url('/') }}";
    function loadStates(ref)
     {
        var selected_country = jQuery(ref).val();

        jQuery.ajax({
                        url:url+'/web_admin/commonFunctions/get_states/'+selected_country,
                        type:'GET',
                        data:'flag=true',
                        dataType:'json',
                        beforeSend:function()
                        {
                            jQuery('select[name="state"]').attr('disabled','disabled');
                        },
                        success:function(response)
                        {
                            if(response.status=="SUCCESS")
                            {
                                jQuery('select[name="state"]').removeAttr('disabled');
                                if(typeof(response.arr_state) == "object")
                                {
                                   var option = '<option value="">Select</option>';
                                   jQuery(response.arr_state).each(function(index,states)
                                   {

                                        option+='<option value="'+states.state_id+'">'+states.state_title+'</option>';
                                   });

                                   jQuery('select[name="state"]').html(option);
                                }
                            }
                            return false;
                        }
        });
     }



</script>




@stop
