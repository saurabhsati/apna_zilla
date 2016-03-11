@extends('front.template.master')

@section('main_section')

<div class="container">
         <div class="row">
             
            <div class="col-sm-12 col-md-3 col-lg-3">
               <!-- Categories Start -->
                   
                <div class="categories_sect sidebar-nav slide_m">
              
                 <div class="sidebar-brand">Fill Profile in Few Steps<span class="spe_mobile">&nbsp;<!--<a href="#"></a>--></span></div>
                 <div class="bor_head">&nbsp;</div>
                 <ul class="spe_submobile">
                    <li class="brdr"><span class="steps">1</span><a href="#">Personal Details</a></li>
                  <li class="brdr"><span class="steps">2</span><a href="#">Addresses</a></li>
                  <li class="brdr"><span class="steps">3</span><a href="#">Family &amp; Friends</a></li>
                  <li class="brdr"><span class="steps">4</span><a href="#">4Credit / Debit Cards</a></li>
                     <li class="brdr has-sub"><span class="steps">5</span><a href="#"><span>Bills &amp; Recharge</span></a>
                    <ul class="make_list" style="display:none;">
                     <li><a href="#">Prepaid Mobile</a> </li>
                         <li><a href="#">Data Card</a></li> 
                         <li><a href="#">DTH</a> </li>
                         <li><a href="#">Electricity</a> </li>
                         <li><a href="#">Postpaid Mobile</a></li>
                         <li><a href="#">Gas Bills</a> </li>
                         <li><a href="#">Insurance Premiums</a> </li>
                         <li><a href="#">Landline</a></li>
                      </ul>
                     </li>
                  <li class="brdr"><span class="steps">6</span><a href="#">Grocery List</a></li>
                  <li class="brdr"><span class="steps">7</span><a href="#">Pharmacy List</a></li>
                     <li class="brdr has-sub"><span class="steps">8</span> <a href="#"><span>Insurance</span></a>
                       <ul class="make_list" style="display:none;">
                     <li><a href="#">Insurance Premiums</a></li>
                       <li><a href="#">Home</a></li>
                       <li><a href="#">Car</a></li>
                       <li><a href="#">Two Wheeler</a></li>
                      </ul>
                     </li>
                     
                                    
                                    
                               
                  <li class="brdr"><span class="steps">9</span><a href="#">Service &amp; Repairs</a></li>
                  <li class="brdr"><span class="steps">10</span><a href="#">Documents</a></li>
                  <li class="brdr"><span class="steps">11</span><a href="#">Favorites</a></li>
                  <li class="brdr"><span class="process_done">12</span><a href="#">Completed</a></li>
                 
               </ul>
               <!-- /#Categoriesr End-->
               <div class="clearfix"></div>
                    </div>
            </div>
             
            <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="my_whit_bg">
                 <div class="title_acc">Please provide home and office address</div>
                   <div class="row">
             
        <div class="col-sm-3 col-md-3 col-lg-3">
                <div class="profile_box">
                    <div class="ig_profile" id="dvPreview">  <img src="images/no-profile.png" alt="no profile view"/></div>
                                                           <div class="button_shpglst">
                              <div class="fileUpload or_btn"><span>Upload Photo</span><input id="fileupload" type="file" value="Change Picture" class="upload change_pic"></div>
                                <div class="remove_b"><a href="#"><i class="fa fa-times"></i> Remove</a></div>                               
                              <div class="clr"></div>
                                 <div class="line">&nbsp;</div>
                           </div>
        
                </div>
              
                       </div>
                       
                        <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="box_profile">
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">First Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                      <div class="row">
                         <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct">
                                 <option>Mr.</option>
                             <option>Miss.</option>
                            
                        </select>  
                            </div>
                          <div class="col-sm-9 col-md-9 col-lg-9"> <input type="text"  class="input_acct" placeholder="Enter name"/></div></div>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Middle Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Middle Name"/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Last Name :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Last Name "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Email ID :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Email ID  "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile No. 1:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91</span>
                        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required/>
                            
                        </div>  
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Mobile No. 2:</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">+91</span>
                        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required/>
                            
                        </div>  
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Home Landline :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                      <input class="std_cont_inpt" type="text" placeholder="STD">
                        <input type="text"  class="input_acct half_2_input" placeholder="Enter home landline"/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Office Landline :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                          <input class="std_cont_inpt" type="text" placeholder="STD">
                        <input type="text"  class="input_acct half_2_input" placeholder="Enter office landline"/>
                          <input class="std_cont_inpt" type="text" placeholder="EXTN">
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">DOB :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                        <div class="row">
                         <div class="col-sm-3 col-md-3 col-lg-2">
                           <select class="input_acct">
                                 <option>dd</option>
                             <option>1</option>
                             <option>2</option>
                               <option>3</option>
                             <option>4</option>
                        </select>  
                            </div>
                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct">
                             <option>mm</option>
                             <option>Jan</option>
                                 <option>Feb</option>
                                 <option>March</option>
                                 <option>April</option>
                                 <option>May</option>
                        </select>  
                            </div>
                             <div class="col-sm-3 col-md-3 col-lg-3">
                           <select class="input_acct">
                             <option>Year</option>
                             <option>2016</option>
                                 <option>2017</option>
                                 <option>2018</option>
                                  <option>2019</option>
                        </select>  
                            </div>
                        </div>
                       
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                     <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Marital Status :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <select class="input_acct">
                             <option>Single</option>
                             <option>Married</option>
                        </select>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                      <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">City :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter City "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                    
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Area :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Area "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                   
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Pincode :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <input type="text"  class="input_acct" placeholder="Enter Pincode  "/>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                  
                    <div class="user_box_sub">
                           <div class="row">
                    <div class="col-lg-3  label-text">Occupation :</div>
                    <div class="col-sm-12 col-md-12 col-lg-9 m_l">
                         <select class="input_acct">
                             <option>Employed</option>
                             <option>officer</option>
                        </select>
                          <div class="error_msg">please enter correct</div>
                        </div>
                         </div>
                    </div>
                  </div>
                  
              <div class="button_save"><a href="#" class="btn btn-post">Save &amp; continue</a></div>
                       </div>
                      
                </div>
                
                 </div>
                          
             </div>
         </div>
       </div>
       
      </div>      

@endsection