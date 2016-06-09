    @extends('sales_user.template.admin')


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
                <a href="{{ url('/').'/sales_user/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-star"></i>
                @if(sizeof($arr_review_view)>0)
                    <a href="{{ url('sales_user/reviews/'.base64_encode($arr_review_view['business_id'])) }}">Reviews</a>
                @endif
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
                <i class="fa fa-star"></i>
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

          @if(sizeof($arr_review_view)>0)

          <form class="form-horizontal" id="validation-form" method="POST" action="" enctype="multipart/form-data">

           {{ csrf_field() }}
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Business Name</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="name" id="name"  value="{{ $arr_review_view['business_details']['business_name'] }}" readonly="" />
                    <span class='help-block'>{{ $errors->first('name') }}</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Name</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="name" id="name"  value="{{ $arr_review_view['name'] }}" readonly="" />
                    <span class='help-block'>{{ $errors->first('name') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Mobile Number</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="mobile_number" id="mobile_number"  value="{{ $arr_review_view['mobile_number'] }}" readonly="" />
                    <span class='help-block'>{{ $errors->first('mobile_number') }}</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="email_id">Email Id</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="email_id" id="email_id"  value="{{ $arr_review_view['email'] }}" readonly="" />
                    <span class='help-block'>{{ $errors->first('email_id') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="rating">Rating</label>
                <div class="col-sm-6 col-lg-4 controls">
                    @for($i=0; $i<$arr_review_view['ratings']; $i++)
                        <i class="fa fa-star"></i>
                    @endfor

                    <span class='help-block'>{{ $errors->first('rating') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="message">Message</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <textarea class="form-control" name="message" id="message" readonly="">{{ $arr_review_view['message'] }}</textarea>

                    <span class='help-block'>{{ $errors->first('message') }}</span>
                </div>
            </div>


            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
              <a href="{{ url('sales_user/reviews/'.base64_encode($arr_review_view['business_id'])) }}">
                <input type="button"  class="btn btn-primary" value="Back">
              </a>
            </div>
        </div>


    </form>

    @endif

</div>
</div>
</div>
</div>
<!-- END Main Content -->

@stop