import Vue from 'vue';
import Journal from './Journal';

/* eslint-disable no-new */
new Vue({
    el: '#deltaTable',
    template: '<journal/>',
    components: { Journal }
});

// import Vue from 'vue';
// import { App } from './Journal';
//
// new Vue({
//     el: '#deltaTable',
//     render: h => h(App)
// });

// import Vue from "vue";
// import App from "./Journal";
// import Vuetify from "vuetify";
// Vue.use(Vuetify);
//
// Vue.config.productionTip = false;
//
// /* eslint-disable no-new */
// new Vue({
//     el: "#deltaTable",
//     components: { App },
//     template: "<App/>"
// });
