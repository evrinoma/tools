var Encore = require('@symfony/webpack-encore');
var VueLoaderPlugin = require('vue-loader/lib/plugin')

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .enableSourceMaps(!Encore.isProduction())
    // Enable Vue SFC compilation
    .enableVueLoader()

    // assets_old
    // .addEntry('main', './assets/js/main.js')
    // .addEntry('modules', './assets/js/modules.js')
    // .addEntry('tabber', './assets/js/tabber-minimized.js')
    // .addStyleEntry('style', './assets/css/style.css')
    // .addStyleEntry('loginUtils', './assets/css/login/util.css')

    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('loginMain', './assets/css/login/util.css')


    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    .cleanupOutputBeforeBuild()
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
        "window.$": "jquery",
    })
    .enableVersioning(Encore.isProduction())
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
  //  .createSharedEntry('vendor', ['jquery', 'jquery-ui'])

//.enableSassLoader()
//.enableTypeScriptLoader()
//.enableSourceMaps(!Encore.isProduction())
;


module.exports = Encore.getWebpackConfig();
