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

mix.js('resources/assets/js/app.js', 'public/js').version();


mix.styles([
	'resources/assets/admin/bootstrap/css/bootstrap.min.css',
	'resources/assets/admin/font-awesome/4.5.0/css/font-awesome.min.css',
	'resources/assets/admin/ionicons/2.0.1/css/ionicons.min.css',
	'resources/assets/admin/dist/css/skins/_all-skins.min.css',
	'resources/assets/admin/plugins/select2/select2.min.css',
	'resources/assets/admin/dist/css/AdminLTE.min.css',	
	'resources/assets/admin/dist/css/style_add.css'
], 'public/css/admin.css');

mix.scripts([
	'resources/assets/admin/plugins/jQuery/jquery-2.2.3.min.js',
	'resources/assets/admin/bootstrap/js/bootstrap.min.js',
	'resources/assets/admin/dist/js/app.min.js',
	'resources/assets/admin/plugins/select2/select2.full.js',
	'resources/assets/admin/dist/js/promise.js'
], 'public/js/admin.js');

mix.copy('resources/assets/admin/bootstrap/fonts','public/fonts');
mix.copy('resources/assets/admin/dist/img/loading.gif', 'public/img');