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
                                 @if(Request::segment(2))
                                value="{{urldecode(Request::segment(2))}}"
                                @else value="Mumbai"
                                @endif
                               id="city_search"
                               class="search-txt city_finder ui-autocomplete-input"
                               autocomplete="off">
                               <input type="hidden"
                                id="city_id"
                                name="city_id"
                                value=
                                 <?php
                                 if(Session::has('search_city_id'))
                                 {
                                   echo Session::has('search_city_id');
                                 }else{
                                   echo Session::has('city_id');
                                 }
                               ?>
                                />
                              <div class="has-feedback">
                              <?php
                               $segment2=Request::segment(2);
                               $set_txt_name='';
                               if($segment2=='all-options')
                               {
                                 if(Session::has('category_serach'))
                                  {
                                    $set_txt_name= ucwords(Session::get('category_serach'));
                                   }
                                }
                                else
                                {
                                  if(isset($category_set))
                                  {
                                    $set_txt_name=$category_set;
                                  }
                                  if(Session::has('search_by'))
                                  {
                                    $set_txt_name= ucwords(Session::get('search_by'));
                                  }
                                }
                                ?>
                               <input type="text"  class="search-txt" placeholder="Resturant" id="category_search" name="category_search"
                                value="{{$set_txt_name}}" >
                                  <input type="hidden" id="category_id" name="category_id"
                                  @if(Session::has('category_id'))
                                  value="{{Session::get('category_id') }}"
                                  @else value="0"
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
           $("#city_search").autocomplete(
          {
            minLength:0,
            source:site_url+"/get_city_auto",
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
              $("input[name='get_city']").val(ui.item.label);
              $("input[name='city_id']").val(ui.item.id);
               setSerchCity(ui.item.id,ui.item.label);

            },
            response: function (event, ui)
            {

            }
          });

          var category=$("#category_search").val();
          var city_id=$("#city_id").val();


        });



        function setSerchCity(city_id,city_title)
        {
          var category_id=$("#category_id").val();
          var fromData = {city_id:city_id, city_title:city_title,_token:csrf_token};
           $.ajax({
               url: site_url+"/set_city",
               type: 'POST',
               data: fromData,
               dataType: 'json',
               async: false,

               success: function(response)
               {
                 if (response.status == "1") {
                   var get_url=site_url+'/'+city_title+'/all-options/ct-'+category_id;
                   window.location.href = get_url;
                  //window.location.href = location.href;
                 }
                 return false;
               }
           });
    }
      </script>
<!--search area end here-->