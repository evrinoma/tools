import SimpleTable from "../../components/SimpleTable/SimpleTable";
import Vue from 'vue';

let Delta = function () {

    this.interval = 180000;

    this.deltaTable;

    this.today = undefined;

    this.callBackDelete = function () {

    };

    this.getFormatCurrentDate = function () {
        let today = this.getCurrentDate();
        let dd = String(today.getDate()).padStart(2, '0');
        let mm = String(today.getMonth() + 1).padStart(2, '0');
        let yyyy = today.getFullYear();

        return dd + '-' + mm + '-' + yyyy;
    };

    this.getCurrentDate = function () {
        if (this.today === undefined) {
            this.today = new Date();
            this.today.setHours(0, 0, 0, 0);
        }

        return this.today;
    };

    this.callBackDate = function () {
        App.delta.callBackGetJournal();
    };

    this.callBackAutoUpdate = function () {
        App.showSpinner();
        let delta = App.delta;
        let component = delta.deltaTable.$options.getComponent(delta.deltaTable);
        let date = component.getFilterDateValue();
        if (date === delta.getFormatCurrentDate()) {
            App.delta.callBackGetJournal();
        }
        App.hideSpinner();
        component.setUnLock()
    };

    this.callBackGetJournal = function () {
        App.showSpinner();
        let delta = App.delta;
        let component = delta.deltaTable.$options.getComponent(delta.deltaTable);
        let dataFlow = component.getFilterSelectValue();
        let date = component.getFilterDateValue();
        if (undefined !== dataFlow) {
            let requestParam = {
                dataFlow: dataFlow,
                date: date
            };
            $.ajax({
                url: App.getRouting().generate('api_delta_journal', requestParam),
                type: 'GET',
                success: function (html) {
                    let delta = App.delta;
                    let component = delta.deltaTable.$options.getComponent(delta.deltaTable);
                    if (html.delta_data !== undefined) {
                        let dataLoad = delta.toComponentData(html.delta_data, requestParam.date);
                        component.updateRows(dataLoad);
                    }
                    App.hideSpinner();
                    component.setUnLock()
                }
            });
        } else {
            App.hideSpinner();
            component.setUnLock()
        }
    };

    this.toComponentData = function (journal, date) {

        let componentData = [];
        $.each(journal, function (keyJournal, valueJournal) {
            $.each(valueJournal.discreet_info, function (keyDiscreetInfo, valueDiscreetInfo) {
                componentData.push(componentData[keyDiscreetInfo] = {
                    begin: date + ' ' + valueDiscreetInfo.time,
                    end: valueDiscreetInfo.time_end,
                    object: valueJournal.group.name,
                    message: valueJournal.name,
                    notes: valueJournal.additionalname,
                });
            });
        });

        return componentData;
    };

    this.createTable = function () {
        let loadedData = {
            project: {name: 'Journal'},
            versions: {},//{"snapshotId": {'begin': 'name', 'end': 'id',}},
            deleteRoute: "#"
        };
        let delta = this;

        this.deltaTable = new Vue({
            el: '#deltaTable',
            render(h) {
                return h(SimpleTable, {
                    props: {
                        filter: {
                            selector: {
                                route: window.location.origin + '/api/doc/object',
                                callBack: delta.callBackGetJournal,
                            },
                            update: {
                                isUpdate: true,
                                interval: delta.interval,
                                callBack: delta.callBackAutoUpdate,
                            },
                            date: {
                                value: delta.getFormatCurrentDate(),
                                callBack: delta.callBackDate,
                                format: "DD-MM-YYYY",
                                range: delta.getCurrentDate(),
                            },
                        },
                        headerTable: loadedData.project.name,
                        columnsTable: [
                            {name: 'begin', header: 'Начало', hasClasses: true},
                            {name: 'end', header: 'Конец', hasClasses: true},
                            {name: 'object', header: 'Объект', hasClasses: true},
                            {name: 'message', header: 'Параметр', hasClasses: true},
                            {name: 'notes', header: 'Сообщение', hasClasses: true},
                        ],
                        rowsTable: loadedData.versions,
                        deleteButton: {
                            route: loadedData.deleteRoute,
                            callBack: delta.callBackDelete,
                        },
                    }
                })
            },
            getComponent: function (root) {
                let component = undefined;
                root.$children.filter(
                    function (item, key) {
                        component = item;
                        return false;
                    }
                );
                return component;
            }
        });
    };

    this.init = function () {
        this.createTable();
        // this.callBackGetJournal();
        //window.setInterval(this.callBackGetJournal, this.interval);
    };


    this.init();
};
export default Delta;
