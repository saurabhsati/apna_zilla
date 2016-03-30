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
                <a href="{{ url('/').'/web_admin/cities' }}">Cities</a>
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
                action="{{ url('/web_admin/cities/store')}}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}



            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="country_code">Country Name <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <select class="form-control" name="country_name" id="country_name" data-rule-required="true" onchange="loadStates(this)"   >
                        <option value="">Select</option>
                          @if(isset($arr_country) && sizeof($arr_country)>0)
                              @foreach($arr_country as $county)
                                  <option value="{{$county['id']}}">{{$county['country_name']}}</option>
                              @endforeach
                          @endif
                    </select>
                    <span class='help-block'>{{ $errors->first('country_name') }}</span>
                </div>
            </div>

             <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label">State/Region Name<i class="red">*</i></label>
              <div class="col-sm-6 col-lg-4 controls">
                 <select class="form-control" data-placeholder="Select State/Region" tabindex="1"
                 name="state" >
                    <option value="">Select</option>
                    <!-- @if(isset($arr_state) && sizeof($arr_state)>0)
                       @foreach($arr_state as $state)
                    <option value="{{$state['id']}}">{{$state['state_title']}}</option>
                      @endforeach
                      @endif -->
                 </select>
                   <span class='help-block'>{{ $errors->first('state') }}</span>
              </div>
           </div>


           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="state">City name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="city_title" data-rule-required="true"   />
                    <span class='help-block'>{{ $errors->first('city') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label"> Image <i class="red">*</i> </label>
                <div class="col-sm-9 col-lg-10 controls">
                   <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">

                      </div>
                      <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                         <span class="btn btn-default btn-file"><span class="fileupload-new" >Select image</span>
                         <span class="fileupload-exists">Change</span>
                         <input type="file" class="file-input" name="image" id="ad_image"/></span>
                         <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>

                         <span  >

                         </span>

                      </div>
                   </div>
                    <span class='help-block'>{{ $errors->first('image') }}</span>
                     <!--<br/>
                     <button class="btn btn-warning" onclick="return show_more_images()" id="show_more_images_button">Do you want to add slider images ? </button>  -->
                </div>
             </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="is_popular">Is Popular City <i class="red">*</i></label>
                <div class="col-sm-1 col-lg-1 controls">
                    <input class="form-control" id="is_popular"  type="checkbox" name="is_popular" value="1" />
                    <span class='help-block'>{{ $errors->first('is_popular') }}</span>
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
<!-- END Main Content -->


<script type="text/javascript">

    var url = "{{ url('/') }}";
    function loadStates(ref)
     {
        var selected_country = jQuery(ref).val();

        jQuery.ajax({
                        url:url+'/web_admin/common/get_states/'+selected_country,
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

                                        option+='<option value="'+states.id+'">'+states.state_title+'</option>';
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
