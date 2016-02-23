<!-- HEader -->        
@include('web_admin.template.header')    
        
<!-- BEGIN Sidebar -->
@include('web_admin.template.sidebar')
<!-- END Sidebar -->

<!-- BEGIN Content -->
<div id="main-content">
    @yield('main_content')
</div>
    <!-- END Main Content -->

<!-- Footer -->        
@include('web_admin.template.footer')    
                
              