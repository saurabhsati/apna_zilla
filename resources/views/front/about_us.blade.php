@extends('front.template.master')

@section('main_section')

<!--search area start here-->
       <div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
       <div class="container">
           <div class="row">
           <div class="col-sm-12 col-md-12 col-lg-12">
             <div class="title_bag">About Us</div>
             </div>
            </div>
           </div>
       </div>
<!--search area end here-->
 <div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
			     <ol class="breadcrumb">
			         <span>You are here :</span>
					  <li><a href="#">Home</a></li>
					  <li class="active">About Us</li>

				</ol>
             </div>
          </div>
     </div>
    <hr/>

       <div class="container">
         <div class="row">
              <div class="col-lg-1">&nbsp;</div>
                     <div class="col-sm-12 col-md-12 col-lg-10">
                          <div class="text_about">
                            Listable provides you with a smart set of tools to showcase your business and connect to your community.<br/> Beautiful, simple and easy to use, Listable is a fun and friendly place to hook up with your customers.
                         </div>
                         <div class="row">
		                      <div class="col-sm-6 col-md-6 col-lg-6 abot_img_l"><img src="{{ url('/') }}/assets/front/images/about_us_1.png" alt="Add or Claim your Listing"/></div>
		                         <div class="col-sm-6 col-md-6 col-lg-6">
		                            <div class="about_box">
                                     <div class="steps_about">1. Add or Claim your Listing</div>
                                         <div class="sub-text-about">Upload photos, add helpful links to your website or to social media, set an address and hours of operation and other informations that you may find relevant.</div>
                                         <div class="link_about"><a href="#">See How a Claimed Listings Looks <img src="{{ url('/') }}/assets/front/images/arrow.png" alt="arrow"/></a></div>
			                          </div>
			                        </div>
			    				   </div>
                        <div class="row">
	                        <div class="col-sm-6 col-md-6 col-lg-6">
	                                     <div class="about_box">
	                                     <div class="steps_about">2. Get Discovered by Visitors</div>
	                                         <div class="sub-text-about">Upon confirmation, your listing will appear throughout the website and will be searchable by visitors interested on similar places. A badge will be added to your listing to mark it as official.</div>
	                                         <div class="link_about"><a href="#">See How a Claimed Listings Looks <img class="abot_img" src="{{ url('/') }}/assets/front/images/arrow.png" alt="arrow"/></a></div>
	                                     </div>
	                         </div>
                             <div class="col-sm-6 col-md-6 col-lg-6 abot_img_r"><img src="{{ url('/') }}/assets/front/images/about_us_1.png" alt="2. Get Discovered by Visitors"/></div>
       					</div>
                        <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6 abot_img_l"><img src="{{ url('/') }}/assets/front/images/about_us_3.png" alt="Increase your earnings"/></div>
	                        <div class="col-sm-6 col-md-6 col-lg-6">
	                                     <div class="about_box">
	                                     <div class="steps_about">3. Increase your earnings</div>
	                                         <div class="sub-text-about">Upon confirmation, your listing will appear throughout the website and will be searchable by visitors interested on similar places. A badge will be added to your listing to mark it as official.</div>
	                                         <div class="link_about"><a href="#">Find and Claim Your Business <img src="{{ url('/') }}/assets/front/images/arrow.png" alt="arrow"/></a></div>
	                                     </div>
	                         </div>
       					</div>
                         <div class="text_a"> Ready to reach all of the people who matter most to your business?</div>
                         <div class="post_org">
                        <!--  <a href="#">Add Your Listng Now</a> -->
                        <?php if(!Session::has('user_name'))
                        {
                          /*echo '<a data-toggle="modal" id="open_register" data-target="#reg_poup" class="btn btn-post" >List your Business </a>';*/
                          echo '<a data-toggle="modal" id="open_register" data-target="#reg_poup" class="btn btn-post" onclick="set_flag()" >Add Your Listing Now </a>';
                        }
                        else {
                          echo '<a class="btn btn-post" href="'.url('/').'/front_users/add_business" id="list_your_business" >Add Your Listing Now</a>';
                        }

                      ?>
                         </div>
           </div>
              <div class="col-lg-1">&nbsp;</div>
      </div>
       </div>
       </div>

@endsection