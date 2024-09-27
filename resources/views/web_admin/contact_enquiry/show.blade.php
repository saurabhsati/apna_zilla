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
                <a href="{{ url('/').'/web_admin/contact_enquiry' }}">Show Contact Enquiry</a>
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
                          <h3><i class="fa fa-file"></i>Show Contact Enquiry</h3>
                          <div class="box-tool">
                            
                          </div>
                      </div>
                      <div class="box-content">
                          <div class="row">
                              <div class="col-md-9 user-profile-info">
                                  <p><span>Name      :</span>{{ isset($arr_contact['full_name'])?$arr_contact['full_name']:'' }}</p> 
                                  <p><span>Email Address :</span> {{ isset($arr_contact['email_address'])?($arr_contact['email_address']):'' }}</p>

                                   <p><span>Mobile Number :</span> {{ isset($arr_contact['mobile_number'])?($arr_contact['mobile_number']):'' }}</p>

                                  <p><span>Message    :</span>{{ isset($arr_contact['message'])?$arr_contact['message']:"" }}</p>
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
  <!-- END Main Content -->
  @stop                    


