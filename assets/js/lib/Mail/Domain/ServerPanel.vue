<template>
    <div class="server-panel">
        <div class="ui huge header">Edit Server</div>
        <p></p>
        <div class="ui form">
            <div class="field" v-bind:class="{ 'error': hasError }">
                <label>Mx:</label>
                <div class="ui right labeled left icon input">
                    <i class="linkify icon "></i>
                    <input type="text" v-model="mxText"  @input="_cheangeIpTextAction" class="three wide column" placeholder="MX name">
                    <a class="ui tag label">
                        ID[{{ idServerSelected }}]
                    </a>
                </div>
            </div>
            <div class="field" v-bind:class="{ 'error': hasError }">
                <label>IP:</label>
                <div class="ui input">
                    <input type="text" v-model="ipText" class="three wide column" placeholder="IP address">
                </div>
            </div>
            <div class="field">
                <label>Server Address:</label>
                <select class="form-control" @change="relayAdrHandleChange">
                    <option v-if="hostnameSelected === false" selected>
                        Select Relay Address
                    </option>
                    <option v-else>
                        Select Relay Address
                    </option>
                    <option v-for="(selectValue, index) in servers" :index="index" :param="selectValue.id" :value="selectValue.hostname" :selected="hostnameSelected === selectValue.hostname">{{ selectValue.hostname }}</option>

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
            <div class="ui vertical animated button" tabindex="0" @click="_resetEdit">
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
            apiUrlDelete: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                mxText: '',
                ipText: '',
                servers: {},
                hostnameSelected: false,
                idServerSelected: '',
                hasError: false,
                showError: false,
                errorText: '',
            }
        },
        mounted() {
            this.doMount();
        },
        methods: {
            relayAdrHandleChange(e) {
                const select = e.target;
                const selectedIndex = select.options[select.selectedIndex].attributes.index.value;
                this.mxText = this.servers[selectedIndex].hostname;
                this.ipText = this.servers[selectedIndex].ip;
                this.hostnameSelected = this.servers[selectedIndex].hostname;
                this.idServerSelected = this.servers[selectedIndex].id;
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
                        this.errorText = 'Запись [' + response.response.data.servers.name + '] невозможно удалить.';
                        setTimeout(this._resetError, 2000);
                        break;
                    case 'server-save':
                        this.$events.fire('table-save', this._updateData());
                        this.hostnameSelected = response.data.servers.hostname;
                        this.doMount();
                        break;
                    case 'server-save-error':
                        this.hasError = true;
                        this.showError = true;
                        let errorMessage = (response.response.data.servers) ? '[' + response.response.data.servers.name + '] ' : '';
                        this.errorText = 'Запись ' + errorMessage + 'невозможно сохранить.';
                        setTimeout(this._resetError, 2000);
                        this.$events.fire('info-add', this._updateData());
                        break;
                }
            },
            _resetError() {
                this.hasError = false;
                this.showError = false;
            },
            messageError() {
                this.showError = false;
                this.errorText = '';
            },
            _resetEdit() {
                this.mxText = '';
                this.ipText = '';
                this.hostnameSelected = false;
                this._cheangeIpTextAction();
            },
            _cheangeIpTextAction() {
                this.idServerSelected = '';
            },
            _updateData() {
                return {
                    hostNameServer: this.mxText,
                    ipServer: this.ipText,
                    idServer: this.idServerSelected
                }
            },
            _getAddData() {
                return {
                    hostNameServer: this.mxText,
                    ipServer: this.ipText,
                    idServer: this.idServerSelected,
                }
            },
            // onSet(eventData) {
            //     this.mxText = eventData.mx;
            //     this.hostnameSelected = eventData.relayAdr;
            // },
            doMount() {
                this.$events.fire('info-reload');
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
                this._resetEdit();
            }
        }
    }
</script>

<style scoped>

</style>