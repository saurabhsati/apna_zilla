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
                <i class="fa fa-text-width"></i>
                <a href="{{ url('/').'/web_admin/membership' }}">Membership Plans</a>
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
          action="{{ url('/web_admin/membership/update/'.base64_encode($arr_plan_data['plan_id'])) }} ' "
          >


           {{ csrf_field() }}


            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="title">Title</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="title"
                           id="title"
                           value="{{ isset($arr_plan_data['title'])?$arr_plan_data['title']:'' }}"
                           disabled="disabled" />

                    <span class='help-block'>{{ $errors->first('title') }}</span>
                </div>
            </div>
            <div class="form-group">

                <label class="col-sm-2 col-lg-2 control-label" for="no_normal_deal">No. Normal Deals</label>

                    @if($arr_plan_data['title']=='Premium')
                        <div class="col-sm-3 col-lg-2 controls">

                         @if($arr_plan_data['no_normal_deals']=='Unlimited')
                         <input class="form-control" name="no_normal_deal" id="no_normal_deal" data-rule-number="true"  value="{{ $arr_plan_data['no_normal_deals'] }}" disabled="">
                         @else
                         <input class="form-control" name="no_normal_deal" id="no_normal_deal" data-rule-number="true"  value="{{ $arr_plan_data['no_normal_deals'] }}">
                         @endif


                            <span class='help-block'>{{ $errors->first('no_normal_deals') }}</span>


                        </div>

                        <label class="col-sm-2 col-lg-1 control-label" for="unlimited_normal_deal">Unlimited</label>
                        <div class="col-sm-3 col-lg-1 controls">

                            @if($arr_plan_data['no_normal_deals']=='Unlimited')
                                <input type="checkbox" class="form-control" name="unlimited_normal_deal" checked="checked" id="unlimited_normal_deal"/>
                            @else
                                <input type="checkbox" class="form-control" name="unlimited_normal_deal" id="unlimited_normal_deal"/>
                            @endif

                        </div>
                    @else
                       <div class="col-sm-3 col-lg-2 controls">
                            <input class="form-control" name="no_normal_deal" id="no_normal_deal"  value="{{ $arr_plan_data['no_normal_deals'] }}" data-rule-number="true"  />
                            <span class='help-block'>{{ $errors->first('no_normal_deals') }}</span>
                        </div>
                    @endif

              </div>
             <!--  <div class="form-group">

                <label class="col-sm-2 col-lg-2 control-label" for="no_instant_deal">No. Instant Deals</label>

                 @if($arr_plan_data['title']=='Premium')
                        <div class="col-sm-3 col-lg-2 controls">

                         @if($arr_plan_data['no_instant_deals']=='Unlimited')
                            <input class="form-control" name="no_instant_deal" id="no_instant_deal" data-rule-number="true"  value="{{ $arr_plan_data['no_instant_deals'] }}" disabled="" />
                         @else
                            <input class="form-control" name="no_instant_deal" id="no_instant_deal" data-rule-number="true"  value="{{ $arr_plan_data['no_instant_deals'] }}" />
                         @endif


                            <span class='help-block'>{{ $errors->first('no_instant_deal') }}</span>
                        </div>

                        <label class="col-sm-2 col-lg-1 control-label" for="unlimited_instant_deal">Unlimited</label>
                        <div class="col-sm-3 col-lg-1 controls">

                         @if($arr_plan_data['no_instant_deals']=='Unlimited')
                            <input type="checkbox" class="form-control" checked="checked" name="unlimited_instant_deal" id="unlimited_instant_deal"/>
                         @else
                            <input type="checkbox" class="form-control" name="unlimited_instant_deal" id="unlimited_instant_deal"/>
                         @endif


                        </div>
                    @else
                       <div class="col-sm-3 col-lg-2 controls">
                            <input class="form-control" name="no_instant_deal" id="no_instant_deal"  value="{{ $arr_plan_data['no_instant_deals'] }}" data-rule-number="true" />
                            <span class='help-block'>{{ $errors->first('no_instant_deal') }}</span>
                        </div>
                    @endif


               </div>

             <div class="form-group">

                <label class="col-sm-2 col-lg-2 control-label" for="no_featured_deal">No. Featured Deals</label>

                @if($arr_plan_data['title']=='Premium')
                    <div class="col-sm-3 col-lg-2 controls">

                        @if($arr_plan_data['no_featured_deals']=='Unlimited')
                            <input class="form-control" name="no_featured_deal" id="no_featured_deal" data-rule-number="true"  value="{{ $arr_plan_data['no_featured_deals'] }}" disabled="" />
                        @else
                            <input class="form-control" name="no_featured_deal" id="no_featured_deal" data-rule-number="true"  value="{{ $arr_plan_data['no_featured_deals'] }}"  />
                        @endif


                        <span class='help-block'>{{ $errors->first('no_featured_deal') }}</span>
                    </div>

                    <label class="col-sm-2 col-lg-1 control-label" for="unlimited_featured_deal">Unlimited</label>
                    <div class="col-sm-3 col-lg-1 controls">

                        @if($arr_plan_data['no_featured_deals']=='Unlimited')
                            <input type="checkbox" class="form-control" checked="checked" name="unlimited_featured_deal" id="unlimited_featured_deal "/>
                        @else
                            <input type="checkbox" class="form-control" name="unlimited_featured_deal" id="unlimited_featured_deal "/>
                        @endif


                    </div>
                @else
                    <div class="col-sm-3 col-lg-2 controls">
                        <input class="form-control" name="no_featured_deal" id="no_featured_deal"  value="{{ $arr_plan_data['no_featured_deals'] }}" data-rule-number="true" />
                        <span class='help-block'>{{ $errors->first('no_featured_deal') }}</span>
                    </div>
                @endif


            </div> -->


             <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="description">Description</label>
                <div class="col-sm-6 col-lg-4 controls">
                <textarea rows="5" class="form-control" name="description" id="description" data-rule-required="true" />{{ $arr_plan_data['description'] }} </textarea>
                   <!--  <input class="form-control"
                           name="description"
                           id="description"
                           data-rule-required="true"
                           value="{{ isset($arr_plan_data['description'])?$arr_plan_data['description']:'' }}" /> -->

                    <span class='help-block'>{{ $errors->first('description') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 col-lg-2 control-label" for="validity">Validity(in days)</label>
                <div class="col-sm-6 col-lg-4 controls">
                    <input class="form-control"
                           name="validity"
                           id="validity"
                           data-rule-required="true"
                           {{-- data-rule-min="1"  --}}
                           value="{{ isset($arr_plan_data['validity'])?$arr_plan_data['validity']:'' }}" />

                    <span class='help-block'>{{ $errors->first('validity') }}</span>
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


</script>
@stop