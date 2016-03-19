 <!--slider start here-->
      <div class="intro-header">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="intro-message">
                     <h1>
                        Discover Your City
                        <br/>
                        <span></span>
                     </h1>
                     <ul class="list-inline">
                        <li>
                           <div class="form-group form-control">
                          {{ csrf_field() }}
                              <!--<button class="form-control-map ui-widget" aria-hidden="true" type="submit"><img src="images/home_map.png" alt="" /></button>-->
                               <input type="text" class="search-txt city_finder" id="tags"
                               placeholder="Vishakhapatanm"
                               @if(Session::has('city'))
                               value="{{Session::get('city') }}"
                                @else value="Mumbai"
                                @endif />
                              <div class="has-feedback">
                                 <input type="text" class="search-txt" placeholder="Resturant" id="category_search" name="category_search" value=""/>
                                  <input type="hidden" id="category_id" name="category_id" value=""/>
                                 <button class="form-control-feedback search_home_buisness" aria-hidden="true" type="submit"><img src="{{ url('/') }}/assets/front/images/home_search.png" alt="" /></button>
                              </div>
                              <!--    <span class="form-control-feedback" aria-hidden="true"><a href="#"><img src="images/search-icon.png" alt="" /></a></span>-->
                           </div>
                        </li>
                        <!--
                           <li>
                               <input type="text" class="form-control search-txt" id="" placeholder="Location">
                           </li>
                           <li>
                               <input type="text" class="form-control search-txt" id="" placeholder="Select Category">
                           </li>
                           -->
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script type="text/javascript">
      var site_url="{{url('/')}}";
      var city="{{Session::get('city') }}";
            var csrf_token = "{{ csrf_token() }}";
        $(function(){
          var category=$("#category_search").val();
          $("#category_search").autocomplete({
          minLength:3,
          source:site_url+"/get_category_auto/"+category,
          search: function( event, ui )
          {
            if(category==false)
            {
                alert("Select Category First");
                event.preventDefault();
                return false;
            }
          },
          select:function(event,ui)
          {
            $("input[name='category_search']").val(ui.item.label);
            $("input[name='category_id']").val(ui.item.id);
            //$("input[name='category_search']").val(ui.item.value);

           },
          response: function (event, ui)
          {

          }
           });
        });

$(document.body).on( 'click', '.search_home_buisness', function( event ) {

        var category_id=$( "#category_id").val();
        var category_search=$("#category_search").val();
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
       <!--slider start here-->