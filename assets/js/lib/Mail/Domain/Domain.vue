<template>
    <div>
        <div class="ui segment block">
            <div class="ui two column very relaxed grid">
                <div class="column">
                    <vuetable
                            :fields="fields"
                            :sort-order="sortOrder"
                            :api-url="apiUrl"
                            :api-url-delete="apiUrlDelete"
                    ></vuetable>
                </div>
                <div class="column">
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <info-panel
                            :api-url-servers="apiUrlServers"
                            :api-url-save="apiUrlSave"
                    ></info-panel>
                    <server-panel
                            :api-url-servers="apiUrlServers"
                            :api-url-save="apiUrlServerSave"
                            :api-url-delete="apiUrlServerDelete"
                    ></server-panel>
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
    import DomainFieldDefs from './DomainFieldDefs';
    import InfoPanel from './InfoPanel';
    import ServerPanel from './ServerPanel';
    import Vuetable from '../../../components/VueTables2/VueTables2';

    Vue.component('info-panel', InfoPanel);
    Vue.component('server-panel', ServerPanel);

    export default {
        name: 'domain',
        components: {
            Vuetable
        },
        data() {
            return {
                fields: DomainFieldDefs,
                sortOrder: [
                    {
                        field: 'domain',
                        sortField: 'domain',
                        direction: 'asc'
                    }
                ],
                apiUrl: 'http://php72.tools/internal/domain/query',
                apiUrlDelete: 'http://php72.tools/internal/domain/delete',
                apiUrlServers: 'http://php72.tools/internal/server/server',
                apiUrlSave: 'http://php72.tools/internal/domain/save',
                apiUrlServerDelete:'http://php72.tools/internal/server/delete',
                apiUrlServerSave:'http://php72.tools/internal/server/save',
            }
        }
    }
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 5px;
        font-size: smaller;
    }

    .ui.table.vuetable td {
        padding: 5px;

    }

    .ui.segment.block {
        height: 84vh;
    }
</style>