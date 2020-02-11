import SimpleTable from "../../components/SimpleTable/SimpleTable";
import Vue from 'vue';

let Delta = function () {

    this.interval = 20000;


    this.deltaTable;


    this.callBackDelete = function () {

    };

    this.callBackGetJournal = function () {
        App.showSpinner();
        let requestParam = {
            dataFlow: 'TAZOVSKIY',
            date: '11-02-2020'
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
            }
        });
    };

    this.toComponentData = function (journal, date) {

        let componentData = [];
        $.each(journal, function (keyJournal, valueJournal) {
            $.each(valueJournal.discreet_info, function (keyDiscreetInfo, valueDiscreetInfo) {
                componentData.push(componentData[keyDiscreetInfo] = {
                    begin: date + ' ' + valueDiscreetInfo.time,
                    end: date + ' ' + valueDiscreetInfo.time_end,
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
            project: {name: 'Журнал'},
            versions: {},//{"snapshotId": {'begin': 'name', 'end': 'id',}},
            deleteRoute: "#"
        };
        let delta = this;

        this.deltaTable = new Vue({
            el: '#deltaTable',
            render(h) {
                return h(SimpleTable, {
                    props: {
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
        this.callBackGetJournal();
        //window.setInterval(this.callBackGetJournal, this.interval);
    };


    this.init();
};
export default Delta;
