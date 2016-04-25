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
                                 @if(Request::segment(1))
                                value="{{urldecode(Request::segment(1))}}"
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
                                ?>
                                <input type="hidden" value="business_module" id="module_type" name="module_type">
                                <?php
                                 if(Session::has('category_serach'))
                                  {
                                    $set_txt_name= ucwords(Session::get('category_serach'));
                                   }
                                }
                                else if($segment2=='deals')
                                {
                                  ?>
                                <input type="hidden" value="deal_module" id="module_type" name="module_type">
                                <?php
                                  $set_txt_name= ucwords(urldecode(str_replace('-',' ',Request::segment(3))));
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
          var view=$("input[name='module_type']").val();

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
               setSerchCity(ui.item.id,ui.item.label,view);

            },
            response: function (event, ui)
            {

            }
          });

          var category=$("#category_search").val();
          var city_id=$("#city_id").val();
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
              var city_search=$("#city_search").val();
              if(city_search!='')
              {
                city=city_search;
              }
              var type = ui.item.data_type;
              /*alert(type);
              $("#module_type").attr('value',type);*/
              if(type=='list')
              {
                  var get_url=site_url+'/'+city+'/all-options/ct-'+ui.item.cat_id;
                  window.location.href = get_url;
              }
              else if(type=='deal_detail')
              {
                  var get_url=site_url+'/'+city+'/deals/'+ui.item.slug+'/'+ui.item.deal_id;
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
              $('.ui-autocomplete').css({
                     'position': 'absolute'

                  });

             /*$(".ui.autocomplete", ui.item.label)
                 .append('<span style="color:#7b7b7b"> '+ui.item.span+'</span>');*/

            }
          }).data("ui-autocomplete")._renderItem = function (ul, item) {
             return $("<li></li>")
                 .data("item.autocomplete", item)
                 .append( item.label +'<span style="color:#7b7b7b"> '+item.span+'</span>')
                 .appendTo(ul);
            };

        });

        $(document.body).on( 'click', '.search_buisness', function( event )
        {
         var city_search=$("#city_search").val();
         //alert(city_search);
         var category_search=$("#category_search").val();
           if(city_search!='')
          {
            city=city_search;
          }
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

        function setSerchCity(city_id,city_title,view)
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
                 if (response.status == "1")
                  {
                    if(view=='business_module')
                    {
                     var get_url=site_url+'/'+city_title+'/all-options/ct-'+category_id;
                     window.location.href = get_url;
                    }
                     else if(view=='deal_module')
                     {
                      var get_url=site_url+'/'+city_title+'/deals';
                     window.location.href = get_url;
                     }
                  //window.location.href = location.href;
                 }
                 return false;
               }
           });
    }
      </script>
<!--search area end here-->