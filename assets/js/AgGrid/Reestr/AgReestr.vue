<template>
    <div>
        <div class="ui segment block">
            <h3 class="ui header">Project viewer</h3>
            <div class="ui segment segment_top">
                <div class="ui two column very relaxed grid">
                    <!--                    <div style="background-color:#ccc; padding: 2rem">left side column</div>-->
                    <div class="column">
                        <!--                        ag-grid-angular style="height: 100%; width:100%" *-->
                        <ag-grid-vue style="width: 100%; height: 100%;"
                                     class="ag-theme-balham-dark"
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
            <h4 class="ui horizontal divider custom_divider">
                <i class="resize vertical icon"></i>
            </h4>
            <div class="ui segment segment_bottom">
                <div style="background-color:#ccc; margin-top: -10px;">right side column</div>
            </div>
        </div>
    </div>
</template>

<script>
    import {AgGridVue} from "ag-grid-vue";
    import {fetch} from 'whatwg-fetch';
    import DatePicker from '../../Components/Edit/DatePicker';

    export default {
        name: 'agReestrVue',
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
            this.components = {datePicker: getDatePicker()};
            //полнострочное редактирование
            this.editType = 'fullRow';
        },
        created() {
            this.loadRowData();
        }
    }
</script>

<style lang="scss">
    @import "../../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
    @import "../../../../node_modules/ag-grid-community/dist/styles/ag-theme-balham-dark.css";

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

    /* верхний блок */
    div.ui.segment_top {
        width: 100%;
        height: 85%;
    }

    /* нижний блок */
    div.ui.segment_bottom {
        width: 100%;
        height: 10%;
    }

    .ui[class*="two column"].grid > .column:not(.row), .ui[class*="two column"].grid > .row > .column {
        width: 100%;
    }

    div.ui.two.column.very.relaxed.grid {
        height: 105%;
        width: 100%;
    }

    .ui.divider.custom_divider {
        margin: -1rem 0;
    }

    /*подстветка столюца и строки*/
    .ag-row-hover {
        /* putting in !important so it overrides the theme's styling as it hovers the row also */
        background-color: #525255 !important;
    }

    .ag-column-hover {
        background-color: #2f402f;
    }

    /*DatePicker*/
    .hasDatepicker {
        background-color: #2d3436;
    }
</style>
