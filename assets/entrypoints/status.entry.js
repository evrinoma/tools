import DashBoard from '../../public/bundles/evrinomadashboard/js/status/status';

export default class MyDashBoard extends DashBoard {
    getUrl(alias) {
        return App.getRouting().generate(alias);
    }

    beforeUpdate() {
        App.showSpinner();
    }

    afterUpdate() {
        App.hideSpinner();
    }
}

new MyDashBoard();