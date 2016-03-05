<!-- HEader -->        
@include('sales_user.template.header')    
        
<!-- BEGIN Sidebar -->
@include('sales_user.template.sidebar')
<!-- END Sidebar -->

<!-- BEGIN Content -->
<div id="main-content">
    @yield('main_content')
</div>
    <!-- END Main Content -->

<!-- Footer -->        
@include('sales_user.template.footer')    
                
              