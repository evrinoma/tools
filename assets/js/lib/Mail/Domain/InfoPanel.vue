<template>
    <div class="info-panel">
        <div class="ui huge header">Edit Domain</div>
        <p></p>
        <div class="ui form">
            <div class="field" v-bind:class="{ 'error': hasError }">
                <label>Domain Name:</label>
                <div class="ui right labeled left icon input">
                    <i class="linkify icon "></i>
                    <input type="text" v-model="domainText" class="three wide column" placeholder="Domain name">
                    <a class="ui tag label">
                        ID[{{ id }}]
                    </a>
                </div>
            </div>
            <div class="field">
                <label>Relay Address:</label>
                <select class="form-control" @change="relayAdrHandleChange">
                    <option v-if="relayAdrSelected === false" selected>
                        Select Relay Address
                    </option>
                    <option v-else>
                        Select Relay Address
                    </option>
                    <option v-for="(selectValue, index) in servers" :index="index" :param="selectValue.id" :value="selectValue.ip" :selected="relayAdrSelected === selectValue.ip">{{ selectValue.ip }}</option>

                </select>
            </div>
            <div class="field">
                <label>Mx:</label>
                <div class="ui disabled input">
                    <input type="text" v-model="mxText" class="three wide column" placeholder="MX name">
                </div>
            </div>
            <br>
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
        <br>
        <div v-if="showError" id="hide">
            <div class="ui negative message">
                <i class="close icon" @click="messageError"></i>
                <div class="header">
                    Ошибка
                </div>
                <p>{{errorText}}
                </p>
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
        props: {
            apiUrlServers: {
                type: String,
                required: true
            },
            apiUrlSave: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                domainText: '',
                mxText: '',
                id: '',
                servers: {},
                relayAdrSelected: false,
                hasError: false,
                showError: false,
                errorText: ''
            }
        },
        mounted() {
            this.$events.$on('info-set', eventData => this.onSet(eventData));
            this.$events.$on('info-reload', eventData => this.doLoad());
            this.doLoad();
        },
        methods: {
            relayAdrHandleChange(e) {
                const select = e.target;
                const selectedIp = select.value;
                const selectedId = select.options[select.selectedIndex].attributes.param.value;
                const selectedIndex = select.options[select.selectedIndex].attributes.index.value;
                this.mxText = this.servers[selectedIndex].hostname;
                this.relayAdrSelected = this.servers[selectedIndex].ip;
            },
            _axiosResponse(type, response) {
                switch (type) {
                    case 'info-load':
                        this.servers = response.data.servers;
                        break;
                    case 'info-save':
                        this.$events.fire('table-save', this._getData());
                        break;
                    case 'info-save-error':
                        this.hasError = true;
                        this.showError = true;
                        this.errorText = 'Запись [' + response.response.data.domains.name + '] невозможно сохранить.';
                        setTimeout(this._resetError, 2000);
                        this.$events.fire('info-add', this._getData());
                        break;
                }
            },
            _resetError() {
                this.hasError = false;
            },
            messageError() {
                this.showError = false;
                this.errorText = '';
            },
            _getData() {
                return {
                    domainName: this.domainText,
                    ipServer: this.relayAdrSelected,
                    hostNameServer: this.mxText,
                    domainId: this.id
                }
            },
            _getAddData() {
                return {
                    domainName: this.domainText,
                    hostNameServer: this.mxText,
                    ipServer: this.relayAdrSelected,
                }
            },
            onSet(eventData) {
                this.domainText = eventData.domain;
                this.mxText = eventData.mx;
                this.id = eventData.id;
                this.relayAdrSelected = eventData.relayAdr;
            },
            doLoad() {
                this.resetEdit();
                axios
                    .get(this.apiUrlServers)
                    .then(response => (this._axiosResponse('info-load', response)));
            },
            doSave() {
                axios
                    .post(this.apiUrlSave, this._getAddData())
                    .then(response => (this._axiosResponse('info-save', response)))
                    .catch(error => (this._axiosResponse('info-save-error', error)));
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