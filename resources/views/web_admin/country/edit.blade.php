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
                <a href="{{ url('/').'/web_admin/countries' }}">Countries</a>
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
                {{ isset($page_title)?$page_title:"" }}
            </h3>
            <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
            </div>
        </div>
        <div class="box-content">

          @include('web_admin.template._flash_errors')

          <form class="form-horizontal" 
                id="validation-form" 
                method="POST" 
                action="{{ url('/web_admin/countries/update/'.base64_encode($arr_country['id'])) }}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}



           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="country_name">Country name<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="country_name" data-rule-required="true"
                        value="{{ isset($arr_country['country_name'])?$arr_country['country_name']:'' }}"
                     />
                    <span class='help-block'>{{ $errors->first('country_name') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="country_code">Country code <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="country_code" data-rule-required="true" 
                        value="{{ isset($arr_country['country_code'])? strtoupper($arr_country['country_code']):'' }}"
                    />
                    <span class='help-block'>{{ $errors->first('country_code') }}</span>
                </div>
            </div>
            
           
             <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label"> Image <i class="red">*</i> </label>
                            <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src={{ $country_public_img_path.$arr_country['country_image']}} alt="" />
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
