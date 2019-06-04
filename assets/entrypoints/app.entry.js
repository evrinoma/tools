import '../css/menu/menu.css'
import '../css/app.css'
const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import Vue from 'vue';
Routing.setRoutingData(routes);
import Application from '../js/Application';

window.App = new Application();
window.App.setRouting(Routing);