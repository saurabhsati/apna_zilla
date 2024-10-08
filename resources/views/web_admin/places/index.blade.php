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
                <i class="fa fa-desktop"></i>
                <a href="{{ url('/').'/web_admin/places' }}">places</a>
            </span>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                  <i class="fa fa-edit"></i>
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
          <form class="form-horizontal" id="frm_manage" method="POST" action="{{ url('/').'/web_admin/places/multi_action' }}">

            {{ csrf_field() }}

            <div class="col-md-10">


            <div id="ajax_op_status">

            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">


          <!-- <div class="btn-group">
          <a href="{{ url('/web_admin/places/create')}}" class="btn btn-primary btn-add-new-records">Add New places</a>
          </div> -->

           <div class="btn-group">
                <a href="{{ url('/web_admin/places/export/csv')}}" class="btn btn-warning btn-add-new-records" title="Click to Excel Export"><i class="fa fa-file-excel-o"></i>
</a>
                </div>

          <div class="btn-group">
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
                   href="{{ url('/').'/web_admin/places' }}"
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
                  <th>Place</th>
                  <th>City :: State/Region :: Country</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @if(sizeof($arr_paginated_places['data'])>0 && isset($arr_paginated_places['data']))
                  @foreach($arr_paginated_places['data'] as $places)

                   <?php
                          $show_url = '/web_admin/places/edit/'.base64_encode($places['id']);
                          //$desctination_url = '/web_admin/places/nearby_destinations/'.base64_encode($places['id']);
                    ?>

                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($places['id']) }}" />
                    </td>
                    <td  onclick="show_details('{{ url('/') .$show_url}}')" > {{ $places['place_name'] }} </td>
                    <td  onclick="show_details('{{ url('/')}}')" >
                    {{ isset($places['city_details']['city_title'])?$places['city_details']['city_title'].'::':''}}
                    {{ isset($places['state_details']['state_title'])?$places['state_details']['state_title'].'::':''}}
                    {{ $places['country_details']['country_name'] }} </td>

                    <td>
                      <a href="{{ url('/').'/web_admin/places/show/'.base64_encode($places['id']) }}"
                          >
                          <i class="fa fa-eye" > </i>
                        </a>
                        &nbsp;

                        <a href="{{ url('/').'/web_admin/places/edit/'.base64_encode($places['id']) }}">
                          <i class="fa fa-edit" ></i>
                        </a>

                        &nbsp;
                        @if($places['is_active']==0)
                        <a href="{{ url('/').'/web_admin/places/toggle_status/'.base64_encode($places['id']).'/activate' }}">
                            <i class="fa fa-lock" ></i>
                        </a>

                        @elseif($places['is_active']==1)
                        <a href="{{ url('/').'/web_admin/places/toggle_status/'.base64_encode($places['id']).'/deactivate' }}">
                            <i class="fa fa-unlock" ></i>
                        </a>
                        @endif
                        &nbsp;
                     <a href="{{ url('/').'/web_admin/places/delete/'.base64_encode($places['id'])}}"
                       onclick="return confirm_delete();"
                           onclick="javascript:return confirm_delete()">
                          <i class="fa fa-trash" ></i>
                    </td>
                  </tr>
                  @endforeach
                @endif





              </tbody>
            </table>

            @if (isset($arr_paginated_places['to']) && $arr_paginated_places['to'] > 1)
                              <div style="float:right;" class="pagination">
                                <ul class="pagination">
                                    <?php
                                        $arr_get_params = Input::input();
                                    ?>
                                    @for ($i = 1; $i <= $arr_paginated_places['last_page']; $i++)
                                        <?php
                                            $arr_page = ['page'=>$i];
                                            $full_data = array_merge($arr_get_params, $arr_page);
                                            $url_param = http_build_query($full_data);
                                        ?>
                                        <li class="{{ ($arr_paginated_places['current_page'] == $i) ? ' active' : '' }}">
                                            <a href="{{ Request::url().'?'.$url_param }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                </ul>
                              </div>
                            @endif




          </div>
        <div> </div>

          </form>
      </div>
  </div>
</div>


</div>
<!-- END Main Content -->
<script type="text/javascript">
$(document).ready( function() {
           $('#table1').dataTable( {
             "iDisplayLength": 30,
             "aLengthMenu": [[30, 60, 90, -1], [30, 60, 90, "All"]],
             "bDestroy": true
           } );

         });
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


