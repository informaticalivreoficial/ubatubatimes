const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
 //WEB
 .styles([
     'resources/views/web/_cdn/css/bootstrap_custom.css'
 ], 'public/frontend/assets/css/bootstrap.css') 

 .styles([
    'resources/views/web/_cdn/css/app.css'
], 'public/frontend/assets/css/app.css') 
 
.copyDirectory('resources/views/web/_cdn/css/fonts','public/frontend/assets/css/fonts')
.copyDirectory('resources/views/web/assets/images','public/frontend/assets/images')
.copyDirectory('resources/views/web/assets/icons','public/frontend/assets/icons')
.copyDirectory('resources/views/web/assets/js/ekko-lightbox','public/frontend/assets/js/ekko-lightbox')
// 
// .styles([
//     'resources/views/web/css/flexslider.css',
//     'resources/views/web/css/owl.carousel.min.css',
//     'resources/views/web/css/owl.theme.min.css'
// ], 'public/frontend/css/libs.min.css') 
// 
// .styles([
//     'resources/views/web/css/style.css'
// ], 'public/frontend/css/style.css')

.scripts([
    'node_modules/jquery/dist/jquery.min.js'
], 'public/frontend/assets/js/jquery.min.js')

.scripts([
    'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'
], 'public/frontend/assets/js/bootstrap.js')

.scripts([
    'node_modules/bootstrap-select/dist/js/bootstrap-select.min.js'
], 'public/frontend/assets/js/bootstrap-select.js')

.scripts([
    'node_modules/bootstrap-select/dist/js/i18n/defaults-pt_BR.min.js'
], 'public/frontend/assets/js/defaults-pt_BR.js')

.scripts([
    'resources/views/web/assets/js/jquery.mask.js'
], 'public/frontend/assets/js/jquery.mask.js')

.scripts([
    'resources/views/web/assets/js/scripts.js'
], 'public/frontend/assets/js/scripts.js')

// .scripts([
//     'resources/views/web/js/jquery.flexslider-min.js',
//     'resources/views/web/js/owl.carousel.min.js',
//     'resources/views/web/js/waypoints.min.js',
//     'resources/views/web/js/jquery.counterup.min.js',
//     'resources/views/web/js/back-to-top.js',
//     'resources/views/web/js/validate.js',
//     'resources/views/web/js/subscribe.js'
// ], 'public/frontend/js/libs.js')
// 
// .scripts([
//     'resources/views/web/js/main.js'
// ], 'public/frontend/js/main.js')
 
 //ADMIN
 
 
 .styles([
     'resources/views/admin/dist/css/adminlte.min.css'
 ], 'public/backend/assets/css/adminlte.min.css')
 //Login fim
 
 .copyDirectory('resources/views/admin/plugins/fontawesome-free','public/backend/assets/plugins/fontawesome-free')
 .copyDirectory('resources/views/admin/plugins/icheck-bootstrap','public/backend/assets/plugins/icheck-bootstrap')
 .copyDirectory('resources/views/admin/dist/images','public/backend/assets/images')
 
 //Login 
