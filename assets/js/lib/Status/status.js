let Status = function () {
    this.interval = 5000;

    this.callBackGetStatus = function () {
        let dashboard= $('#dashboard');
        App.showSpinner();
        $.ajax({
            url: App.getRouting().generate('dashboard_status'),
            type: 'GET',
            success: function (html) {
                let div = $('<div/>').html(html).contents();
                dashboard.html(div.find('#dashboard'));
                App.hideSpinner();
            }
        });
    };

    this.init = function () {
        window.setInterval(this.callBackGetStatus, this.interval);
    };

    this.init();
};
export default Status;
