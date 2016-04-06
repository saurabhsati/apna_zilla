  @extends('sales_user.template.sales')


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
                <i class="fa fa-text-width"></i>
                <a href="{{ url('/').'/sales_user/business_listing' }}">Business Listing</a>
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
          action="{{ url('/sales_user/business_listing/purchase_plan')}}"
          >


           {{ csrf_field() }}
           <input type="hidden" name="business_id" id="business_id" value="{{$enc_business_id}}">
           <input type="hidden" name="user_id" id="user_id" value="{{$enc_user_id}}">
           <input type="hidden" name="category_id" id="category_id" value="{{$enc_category_id}}">
           <input type="hidden" name="validity" id="validity" value="">

            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">Select Membership Plan</label>
                <div class="col-sm-6 col-lg-4 controls">
                   <select class="form-control" name="plan_id" id="plan_id" onchange="return get_plan_cost();">
                    <option value="" >Select Membership Plan</option>

                   @if(isset($arr_membership_plan) && sizeof($arr_membership_plan)>0)
                   @foreach($arr_membership_plan as $plan)
                     <option value="{{ $plan['plan_id'] }}" >
                      {{ $plan['title'] }}
                    </option>
                   @endforeach
                    @endif
                  </select>
                    <span class='help-block'>{{ $errors->first('plan_id') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Price<i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="price"
                           id="price"
                           data-rule-required="true"
                           value=""
                           disabled=""
                           />
                    <span class='help-block'>{{ $errors->first('price') }}</span>
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

<script type="text/javascript">
var site_url = "{{url('/')}}";
function get_plan_cost()
{

  var _token = $('input[name=_token]').val();
  var plan_id=$("#plan_id").val();
  var category_id=$("#category_id").val();
  if(plan_id!='' && category_id!='')
  {
  var dataString = { plan_id:plan_id, category_id:category_id, _token: _token };
  var url= site_url+'/sales_user/business_listing/get_plan_cost';
  $.post( url, dataString)
      .done(function( response ) {
                            if(response.status=="SUCCESS")
                            {
                                  $('input[name="price"]').removeAttr('disabled');
                                  var option = response.price;
                                  $('input[name="price"]').attr('value',option);
                                   var option = response.validity;
                                  $('input[name="validity"]').attr('value',option);
                            }
      });

  }
  else
  {
    alert("Please select the Membership Plan");
  }
  return false;
}

</script>
@stop