//    .scripts([
//        'resources/views/admin/plugins/jquery/jquery.min.js'
//    ], 'public/backend/assets/js/jquery.js')
 .copyDirectory('resources/views/admin/plugins/jquery','public/backend/assets/plugins/jquery')
 //.copyDirectory('resources/views/admin/plugins/bs-custom-file-input','public/backend/assets/plugins/bs-custom-file-input')
    
 //.scripts([
 //    'resources/views/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'
 //], 'public/backend/assets/js/bootstrap.bundle.min.js')
 .copyDirectory('resources/views/admin/plugins/bootstrap','public/backend/assets/plugins/bootstrap')
 
 .scripts([
     'resources/views/admin/plugins/datatables/jquery.dataTables.min.js',
     'resources/views/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
     'resources/views/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js',
     'resources/views/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'
 ], 'public/backend/assets/js/datatables-lib.js')
 
 .copyDirectory('resources/views/admin/plugins/datatables','public/backend/assets/plugins/datatables')
 .copyDirectory('resources/views/admin/plugins/datatables-bs4','public/backend/assets/plugins/datatables-bs4')
 .copyDirectory('resources/views/admin/plugins/datatables-responsive','public/backend/assets/plugins/datatables-responsive') 
 .copyDirectory('resources/views/admin/plugins/chartjs','public/backend/assets/plugins/chartjs')   
 
 
 .scripts([
     'resources/views/admin/dist/js/adminlte.min.js'
 ], 'public/backend/assets/js/adminlte.min.js')
 //Login fim
 
 
 
 .styles([
     'resources/views/admin/plugins/jquery-tags-input/jquery.tagsinput.css'
 ], 'public/backend/assets/plugins/jquery-tags-input/jquery.tagsinput.css')
 
 .styles([
     'resources/views/admin/dist/css/styles.css'
 ], 'public/backend/assets/css/styles.css')
 
 
 
 .copyDirectory('resources/views/admin/plugins/moment','public/backend/assets/plugins/moment')
 .copyDirectory('resources/views/admin/plugins/toastr','public/backend/assets/plugins/toastr')
 .copyDirectory('resources/views/admin/plugins/inputmask','public/backend/assets/plugins/inputmask')
 
 .copyDirectory('resources/views/admin/plugins/ekko-lightbox','public/backend/assets/plugins/ekko-lightbox')
  
 .copyDirectory('resources/views/admin/plugins/jquery-ui','public/backend/assets/plugins/jquery-ui')    
 .copyDirectory('resources/views/admin/plugins/chartjs','public/backend/assets/plugins/chartjs')
 .copyDirectory('resources/views/admin/plugins/sparklines','public/backend/assets/plugins/sparklines')
 .copyDirectory('resources/views/admin/plugins/jqvmap','public/backend/assets/plugins/jqvmap')
 .copyDirectory('resources/views/admin/plugins/jquery-knob','public/backend/assets/plugins/jquery-knob')
 .copyDirectory('resources/views/admin/plugins/moment','public/backend/assets/plugins/moment')
 .copyDirectory('resources/views/admin/plugins/daterangepicker','public/backend/assets/plugins/daterangepicker')
 .copyDirectory('resources/views/admin/plugins/tempusdominus-bootstrap-4','public/backend/assets/plugins/tempusdominus-bootstrap-4')
 .copyDirectory('resources/views/admin/plugins/summernote','public/backend/assets/plugins/summernote')
 .copyDirectory('resources/views/admin/plugins/overlayScrollbars','public/backend/assets/plugins/overlayScrollbars')
 .copyDirectory('resources/views/admin/plugins/bootstrap-toggle','public/backend/assets/plugins/bootstrap-toggle')
 
 
 
 
 .scripts([
     'resources/views/admin/dist/js/adminlte.js'
 ], 'public/backend/assets/js/adminlte.js')
 
 .scripts([        
     'resources/views/admin/dist/js/pages/dashboard.js'
 ], 'public/backend/assets/js/dashboard.js')
 
 .scripts([        
     'resources/views/admin/plugins/jquery-tags-input/jquery.tagsinput.js'
 ], 'public/backend/assets/plugins/jquery-tags-input/jquery.tagsinput.js')
 
 .scripts([        
     'resources/views/admin/dist/js/jquery.mask.js'
 ], 'public/backend/assets/js/jquery.mask.js')
 
 .scripts([        
     'resources/views/admin/dist/js/demo.js'
 ], 'public/backend/assets/js/demo.js')
 
 
 
 .scripts([
     'resources/views/admin/dist/js/scripts.js'
 ], 'public/backend/assets/js/scripts.js')
 
 .scripts([
     'resources/views/admin/dist/js/login.js'
 ], 'public/backend/assets/js/login.js')
 
 .options({
     processCssUrls: false
 })
 
 .version()
     
;