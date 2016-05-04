   @extends('front.template.landing')

   @section('main_section')
   <script type="text/javascript">
      $(document).ready(function () {
        $('#shop_tab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion
                    width: 'auto', //auto or any width like 600px
                    fit: true,   // 100% fit in a container
                    closed: 'accordion', // Start closed if in accordion view
                    activate: function(event) { // Callback function if tab is switched
                     var $tab = $(this);
                     var $info = $('#tabInfo');
                     var $name = $('span', $info);

                     $name.text($tab.text());

                     $info.show();
                  }
               });

        $('#verticalTab').easyResponsiveTabs({
          type: 'vertical',
          width: 'auto',
          fit: true
       });
     });
   </script>
   <div class="catetory-block">
      <div class="container">

         <div class="category-head">
            <h3>Most Popular Categories</h3>
            <span></span>
         </div>
         <div class="cate-count-block">
            <?php
               //echo '<pre>';
               //print_r($arr_category);
            ?>
            <ul class="category_list">
               @if(isset($arr_category) && sizeof($arr_category)>0)
               @foreach($arr_category as $key => $category)
               <?php $count=0; ?>
               <li <?php if($key>11){echo 'style=display:none;';}?> >
                  <a href="{{ url('/') }}/{{$current_city}}/category-{{$category['cat_slug']}}/{{$category['cat_id']}}">
                     <span class="cate-img"><img src="{{ $cat_img_path.'/'.$category['cat_img']}}" alt="" height="30px" width="30px" /></span>
                     <span class="cate-txt">{{ ucfirst($category['title'])}}</span>
                     <span class="cate-count">
                       @foreach($sub_category as $subcategory)
                       <?php
                       if($subcategory['parent']==$category['cat_id'])
                       {
                          if(array_key_exists($subcategory['cat_id'],$category_business))
                          {
                           if($count==0)
                           {
                            $count=$category_business[$subcategory['cat_id']];
                         }
                         else
                         {
                          $count=$count+$category_business[$subcategory['cat_id']];
                       }
                    }
                 }
                 ?>
                 @endforeach
                 <?php //echo '('.$count.')';?>
              </span>
           </a>
        </li>

        @endforeach
        @endif

     </ul>
     <div class="clearfix"></div>
  </div>
  <div class="all-cate-btn browse_all_cat btns-widt">
   <button> Browse All Popular Categories</button>
</div>
</div>
</div>


<div class="explore-category">
   <div class="container">
      <div class="exp-category-head">
         <h3>Explore Directory Category</h3>
         <span></span>
      </div>
      <div class="cate-content">
         Lorem Ipsum is simply dummy text of the printing and typesetting industry.
         Lorem Ipsum has been the
      </div>
      <div class="tours-detail-tab">
         <div id="shop_tab">
            <ul class="resp-tabs-list cate-btns">
            <!--  <li>ALL</li> -->
              @if(isset($explore_category) && sizeof($explore_category)>0)
               @foreach($explore_category as $key => $category)
                   <li lang="{{$category['cat_id']}}" id="exp_cat" onclick="return get_business_by_exp_categry(this);">{{ ucfirst($category['title'])}}</li>
             @endforeach
            @endif

             <div class="clearfix"></div>
          </ul>
          <div class="resp-tabs-container" id="cat_tabs_result">
         <div>
                           <div class="row" id="cattab1">
                             @if(isset($business_listing) && sizeof($business_listing)>0)
                             @foreach($business_listing as $key => $business)
                              <?php
                             $slug_business=str_slug($business['business_name']);
                             $slug_area=str_slug($business['area']);
                             $business_area=$slug_business.'@'.$slug_area;
                            ?>
                            <a href="{{url('/')}}/{{$current_city}}/{{$business_area}}/{{base64_encode($business['id'])}}">
                                 <div class="col-sm-3 col-md-3 col-lg-3 col-bott-mar">

                                 <div class="first-cate-img">
                                    <img class="over-img" alt="" src="{{get_resized_image_path($business['main_image'],$main_image_path,205,270) }}">
                                    @if($business['is_verified']==1)<img class="first-cate-veri" src="{{ url('/') }}/assets/front/images/verified.png" alt="write_review"/>@endif
                                 </div>
                                 <div class="first-cate-white">
                                    <div class="f1_container">
                                       <div class="f1_card shadow">
                                          <div class="cate-addre-block-two front face">
                                          <div class="img-hm img_circle">
                                          <img alt="" src="{{get_resized_image_path($first_cat_images,'uploads/category',16,16) }}"><!-- <img alt="" src="{{url('/')}}/assets/front/images/plus-incc.png"> -->
                                          </div>
                                          <div class="img-hm1">
                                          <img alt="" src="{{url('/')}}/assets/front/images/cate-address-ica.png">
                                          </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="resta-name">
                                       <h6>{{$business['business_name']}}</h6>
                                       <span></span>
                                    </div>
                                    <div class="resta-content">
                                      {{$business['building']}} &nbsp {{$business['street']}} &nbsp{{ $business['landmark']}}&nbsp{{$business['area']}}&nbsp -{{$business['pincode']}}
                                    </div>
                                        <div class="resta-rating-block">
                                    <?php for($i=0;$i<round($business['avg_rating']);$i++)
                                        { ?>
                                       <i class="fa fa-star star-acti"></i>
                                        <?php
                                      }
                                       for($i=0;$i<(5-round($business['avg_rating']));$i++){?>
                                      <i class="fa fa-star"></i>
                                       <?php }?>

                                     </div>
                                 </div>
                              </div>
                           </a>
                            @endforeach
                           @endif
                           </div>
                         </div>
              <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>

         </div>


      </div>
      <br />
   </div>
