<template>
    <div>
        <div class="ui segment block">
            <h3 class="ui header">Project viewer</h3>
            <div class="ui segment">
                <div class="ui two column very relaxed grid">
                    <!--                    <div style="background-color:#ccc; padding: 2rem">left side column</div>-->
                    <div class="column">
                        <!--                        ag-grid-angular style="height: 100%; width:100%" *-->
                        <ag-grid-vue style="width: 100%; height: 100%;"
                                     class="ag-theme-balham"
                                     :columnDefs="columnDefs"
                                     :rowData="rowData"
                                     :editType="editType"
                                     rowSelection="multiple"
                                     @grid-ready="onGridReady"
                                     :components="components"
                                     @first-data-rendered="onFirstDataRendered"
                        >
                        </ag-grid-vue>
                    </div>
                    <!--                    &lt;!&ndash;                    <div style="background-color:#ccc; padding: 2rem">right side column</div>&ndash;&gt;-->
                    <!--                    <div class="column">-->
                    <!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {AgGridVue} from "ag-grid-vue";
    import {fetch} from 'whatwg-fetch';
    import DatePicker from '../../../Components/Edit/datePicker';

    export default {
        name: 'agProjectVue',
        data() {
            return {
                gridOptions: null,
                gridApi: null,
                columnApi: null,
                columnDefs: null,
                defaultColDef: null,
                components: null,
                editType: null,
                rowData: null,
            }
        },
        components: {
            AgGridVue
        },
        methods: {
            //автоматический ресайз всех столбцов в ширину окна таблицы
            onFirstDataRendered(params) {
                params.api.sizeColumnsToFit();
            },
            loadRowData() {
                fetch(location.protocol + '//' + location.hostname + '/evrinoma/api/quantity_surveyor/project')
                    .then(result => result.json())
                    .then(rowData => this.rowData = rowData);
            },
            onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
            },
        },
        beforeMount() {
            fetch(location.protocol + '//' + location.hostname + '/evrinoma/api/quantity_surveyor/project/column_defs')
                .then(result => result.json())
                .then(rowData => this.columnDefs = rowData);
            //помпонеты редактирования
            this.components = { datePicker: getDatePicker() };
            //полнострочное редактирование
            this.editType = 'fullRow';
        },
        created() {
            this.loadRowData();
        }
    }
</script>

<style lang="scss">
    @import "../../../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
    @import "../../../../../node_modules/ag-grid-community/dist/styles/ag-theme-balham.css";

    .ui.segment.block {
        height: 90vh;
    }

    div#footer {
        height: 35px;
    }

    div .ag-grid {
        display: block;
        width: 100%;
    }

    div.ui.segment {
        width: 100%;
        height: 95%;
    }

    .ui[class*="two column"].grid>.column:not(.row), .ui[class*="two column"].grid>.row>.column {
        width: 100%;
    }

    div.ui.two.column.very.relaxed.grid {
        height: 100%;
        width: 100%;
    }

    /*подстветка столюца и строки*/
    .ag-row-hover {
        /* putting in !important so it overrides the theme's styling as it hovers the row also */
        background-color: #dfdfff !important;
    }
    .ag-column-hover {
        background-color: #dfffdf;
    }
</style>
