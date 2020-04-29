import '../../../../node_modules/jquery-ui/ui/widgets/datepicker.js';
import '../../../../node_modules/jquery-ui/ui/i18n/datepicker-ru';
import '../../../../node_modules/jquery-ui/themes/base/all.css';

window.getDatePicker = function getDatePicker() {
    function Datepicker() {
    }

    Datepicker.prototype.init = function (params) {
        this.eInput = document.createElement('input');
        this.eInput.value = params.value;
        $(this.eInput).datepicker({dateFormat: 'dd-mm-yy'});
    };
    Datepicker.prototype.getGui = function () {
        return this.eInput;
    };
    //показать компанент при начале редактирования строки
    Datepicker.prototype.afterGuiAttached = function () {
       // this.eInput.focus();
       // this.eInput.select();
    };
    Datepicker.prototype.getValue = function () {
        return this.eInput.value;
    };
    Datepicker.prototype.destroy = function () {
    };
    Datepicker.prototype.isPopup = function () {
        return false;
    };
    return Datepicker;
};
