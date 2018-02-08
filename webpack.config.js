var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableSassLoader()
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    // .addEntry('js/app', './assets/js/app.js')
    // .addStyleEntry('css/app', './assets/css/app.scss')
    .addEntry('main', './assets/js/main.js')
  //  .addEntry('menu', './assets/js/menu.js')
    .addEntry('modules', './assets/js/modules.js')
    .addEntry('tabber', './assets/js/tabber-minimized.js')
    .addStyleEntry('style', './assets/css/style.css')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
        "window.$": "jquery",
    })
    .enableVersioning()
    .createSharedEntry('vendor', ['jquery', 'jquery-ui'])

//.enableSassLoader()
//.enableTypeScriptLoader()
//.enableSourceMaps(!Encore.isProduction())
;
;

module.exports = Encore.getWebpackConfig();
