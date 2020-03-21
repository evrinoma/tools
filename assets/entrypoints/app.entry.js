import '../css/menu/menu.css'
import '../css/app.css'
const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../public/bundles/fosjsrouting/js/router.min.js';
import SwaggerUI from '../../vendor/evrinoma/utils-bundle/src/Resources/public/js/SwaggerUI/init-swagger-ui.js';

Routing.setRoutingData(routes);
import Application from '../js/Application';

window.App = new Application();
window.App.setRouting(Routing);