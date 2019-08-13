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
                  pagination-path=""
                  @vuetable:pagination-data="onPaginationData"
        ></vuetable>
        <div class="vuetable-pagination ui basic segment grid">
            <vuetable-pagination-info ref="paginationInfo">
            </vuetable-pagination-info>

            <vuetable-pagination ref="pagination"
                                 @vuetable-pagination:change-page="onChangePage"
            ></vuetable-pagination>
        </div>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable';
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'

    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo
        },
        data() {
            return {
                fields: [
                    'name', 'email',
                    {
                        name: 'birthdate',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned'
                    },
                    {
                        name: 'nickname',
                        callback: 'allcap'
                    },
                    {
                        name: 'gender',
                        titleClass: 'center aligned',
                        dataClass: 'center aligned',
                        callback: 'genderLabel'
                    },
                    {
                        name: 'salary',
                        titleClass: 'center aligned',
                        dataClass: 'right aligned',
                        // visible: false
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
        }
    }
</script>