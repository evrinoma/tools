import MyVuetable from '../../components/VueTables2/VueTables2'
import Vue from 'vue';

let MailDomain = function () {

    this.createTable = function () {
        new Vue({
            el: '#table',
            render (h) {
                return h(MyVuetable)
            }
        });
    };

    this.init = function () {
        this.createTable();
    };

    this.init();
};
export default MailDomain;
