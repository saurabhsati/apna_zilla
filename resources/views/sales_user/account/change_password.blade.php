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
              
        
            <li class="active">  {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
    </div>
    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->
    
    
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-cog"></i> Change Password </h3>
                    <div class="box-tool">
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
                        action="{{ url('/sales_user/update_password')}}"
                        >
                            {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Current password <i style="color:red;">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="password" class="form-control" name="current_password" id="current_password" data-rule-minlength="6" data-rule-required="true"/>
                                
                                <span class='help-block'>{{ $errors->first('current_password') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">New password <i style="color:red;">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="password" class="form-control" name="new_password" id="new_password" data-rule-minlength="6" data-rule-required="true"/>
                                <span class='help-block'>{{ $errors->first('new_password') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-lg-2 control-label">Re-type new password <i style="color:red;">*</i></label>
                            <div class="col-sm-9 col-lg-4 controls">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" data-rule-minlength="6" data-rule-required="true" data-rule-equalto="#new_password"/>
                                <span class='help-block'>{{ $errors->first('confirm_password') }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- END Main Content -->


@stop