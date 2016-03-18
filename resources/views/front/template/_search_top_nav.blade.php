  <!--search area start here-->
       <div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
       <div class="container">
           <div class="row">
           <div class="col-sm-12 col-md-12 col-lg-12">
              <ul class="search_sub">
                        <li>
                           <div class="form-group form-control">

                              <!--<button class="form-control-map ui-widget" aria-hidden="true" type="submit"><img src="images/home_map.png" alt="" /></button>-->
                               <input type="text"
                               @if(Session::has('city'))
                               value="{{Session::get('city') }}"
                                @else value="Mumbai"
                                @endif
                               id="tags"
                               class="search-txt city_finder ui-autocomplete-input"
                               autocomplete="off">
                              <div class="has-feedback">
                                 <input type="text" placeholder="Resturant" class="search-txt">
                                 <button type="submit" aria-hidden="true" class="form-control-feedback"><i class="fa fa-search"></i></button>
                              </div>
                              <!--    <span class="form-control-feedback" aria-hidden="true"><a href="#"><img src="images/search-icon.png" alt="" /></a></span>-->
                           </div>
                        </li>

                     </ul>
               </div>

           </div>
           </div>
       </div>
<!--search area end here-->