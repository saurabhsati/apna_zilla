<style type="text/css">
 .categ li .active{
    color: #f9a820 !important;
  }
   
</style>
<div class="gry_container" style="padding: 7px 0 16px;">
<div class="black-strip">
   <div class="container">
        <div class="row">
       <div class="col-lg-12">
            <div class="categ">
            <?php  //print_r($deal_category); ?>
           <ul class="sub-munsd hidden-xs hidden-sm">
              <?php 
              if(Request::segment(1) )
              {
                 $city=urldecode(Request::segment(1));
              }
              else
              {
                  $city="Mumbai";
              }?>
          <li><a href="{{ url('/') }}/{{$city}}/deals" class="<?php if( url('/').'/'.$city.'/deals'==Request::url()){echo'active';}?>">All Deals</a>
          </li>
          @if(isset($deal_category) && sizeof($deal_category)>0)

            @foreach($deal_category as $key => $category)
            <?php $category_url='';
             $category_url=url('/').'/'.$city.'/deals/cat-'.$category['cat_slug']; ?>
                  <li class="dropdown w3_megamenu-fw ">
                <a data-hover="dropdown" class="dropdown-toggle ser <?php if('cat-'.$category['cat_slug']==Request::segment(3)){echo'active';}?>" href="<?php echo $category_url;?>" onclick="run_url('<?php echo $category_url;?>');"> {{ ucfirst($category['title'])}}<b style="margin-left:5px;vertical-align:super;" class="caret" > </b></a>
                   <ul class="dropdown-menu abslotd">
                          <li class="w3_megamenu-content withdesc">
                             <ul>
                              @if(isset($allow_deal_sub_category) && sizeof($allow_deal_sub_category)>0)
                                  @foreach($allow_deal_sub_category as $key => $sub_category)
                                    @if($sub_category['parent']==$category['cat_id'])
                                   <li><a href="{{ url('/') }}/{{$city}}/deals/cat-{{$category['cat_slug']}}/{{$sub_category['cat_slug']}}" class="<?php if($sub_category['cat_slug']==Request::segment(4)){echo'active';}?>"> {{ ucfirst($sub_category['title'])}}</a></li>
                                   @endif
                                  @endforeach
                               @endif
                               </ul>
                          </li>
                        </ul>
                 </li>
                @endforeach
               @endif
                  <!-- <li class="dropdown w3_megamenu-fw"><a href="#" class="dropdown-toggle ser" data-hover="dropdown">More <b style="margin-left:5px;vertical-align:super;" class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="w3_megamenu-content withdesc">
                             <ul>
                                 <li><a href="#"> Eyelash Extensions</a></li>
                                  <li><a href="#"> Facial</a></li>
                                  <li><a href="#"> Makeup Application</a></li>
                                  <li><a href="#"> Tinting</a></li>
                                </ul>
                          </li>
                        </ul>
                        </li>  
 -->
                </ul>

          <ul class="sub-munsd hidden-lg hidden-md actv-mns">
              <?php 
              if(Request::segment(1) )
              {
                 $city=urldecode(Request::segment(1));
              }
              else
              {
                  $city="Mumbai";
              }?>
          <li><a href="{{ url('/') }}/{{$city}}/deals" class="<?php if( url('/').'/'.$city.'/deals'==Request::url()){echo'active';}?>">All Deals</a>
          </li>
          @if(isset($deal_category) && sizeof($deal_category)>0)

            @foreach($deal_category as $key => $category)
            <?php $category_url='';
             $category_url=url('/').'/'.$city.'/deals/cat-'.$category['cat_slug']; ?>
                  <li class="dropdown w3_megamenu-fw ">
                <a data-hover="dropdown" class="dropdown-toggle ser <?php if('cat-'.$category['cat_slug']==Request::segment(3)){echo'active';}?>" href="<?php echo $category_url;?>" onclick="run_url('<?php echo $category_url;?>');"> {{ ucfirst($category['title'])}}<b style="margin-left:5px;vertical-align:super;" class="caret" onclick=""> </b></a>
                   <ul class="dropdown-menu abslotd">
                          <li class="w3_megamenu-content withdesc">
                             <ul>
                              @if(isset($allow_deal_sub_category) && sizeof($allow_deal_sub_category)>0)
                                  @foreach($allow_deal_sub_category as $key => $sub_category)
                                    @if($sub_category['parent']==$category['cat_id'])
                                   <li><a href="{{ url('/') }}/{{$city}}/deals/cat-{{$category['cat_slug']}}/{{$sub_category['cat_slug']}}" class="<?php if($sub_category['cat_slug']==Request::segment(4)){echo'active';}?>"> {{ ucfirst($sub_category['title'])}}</a></li>
                                   @endif
                                  @endforeach
                               @endif
                               </ul>
                          </li>
                        </ul>
                 </li>
                @endforeach
               @endif
                  <!-- <li class="dropdown w3_megamenu-fw"><a href="#" class="dropdown-toggle ser" data-hover="dropdown">More <b style="margin-left:5px;vertical-align:super;" class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="w3_megamenu-content withdesc">
                             <ul>
                                 <li><a href="#"> Eyelash Extensions</a></li>
                                  <li><a href="#"> Facial</a></li>
                                  <li><a href="#"> Makeup Application</a></li>
                                  <li><a href="#"> Tinting</a></li>
                                </ul>
                          </li>
                        </ul>
                        </li>  
 -->
                </ul>
           </div>
            </div>

       </div>

        </div>
   </div>
   <script type="text/javascript">
   function run_url(url)
   {
     window.location.href=url;
   }
   </script>