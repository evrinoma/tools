<template>
    <div>
        <div class="ui segment block">
            <div class="ui two column very relaxed grid">
                <div class="column">
                    <filter-bar></filter-bar>
                    <vuetable ref="vuetable"
                              api-url="http://php72.tools/internal/domain/query"
                              :fields="fields"
                              :per-page="5"
                              :multi-sort="true"
                              multi-sort-key="ctrl"
                              :sort-order="sortOrder"
                              pagination-path=""
                              @vuetable:pagination-data="onPaginationData"
                              @vuetable:cell-clicked="onCellClicked"
                              :append-params="moreParams" s
                    ></vuetable>
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
    import FilterBar from './FilterBar';
    import FieldDefs from './FieldDefs';
    import InfoPanel from './InfoPanel';

    Vue.use(VueEvents);
    Vue.component('custom-actions', CustomActions);
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
                        field: 'domain',
                        sortField: 'domain',
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
            this.$events.$on('info-save', eventData => this.update(eventData));
            this.$events.$on('custom-actions-delete', eventData => this.update(eventData));
        },
        methods: {
            onChangePage(page) {
                this.$refs.vuetable.changePage(page)
            },
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            onCellClicked(data, field, event) {
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
            update(infoPanel) {
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            },
        }
    }
</script>