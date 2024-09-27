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
                <a href="{{ url('/').'/web_admin/faq' }}">FAQ</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-home"></i> Edit</li>
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
                {{ isset($answer)?$answer:"" }}
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
                action="{{ url('/web_admin/faq/update/'.base64_encode($arr_pages['id'])) }}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}

           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="locality_name">Question<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="question" data-rule-required="true"
                        value="{{ isset($arr_pages['question'])?$arr_pages['question']:'' }}"
                     />
                    <span class='help-block'>{{ $errors->first('question') }}</span>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="locality_name">Answer<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-10 controls">
                    <textarea class="form-control col-md-12 ckeditor" name="answer" rows="6" data-rule-required="true">
                    {{ isset($arr_pages['answer'])?$arr_pages['answer']:'' }}
                 </textarea>
                    <span class='help-block'>{{ $errors->first('answer') }}</span>
                </div>
            </div>


            @if($show_slug == 1)
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="page_slug">Page slug<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="page_slug" data-rule-required="true"
                    value="{{ isset($arr_pages['page_slug'])?$arr_pages['page_slug']:0 }}"
                    />
                    <span class='help-block'>{{ $errors->first('page_slug') }}</span>
                </div>
            </div>
           @endif
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

    var url = '{{ url('/') }}';
    function loadCities(ref)
     {
        var selected_country = jQuery(ref).val();

        jQuery.ajax({
                        url:url+'/web_admin/commonFunctions/get_cities/'+selected_country,
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

                                      option+='<option value="'+city.city_id+'" >'+city.city_name+'</option>';

                                   });

                                   jQuery('select[name="city"]').html(option);
                                }
                            }
                            return false;
                        }
        });
     }

</script>
@stop