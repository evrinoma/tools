<template>
    <div class="ui container">
        <div class="vuetable-pagination ui basic segment grid">
            <vuetable-pagination-info ref="paginationInfoTop"
            ></vuetable-pagination-info>
            <vuetable-pagination ref="paginationTop"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
        <vuetable ref="vuetable"
                  api-url="https://vuetable.ratiw.net/api/users"
                  :fields="fields"
                  :per-page="5"
                  :multi-sort="true"
                  multi-sort-key="ctrl"
                  :sort-order="sortOrder"
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
                  detail-row-component="my-detail-row"
                  @vuetable:cell-clicked="onCellClicked"
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
        <!--<div class="vuetable-pagination ui basic segment grid">-->
        <!--<vuetable-pagination-info ref="paginationInfo">-->
        <!--</vuetable-pagination-info>-->

        <!--<vuetable-pagination ref="pagination"-->
        <!--@vuetable-pagination:change-page="onChangePage"-->
        <!--&gt;</vuetable-pagination>-->
        <!--</div>-->
    </div>
</template>

<script>
    import Vue from 'vue';
    import Vuetable from 'vuetable-2/src/components/Vuetable';
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import CustomActions from './CustomActions';
    import DetailRow from './DetailRow';

    Vue.component('custom-actions', CustomActions);
    Vue.component('my-detail-row', DetailRow);

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
                fields: [
                    {
                        name: '__sequence',   // <----
                        title: '#',
                        titleClass: 'center aligned',
                        dataClass: 'right aligned'
                    },
                    {
                        name: 'name',
                        sortField: 'name'
                    },
                    {
                        name: 'age',
                        sortField: 'birthdate',
                        dataClass: 'center aligned'
                    },
                    {
                        name: 'email',
                        sortField: 'email'
                    },
                    {
                        name: 'birthdate',
                        sortField: 'birthdate',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    },
                    {
                        name: 'nickname',
                        sortField: 'nickname',
                        callback: 'allcap'
                    },
                    {
                        name: 'gender',
                        sortField: 'gender',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned',
                        callback: 'genderLabel'
                    },
                    {
                        name: 'salary',
                        sortField: 'salary',
                        titleClass: 'center aligned',
                        dataClass: 'right aligned',
                        // visible: false
                    },
                    {
                        name: '__component:custom-actions',   // <----
                        title: 'Actions',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    }
                ]
            }
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
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage(page) {
                this.$refs.vuetable.changePage(page)
            },
            onPaginationData(paginationData) {
                this.$refs.paginationTop.setPaginationData(paginationData);
                this.$refs.paginationInfoTop.setPaginationData(paginationData);

                this.$refs.pagination.setPaginationData(paginationData);
                this.$refs.paginationInfo.setPaginationData(paginationData);
            },
            onCellClicked (data, field, event) {
                console.log('cellClicked: ', field.name)
                this.$refs.vuetable.toggleDetailRow(data.id)
            }
        }
    }
</script>