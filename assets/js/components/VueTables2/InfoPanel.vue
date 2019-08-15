<template>
    <div class="info-panel">
        <div class="ui huge header">Edit Row</div>
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
                    <option :key="componentKey" :selected="relayAdrSelected === false">Select Relay Address</option>
                    <option :key="componentKey" v-for="(selectValue, index) in servers" :index="index" :param="selectValue.id" :value="selectValue.ip" :selected="relayAdrSelected === selectValue.ip">{{ selectValue.ip }}</option>
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
        data() {
            return {
                domainText: '',
                mxText: '',
                id: '',
                servers: {},
                relayAdrSelected: false,
                hasError: false,
                showError: false,
                componentKey: false,
                errorText: ''
            }
        },
        mounted() {
            this.$events.$on('info-set', eventData => this.onSet(eventData));
            axios
                .get('http://php72.tools/internal/servers/servers')
                .then(response => (this._axiosResponse('info-mount', response)));
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
                    case 'info-mount':
                        this.servers = response.data.servers;
                        break;
                    case 'info-save':
                        this.$events.fire('info-save', this._getData());
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
                    domain: this.domainText,
                    relayAdr: this.relayAdrSelected,
                    mx: this.mxText,
                    id: this.id
                }
            },
            _getAddData() {
                return {
                    name: this.domainText,
                    ip: this.relayAdrSelected,
                }
            },
            onSet(eventData) {
                this.domainText = eventData.domain;
                this.mxText = eventData.mx;
                this.id = eventData.id;
                this.relayAdrSelected = eventData.relayAdr;
            },
            doSave() {
                axios
                    .post('http://php72.tools/internal/domain/save', this._getAddData())
                    .then(response => (this._axiosResponse('info-save', response)))
                    .catch(error => (this._axiosResponse('info-save-error', error)));
            },
            resetEdit() {
                this.domainText = '';
                this.relayAdrSelected = false;
                this.mxText = '';
                componentKey = true;
                Vue.nextTick(() => this.$refs.vuetable.refresh());
            }
        }
    }
</script>

<style scoped>

</style>