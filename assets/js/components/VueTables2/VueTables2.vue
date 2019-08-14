<template>
    <div>
        <div class="ui segment">
            <div class="ui two column very relaxed grid">
                <div class="column">
                    <filter-bar></filter-bar>
                    <!--<div class="vuetable-pagination ui basic segment grid">-->
                    <!--<vuetable-pagination-info ref="paginationInfoTop"-->
                    <!--&gt;</vuetable-pagination-info>-->
                    <!--<vuetable-pagination ref="paginationTop"-->
                    <!--@vuetable-pagination:change-page="onChangePage"-->
                    <!--&gt;</vuetable-pagination>-->
                    <!--</div>-->


                    <!--detail-row-component="my-detail-row"-->

                    <vuetable ref="vuetable"
                              api-url="https://vuetable.ratiw.net/api/users"
                              :fields="fields"
                              :per-page="5"
                              :multi-sort="true"
                              multi-sort-key="ctrl"
                              :sort-order="sortOrder"
                              pagination-path=""
                              @vuetable:pagination-data="onPaginationData"
                              @vuetable:cell-clicked="onCellClicked"
                              :append-params="moreParams"
                    ></vuetable>
                    <template slot="actions" scope="props">
                        <div class="custom-actions">
                            <button class="ui basic button"
                                    @click="onAction('view-item', props.rowData, props.rowIndex)">
                                <i class="zoom icon"></i>
                            </button>
                            <button class="ui basic button"
                                    @click="onAction('edit-item', props.rowData, props.rowIndex)">
                                <i class="edit icon"></i>
                            </button>
                            <button class="ui basic button"
                                    @click="onAction('delete-item', props.rowData, props.rowIndex)">
                                <i class="delete icon"></i>
                            </button>
                        </div>
                    </template>
                    <div class="vuetable-pagination ui basic segment grid">
                        <vuetable-pagination-info ref="paginationInfo">
                        </vuetable-pagination-info>

                        <vuetable-pagination ref="pagination"
                                             @vuetable-pagination:change-page="onChangePage"
                        ></vuetable-pagination>
                    </div>
                </div>
                <div class="column">
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <info-panel></info-panel>
                </div>
            </div>
            <div class="ui vertical divider">
                |
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueEvents from 'vue-events';
    import Vuetable from 'vuetable-2/src/components/Vuetable';
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import CustomActions from './CustomActions';
    // import DetailRow from './DetailRow';
    import FilterBar from './FilterBar';
    import FieldDefs from './FieldDefs';
    import InfoPanel from './InfoPanel';

    Vue.use(VueEvents);
    Vue.component('custom-actions', CustomActions);
    // Vue.component('my-detail-row', DetailRow);
    Vue.component('filter-bar', FilterBar)
    Vue.component('info-panel', InfoPanel);

    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo
        },
        data() {
            return {
                sortOrder: [
                    {
                        field: 'email',
                        sortField: 'email',
                        direction: 'asc'
                    }
                ],
                moreParams: {},
                fields: FieldDefs,
            }
        },
        mounted() {
            this.$events.$on('filter-set', eventData => this.onFilterSet(eventData));
            this.$events.$on('filter-reset', eventData => this.onFilterReset());
            this.$events.$on('info-save', eventData => this.onInfoSave(eventData));
            this.$events.$on('info-delete', eventData => this.onInfoDelete(eventData));
        },
        methods: {
            allcap(value) {
                return value.toUpperCase()
            },
            genderLabel(value) {
                return value === 'M'
                    ? '<span class="ui teal label"><i class="large man icon"></i>Male</span>'
                    : '<span class="ui pink label"><i class="large woman icon"></i>Female</span>'
            },
            onChangePage(page) {
                this.$refs.vuetable.changePage(page)
            },
            onPaginationData(paginationData) {
                // this.$refs.paginationTop.setPaginationData(paginationData);
                // this.$refs.paginationInfoTop.setPaginationData(paginationData);

                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            onCellClicked(data, field, event) {
                console.log('cellClicked: ', field.name);
                this.$refs.vuetable.toggleDetailRow(data.id);
                this.$events.fire('info-set', data);
            },
            onFilterSet(filterText) {
                this.moreParams.filter = filterText;
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
            onFilterReset() {
                delete this.moreParams.filter;
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
            onInfoSave(infoPanel) {
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
            onInfoDelete(infoPanel) {
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
        }
    }
</script>