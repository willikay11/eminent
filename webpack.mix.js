let mix = require('laravel-mix');

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

mix.js(['resources/assets/js/app.js',
    'bower_components/jquery/dist/jquery.min.js',
    'bower_components/jquery-ui/jquery-ui.min.js',
    'bower_components/bootstrap/dist/js/bootstrap.min.js',
    'bower_components/raphael/raphael.min.js',
    'bower_components/morris.js/morris.min.js',
    'bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
    'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
    'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
    'bower_components/jquery-knob/dist/jquery.knob.min.js',
    'bower_components/moment/min/moment.min.js',
    // 'bower_components/bootstrap-daterangepicker/daterangepicker.js',
    'bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    // 'bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js',
    'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
    'bower_components/fastclick/lib/fastclick.js',
    'resources/assets/adminLTE/js/adminlte.js',
    'resources/assets/adminLTE/js/pages/dashboard.js',
    'resources/assets/adminLTE/js/demo.js'
], 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css/styles.css')
    .styles([
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        // 'bower_components/font-awesome/css/font-awesome.min.css',
        // 'bower_components/Ionicons/css/ionicons.min.css',
        'resources/assets/adminLTE/css/AdminLTE.css',
        'resources/assets/adminLTE/css/skins/_all-skins.css',
        'bower_components/morris.js/morris.css',
        'bower_components/jvectormap/jquery-jvectormap.css',
        'bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'bower_components/bootstrap-daterangepicker/daterangepicker.css',
        'public/css/styles.css',
        // 'bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css'
    ], 'public/css/app.css');

mix.autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery'],
    'vue': ['Vue','window.Vue'],
    'moment': ['moment','window.moment'],
});

if (mix.inProduction()) {
    mix.version();
}
