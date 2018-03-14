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
let resNodeModules  = "node_modules";
//tambien lo versionamos en el caso de agregar o quitar mas librerias
mix.styles([
    `${resNodeModules}/bootstrap/dist/css/bootstrap.min.css`,
], 'public/css/core.css').version();

mix.styles([
    //`${resNodeModules}/datatables.net-bs4/css/dataTables.bootstrap4.css`,
    `${resNodeModules}/datatables.net-bs/css/dataTables.bootstrap.css`,
    `${resNodeModules}/datatables.net-responsive-bs/css/responsive.bootstrap.min.css`
    
], 'public/css/datatables-pack.css').version();

mix.combine([
    `${resNodeModules}/jquery/dist/jquery.min.js`,
    `${resNodeModules}/datatables.net/js/jquery.dataTables.js`,
    `${resNodeModules}/datatables.net-bs/js/dataTables.bootstrap.js`,
    `${resNodeModules}/bootstrap/dist/js/bootstrap.min.js`,
    `${resNodeModules}/datatables.net-responsive/js/dataTables.responsive.min.js`,
        
], 'public/js/core.js').version();


mix.js('resources/views/productos/producto.js', 'public/views/productos/producto.js').version();
mix.js('resources/views/estadisticas/estadistica.js', 'public/views/estadisticas/estadistica.js').version();