<div class="email-block">
   <div class="email-content">
      Be A Part Of Our Family &amp; Get Everything In Your
      Email Address
   </div>
<div style="position:fixed;
                top: 0;
                bottom: 0;
                left:0;
                right:0;
                background-color:#ccc;
                opacity:0.5;
                display:none;"
          id="subscribr_loader">
                <img src="{{url('/')}}/assets/front/images/ajax-loader.gif" style="height:100px; width:100px; position:absolute; top:35%;left:45%" />
        </div>

   <form class="form-horizontal"
   id="newsletter_form"
   method="POST"
   action="{{ url('/newsletter') }}"
   enctype="multipart/form-data"
   >

   {{ csrf_field() }}

   <div class="email-textbox">

      <img src="{{ url('/') }}/assets/front/images/email-image.png" alt="" />
      <input type="text" name="email" id="email" placeholder="Enter Your Email Address" />
      <div class="error_msg" id="err_email"></div>
      <div class="alert alert-success fade in  " id = "contact_succ_info" style="display:none;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Info!</strong> Already Subscribe For This Email ID..
          </div>
          <div class="alert alert-success fade in " id = "contact_succ" style="display:none;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> Thank You ,Your are Subscribe Successfully..
          </div>
           <div class="alert alert-danger" style="display:none;" id = "contact_err">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Error!</strong>While Subscribing Email .
          </div>

      <button  type="button" id="submit_subscriber" name="submit_subscriber"><i class="fa fa-paper-plane"></i></button>
   </div>

</form>

</div>
<div class="how-it-work-block">
   <div class="category-head how-it">
      <h3>How It Work</h3>
      <span></span>
   </div>
   <div class="row">
      <div class="col-sm-4 col-md-4 col-lg-4">
         <div class="what-to-do">
            <div class="f1_container-tow">
               <div class="f1_card shadow">
                  <div class="front face"><img src="{{ url('/') }}/assets/front/images/how-to-img1.png" alt="" /> </div>
               </div>
            </div>
            <h4><a href="#">Choose What To Do</a></h4>
            <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</h6>
         </div>
      </div>
      <div class="col-sm-4 col-md-4 col-lg-4">
         <div class="what-to-do">
            <div class="f1_container-tow">
               <div class="f1_card shadow">
                  <div class="front face"><img src="{{ url('/') }}/assets/front/images/how-to-img2.png" alt="" /></div>
               </div>
            </div>
            <h4><a href="#">Find What You Want</a></h4>
            <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</h6>
         </div>
      </div>
      <div class="col-sm-4 col-md-4 col-lg-4">
         <div class="what-to-do">
            <div class="f1_container-tow">
               <div class="f1_card shadow">
                  <div class="front face"><img src="{{ url('/') }}/assets/front/images/how-to-img3.png" alt="" /></div>
               </div>
            </div>
            <h4><a href="#">Explore Amazing Places</a></h4>
            <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's</h6>
         </div>
      </div>
   </div>
