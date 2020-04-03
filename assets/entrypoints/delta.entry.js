import Delta from '../../public/bundles/evrinomadelta8/js/Delta/delta';

export default class MyDelta extends Delta {
    getUrl(alias, requestParam) {
        return (requestParam === undefined) ? App.getRouting().generate(alias) : App.getRouting().generate(alias, requestParam);
    }

    beforeUpdate() {
        App.showSpinner();
    }

    afterUpdate() {
        App.hideSpinner();
    }
}

new MyDelta();