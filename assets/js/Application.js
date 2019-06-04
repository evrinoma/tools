let Application = function () {
    this.Routing;

    this.setRouting = function (Routing) {
        this.Routing = Routing;
    };

    this.getRouting = function () {
       return this.Routing;
    };

    this.showSpinner = function () {
        $('div#spinner').show();
    };

    this.hideSpinner = function () {
        $('div#spinner').hide();
    };
};
export default Application;