import datepicker from 'vue-date-picker';

window.getDatePicker = function getDatePicker() {
    function Datepicker() {}
    Datepicker.prototype.init = function(params) {
        this.eInput = document.createElement('input');
        this.eInput.value = '12/08/2012';//params.value;
        $(this.eInput).datepicker({ dateFormat: 'dd/mm/yy' });
    };
    Datepicker.prototype.getGui = function() {
        return this.eInput;
    };
    Datepicker.prototype.afterGuiAttached = function() {
        this.eInput.focus();
        this.eInput.select();
    };
    Datepicker.prototype.getValue = function() {
        return this.eInput.value;
    };
    Datepicker.prototype.destroy = function() {};
    Datepicker.prototype.isPopup = function() {
        return false;
    };
    return Datepicker;
};
