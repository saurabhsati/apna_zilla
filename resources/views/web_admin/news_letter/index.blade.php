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
                <a href="{{ url('/').'/web_admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                <i class="fa fa-desktop"></i>
                <a href="{{ url('/').'/web_admin/newsletter' }}">News Letter</a>
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
          <form class="form-horizontal" id="frm_dynamic_pages_manage" method="POST" action="{{ url('/').'/web_admin/newsletter/multi_action' }}">

            {{ csrf_field() }}

            <div class="col-md-10">


            <div id="ajax_op_status">

            </div>
            <div class="alert alert-danger" id="no_select" style="display:none;"></div>
            <div class="alert alert-warning" id="warning_msg" style="display:none;"></div>
          </div>
          <div class="btn-toolbar pull-right clearfix">

          <div class="btn-group">
          <a href="{{ url('/web_admin/newsletter/create')}}" class="btn btn-primary btn-add-new-records">Add New Letter</a>
          </div>
            <div class="btn-group">
          <a href="{{ url('/web_admin/newsletter/compose')}}" class="btn btn-primary btn-add-new-records">Compose Email</a>
          </div>

             <div class="btn-group">
            <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                    title="Multiple Active/Unblock"
                    href="javascript:void(0);"
                    onclick="javascript : return check_multi_action('frm_dynamic_pages_manage','activate');"
                    style="text-decoration:none;">

                    <i class="fa fa-unlock"></i>
                </a>
                </div>
                <div class="btn-group">
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Multiple Deactive/Block"
                   href="javascript:void(0);"
                   onclick="javascript : return check_multi_action('frm_dynamic_pages_manage','block');"
                   style="text-decoration:none;">
                    <i class="fa fa-lock"></i>
                </a>
                </div>
             <div class="btn-group">

                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Multiple Delete"
                   href="javascript:void(0);"
                   onclick="javascript : return check_multi_action('frm_dynamic_pages_manage','delete');"
                   style="text-decoration:none;">
                   <i class="fa fa-trash-o"></i>
                </a>
            </div>
            <div class="btn-group">
                <a class="btn btn-circle btn-to-success btn-bordered btn-fill show-tooltip"
                   title="Refresh"
                   href="{{ url('/').'/web_admin/newsletter' }}"
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
                 <!--  <th>Name</th> -->
                  <th>Email address</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @if(sizeof($arr_data)>0)
                  @foreach($arr_data as $news_letter)
                  <tr>
                    <td>
                      <input type="checkbox"
                             name="checked_record[]"
                             value="{{ base64_encode($news_letter['news_letter_id']) }}" />
                    </td>
                   <!--  <td> {{ $news_letter['name'] }} </td> -->
                    <td> {{ $news_letter['email_address'] }} </td>

                    @if($news_letter['is_active']==1)
                      <td>
                        <a class="btn btn-success" href="{{ url('/').'/web_admin/newsletter/toggle_status/'.base64_encode($news_letter['news_letter_id']).'/deactivate' }}">Active</a>
                      </td>
                    @else
                      <td>
                        <a class="btn btn-danger"href="{{ url('/').'/web_admin/newsletter/toggle_status/'.base64_encode($news_letter['news_letter_id']).'/activate' }}">Blocked</a>
                      </td>
                    @endif

                    <td>
                      <a href="{{ url('/').'/web_admin/newsletter/show/'.base64_encode($news_letter['news_letter_id']) }}">
                          <i class="fa fa-eye" > </i>
                        </a>
                        &nbsp;

                        <a href="{{ url('/').'/web_admin/newsletter/edit/'.base64_encode($news_letter['news_letter_id']) }}">
                          <i class="fa fa-edit" ></i>
                        </a>
                        &nbsp;

                        @if($news_letter['is_active']==0)
                        <a href="{{ url('/').'/web_admin/newsletter/toggle_status/'.base64_encode($news_letter['news_letter_id']).'/activate' }}">
                            <i class="fa fa-lock" ></i>
                        </a>
                        @elseif($news_letter['is_active']==1)
                        <a href="{{ url('/').'/web_admin/newsletter/toggle_status/'.base64_encode($news_letter['news_letter_id']).'/deactivate' }}">
                            <i class="fa fa-unlock" ></i>
                        </a>
                        @endif
                         &nbsp;
                          <a href="{{ url('/').'/web_admin/newsletter/toggle_status/'.base64_encode($news_letter['news_letter_id']).'/delete' }}"
                          onclick="return confirm_delete()">
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

          if(action == 'delete')
          {
            if(confirm_delete() == false)
                return false;
          }

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


