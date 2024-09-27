    @extends('web_admin.template.admin')


    @section('main_content')

    <style type="text/css">
    .btn-file
    {
      display: none !important;
    }
    </style>
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
                <a href="{{ url('/').'/web_admin/front_slider' }}"> Front Slider </a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"><i class="fa fa-edit"></i> Show</li>
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

             <div class="row">
                                    <div class="col-md-3">
                                    @if($arr_slider['image'] != '')
                                          <img class="img-responsive img-thumbnail"  src="{{ $slider_public_img_path.$arr_slider['image']}}" alt="Country logo" />
                                    @endif
                                        <br/><br/>
                                    </div>
                                    <div class="col-md-9 user-profile-info">
                                        <p><span>Title :</span>{{ isset($arr_slider['title'])?$arr_slider['title']:'' }}</p>

                                        <p><span>Link :</span> {{ isset($arr_slider['link'])?$arr_slider['link']:'' }}</p>


                                    </div>
                                </div>
                            </div>


</div>
</div>
</div>
</div>
<!-- END Main Content -->


@stop


<script type="text/javascript">


</script>