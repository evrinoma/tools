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
                                     rowSelection="multiple"
                                     @grid-ready="onGridReady"
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

    export default {
        name: 'agProjectVue',
        data() {
            return {
                columnDefs: null,
                rowData: null
            }
        },
        components: {
            AgGridVue
        },
        methods: {
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
</style>
