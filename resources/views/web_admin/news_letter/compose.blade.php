    @extends('web_admin.template.admin')                


    @section('main_content')
    <!-- BEGIN Page Title -->

    <div class="page-title">
        <div>

        </div>
    </div>


    <!-- END Page Title -->

    <!-- BEGIN Breadcrumb -->
    <div id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/').'/web_admin/dashboard' }}">Dashboard</a>
            </li>
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                <i class="fa fa-desktop"></i>
                <a href="{{ url('/').'/web_admin/newsletter' }}">News Letter</a>
            </span> 
            <span class="divider">
                <i class="fa fa-angle-right"></i>
                  <i class="fa fa-edit"></i>
            </span>
            <li class="active">{{ isset($page_title)?$page_title:"" }}</li>
        </ul>
      </div>
    <!-- END Breadcrumb -->

    <!-- BEGIN Main Content -->

    <div class="row">
      <div class="col-md-12">

          <div class="box">
            <div class="box-title">
              <h3>
                <i class="fa fa-plus-circle"></i>
                {{ isset($page_title)?$page_title:"" }}
              </h3>
              <div class="box-tool">
                <a data-action="collapse" href="#"></a>
                <a data-action="close" href="#"></a>
              </div>
           </div>
            <div class="box-content">


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

         <!--******************** Add email addreses script **************************-->
           <form class="form-horizontal" 
                id="validation-form" 
                method="POST" 
                action="{{ url('/web_admin/newsletter/send_email') }}" 
                enctype="multipart/form-data"
          > 
          
           {{ csrf_field() }}



          <div class="form-group">
            <label class="col-sm-3 col-lg-2 control-label">To:<i class="red">*</i></label>
            <div class="col-sm-6 col-lg-8 controls">
               <select data-placeholder="Enter Recipient(s) email address "  name="to_address" class="form-control chosen" multiple="multiple" style="height: 25px;" data-rule-required="true">
                  <option value=""> </option>

                    @if(sizeof($arr_newsletter)>0)
                        @foreach($arr_newsletter as $news_letter)
                            <option value="{{ $news_letter['news_letter_id'] }}"> {{ $news_letter['email_address'] }}</option>
                        @endforeach
                    @endif

               </select>
            </div>
          </div>


             <div class="form-group">
              <label class="col-sm-3 col-lg-2 control-label">Compose Email Description<i class="red">*</i></label>
              <div class="col-sm-9 col-lg-10 controls">
              <textarea class="form-control" name="message" rows="6"></textarea> 
                 <span class='help-block'>{{ $errors->first('message') }}</span>
              </div>
           </div>

           <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                <input type="submit"  class="btn btn-primary" value="Send" onclick="return confirm_send();">
            </div>
        </div>

        <input type="hidden" name="email_str" id="email_str" value="">
          </form>
        <!--**************************************************************************-->
       
</div>

      </div>
  </div>
</div>

<!-- END Main Content --> 
<!--page specific plugin scripts-->
<script type="text/javascript" src="{{ url('/') }}/assets/chosen-bootstrap/chosen.jquery.js"></script>

<script type="text/javascript">
    tinymce.init({ selector:'textarea' });
    //tinymce.init('#page_desc');
</script>

   
<script type="text/javascript">
    function confirm_send()
    {
      var email_str = '';

      var class_ele = document.getElementsByClassName('selcted_email');
      for (var i = 0; i < class_ele.length; ++i) {
          var item = class_ele[i]; 
          email_str +=' '+item.innerHTML;
        
      }

      document.getElementById("email_str").value = email_str;
      
       if(confirm('Are you sure you want to send  ?'))
       {
        return true;
       }
       return false;
    }
</script>

@stop                    


