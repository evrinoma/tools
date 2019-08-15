<template>
    <div class="server-panel">
        <div class="ui huge header">Edit Server</div>
        <p></p>
        <div class="ui form">
            <div class="field">
                <label>Mx:</label>
                <div class="ui input">
                    <input type="text" v-model="mxText" class="three wide column" placeholder="MX name">
                </div>
            </div>
            <div class="field">
                <label>IP:</label>
                <div class="ui input">
                    <input type="text" v-model="ipText" class="three wide column" placeholder="IP address">
                </div>
            </div>
            <div class="field">
                <label>Server Address:</label>
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
            <br>
            <div class="ui animated button" tabindex="0" @click="doSave">
                <div class="visible content">Save</div>
                <div class="hidden content">
                    <i class="right save icon"></i>
                </div>
            </div>
            <div class="ui vertical animated button" tabindex="0" @click="doDelete">
                <div class="hidden content">Delete</div>
                <div class="visible content">
                    <i class="shop trash icon"></i>
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
            apiUrlDelete: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                domainText: '',
                mxText: '',
                ipText: '',
                id: '',
                servers: {},
                relayAdrSelected: false,
                hasError: false,
                showError: false,
                errorText: ''
            }
        },
        mounted() {
            this.doMount();
        },
        methods: {
            relayAdrHandleChange(e) {
                const select = e.target;
                const selectedIp = select.value;
                const selectedId = select.options[select.selectedIndex].attributes.param.value;
                const selectedIndex = select.options[select.selectedIndex].attributes.index.value;
                this.mxText = this.servers[selectedIndex].hostname;
                this.ipText = this.servers[selectedIndex].ip;
                this.relayAdrSelected = this.servers[selectedIndex].ip;
            },
            _axiosResponse(type, response) {
                switch (type) {
                    case 'server-mount':
                        this.servers = response.data.servers;
                        break;
                    case 'server-delete':
                        this.doMount();

                        break;
                    case 'server-delete-error':
                        this.hasError = true;
                        this.showError = true;
                        this.errorText = 'Запись [' + response.response.data.domains.name + '] невозможно удалить.';
                        setTimeout(this._resetError, 2000);
                        break;
                    case 'server-save':
                        this.$events.fire('table-save', this._getData());
                        break;
                    case 'server-save-error':
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
                    ip: this.ipText,
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
            doMount() {
                this.$events.fire('info-reload');
                this.$events.fire('table-save', this._getData());
                axios
                    .get(this.apiUrlServers)
                    .then(response => (this._axiosResponse('server-mount', response)));
            },
            doSave() {
                axios
                    .post(this.apiUrlSave, this._getAddData())
                    .then(response => (this._axiosResponse('server-save', response)))
                    .catch(error => (this._axiosResponse('server-save-error', error)));
            },
            doDelete() {
                axios
                    .delete(this.apiUrlDelete, {data: this._getAddData()})
                    .then(response => (this._axiosResponse('server-delete', response)))
                    .catch(error => (this._axiosResponse('server-delete-error', error)));
                this.domainText = '';
                this.relayAdrSelected = false;
                this.mxText = '';
                this.ipText = '';
            }
        }
    }
</script>

<style scoped>

</style>