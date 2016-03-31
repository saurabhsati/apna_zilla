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
                <a href="{{ url('/').'/web_admin/places' }}">Place</a>
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
                        <h3><i class="fa fa-file"></i> Place Information</h3>
                        <div class="box-tool">

                        </div>
                    </div>
                    <div class="box-content">
                        <div class="row">

                            <div class="col-md-9 user-profile-info">
                            @if(sizeof($arr_places)>0)
                                <p><span>City Name :</span>{{ isset($arr_places[0]['city_details']['city_title'])?$arr_places[0]['city_details']['city_title']:'' }}</p>

                                 <p><span>State Name :</span> {{ isset($arr_places[0]['state_details']['state_title'])?$arr_places[0]['state_details']['state_title']:'-' }}</p>

                                <p><span>Country Name :</span> {{ isset($arr_places[0]['country_details']['country_name'])?$arr_places[0]['country_details']['country_name']:'' }}</p>
                                <p><span>Postal Code :</span> {{ isset($arr_places[0]['postal_code'])?$arr_places[0]['postal_code']:'' }}</p>
                                <p><span>Place Name :</span> {{ isset($arr_places[0]['place_name'])?$arr_places[0]['place_name']:'' }}</p>
                                <p><span>Latitude :</span> {{ isset($arr_places[0]['latitude'])?$arr_places[0]['latitude']:'' }}</p>
                                <p><span>Longitude :</span> {{ isset($arr_places[0]['longitude'])?$arr_places[0]['longitude']:'' }}</p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- END Main Content -->


  @stop


