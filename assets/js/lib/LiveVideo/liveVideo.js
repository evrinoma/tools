import Wowza from '../../components/Wowza/wowzaplayer.min';
import Vue from 'vue';
import LiveVideo from './LiveVideo';

/* eslint-disable no-new */
new Vue({
    el: '#app',
    template: '<LiveVideo/>',
    components: { LiveVideo }
});
