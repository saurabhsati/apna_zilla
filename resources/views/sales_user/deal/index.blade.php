@extends('sales_user.template.sales')

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
                <a href="{{ url('/sales_user/dashboard') }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li>
                <i class="fa fa-money"></i>
                <a href="{{ url('/sales_user/business_listing') }}">Business Listing</a>
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
                <i class="fa fa-money"></i>

                @if(isset($arr_restaurant) && sizeof($arr_restaurant)>0)
                  {{ $arr_restaurant['name'] }}
                @endif
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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/sales_user/deals/multi_action') }}">

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
                @if($add_deal=="1")
                 @if(isset($arr_business) && sizeof($arr_business)>0)
                   <!--  <a href="{{ url('/sales_user/deals/create/'.base64_encode($arr_business['id']))}}" class="btn btn-primary btn-add-new-records">Add Deal</a>
                  --> @endif
                   @elseif($add_deal=="0")
                      <div style="color: Red;">Total Deal Count Reached</div>
                  @elseif($add_deal=="expired")
                   <div style="color: Red;"> Deals Get Expired </div>
                  @else
                  <div style="color: Red;">Total Deal Count Reached</div>
                  @endif
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
             @if(isset($arr_business) && sizeof($arr_business)>0)
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Refresh"
                   href="{{ url('/sales_user/deals/'.base64_encode($arr_business['id'])) }}"
                   style="text-decoration:none;">
                   <i class="fa fa-repeat"></i>
                </a>
             @endif
            </div>
          </div>
          <br/>
          <div class="clearfix"></div>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="user_manage" >
              <thead>
                <tr>
                  <th> <input type="checkbox" name="mult_change" id="mult_change" value="delete" /></th>
                  <th>Sr. No.</th>
                  <th>Business</th>
                  <th>Deal Image</th>
                  <th>Deal Name</th>
                  <th>Deal Type</th>
                  <th>Discount Price</th>
                  <th>Status</th>
                  <th>Action</th>
                  <th>Validity status</th>
                </tr>
              </thead>
              <tbody>

                @if(isset($arr_deal) && sizeof($arr_deal)>0)
                  @foreach($arr_deal as $key => $deal)
                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($deal['id']) }}" />
                    </td>
                    <td>{{ $key+1 }}</td>
                    <td>
                          {{ $deal['business_info']['business_name'] }}
                    </td>
                      <td>
                    <img src="{{ $deal_public_img_path.'/'.$deal['deal_image']}}" alt=""  style="width:75px; height:50px;" />   </td>
                    <td>{{ $deal['name'] }}</td>
                    <td>
                      @if($deal['deal_type']=='1')
                        {{ 'Normal Deal' }}
                      @elseif($deal['deal_type']=='2')
                        {{ 'Instant Deal' }}
                      @elseif($deal['deal_type']=='3')
                        {{ 'Featured Deal' }}
                      @endif
                    </td>
                     <td>
                          {{ $deal['discount_price'] }}
                    </td>
                    <td width="250">
                         @if($deal['is_active']=="0")
                        <a class="btn btn-danger" href="{{ url('/sales_user/deals/toggle_status/').'/'.base64_encode($deal['id']).'/activate' }}">
                            Block
                        </a>

                        @elseif($deal['is_active']=="1")
                        <a  class="btn btn-success" href="{{ url('/sales_user/deals/toggle_status/').'/'.base64_encode($deal['id']).'/block' }}">
                            Active
                        </a>
                        @endif
                    </td>
                    <td>
                     
                       <!--  <a href="{{ url('/sales_user/deals/edit/').'/'.base64_encode($deal['id']) }}" class="show-tooltip" title="Edit">
                          <i class="fa fa-edit" ></i>
                        </a> -->

                        &nbsp;
                        <a href="{{ url('/sales_user/deals/delete/').'/'.base64_encode($deal['id']) }}"
                           onclick="javascript:return confirm_delete()" class="show-tooltip" title="Delete">
                          <i class="fa fa-trash" ></i>
                        </a>

                    </td>
                    <td>
                     <?php
                      if(isset($expired_date) && sizeof($expired_date)>0)
                    {
                        $expire_date = new \Carbon($expired_date);
                       $now = Carbon::now();
                       $difference = ($expire_date->diff($now)->days < 1)
                            ? 'today'
                            : $expire_date->diffForHumans($now);
                           
                        if (strpos($difference, 'after') !== false || strpos($difference, 'today') !== false) 
                        {
                          if($difference=='today')
                          {
                           echo "<div style='color: Green;'>Active only for ".$difference;
                          }
                          else
                          {
                            echo "<div style='color: Green;'>".$difference."  Membership plan get expired";;
                          }
                        }
                        else
                        {
                           echo "<div style='color: red;'>Expired</div>";
                        }
                      }
                      ?>
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