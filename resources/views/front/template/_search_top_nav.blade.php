  <!--search area start here-->
       <div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
       <div class="container">
           <div class="row">
           <div class="col-sm-12 col-md-12 col-lg-12">
              <ul class="search_sub">
                        <li>
                           <div class="form-group form-control">
                             {{ csrf_field() }}
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
                                 <input type="text"  class="search-txt" placeholder="Resturant" id="category_search" name="category_search"
                                   @if(Session::has('category_serach'))
                                value="{{Session::get('category_serach') }}"
                                @else value=""
                                @endif
                                 >
                                  <input type="hidden" id="category_id" name="category_id"
                                  @if(Session::has('category_id'))
                                value="{{Session::get('category_id') }}"
                                @else value=""
                                @endif/>
                                 <button type="submit" aria-hidden="true" class="form-control-feedback search_buisness" id="search_buisness"><i class="fa fa-search"></i></button>
                              </div>
                              <!--    <span class="form-control-feedback" aria-hidden="true"><a href="#"><img src="images/search-icon.png" alt="" /></a></span>-->
                           </div>
                        </li>

                     </ul>
               </div>

           </div>
           </div>
       </div>
       <script type="text/javascript">
        var site_url="{{url('/')}}";
        var city="{{Session::get('city') }}";
        var csrf_token = "{{ csrf_token() }}";
       $(document).ready(function()
        {
          var category=$("#category_search").val();
          $("#category_search").autocomplete(
          {
            minLength:3,
            source:site_url+"/get_category_auto",
            search: function( event, ui )
            {
             /* if(category==false)
              {
                  alert("Select Category First");
                  event.preventDefault();
                  return false;
              }*/
            },
            select:function(event,ui)
            {
              $("input[name='category_search']").val(ui.item.label);
              $("input[name='category_id']").val(ui.item.cat_id);

              var type = ui.item.data_type;
              if(type=='list') {
                  var get_url=site_url+'/'+city+'/all-options/ct-'+ui.item.cat_id;
              window.location.href = get_url;
              }
              else
              {
                var get_url=site_url+'/'+city+'/'+ui.item.slug+'/'+ui.item.business_id;
                window.location.href = get_url;
              }
             },
            response: function (event, ui)
            {

            }
          });

        });

        $(document.body).on( 'click', '.search_buisness', function( event )
        {
          var category_search=$("#category_search").val();
          var category_id=$("#category_id").val();
          if(category_search=='')
          {
              alert("Select Category First");
              event.preventDefault();
              return false;
          }
          else
          {
             var get_url=site_url+'/'+city+'/all-options/ct-'+category_id;
              window.location.href = get_url;
          }
        });
      </script>
<!--search area end here-->