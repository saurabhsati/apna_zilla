@extends('front.template.master')

@section('main_section')
<!--search area start here-->
<div class="search_bg" style="background: url('{{ url('/') }}/assets/front/images/search_bg.jpg') repeat scroll 0px 0px;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="title_bag">{{ isset($data_page['page_title'])?$data_page['page_title']:"" }}</div>
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
					<li><a href="{{ url('/') }}">Home</a></li>
					<li class="active">{{ isset($data_page['page_title'])?$data_page['page_title']:"" }} </li>

				</ol>
			</div>
		</div>
	</div>
	<hr/>

	<div class="container">
		<div class="row">

			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="content_page">
					<div class="cont_head">{{ isset($data_page['meta_desc'])?$data_page['meta_desc']:"" }}</div>

					<div class="cont_txt"><p>{{ isset($data_page['page_desc'])?$data_page['page_desc']:"" }}</p></div>

					<!-- <div class="cont_head">1. Welcome to Right Next.com</div>
					<div class="cont_txt">
					<p>Praesent tempus leo justo, eget iaculis est molestie nec.
					 Donec accumsan tortor venenatis, imperdiet lectus id, luctus nibh. Vestibulum fermentum
					 elit vel viverra viverra. Suspendisse imperdiet risus eu magna pretium, et faucibus eros mattis.
					  ornare eros quis mauris consectetur porta. Phasellus fermentum fermentum magna a efficitur.
					   fermentum erat eu enim euismod pretium. Sed molestie aliquet purus. Pellentesque et aliquam velit,
					    vulputate maximus quam. Phasellus vel dapibus nisi.</p>
						<p>Mauris diam velit, elementum pretium dolor eu, iaculis hendrerit velit. Maecenas eu ex non
							nibh varius euismod. Suspendisse porta, urna id porttitor faucibus, ex nunc pulvinar nibh,
							et consequat ex ante vel est.</p>
							</div>
							<div class="cont_head">2. Using our Services</div>
							 <div class="cont_txt"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut metus tortor, condimentum eget scelerisque quis, viverra eget orci. Nullam et orci id sem pulvinar condimentum in ut erat. Mauris sed ligula risus. Integer suscipit ante sit amet est suscipit tempor. Phasellus neque felis, commodo eu ultricies id, accumsan at ante.</p>
							   <p>Vivamus tincidunt augue arcu, sit amet dictum urna facilisis at. Integer nec scelerisque metus. Suspendisse ex metus, mattis vel volutpat at, lobortis sed justo. Integer blandit ullamcorper rutrum. In hac habitasse platea dictumst. Nam scelerisque gravida sodales. Integer in mauris nec nunc varius dictum vel a diam. Vivamus pharetra tristique consequat. Mauris id tincidunt nisi, vitae ultricies velit. Phasellus commodo, libero in molestie semper, purus neque ultrices lectus, ac aliquam mauris eros a turpis.</p>
							</div>
							<div class="cont_head">3. Access to the Services</div>
							<div class="cont_txt">
									<p>Aenean scelerisque risus at semper condimentum. Morbi tempus lorem enim, eu pulvinar mi ultrices ut. Aenean congue magna quam, nec laoreet metus suscipit lacinia. Fusce varius finibus lacus. Duis eu rhoncus mi. Nullam pellentesque scelerisque sapien, ac pharetra ligula. Vestibulum viverra, neque at malesuada pellentesque, metus massa luctus odio, sed consequat neque elit quis mauris. Praesent ornare eros quis mauris sodales, ac facilisis nisi molestie. Duis placerat purus vel enim laoreet, vel egestas justo facilisis.
									</p>
									<p>Praesent pellentesque mattis dui quis tempus. Nulla id felis mattis, porttitor augue sed, sollicitudin enim. Nunc interdum facilisis arcu vitae faucibus. Donec sit amet pretium eros. Donec eu porta ipsum.</p>
							</div>

							<div class="cont_head">4. Payment Terms</div>
							<div class="cont_txt">
									<p>Praesent tempus leo justo, eget iaculis est molestie nec
									Donec accumsan tortor venenatis, imperdiet lectus id, luctus nibh. Vestibulum fermentum elit vel
									viverra viverra. Suspendisse imperdiet risus eu magna pretium, et faucibus eros mattis. Etiam ornare
									eros quis mauris consectetur porta. Phasellus fermentum fermentum magna a efficitur. Maecenas fermentum
									erat eu enim euismod pretium. Sed molestie aliquet purus. Pellentesque et aliquam velit, vulputate maximus
									. Phasellus vel dapibus nisi.
									</p>
									<p>Mauris diam velit, elementum pretium dolor eu, iaculis hendrerit velit.
									Maecenas eu ex non nibh varius euismod. Suspendisse porta, urna id porttitor
									, ex nunc pulvinar nibh, et consequat ex ante vel est.</p>
								</div>
							</div> -->

						</div>

					</div>
				</div>
			</div>
			@endsection