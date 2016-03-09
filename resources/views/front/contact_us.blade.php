@extends('front.template.master')

@section('main_section')
<!--search area start here-->
<div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
 <div class="container">
   <div class="row">
     <div class="col-sm-12 col-md-12 col-lg-12">
       <div class="title_bag">Contact us</div>
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
       <li class="active">Contact us</li>
     </ol>
   </div>
 </div>
</div>
<hr/>

<div class="container">
 <div class="row">
   <div class="col-sm-12 col-md-12 col-lg-12">
     <div class="row">
       <div class="col-sm-6 col-md-6 col-lg-6">
         <div class="box_contact">
           <div class="gren_bor_title">GET IN TOUCH</div>
           <div class="bor_grn">&nbsp;</div>
           <div class="user_box"><input class="input_acct" type="text" placeholder="Name"><div class="error_msg">please enter correct</div></div>
           <div class="user_box"><input class="input_acct" type="text" placeholder="Mobile No"><div class="error_msg">please enter correct</div></div>
           <div class="user_box"><input class="input_acct" type="text" placeholder="Email"><div class="error_msg">please enter correct</div></div>
           <div class="user_box">  <textarea class="textarea_box" placeholder="Message" type=""></textarea><div class="error_msg">please enter correct</div></div>
           <br/>
           <button class="pull-left btn btn-post">Submit now</button>
           <div class="clr"></div>
         </div>
       </div>
       <div class="col-sm-6 col-md-6 col-lg-6">
         <div class="box_contact">
           <div class="row">
             <div class="col-sm-12 col-md-12 col-lg-6">
              <div class="gren_bor_title">Locate us</div>
              <div class="bor_grn">&nbsp;</div>
              <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/map.png" alt="contcat us map"/></span>
               <div class="addrsss">Rightnext Mall 39, M.G. Road Boulevard Ground Floor London</div>
             </div>
             <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/msg.png" alt="message"/></span>
               <div class="addrsss">info@rightnext.com</div>
             </div>

           </div>
           <div class="col-sm-12 col-md-12 col-lg-6">
             <div class="gren_bor_title">Contact Info</div>
             <div class="bor_grn">&nbsp;</div>
             <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/phone.png" alt="contcat us map"/></span>
               <div class="phone-number">+01-234-5789</div>
             </div>

             <div class="user_box">
               <span><img src="{{ url('/') }}/assets/front/images/ph.png" alt="contcat us map"/></span>
               <div class="phone-number">0333 011 1901</div>
             </div>
           </div>
         </div>

         <div class="whit_box">
           <div class="any_q">Have Any Question?</div>
           <div class="get_tuch">Getting in touch? If You have any more Question Not Listed in.</div>
           <div class="btn_gren"><a href="#">Ask a Quesion</a></div>
         </div>
       </div>
     </div>





   </div>
   <div class="gren_bor_title">Map and Location</div>
   <div class="bor_grn">&nbsp;</div>
   <div class="map"> <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3749.453253030988!2d73.80146181487628!3d19.989482927817193!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddeae4e0245423%3A0xeb6a128eb0f552ae!2sWebwing+Technologies!5e0!3m2!1sen!2sin!4v1455886533191" width="100%" height="403" frameborder="0" style="border:0" allowfullscreen></iframe>
   </div>
 </div>
</div>
</div>
</div>
@endsection