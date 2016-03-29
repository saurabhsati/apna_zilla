@extends('front.template.master')

@section('main_section')

 <div class="gry_container">
      <div class="container">
         <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
     <ol class="breadcrumb">
         <span>You are here :</span>
  <li><a href="#">Home</a></li>
  <li class="active">Contact Information</li>
  
</ol>
             </div>
          </div>
     </div>
     <hr/>
     
       <div class="container">
         <div class="row">
             
         <div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->
                   
                <div class="categories_sect sidebar-nav slide_m">
              
                 <div class="sidebar-brand">Business information</div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="">
                    <li class="brdr"><a href="#">Location Information</a></li>
                  <li class="brdr"><a href="#">contact information </a></li>
                  <li class="brdr"><a href="#">other information</a></li>
                     <li class="brdr has-sub"><a href="#"><span>business keywords</span></a>
                    <ul class="make_list" style="display:none;">
                     <li><a href="#">view/remove keywords</a> </li>
                         <li><a href="#">add keywords</a></li> 
                       </ul>
                     </li>
                  <li class="brdr"><a href="#">upload video/logo/pictures</a></li>
    
                 
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
                
                
                <div class="categories_sect sidebar-nav slide_m">
              
                 <div class="sidebar-brand">Service Request</div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="">
                    <li class="brdr"><a href="#">ECS/CCSI Active/Pause</a></li>
                  <li class="brdr"><a href="#">Submit An online Request/Complaint</a></li>
              
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
            </div>
             
         
             
             
             <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="my_whit_bg">
                 <div class="title_acc">Please provide home and office address</div>
                   <div class="row">
             
        
                       
                   <!--      <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="box_profile">
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">Contact Person <span>:</span></div>
                   <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                      <div class="row">
                         <div class="col-sm-2 col-md-2 col-lg-2">
                           <select class="input_acct">
                                 <option>Mr.</option>
                             <option>Miss.</option>
                            
                        </select>  
                            </div>
                          <div class="col-sm-5 col-md-5 col-lg-6"> <input type="text" class="input_acct" placeholder="Enter name"></div>
                          <div class="col-sm-5 col-md-5 col-lg-4"> <input type="text" class="input_acct" placeholder="Designation"></div></div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div> -->
                    
                    <!--  <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">Contact Person <span>:</span></div>
                   <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                      <div class="row">
                         <div class="col-sm-2 col-md-2 col-lg-2">
                           <select class="input_acct">
                                 <option>Mr.</option>
                             <option>Miss.</option>
                            
                        </select>  
                            </div>
                          <div class="col-sm-5 col-md-5 col-lg-6"> <input type="text" class="input_acct" placeholder="Enter name"></div>
                            <div class="col-sm-5 col-md-5 col-lg-4"> <input type="text" class="input_acct" placeholder="Designation"></div></div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                     -->


                <div class="user_box_sub">
                  <div class="row">
                    <div class="col-lg-3  label-text">Mobile No:</div>
                      <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <input type="text" name="mobile_number" class="input_acct" placeholder="Enter Mobile Number" />
                      </div>
                    </div>
                </div>

                 <div class="user_box_sub">
                   <div class="row">
                      <div class="col-lg-3  label-text">Landline No:</div>
                      <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                           <input type="text" name="landline_number"  class="input_acct" placeholder="Enter Landline Number" />
                      </div>
                    </div>
                  </div>




                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">Landline No <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                      <input class="std_cont_inpt" type="text" placeholder="STD">
                        <input type="text"  class="input_acct half_2_input" placeholder="Enter landline"/>
                        <div class="hyper_link_more"><a href="#">Add more landline number</a></div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                    
                     
                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">Mobile No. 1<span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91</span>
                        <input type="text" class="form-control" placeholder="Mobile No" aria-describedby="basic-addon1" required/>
                              
                        </div>  
                         <div class="hyper_link_more"><a href="#">Add more mobile number</a></div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">fax No. <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91-22</span>
                        <input type="text" class="form-control" placeholder="fax No" aria-describedby="basic-addon1" required/>
                            
                        </div>  
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">fax No.2 <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91-22</span>
                        <input type="text" class="form-control" placeholder="fax No" aria-describedby="basic-addon1" required/>
                            
                        </div>  
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                   
                    
                  
                     
                   
                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">Toll free no. <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Toll free no "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                      <div class="user_box_sub">
                        <div class="row">
                    <div class="col-lg-2 label-text">Toll free no2. <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Toll free no "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">Email Id <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Email Id "/>
                         <div class="hyper_link_more"><a href="#">Add more Email Id</a></div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                   
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-2 label-text">website <span>:</span></div>
                    <div class="col-sm-12 col-md-12 col-lg-10 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Website"/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                   
                  
                    
                                   </div>
           <div class="button_save1">
                    <button type="submit" class="btn btn-post pull-left" style="float: left; margin-left:125px; margin-top: 15px" name="add_business" >Save &amp; continue</button>
                <!--<a class="btn btn-post pull-left" href="#">previous</a>
                    <a class="btn btn-post" href="#">Save &amp; exit</a>

                    <a class="btn btn-post pull-right" href="#">Next</a> -->
                 </div>
                       </div>
                      
                </div>
                
                 </div>
               
            
              
             </div>
         </div>
       </div>
       
      </div>  



<script type="text/javascript">

    var site_url = "{{url('/')}}";
    
    function loadPreviewImage(ref)
    {
        var file = $(ref)[0].files[0];

        var img = document.createElement("img");
        reader = new FileReader();
        reader.onload = (function (theImg) {
            return function (evt) {
                theImg.src = evt.target.result;
                $('#preview_profile_pic').attr('src', evt.target.result);
            };
        }(img));
        reader.readAsDataURL(file);
        $("#removal_handle").show();
    }

    function clearPreviewImage()
    {
        $('#preview_profile_pic').attr('src',site_url+'/images/front/avatar.jpg');
        $("#removal_handle").hide();
    }
</script>

<script type="text/javascript"> 
jQuery(document).ready(function () {
 token   = jQuery("input[name=_token]").val();
  jQuery('#city').on('change', function() {
    var city_id = jQuery(this).val();
    jQuery.ajax({
       url      : site_url+"/front_users/get_state_country?_token="+token,
       method   : 'POST',
       dataType : 'json',
       data     : { city_id:city_id },
       success: function(responce){
          if(responce.length == 0)
          {
            var  state   = "<option value='' >State</option>";
            var  country = "<option value='' >Country</option>";  
          }else
          {
            var  state   = "<option value='"+responce.state_id+"' >"+responce.state_name+"</option>";
            var  country = "<option value='"+responce.country_id+"' >"+responce.country_name+"</option>";
          }
          $('#state').html(state);
          $('#country').html(country);
       }  
    });
  });  
});
</script>


@stop