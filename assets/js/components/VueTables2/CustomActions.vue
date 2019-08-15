<template>
    <div class="custom-actions">
        <!--<button class="ui basic button" @click="itemAction('edit-item', rowData, rowIndex)"><i class="edit icon"></i></button>-->
        <button class="ui basic button" @click="itemAction('delete-item', rowData, rowIndex)"><i class="trash icon"></i></button>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueEvents from 'vue-events';
    import axios from 'axios';

    Vue.use(VueEvents);
    Vue.use(axios);

    export default {
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            }
        },
        data() {
            return {
                servers: {},
            }
        },
        methods: {
            itemAction(action, data, index) {
                axios
                    .delete('http://php72.tools/internal/domain/delete', {data: data})
                    .then(response => (this._axiosResponse(response)));
            },
            _axiosResponse(response) {
                this.servers = response.data.servers;
                this.$events.fire('custom-actions-delete');
            },
        }
    }
</script>

<style>
    .custom-actions button.ui.button {
        padding: 8px 8px;
    }

    .custom-actions button.ui.button > i.icon {
        margin: auto !important;
    }
</style>