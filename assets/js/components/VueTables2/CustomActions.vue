<template>
    <div class="custom-actions">
        <button class="ui basic button" @click="itemAction('delete-item', rowData, rowIndex)"><i class="trash icon"></i></button>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueEvents from 'vue-events';

    Vue.use(VueEvents);

    export default {
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            },
        },
        data() {
            return {
                servers: {},
            }
        },
        methods: {
            itemAction(action, data, index) {
                this.$events.fire('custom-actions-delete', {data: data});
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