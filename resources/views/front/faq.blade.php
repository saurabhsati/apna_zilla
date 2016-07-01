 @extends('front.template.master')

@section('main_section')
 <!--search area start here-->
       <div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
       <div class="container">
           <div class="row">
           <div class="col-sm-12 col-md-12 col-lg-12">
             <div class="title_bag">FAQs</div>
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
  <li class="active">FAQs</li>

</ol>
             </div>
          </div>
     </div>
     <hr/>

       <div class="container">
         <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <div class="about_us_section min-height">
                     <div id='faq_acc'>
                        <ul>
                        	 @if(isset($faq_pages) && sizeof($faq_pages)>0)
                        	@foreach($faq_pages as $key => $faq )
                           <li class='has-sub <?php if($key==0){echo "active";}?>'>
                              <a href='#'><span>{{ isset($faq['question'])?$faq['question']:"" }}</span>
                              </a>
                              <ul <?php if($key==0){echo "style='display:block;'";}?>>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">{{ isset($faq['answer'])?strip_tags($faq['answer']):"" }}</div>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                           @endforeach
                           @endif

                           <!-- <li class='has-sub'>
                              <a href='#'><span>Should I expect shade variations or imperfection i this product?</span></a>
                              <ul>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">Secoin encaustic cement tiles are hand-made, aesthetic tiles with many colored patterns used for floor and wall coverings.  Our tiles are made with two layers: The first layer (about 2-3mm thick) is a mixture of white cement, pigment, stone powder and additives which is hand-poured into divider mould to create desired patterned. The second layer is made of grey cement and sand to ensure the strength of tiles.</div>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                           <li class='has-sub'>
                              <a href='#'><span>How To post Classifields Ads?</span></a>
                              <ul>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">Secoin encaustic cement tiles are hand-made, aesthetic tiles with many colored patterns used for floor and wall coverings.  Our tiles are made with two layers: The first layer (about 2-3mm thick) is a mixture of white cement, pigment, stone powder and additives which is hand-poured into divider mould to create desired patterned. The second layer is made of grey cement and sand to ensure the strength of tiles.</div>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                           <li class='has-sub'>
                              <a href='#'><span>At vero eos et accusamus et iusto odio dignissimos?</span></a>
                              <ul>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">Secoin encaustic cement tiles are hand-made, aesthetic tiles with many colored patterns used for floor and wall coverings.  Our tiles are made with two layers: The first layer (about 2-3mm thick) is a mixture of white cement, pigment, stone powder and additives which is hand-poured into divider mould to create desired patterned. The second layer is made of grey cement and sand to ensure the strength of tiles.</div>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                           <li class='has-sub'>
                              <a href='#'><span>At vero eos et accusamus et iusto odio dignissimos?</span></a>
                              <ul>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">Secoin encaustic cement tiles are hand-made, aesthetic tiles with many colored patterns used for floor and wall coverings.  Our tiles are made with two layers: The first layer (about 2-3mm thick) is a mixture of white cement, pigment, stone powder and additives which is hand-poured into divider mould to create desired patterned. The second layer is made of grey cement and sand to ensure the strength of tiles.</div>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                           <li class='has-sub'>
                              <a href='#'><span>At vero eos et accusamus et iusto odio dignissimos?</span></a>
                              <ul>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">Secoin encaustic cement tiles are hand-made, aesthetic tiles with many colored patterns used for floor and wall coverings.  Our tiles are made with two layers: The first layer (about 2-3mm thick) is a mixture of white cement, pigment, stone powder and additives which is hand-poured into divider mould to create desired patterned. The second layer is made of grey cement and sand to ensure the strength of tiles.</div>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                           <li class='has-sub'>
                              <a href='#'><span>At vero eos et accusamus et iusto odio dignissimos? </span></a>
                              <ul>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">Secoin encaustic cement tiles are hand-made, aesthetic tiles with many colored patterns used for floor and wall coverings.  Our tiles are made with two layers: The first layer (about 2-3mm thick) is a mixture of white cement, pigment, stone powder and additives which is hand-poured into divider mould to create desired patterned. The second layer is made of grey cement and sand to ensure the strength of tiles.</div>
                                    </div>
                                 </li>
                              </ul>
                           </li>
                           <li class='has-sub'>
                              <a href='#'><span>At vero eos et accusamus et iusto odio dignissimos? </span></a>
                              <ul>
                                 <li>
                                    <div class="row">
                                       <div class="faq-text">Secoin encaustic cement tiles are hand-made, aesthetic tiles with many colored patterns used for floor and wall coverings.  Our tiles are made with two layers: The first layer (about 2-3mm thick) is a mixture of white cement, pigment, stone powder and additives which is hand-poured into divider mould to create desired patterned. The second layer is made of grey cement and sand to ensure the strength of tiles.</div>
                                    </div>
                                 </li>
                              </ul>
                           </li> -->
                        </ul>
                     </div>
                  </div>
               </div>
           </div>
      </div>
   </div>
@endsection