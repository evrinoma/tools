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
                <select class="form-control" @change="relayAdrHandleChange">
                    <option :selected="relayAdrSelected === false">Select Relay Address</option>
                    <option v-for="(selectValue, index) in servers" :index="index" :param="selectValue.id" :value="selectValue.ip" :selected="relayAdrSelected === selectValue.ip">{{ selectValue.ip }}</option>
                </select>
            </div>
            <div class="field">
                <label>Mx:</label>
                <input type="text" v-model="mxText" class="three wide column" placeholder="MX name">
            </div>
            <br>
            <div class="ui animated button" tabindex="0" @click="doAdd">
                <div class="visible content">Add</div>
                <div class="hidden content">
                    <i class="right plus circle icon"></i>
                </div>
            </div>
            <div class="ui animated button" tabindex="0" @click="doSave">
                <div class="visible content">Save</div>
                <div class="hidden content">
                    <i class="right save icon"></i>
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
    import axios from 'axios';

    Vue.use(VueEvents);
    Vue.use(axios);

    export default {
        data() {
            return {
                domainText: '',
                mxText: '',
                id: '',
                servers: {},
                relayAdrSelected: false,
            }
        },
        mounted() {
            this.$events.$on('info-set', eventData => this.onSet(eventData));
            axios
                .get('http://php72.tools/internal/servers/servers')
                .then(response => (this._setServers(response)));
        },
        methods: {
            relayAdrHandleChange(e) {
                const select = e.target;
                const selectedIp = select.value;
                const selectedId = select.options[select.selectedIndex].attributes.param.value;
                const selectedIndex = select.options[select.selectedIndex].attributes.index.value;
                this.mxText = this.servers[selectedIndex].hostname;
            },
            _setServers(response) {
                this.servers = response.data.servers;
            },
            // _createSelector() {
            //     let selector = [];
            //     this.servers.some(function (value, key) {
            //         selector.push(value.ip);
            //     });
            //     this.relayAdrSelector = selector;
            // },
            _getData() {
                return {
                    domain: this.domainText,
                    relayAdr: this.relayAdrSelected,
                    mx: this.mxText,
                    id: this.id
                }
            },
            onSet(eventData) {
                this.domainText = eventData.domain;
                this.mxText = eventData.mx;
                this.id = eventData.id;
                this.relayAdrSelected = eventData.relayAdr;
            },
            doSave() {
                this.$events.fire('info-save', this._getData());
            },
            doAdd() {
                this.$events.fire('info-add', this._getData());
            },
            resetEdit() {
                this.domainText = '';
                this.relayAdrSelected = false;
                this.mxText = '';
            }
        }
    }
</script>

<style scoped>

</style>