@extends('front.template.master')

@section('main_section')
@include('front.template._search_top_nav')
<!--search area end here-->
<style type="text/css">
       .brdr.has-sub img {
    display: inline-block;
    float: left;
    margin-right: 6px;
}
    hr.nn {
    border-color: #ddd;
    border-width: 2px;
    margin: -1px 0 5px;
}
</style>
<div class="gry_container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<ol class="breadcrumb">
					<span>You are here:</span>
					<li><a href="{{ url('/') }}">Home</a></li>
					<li class="active">search </li>

				</ol>
			</div>
		</div>
	</div>
	<hr/>

	<div class="container">
		<div class="row">
		<?php //echo '<pre>';print_r($arr_sub_category);?>
			<div class="col-lg-1">&nbsp;</div>
			<div class="col-sm-12 col-md-12 col-lg-10">
				<div class="my_whit_bg">
					<div class="title_acc"> Refine your search by clicking any of the links below </div>
					<div class="categories_sect sidebar-nav slide_m">

						<div class="sidebar-brand"><img src="{{ url('/') }}/assets/front/images/shapes.png" alt=""/>Popular Categories</div>
						<div class="bor_head">&nbsp;</div>
						@if(isset($arr_sub_category) && sizeof($arr_sub_category)>0)
                        @foreach($arr_sub_category as $sub_category)
						<ul class="">
						    @if($sub_category['is_popular']==1)
						<li class="brdr has-sub"><a href="{{ url('/') }}/{{$c_city}}/all-options/ct-{{$sub_category['cat_id']}}"><img src="{{ url('/') }}/assets/front/images/shape.png" alt=""/><span>{{$sub_category['title']}}</span></a></li>
							<hr class="nn"/>
							 @else
							 <li class="brdr"><a href="{{ url('/') }}/{{$c_city}}/all-options/ct-{{$sub_category['cat_id']}}">{{$sub_category['title']}}</a></li>
							 @endif
							</ul>
						@endforeach
						@endif
						<!-- /#Categoriesr End-->
						<div class="clearfix"></div>
					</div>

				</div>
			</div>
			<div class="col-lg-1">&nbsp;</div>
		</div>
	</div>

</div>
@endsection