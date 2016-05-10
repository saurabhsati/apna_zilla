    @extends('web_admin.template.admin')

<style type="text/css">
    .price-old {
    color: red;
    display: inline-block;
    font-size: 13px;
    padding-left: 12px;
    text-decoration: line-through;
}
</style>
    @section('main_content')
    <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-credit-card"></i> Payment</h1>
                        <h4>Transaction Edit</h4>
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="{{ url('web_admin/dashboard') }}">Dashboard</a>
                            <span class="divider"><i class="fa fa-angle-right"></i></span>
                            <i class="fa fa-credit-card"></i>
                            <a href="{{ url('web_admin/deals_offers_transactions') }}"> Payment Transaction</a>
                            <span class="divider"><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li class="active">Invoice</li>
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
                action="{{ url('/web_admin/deals_offers_transactions/update/'.base64_encode($arr_single_transaction['id'])) }}"
                enctype="multipart/form-data"
                files="true"
                >

           {{ csrf_field() }}
          <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="first_name">User Name <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="first_name" data-rule-required="true"
                        value="{{ isset($arr_single_transaction['user_records']) && $arr_single_transaction['user_records']? ucfirst($arr_single_transaction['user_records']['first_name']):'' }}
                        " readonly
                    />
                    <span class='help-block'>{{ $errors->first('first_name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="first_name">Deal Name <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="first_name" data-rule-required="true"
                        value="{{ isset($arr_single_transaction['order_deal']['title']) && $arr_single_transaction['order_deal']['title']? ucfirst($arr_single_transaction['order_deal']['title']):'' }}
                        " readonly
                    />
                    <span class='help-block'>{{ $errors->first('first_name') }}</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Purchase Offers <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                   <?php $total=0;?>
                      @foreach($arr_single_transaction['order_deal']['offers_info'] as $offers)
                        @foreach($arr_single_transaction['user_orders'] as $selected_offers)
                         @if($selected_offers['offer_id']==$offers['id'])

                          <?php  $total=$total+$offers['discounted_price']*$selected_offers['order_quantity']; ?>
                       <div  class="">
                                                 
                                                   <div class="">
                                                        <h4 class="" id="dealTitle0">{{$offers['title']}}</h4>
                                                     </div>
                                                     <div class="">
                                                        <h4 class="">Qty - {{$selected_offers['order_quantity']}}</h4>
                                                     </div>
                                                     <div class="">
                                                        <p class="">
                                                        <span class=""></span>
                                                        <span class="">
                                                         <p class="price-old"><i class="fa fa-inr "></i>{{$offers['main_price']}}</p>
                                                         <p class=""><i class="fa fa-inr "></i><span class="sell_price">{{$offers['discounted_price']}}</span></p>
                                                    </div>
                                                   
                                                  </div>
                         @endif                         
                        @endforeach
                      @endforeach
                      
                     </div>
            </div> 
             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Price <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control" name="price" data-rule-required="true"
                        value="{{ $arr_single_transaction['price'] }}/- " readonly
                    />
                    <span class='help-block'>{{ $errors->first('price') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="price">Status <i class="red">*</i></label>
                <div class="col-sm-6 col-lg-4 controls">
                   <!--  <input class="form-control" name="price" data-rule-required="true"
                        value="{{ $arr_single_transaction['price'] }}/- " readonly
                    /> -->
                    <select name="status" id="status" class="form-control">
                        <option value="Active" {{ $arr_single_transaction['transaction_status']=='Active' ? 'selected=selected':'' }}>Active</option>
                        <option value="Pending" {{ $arr_single_transaction['transaction_status']=='Pending' ? 'selected=selected':'' }}>Pending</option>
                        <option value="in progress" {{ $arr_single_transaction['transaction_status']=='in progress' ? 'selected=selected':'' }}>In progress</option>
                        <option value="success" {{ $arr_single_transaction['transaction_status']=='success' ? 'selected=selected':'' }}>Success</option>
                   </select>
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
</div></div>
<!-- END Main Content -->



@stop