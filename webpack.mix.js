const mix = require('laravel-mix');

mix
    //WEB
    .styles([
        'resources/views/web/assets/css/bootstrap.css'
    ], 'public/frontend/assets/css/bootstrap.css') 

    .styles([
        'resources/views/web/assets/css/style.css'
    ], 'public/frontend/assets/css/style.css') 

    .styles([
    'resources/views/web/assets/css/colors/color1.css'
    ], 'public/frontend/assets/css/colors/color1.css') 

    .styles([
    'resources/views/web/assets/css/animate.css'
    ], 'public/frontend/assets/css/animate.css') 

    .copyDirectory('resources/views/web/assets/font','public/frontend/assets/font')

    .scripts([
        'resources/views/web/assets/js/jquery.min.js'
    ], 'public/frontend/assets/js/jquery.min.js')

    .scripts([
        'resources/views/web/assets/js/jquery.easing.js'
    ], 'public/frontend/assets/js/jquery.easing.js')

    .scripts([
        'resources/views/web/assets/js/matchMedia.js'
    ], 'public/frontend/assets/js/matchMedia.js')

    .scripts([
        'resources/views/web/assets/js/bootstrap.min.js'
    ], 'public/frontend/assets/js/bootstrap.min.js')

    .scripts([
        'resources/views/web/assets/js/jquery-waypoints.js',
        'resources/views/web/assets/js/jquery.flexslider.js',
        'resources/views/web/assets/js/jquery.transit.js',
        'resources/views/web/assets/js/jquery.leanModal.min.js',
        'resources/views/web/assets/js/jquery.tweet.min.js',
        'resources/views/web/assets/js/jquery.cookie.js',
        'resources/views/web/assets/js/switcher.js',
        'resources/views/web/assets/js/jquery.doubletaptogo.js',
        'resources/views/web/assets/js/smoothscroll.js'
    ], 'public/frontend/assets/js/libs.js')

    .scripts([
        'resources/views/web/assets/js/main.js'
    ], 'public/frontend/assets/js/main.js')
    
 //ADMIN
 
 
//  .styles([
//      'resources/views/admin/dist/css/adminlte.min.css'
//  ], 'public/backend/assets/css/adminlte.min.css')
 //Login fim
 
//  .copyDirectory('resources/views/admin/plugins/fontawesome-free','public/backend/assets/plugins/fontawesome-free')
//  .copyDirectory('resources/views/admin/plugins/icheck-bootstrap','public/backend/assets/plugins/icheck-bootstrap')
//  .copyDirectory('resources/views/admin/dist/images','public/backend/assets/images')
 
 //Login 
//    .scripts([
//        'resources/views/admin/plugins/jquery/jquery.min.js'
//    ], 'public/backend/assets/js/jquery.js')
 //.copyDirectory('resources/views/admin/plugins/jquery','public/backend/assets/plugins/jquery')
 //.copyDirectory('resources/views/admin/plugins/bs-custom-file-input','public/backend/assets/plugins/bs-custom-file-input')
    
 //.scripts([
 //    'resources/views/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'
 //], 'public/backend/assets/js/bootstrap.bundle.min.js')
 //.copyDirectory('resources/views/admin/plugins/bootstrap','public/backend/assets/plugins/bootstrap')
 
//  .scripts([
//      'resources/views/admin/plugins/datatables/jquery.dataTables.min.js',
//      'resources/views/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
//      'resources/views/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js',
//      'resources/views/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'
//  ], 'public/backend/assets/js/datatables-lib.js')
 
//  .copyDirectory('resources/views/admin/plugins/datatables','public/backend/assets/plugins/datatables')
//  .copyDirectory('resources/views/admin/plugins/datatables-bs4','public/backend/assets/plugins/datatables-bs4')
//  .copyDirectory('resources/views/admin/plugins/datatables-responsive','public/backend/assets/plugins/datatables-responsive') 
//  .copyDirectory('resources/views/admin/plugins/chartjs','public/backend/assets/plugins/chartjs')   
 
 
//  .scripts([
//      'resources/views/admin/dist/js/adminlte.min.js'
//  ], 'public/backend/assets/js/adminlte.min.js')
 //Login fim
 
 
 
//  .styles([
//      'resources/views/admin/plugins/jquery-tags-input/jquery.tagsinput.css'
//  ], 'public/backend/assets/plugins/jquery-tags-input/jquery.tagsinput.css')
 
//  .styles([
//      'resources/views/admin/dist/css/styles.css'
//  ], 'public/backend/assets/css/styles.css')
 
 
 
//  .copyDirectory('resources/views/admin/plugins/moment','public/backend/assets/plugins/moment')
//  .copyDirectory('resources/views/admin/plugins/toastr','public/backend/assets/plugins/toastr')
//  .copyDirectory('resources/views/admin/plugins/inputmask','public/backend/assets/plugins/inputmask')
 
//  .copyDirectory('resources/views/admin/plugins/ekko-lightbox','public/backend/assets/plugins/ekko-lightbox')
  
//  .copyDirectory('resources/views/admin/plugins/jquery-ui','public/backend/assets/plugins/jquery-ui')    
//  .copyDirectory('resources/views/admin/plugins/chartjs','public/backend/assets/plugins/chartjs')
//  .copyDirectory('resources/views/admin/plugins/sparklines','public/backend/assets/plugins/sparklines')
//  .copyDirectory('resources/views/admin/plugins/jqvmap','public/backend/assets/plugins/jqvmap')
//  .copyDirectory('resources/views/admin/plugins/jquery-knob','public/backend/assets/plugins/jquery-knob')
//  .copyDirectory('resources/views/admin/plugins/moment','public/backend/assets/plugins/moment')
//  .copyDirectory('resources/views/admin/plugins/daterangepicker','public/backend/assets/plugins/daterangepicker')
//  .copyDirectory('resources/views/admin/plugins/tempusdominus-bootstrap-4','public/backend/assets/plugins/tempusdominus-bootstrap-4')
//  .copyDirectory('resources/views/admin/plugins/summernote','public/backend/assets/plugins/summernote')
//  .copyDirectory('resources/views/admin/plugins/overlayScrollbars','public/backend/assets/plugins/overlayScrollbars')
//  .copyDirectory('resources/views/admin/plugins/bootstrap-toggle','public/backend/assets/plugins/bootstrap-toggle')
 
 
 
 
//  .scripts([
//      'resources/views/admin/dist/js/adminlte.js'
//  ], 'public/backend/assets/js/adminlte.js')
 
//  .scripts([        
//      'resources/views/admin/dist/js/pages/dashboard.js'
//  ], 'public/backend/assets/js/dashboard.js')
 
//  .scripts([        
//      'resources/views/admin/plugins/jquery-tags-input/jquery.tagsinput.js'
//  ], 'public/backend/assets/plugins/jquery-tags-input/jquery.tagsinput.js')
 
//  .scripts([        
//      'resources/views/admin/dist/js/jquery.mask.js'
//  ], 'public/backend/assets/js/jquery.mask.js')
 
//  .scripts([        
//      'resources/views/admin/dist/js/demo.js'
//  ], 'public/backend/assets/js/demo.js')
 
 
 
//  .scripts([
//      'resources/views/admin/dist/js/scripts.js'
//  ], 'public/backend/assets/js/scripts.js')
 
//  .scripts([
//      'resources/views/admin/dist/js/login.js'
//  ], 'public/backend/assets/js/login.js')
 
 .options({
     processCssUrls: false
 })
 
 .version()
     
;