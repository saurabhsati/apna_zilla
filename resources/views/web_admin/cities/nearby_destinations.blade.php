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
                <a href="{{ url('/').'/web_admin/cities' }}">City</a>
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
                action="{{ url('/web_admin/cities/add_destinations') }}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}

            @if(isset($dest_ary) && sizeof($dest_ary)>0)

               
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label"><strong>Select Nearby Destinations</strong> </label>
                    <div class="col-sm-9 col-lg-10 controls"> 

                    @for($d=0; $d < sizeof($dest_ary); $d++)
 
                        <div class="col-md-3">
                          <input type="checkbox"  <?php if($dest_ary[$d]['selected']=='1') { ?> checked="" <?php } ?>
                           value="{{$dest_ary[$d]['city_id']}}" name="checkbox_{{$d}}" /> {{$dest_ary[$d]['city_title']}}
                       </div>
                        
                    @endfor
     
                    </div>
                 </div> 
                
                <input type="hidden" name="records" value="{{$d}}">
                <input type="hidden" name="city" value="{{$enc_id}}">

            @endif


<br/></br>
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
