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
                <i class="fa fa-desktop"></i>
                <a href="{{ url('/').'/web_admin/newsletter' }}">News Letter</a>
            </li>   
            <span class="divider">
                <i class="fa fa-angle-right"></i>
            </span>
            <li class="active"> {{ isset($page_title)?$page_title:"" }}</li>
        </ul>
      </div>
      <!-- END Breadcrumb -->

 
        <!-- START Main Content -->


          <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-title">
                                <h3><i class="fa fa-file"></i> News Letter Subscribers Information</h3>
                                <div class="box-tool">
                                  
                                </div>
                            </div>
                            <div class="box-content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <!-- <img class="img-responsive img-thumbnail" src="" alt=" logo" /> -->
                                        <br/><br/>
                                    </div>
                                    <div class="col-md-9 user-profile-info">
                                        <p><span>Name:</span>{{ isset($arr_newsletter['name'])?$arr_newsletter['name']:'' }}</p>  
                                        <p><span>Email:</span> {{ isset($amail_address)?$amail_address:'' }}</p> 
                                        <p><span>Status:</span> {{ ($arr_newsletter['is_active'])?'Active':'Deactive' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



        <!-- END Main Content -->


  @stop                    


