    @extends('web_admin.template.admin')                


    @section('main_content')
    <!-- BEGIN Page Title -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.css">
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
                <i class="fa fa-cut"></i>
                <a href="{{ url('/').'/web_admin/coupons' }}">Coupon</a>
            </span> 
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                  <i class="fa fa-list"></i>
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
                <i class="fa fa-plus-circle"></i>
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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/').'/web_admin/coupons/multi_action' }}">

            {{ csrf_field() }}

            <div class="col-md-10">
            

            <div id="ajax_op_status">
                
            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">

          
          <div class="btn-group">
          <a href="{{ url('/web_admin/coupons/create')}}" class="btn btn-primary btn-add-new-records" title="Add New Coupon">Add New Coupon</a> 
          </div>
 
          
           <!--   <div class="btn-group">
            <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                    title="Multiple Active/Unblock" 
                    href="javascript:void(0);" 
                    onclick="javascript : return check_multi_action('frm_manage','activate');" 
                    style="text-decoration:none;">

                    <i class="fa fa-unlock"></i>
                </a> 
                </div>
                <div class="btn-group">
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                   title="Multiple Deactive/Block" 
                   href="javascript:void(0);" 
                   onclick="javascript : return check_multi_action('frm_manage','block');"  
                   style="text-decoration:none;">
                    <i class="fa fa-lock"></i>
                </a> 
                </div> -->
           <div class="btn-group">
                
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                   title="Multiple Delete" 
                   href="javascript:void(0);" 
                   onclick="javascript : return check_multi_action('frm_manage','delete');"  
                   style="text-decoration:none;">
                   <i class="fa fa-trash-o"></i>
                </a>
            </div>  
            <div class="btn-group"> 
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip" 
                   title="Refresh" 
                   href="{{ url('/').'/web_admin/coupons' }}"
                   style="text-decoration:none;">
                   <i class="fa fa-repeat"></i>
                </a> 
            </div>
          </div>
          <br/>
          <div class="clearfix"></div>
          <div class="table-responsive" style="border:0">

            <input type="hidden" name="multi_action" value="" />

            <table class="table table-advance"  id="table1" >
              <thead>
                <tr>
                  <th style="width:18px"> <input type="checkbox" name="mult_change" id="mult_change" /></th>
                  <th style="width:228px">Coupon Code</th> 
                  <th style="width:208px">Discount Type</th> 
                  <th style="width:208px">Discount</th> 
                  <th>Expiry Date</th> 
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                
                @if(sizeof($arr_coupon)>0)
                  @foreach($arr_coupon as $coupon)
                   <?php $show_url = '/web_admin/coupon/edit/'.base64_encode($coupon['id']); ?>

                  <tr>
                    <td> 
                      <input type="checkbox" 
                             name="checked_record[]"  
                             value="{{ base64_encode($coupon['id']) }}" /> 
                    </td>
                      

                    <td> {{ $coupon['coupon_code'] }} </td> 
                    <td>  <?php 

                            if($coupon['type'] == "AMT") 
                            {
                                echo "Amount";
                            } 
                            elseif($coupon['type'] == "PERCENT")
                            {
                                echo "Percentage";
                            }

                            ?>  </td> 

                    <td> {{ $coupon['discount'] }} </td> 

                    <td> {{ date('d-m-Y',strtotime($coupon['end_date'])) }} </td> 
                    
                    
                    <td>
                          <a href="{{ url('/').'/web_admin/coupons/edit/'.base64_encode($coupon['id']) }}">
                            <i class="fa fa-edit" ></i>
                          </a>  
                          &nbsp;  
                         <a href="{{ url('/').'/web_admin/coupons/delete/'.base64_encode($coupon['id'])}}"  
                              onclick="return confirm_delete();" 
                              onclick="javascript:return confirm_delete()" title="Delete">
                          <i class="fa fa-trash" ></i>  
                    </td>
                  </tr>
                  @endforeach
                @endif
                 
              </tbody>
            </table>
          </div>
        <div>   </div>
         
          </form>
      </div>
  </div>
</div>
</div>
<!-- END Main Content -->
<script type="text/javascript">
function show_details(url)
    { 
       
        window.location.href = url;
    } 

    
    function confirm_delete()
    {
       if(confirm("This will delete the coupon. \n Are you sure ?"))
       {
        return true;
       }
       return false;
    }

    function check_multi_action(frm_id,action)
    {
      
      if(action == 'delete')
      {
        if(confirm_delete() == false)
            return false;
      }

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

 <!--page specific plugin scripts-->
        <script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.js"></script>

@stop                    


