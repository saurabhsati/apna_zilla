    @extends('web_admin.template.admin')


    @section('main_content')

    <link rel="stylesheet" type="text/css" href="{{ url('/assets/data-tables/latest/') }}/dataTables.bootstrap.min.css">
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
                <a href="{{ url('/web_admin/dashboard') }}">Dashboard</a>
            </li>

            <span class="divider">
               <i class="fa fa-angle-right"></i>

            </span>
            <li>

            <i class="fa fa-credit-card"></i>
               <a href="{{ url('/web_admin/deals_bulk_request/') }}">Bulk Request</a>
            </li>

            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active">{{ isset($page_title)?$page_title:"" }}</li>
        </ul>
      </div>
    <!-- END Breadcrumb -->





    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-credit-card"></i>

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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/web_admin/restaurantReviews/multi_action') }}">

            {{ csrf_field() }}

            <div class="col-md-10">


            <div id="ajax_op_status">

            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">
            <!--- Add new record - - - -->
               <div class="btn-group">

                </div>
            <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - -->

            <div class="btn-group">
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                     title="Refresh"
                     href="{{ url('/web_admin/deals_offers_requests/') }}"
                     style="text-decoration:none;">
                     <i class="fa fa-repeat"></i>
                  </a>
            </div>
          </div>
          <br/><br/>
          <div class="clearfix"></div>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="user_manage" >
              <thead>
                <tr>
                  <th> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>
                  <th>Sr. No.</th>
                  <th>Deal Name</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone No</th>
                  <th>Quantity</th>
                 <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @if(sizeof($arr_request)>0)
              @foreach($arr_request as $key => $request)

                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($request['id']) }}" />
                    </td>
                    <td>{{ $key+1 }}</td>
                  
                    
                    <td> {{ isset($request['order_deal']) ? ucfirst($request['order_deal']['title']):'' }}</td>
                     <td>{{ $request['name'] or ''}} </td>
                     <td>{{ $request['email'] or ''}} </td>
                     <td>{{ $request['phone_no'] or '' }} </td>
                    <td>{{ $request['quantity'] or '' }} </td>

                   

                    <td>

                        <a href="{{ url('/web_admin/deals_bulk_request/view/'.base64_encode($request['id'])) }}" class="show-tooltip" title="View">
                          <i class="fa fa-eye" ></i>
                        </a>
                         &nbsp;
                      

                    </td>
                  </tr>

                @endforeach
                @endif

              </tbody>
            </table>
          </div>

          </form>
      </div>
  </div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript" src="{{ url('/assets/data-tables/latest') }}/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ url('/assets/data-tables/latest') }}/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">

   $(document).ready(function()
    {
        $("#user_manage").DataTable();
    });

</script>

@stop