</div>
</div>
<div class="container">
 <div class="exp-category-head">
         <h3>  Recent Search History</h3>

         <button class="btn btn-view-history"type="button" name="btn_history" id="btn_history" onclick="loadScript()">View</button>
       <!-- <a class="btn btn-post" href="javascript void(0);" id="btn_history" onclick="loadScript()">View</a> -->
         <span></span>
      </div>
      <div id="history">

</div>




</div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
   $('.browse_all_cat').click(function(){
      $('ul.category_list *').removeAttr('style');
      $('.browse_all_cat').css('display','none');
   });

function get_business_by_exp_categry(ref)
{

   var exp_cat = $(ref).attr('lang');
   var fromData = {
                                exp_cat:exp_cat,
                                _token:csrf_token
                                  };
                              $.ajax({
                                 url: site_url+"/get_business_by_exp_categry",
                                 type: 'POST',
                                 data: fromData,
                                 dataType: 'html',
                                 async: false,
                                 success: function(responseresult)
                                 {
                                  if(responseresult.length>0)
                                  {
                                    $('#cat_tabs_result').html('<div> <div class="row">'+responseresult+'</div></div>');
                                  }
                                  else
                                  {
                                     $('#cat_tabs_result').html('<div ><div class="row"><span><h4 >Sorry , No Business Found !!</h4></span></div></div>');
                                  }
                                 }
                             });
}
$(document).ready(function(){

  $("#submit_subscriber").click(function(e){
     e.preventDefault();
      var email=$('#email').val();
       var filter = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
       if(email.trim()=='')
      {
        $('#err_email').html('Enter Your Email ID.');
        $('#err_email').show();
        $('#email').focus();
        $('#email').on('keyup', function(){
        $('#err_email').hide();
          });


      }
      else if(!filter.test(email))
     {
        $('#err_email').html('Enter Valid Email ID.');
        $('#err_email').show();
        $('#email').focus();
        $('#email').on('keyup', function(){
        $('#err_email').hide();
          });
       }
       else
      {
        $.ajax({
          type:"POST",
          url:site_url+'/newsletter',
          data:$("#newsletter_form").serialize(),
          beforeSend: function()
          {
            $("#subscribr_loader").show();
          },
          success:function(res)
          {
            if(res=="success")
            {
               $("#contact_succ").fadeIn(3000).fadeOut(3000);
               $("#newsletter_form").trigger('reset');
            }
            else if(res=="exist")
            {
               $("#contact_succ_info").fadeIn(3000).fadeOut(3000);
               $("#newsletter_form").trigger('reset');
            }
            else
            {

              $("#contact_err").fadeIn(3000).fadeOut(3000);
            }
          },
          complete: function() {

          $("#subscribr_loader").hide();

          }
        });


      }

  });
});
   function loadScript()
    {
      if (localStorage.getItem("history") != null)
         {
             var historyTmp = localStorage.getItem("history");

             console.log(historyTmp);

             //var history = $('#history');
             var fromData = {
                                history:historyTmp,
                                _token:csrf_token
                                  };
                              $.ajax({
                                 url: site_url+"/get_business_history",
                                 type: 'POST',
                                 data: fromData,
                                 dataType: 'html',
                                 async: false,
                                 success: function(responseresult)
                                 {
                                  $('#history').html('<div> <div class="row">'+responseresult+'</div></div>');

                                 }
                             });
          }
          else
          {

            $('#history').html('<div> <div class="row"><h4>No Recent History<h4></div></div>');
          }
    }

    //window.onload = loadScript;
</script>


@endsection