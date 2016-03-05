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


            <span class="divider">
                <i class="fa fa-angle-right"></i>
                <i class="fa fa-youtube-play"></i>
                <a href="{{ url('/').'/web_admin/front_slider' }}"> Front Slider </a>
            </span>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                  <i class="fa fa-list"></i>
            </span>
            <li class="active"> Manage </li>
        </ul>
      </div>
    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-list"></i>
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

          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/').'/web_admin/front_slider/multi_action' }}">

            {{ csrf_field() }}

            <div class="col-md-10">


            <div id="ajax_op_status">

            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">


          <div class="btn-group">
              <a href="{{ url('/web_admin/front_slider/create/')}}" class="btn btn-primary btn-add-new-records">Add New Slider</a>
          </div>

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
                   href="javascript:void(0)"
                   onclick="javascript:location.reload();"
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
                  <th>Image</th>
                  <th>Title</th>
                  <th>Order</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @if(sizeof($arr_slider)>0)
                  @foreach($arr_slider as $slider)

                  <tr>

                      <td>
                        <input type="checkbox"
                               name="checked_record[]"
                               value="{{ base64_encode($slider['id']) }}" />
                      </td>

                      <td  onclick="" >
                          <img src="{{ $slider_public_img_path.$slider['image']}}"
                                 alt=""
                                 style="width:75px; height:50px;" />
                      </td>

                      <td> {{ $slider['title']  }} </td>

                      <td> <input type="text"
                                  name="order"
                                  id="order"
                                  data-slider-id="{{ $slider['id'] }}"
                                  value="{{ $slider['order_index'] }}"
                                  class="form-control"
                                  onblur="save_order(this)" > </td>

                      <td>
                            <a href="{{ url('/').'/web_admin/front_slider/edit/'.base64_encode($slider['id']) }}">
                              <i class="fa fa-edit" ></i>
                            </a>
                            &nbsp;

                           <a href="{{ url('/').'/web_admin/front_slider/delete/'.base64_encode($slider['id'])  }}"
                             onclick="return confirm_delete();"
                                 >
                             <i class="fa fa-trash" ></i>  </a>
                                &nbsp;
                            <a href="{{ url('/').'/web_admin/front_slider/show/'.base64_encode($slider['id']) }}">
                              <i class="fa fa-eye" ></i>
                            </a>
                      </td>

                  </tr>
                  @endforeach
                @endif

              </tbody>
            </table>
          </div>
        <div> </div>

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


             if(!confirm('Are you sure ?'))
             {
                return false;
             }

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

    function save_order(elem)
    {
    var url = "{{ url('/') }}";
        var order_id = jQuery(elem).val();
        var slider_id = jQuery(elem).attr("data-slider-id");

        console.log("order_id:-  "+order_id);
        console.log("slider_id:-  "+slider_id);

        jQuery.ajax({
                        url:url+'/web_admin/front_slider/save_order/'+slider_id+'/'+order_id,
                        type:'GET',
                        dataType:'json',

                        success:function(response)
                        {
                            if(response.status=="SUCCESS")
                            {

                            }

                            if(response.status=="DUPLICATE")
                            {
                                alert(response.msg);
                            }
                             if(response.status=="NUMERIC")
                            {
                                alert(response.msg);
                            }
                            return false;
                        }
        });
    }


</script>
 <!--page specific plugin scripts-->
        <script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="{{ url('/') }}/assets/data-tables/latest/dataTables.bootstrap.min.js"></script>
@stop


