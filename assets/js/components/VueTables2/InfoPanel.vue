<template>
    <div class="info-panel">
        <div class="ui huge header">Edit Row</div>
        <p></p>
        <div class="ui form">
            <div class="field">
                <label>Domain Name:</label>
                <div class="ui right labeled left icon input">
                    <i class="linkify icon"></i>
                    <input type="text" v-model="domainText" class="three wide column" placeholder="Domain name">
                    <a class="ui tag label">
                        {{ id }}
                    </a>
                </div>
            </div>
            <div class="field">
                <label>Relay Address:</label>
                <input type="text" v-model="relayAdrText" class="three wide column" placeholder="Address relay">
            </div>
            <div class="field">
                <label>Mx:</label>
                <input type="text" v-model="mxText" class="three wide column" placeholder="MX name">
            </div>
            <br>
            <div class="ui animated button" tabindex="0" @click="doSave">
                <div class="visible content">Save</div>
                <div class="hidden content">
                    <i class="right save icon"></i>
                </div>
            </div>
            <div class="ui animated button" tabindex="0" @click="doDelete">
                <div class="visible content">Delete</div>
                <div class="hidden content">
                    <i class="right trash icon"></i>
                </div>
            </div>
            <div class="ui vertical animated button" tabindex="0" @click="resetEdit">
                <div class="hidden content">Reset</div>
                <div class="visible content">
                    <i class="shop x icon"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueEvents from 'vue-events';

    Vue.use(VueEvents);

    export default {
        data() {
            return {
                domainText: '',
                relayAdrText: '',
                mxText: '',
                id: '',
            }
        },
        mounted() {
            this.$events.$on('info-set', eventData => this.onSet(eventData));
        },
        methods: {
            _getData() {
                return {
                    domain: this.domainText,
                    relayAdr: this.relayAdrText,
                    mx: this.mxText,
                    id: this.id
                }
            },
            onSet(eventData) {
                this.domainText = eventData.domain;
                this.relayAdrText = eventData.relayAdr;
                this.mxText = eventData.mx;
                this.id = eventData.id;
                Vue.nextTick(() => this.$parent.$refs.vuetable.refresh());
            },
            doSave() {
                this.$events.fire('info-save', this._getData());
            },
            doDelete() {
                this.$events.fire('info-delete', this._getData());
            },
            resetEdit() {
                this.domainText = '';
                this.relayAdrText = '';
                this.mxText = '';
            }
        }
    }
</script>

<style scoped>

</style>