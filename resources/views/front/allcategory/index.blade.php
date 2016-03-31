@extends('front.template.master')

  @section('main_section')
  @include('front.template._search_top_nav')

<div class="gry_container">
    <div class="container">
     <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
       <ol class="breadcrumb">
         <span>You are here:</span>
         <li><a href="{{ url('/') }}">Home</a></li>
         <li class="active">All Categories</li>

       </ol>
     </div>
   </div>
 </div>
 <hr/>
<div class="container">
		<div class="row">
		<!-- <div class="category-head">
               <h3>All Categories</h3>
               <span></span>
            </div> -->
            <div class="cate-count-block">
            <?php
            //echo '<pre>';
            //print_r($arr_category);
            ?>
               <ul class="category_list">
                  @if(isset($arr_category) && sizeof($arr_category)>0)
                  @foreach($arr_category as $key => $category)
                   <?php $count=0; ?>
                  <li>
                     <a href="{{ url('/') }}/{{$current_city}}/category-{{$category['cat_slug']}}/{{$category['cat_id']}}">
                     <span class="cate-img"><img src="{{ $cat_img_path.'/'.$category['cat_img']}}" alt="" height="30px" width="30px" /></span>
                     <span class="cate-txt">{{ ucfirst($category['title'])}}</span>
                    </a>
                  </li>

                  @endforeach
                  @endif

               </ul>
               <div class="clearfix"></div>
            </div>

		</div>
	</div>

</div>

     @endsection