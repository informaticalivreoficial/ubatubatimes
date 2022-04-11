const mix = require('laravel-mix');

mix
    //WEB
    .styles([
        'resources/views/web/assets/css/bootstrap.min.css'
    ], 'public/frontend/assets/css/bootstrap.min.css') 

    .styles([
        'resources/views/web/assets/css/style.css'
    ], 'public/frontend/assets/css/style.css') 

    .styles([
        'resources/views/web/assets/css/responsive.css'
    ], 'public/frontend/assets/css/responsive.css') 

    .styles([
        'resources/views/web/assets/css/font-awesome.min.css'
    ], 'public/frontend/assets/css/font-awesome.min.css') 

    .styles([
        'resources/views/web/assets/css/owl.carousel.min.css'
    ], 'public/frontend/assets/css/owl.carousel.min.css') 

    .styles([
        'resources/views/web/assets/css/owl.theme.default.min.css'
    ], 'public/frontend/assets/css/owl.theme.default.min.css') 

    .styles([
    'resources/views/web/assets/css/colorbox.css'
    ], 'public/frontend/assets/css/colorbox.css')     

    .copyDirectory('resources/views/web/assets/fonts','public/frontend/assets/fonts')
    .copyDirectory('resources/views/web/assets/images','public/frontend/assets/images')

    .scripts([
        'resources/views/web/assets/js/jquery-3.2.1.min.js'
    ], 'public/frontend/assets/js/jquery.min.js')

    .scripts([
        'resources/views/web/assets/js/popper.min.js'
    ], 'public/frontend/assets/js/popper.min.js')

    .scripts([
        'resources/views/web/assets/js/bootstrap.min.js'
    ], 'public/frontend/assets/js/bootstrap.min.js')

    .scripts([
        'resources/views/web/assets/js/owl.carousel.min.js'
    ], 'public/frontend/assets/js/owl.carousel.min.js')
    
    .scripts([
        'resources/views/web/assets/js/jquery.colorbox.js'
    ], 'public/frontend/assets/js/jquery.colorbox.js')
    
    .scripts([
        'resources/views/web/assets/js/smoothscroll.js'
    ], 'public/frontend/assets/js/smoothscroll.js')
    
    .scripts([
        'resources/views/web/assets/js/custom_script.js'
    ], 'public/frontend/assets/js/custom_script.js')   
 
 
 .options({
     processCssUrls: false
 })
 
 .version()
     
;