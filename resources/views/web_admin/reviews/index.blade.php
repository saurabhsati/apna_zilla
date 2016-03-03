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

            <i class="fa fa-star"></i>
               <a href="{{ url('/web_admin/reviews/MjU=')}}">Reviews</a>
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
                <i class="fa fa-star  "></i>


                <span class="divider">
                  <i class="fa fa-angle-right"></i>
                </span>
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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/web_admin/reviews/multi_action') }}">

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
                    title="Multiple Unblock"
                    href="javascript:void(0);"
                    onclick="javascript : return check_multi_action('frm_manage','activate');"
                    style="text-decoration:none;">

                    <i class="fa fa-unlock"></i>
                </a>
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Multiple Block"
                   href="javascript:void(0);"
                   onclick="javascript : return check_multi_action('frm_manage','block');"
                   style="text-decoration:none;">
                    <i class="fa fa-lock"></i>
                </a>
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Multiple Delete"
                   href="javascript:void(0);"
                   onclick="javascript : return check_multi_action('frm_manage','delete');"
                   style="text-decoration:none;">
                   <i class="fa fa-trash-o"></i>
                </a>
            </div>
            <div class="btn-group">

              @if(sizeof($arr_reviews)>0)
                  <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                     title="Refresh"
                     href="{{ url('/web_admin/reviews/'.base64_encode($arr_reviews[0]['business_id'])) }}"
                     style="text-decoration:none;">
                     <i class="fa fa-repeat"></i>
                  </a>

               @endif

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
                  <th>Business Name</th>
                  <th>Name</th>
                  <th>Mobile Number</th>
                  <th>Email Id</th>
                  <th>Ratings</th>
                  <th>Message</th>
                  <!-- <th>Status</th> -->
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @if(sizeof($arr_reviews)>0)
              @foreach($arr_reviews as $key => $_review)

                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($_review['id']) }}" />
                    </td>
                    <td>{{ $key+1 }}</td>
                    <td>
                        {{ $_review['business_details']['business_name'] }}
                    </td>
                    <td>
                        {{ $_review['name'] }}
                    </td>
                    <td>
                        {{ $_review['mobile_number'] }}
                    </td>
                    <td>
                        {{ $_review['email'] }}
                    </td>
                    <td>
                      @for($i=0; $i<$_review['ratings']; $i++)
                        <i class="fa fa-star"></i>
                      @endfor

                    </td>
                    <td>
                        {{ $_review['message'] }}
                    </td>


                    <td>

                        <a href="{{ url('/web_admin/reviews/view/'.base64_encode($_review['id'])) }}" class="show-tooltip" title="View">
                          <i class="fa fa-eye" ></i>
                        </a>
                        &nbsp;
                    @if($_review['is_active']=="0")
                        <a  href="{{ url('/web_admin/reviews/toggle_status/').'/'.base64_encode($_review['id']).'/activate' }}">
                         <i class="fa fa-lock" ></i>
                         </a>
                        @elseif($_review['is_active']=="1")

                        <a  href="{{ url('/web_admin/reviews/toggle_status/').'/'.base64_encode($_review['id']).'/block' }}">
                        <i class="fa fa-unlock" ></i>
                        </a>
                       @endif
                        &nbsp;
                        <a href="{{ url('/web_admin/reviews/delete/'.base64_encode($_review['id']))}}"
                           onclick="javascript:return confirm_delete()" class="show-tooltip" title="Delete">
                          <i class="fa fa-trash" ></i>
                        </a>

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

    function confirm_delete()
    {
       if(confirm('Are you sure ?'))
       {
        return true;
       }
       return false;
    }

    function check_multi_action(frm_id,action)
    {
      var frm_ref = jQuery("#"+frm_id);
      if(jQuery(frm_ref).length && action!=undefined && action!="")
      {
        /* Get hidden input reference */
        var input_multi_action = jQuery('input[name="multi_action"]');

        if(jQuery(input_multi_action).length)
        {
          /* Set Action in hidden input*/
          jQuery('input[name="multi_action"]').val(action);

          /*Submit the referenced form */
          jQuery(frm_ref)[0].submit();

        }
        else
        {
          console.warn("Required Hidden Input[name]: multi_action Missing in Form ")
        }
      }
      else
      {
          console.warn("Required Form[id]: "+frm_id+" Missing in Current Page ")
      }
    }
</script>

@stop


