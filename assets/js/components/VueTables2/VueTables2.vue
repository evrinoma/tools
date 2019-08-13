<template>
    <div class="ui container">
    <vuetable ref="vuetable"
              api-url="https://vuetable.ratiw.net/api/users"
              :fields="fields"
              pagination-path=""
              @vuetable:pagination-data="onPaginationData"
    ></vuetable>
        <vuetable-pagination ref="pagination"
               @vuetable-pagination:change-page="onChangePage"
        ></vuetable-pagination>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable';
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';

    export default {
        components: {
            Vuetable,
            VuetablePagination
        },
        data () {
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
                        dataClass: 'right aligned'
                    }
                ]
            }
        },
        methods: {
            allcap (value) {
                return value.toUpperCase()
            },
            genderLabel (value) {
                return value === 'M'
                    ? '<span class="ui teal label"><i class="large man icon"></i>Male</span>'
                    : '<span class="ui pink label"><i class="large woman icon"></i>Female</span>'
            },
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
            },
            onChangePage (page) {
                this.$refs.vuetable.changePage(page)
            }
        }
    }
</script>