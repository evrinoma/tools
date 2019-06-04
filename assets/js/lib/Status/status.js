let Status = function () {
    this.interval = 5000;

    this.getStatus = function () {
        let dashboard= $('#dashboard');
        App.showSpinner();
        $.ajax({
            url: App.getRouting().generate('core_status'),
            type: 'POST',
            success: function (html) {
                let div = $('<div/>').html(html).contents();
                dashboard.html(div.find('#dashboard'));
                App.hideSpinner();
            }
        });
    };

    this.init = function () {
        window.setInterval(this.getStatus, this.interval);
    };

    this.init();
};
export default Status;
