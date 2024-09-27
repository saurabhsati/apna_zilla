@extends('front.template.master')

@section('main_section')

<style type="text/css">
  .error{
    color: red;
    font-size: 12px;
    font-weight: lighter;
    text-transform: capitalize;
  }
</style>


<div class="gry_container">
      <div class="container">
         <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
               <ol class="breadcrumb">
                   <span>You are here :</span>
                  <li><a href="{{ url('/') }}">Home</a></li>
                  <li class="active">Group Booking Request Form</li>
                </ol>
             </div>
          </div>
     </div>
     <hr/>
<div class="container">
         <div class="row">
           
         
            <div class="col-sm-12 col-md-12 col-lg-12">



            <div class="my_whit_bg">
                 <!-- <div class="title_acc"><h3>Group Booking Request Form<h3></div> -->
                 @if(isset($form_data) && sizeof($form_data)>0)
                 <h2>
                   {{$form_data['dealTitle']}}
                 </h2>
                 @endif
                     @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ Session::get('success') }}
                        </div>
                      @endif

                      @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ Session::get('error') }}
                        </div>
                      @endif
                       @if(Session::has('dealUrl') && Session::has('deal_city') )
                         <a  href="{{url('/')}}/{{ Session::get('deal_city')}}/deals" class="yellow1 ui button">Continue Shopping</a>
                         <a  href="{{Session::get('dealUrl')}}" class="yellow1 ui button">Back to Deal</a>
                         @else

                         <div class="error_wrapper">
                         <div class="text-center error_content"><p class="error_name">404</p>
                         <p class="error_discription">Uh oh !</p><p class="error_callback">
                          Sorry but the page you were looking for was not found . <span>
                          Luckily, we have a lot of other awesome pages. Check them out.</span>
                          </p><a href="{{url('/')}}" class="btn_orange visit_orange_btn">Visit our Homepage</a>
                          </div></div>
                          @endif
                   
                </div>
            </div>
         </div>

    </div>
</div>

  </div></div>




@stop