<template>
    <div>
        <div class="ui segment block">
            <div class="ui segment">
                <div class="ui two column very relaxed grid">
                    <div class="column">
                        <h3 class="ui header">Acl Editor</h3>
                        <div class="ui form" :class="{ 'loading' : showPreloadAclForm !== 0}">
                            <div class="inline field">
                                <b><label>Domain:</label></b>
                                <div class="ui simple dropdown item">
                                    {{ _getDomain() }}
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item" v-for="(domain,index) in domains" :class="{ 'active blue' : _initDomain(index)}" @click="_domainAction(index)">
                                            {{domain.domainName}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inline field" v-bind:class="{ 'error': hasError }">
                                <b><label>Record:</label></b>
                                <div class="ui icon input">
                                    <i class="bug icon"></i>
                                    <input type="text" v-model="recordText" placeholder="Email or Domain name">
                                </div>
                                <div class="ui animated button" tabindex="0" @click="doAdd">
                                    <div class="visible content">Add</div>
                                    <div class="hidden content">
                                        <i class="right save icon"></i>
                                    </div>
                                </div>
                                <div class="ui vertical animated button" tabindex="0" @click="resetRecord">
                                    <div class="hidden content">Reset</div>
                                    <div class="visible content">
                                        <i class="shop x icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="inline field">
                                <b><label>List:</label></b>
                                <div class="ui buttons" v-for="(section, index) in aclModel">
                                    <button class="ui button" :class="{ 'active blue' : _initAclList(section)}" @click="_listAclAction(section)">{{section}}</button>
                                    <div class="or" v-if="index < (aclModel.length-1)"></div>
                                </div>
                            </div>
                        </div>

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
                    <div class="column">
                        <h3 class="ui header">Block SPAM activity</h3>
                        <div class="ui form" :class="{ 'loading' : showPreloadSpamForm !== 0}">
                            <div class="inline fields">
                                <div class="inline field">
                                    <b><label>Filter Type:</label></b>
                                    <div class="ui simple dropdown item">
                                        {{ _getRule() }}
                                        <i class="dropdown icon"></i>
                                        <div class="menu">
                                            <div class="item" v-for="(rule,index) in rulesType" :class="{ 'active blue' : _initRule(index)}" @click="_ruleAction(index)">
                                                {{rule.type}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inline field" v-bind:class="{ 'error': hasErrorSpam }">
                                <b><label>Record:</label></b>
                                <div class="ui icon input">
                                    <i class="bug icon"></i>
                                    <input type="text" v-model="recordSpamText" placeholder="Email or Domain name">
                                </div>
                                <div class="ui animated button" tabindex="0" @click="doBan">
                                    <div class="visible content">Ban</div>
                                    <div class="hidden content">
                                        <i class="right ban icon"></i>
                                    </div>
                                </div>
                                <div class="ui vertical animated button" tabindex="0" @click="resetRecordSpam">
                                    <div class="hidden content">Reset</div>
                                    <div class="visible content">
                                        <i class="shop x icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="inline field">
                                <b><label>Conformity:</label></b>
                                <div class="ui buttons" v-for="(section, index) in conformityModel">
                                    <button class="ui button" :class="{ 'active red' : _initConformityList(index)}" @click="_listConformityAction(index)">{{section.type}}</button>
                                    <div class="or" v-if="index < (conformityModel.length-1)"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="ui header">Results</h3>
            <div class="ui two column very relaxed grid">
                <div class="column">
                    <div class="ui tabular menu">
                        <a class="item" :class="{ 'active' : _initAclTab(index)}" v-for="(selectValue, index) in acls" @click="_tabAclAction(index)">{{selectValue.type}}</a>
                    </div>
                    <table class="ui celled table">
                        <div class="ui bottom attached active tab" v-if="aclTabSelected === index" v-for="(selectValue, index) in acls">
                            <div class="html ui top attached segment">
                                <div class="ui top attached label">
                                    <b>List:</b>
                                    <div class="ui input focus">
                                        <input type="text" v-model="aclSearchText" @input="aclSearchAction" placeholder="Local search...">
                                    </div>
                                    <div class="ui vertical animated button" tabindex="0" @click="resetAclSearchAction">
                                        <div class="hidden content">Reset</div>
                                        <div class="visible content">
                                            <i class="shop x icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui spliter">
                                </div>
                                <div class="ui block acl">
                                    <div class="ui grid" v-for="(block, item) in selectValue.items">
                                        <template v-if="block.visible">
                                            <div class="three column">{{block.aclId}}</div>
                                            <div class="three wide column">
                                                <template v-if="_isEditBlock(block.aclId)">
                                                    <div class="ui input focus small">
                                                        <input type="text" v-model="editText" placeholder="Edit...">
                                                    </div>
                                                </template>
                                                <template v-else>{{block.email}}</template>
                                            </div>
                                            <div class="three wide column">
                                                <template v-if="_isEditBlock(block.id)">
                                                    <span class="ui teal label" @click="doEditSaveAction(index, item)"><i class="save outline icon"></i>Save</span>
                                                    <span class="ui teal label" @click="doEditCancelAction(block)"><i class="shop x icon"></i>Cancel</span>
                                                </template>
                                                <template v-else>
                                                    <span class="ui teal label" @click="doEditAction(block)"><i class="edit outline icon"></i>Edit</span>
                                                    <span class="ui teal label" @click="doDeleteAction(index, item)"><i class="trash icon"></i>Delete</span>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
                <div class="column">
                    <div class="ui tabular menu">
                        <a class="item" :class="{ 'active' : _initSpamTab(index)}" v-for="(selectValue, index) in spams" @click="_tabSpamAction(index)">{{selectValue.type}}</a>
                    </div>
                    <table class="ui celled table">
                        <div class="ui bottom attached active tab" v-if="spamTabSelected === index" v-for="(selectValue, index) in spams">
                            <div class="html ui top attached segment">
                                <div class="ui top attached label">
                                    <div class="ui grid">
                                        <div class="four column">ID</div>
                                        <div class="four wide column">
                                            <div class="ui icon input focus">
                                                <i class="close icon resetRecordSpam" @click="resetRecordSpam"></i>
                                                <input type="text" v-model="factorSearchText" @input="factorSearchAction" placeholder="Factor">
                                            </div>
                                        </div>
                                        <div class="four wide column">Conformity</div>
                                        <div class="four wide column">Action</div>
                                    </div>
                                </div>
                                <div class="ui spliter">
                                </div>
                                <div class="ui block spam">
                                    <div class="ui grid" v-for="(block, item) in selectValue.items">
                                        <template v-if="block.visible">
                                            <div class="four column">{{block.spamId}}</div>
                                            <div class="four wide column">
                                                {{block.domain}}
                                            </div>
                                            <div class="four wide column">
                                                {{block.conformity.type}}
                                            </div>
                                            <div class="four wide column">
                                                <span class="ui teal label" @click="doSpamDeleteAction(index, item)"><i class="trash icon"></i>Delete</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
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
        name: 'acl',
        components: {},
        data() {
            return {
                showPreloadAclForm: 0,
                recordText: '',

                apiUrlAclModel: 'http://php72.tools/internal/acl/model',
                apiUrlDomains: 'http://php72.tools/internal/domain/domain',
                apiUrlAcl: 'http://php72.tools/internal/acl/acl',
                apiUrlAclSave: 'http://php72.tools/internal/acl/save',

                apiUrlSpam: 'http://php72.tools/internal/spam/rules',
                apiUrlSpamType: 'http://php72.tools/internal/spam/rules_type',
                apiUrlConformityModel: 'http://php72.tools/internal/spam/conformity',
                apiUrlSpamSave: 'http://php72.tools/internal/spam/save',

                aclModel: null,
                aclModelSelect: '',
                domains: null,
                domainSelect: null,
                acls: [],
                aclTabSelected: null,
                aclSearchText: '',
                editText: '',
                editBlock: null,

                hasError: false,
                showError: false,
                errorText: '',

                rulesType: null,
                ruleTypeSelect: null,
                showPreloadSpamForm: 0,
                hasErrorSpam: false,
                recordSpamText: '',
                conformityModel: null,
                conformityModelSelect: '',
                spams: [],
                spamTabSelected: null,
                factorSearchText: '',

            }
        },
        mounted() {
            this.doLoad();
        },
        methods: {
            _axiosResponse(type, response) {
                switch (type) {
                    case 'acl-load-model':
                        this.aclModel = response.data.model;
                        break;
                    case 'conformity-load-model':
                        this.conformityModel = response.data.model;
                        break;
                    case 'conformity-load-spam': {
                        this.showPreloadSpamForm--;
                        let self = this;
                        let keys = [];
                        let count = 0;
                        response.data.some(function (value) {
                            if (keys[value.type.type] === undefined) {
                                self.spams[count] = {items: [], type: value.type.type};
                                keys[value.type.type] = count++;
                            }
                            value.visible = true;

                            self.spams[keys[value.type.type]].items.push(value);
                        });
                    }
                        break;
                    case 'acl-load-domain':
                        this.domains = response.data;
                        break;
                    case 'acl-load-acl': {
                        this.showPreloadAclForm--;
                        let self = this;
                        let keys = [];
                        let count = 0;
                        response.data.some(function (value) {
                            if (keys[value.type] === undefined) {
                                self.acls[count] = {items: [], type: value.type};
                                keys[value.type] = count++;
                            }
                            value.visible = true;

                            self.acls[keys[value.type]].items.push(value);
                        });
                    }
                        break;
                    case 'acl-add':
                        this._add(response.data);
                    case 'acl-save':
                        this.resetRecord();
                    case 'acl-delete':
                        this.$forceUpdate();
                        break;
                    case 'acl-error':
                        this.hasError = true;
                        this.showError = true;
                        setTimeout(this._resetError, 2000);
                        this.errorText = 'Запись [' + response.response.data + '] невозможно сохранить.';
                        break;
                    case 'acl-load-spam-type':
                        this.rulesType = response.data;
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
            _add(acl) {
                acl.visible = true;
                this.acls.some(function (value) {
                    if (value.type === acl.type) {
                        value.items.push(acl);
                        return true;
                    }
                });
            },
            _getRule() {
                return (this.rulesType === null || this.rulesType[this.ruleTypeSelect] === undefined) ? 'Select Rule' : this.rulesType[this.ruleTypeSelect].type;
            },
            _initRule(index) {
                return (this.ruleTypeSelect !== null) ? (this.ruleTypeSelect === index) : false;
            },
            _ruleAction(index) {
                this.ruleTypeSelect = index;
            },
            _initAclList(select) {
                if (this.aclModelSelect === '') {
                    this.aclModelSelect = select;
                }
                return this.aclModelSelect === select;
            },
            _listAclAction(select) {
                this.aclModelSelect = select;
            },
            _initConformityList(index) {
                if (this.conformityModelSelect === '') {
                    this.conformityModelSelect = index;
                }
                return this.conformityModelSelect === index;
            },
            _listConformityAction(select) {
                this.conformityModelSelect = select;
            },
            _isEditBlock(id) {
                return (this.editBlock === id);
            },
            _getDomain() {
                return (this.domains === null || this.domains[this.domainSelect] === undefined) ? 'Select Domain' : this.domains[this.domainSelect].domainName;
            },
            _initDomain(index) {
                return (this.domainSelect !== null) ? (this.domainSelect === index) : false;
            },
            _domainAction(index) {
                this.domainSelect = index;
                this.showPreloadAclForm++;
                this.acls = [];
                this.resetAclSearchAction();
                this.aclTabSelected = null;
                axios
                    .get(this.apiUrlAcl, {params: this.domains[this.domainSelect]})
                    .then(response => (this._axiosResponse('acl-load-acl', response)));

            },
            _initAclTab(index) {
                if (this.aclTabSelected === null) {
                    this.aclTabSelected = index;
                }
                return this.aclTabSelected === index;
            },
            _tabAclAction(index) {
                this.aclTabSelected = index;
                this._filterAcls();
            },
            _initSpamTab(index) {
                if (this.spamTabSelected === null) {
                    this.spamTabSelected = index;
                }
                return this.spamTabSelected === index;
            },
            _tabSpamAction(index) {
                this.spamTabSelected = index;
                this._filterFactors();
            },
            factorSearchAction() {
                if (this.factorSearchText.length % 2 === 0) {
                    this._filterFactors();
                }
            },
            aclSearchAction() {
                if (this.aclSearchText.length % 2 === 0) {
                    this._filterAcls();
                }
            },
            _filterFactors() {
                let self = this;
                this.spams[this.spamTabSelected].items.some(function (value) {
                    if (value.domain.indexOf(self.factorSearchText) !== -1) {
                        value.visible = true;
                        value.visible = !value.deleted;
                    } else {
                        value.visible = false;
                    }
                });
            },
            _filterAcls() {
                let self = this;
                this.acls[this.aclTabSelected].items.some(function (value) {
                    if (value.email.indexOf(self.aclSearchText) !== -1) {
                        value.visible = true;
                        value.visible = !value.deleted;
                    } else {
                        value.visible = false;
                    }
                });
            },
            doBan() {

            },
            doAdd() {
                let data = {
                    type: this.aclModelSelect,
                    email: this.recordText,
                    domain: this.domains[this.domainSelect]
                };
                axios
                    .post(this.apiUrlAclSave, data)
                    .then(response => (this._axiosResponse('acl-add', response)))
                    .catch(error => (this._axiosResponse('acl-error', error)));
            },
            doEditSaveAction(index, item) {
                this.acls[index].items[item].email = this.editText;
                this.doEditCancelAction();
                axios
                    .post(this.apiUrlAclSave, this.acls[index].items[item])
                    .then(response => (this._axiosResponse('acl-save', response)))
                    .catch(error => (this._axiosResponse('acl-error', error)));
            },
            doEditCancelAction() {
                this.editBlock = null;
                this.editText = '';
            },
            doEditAction(block) {
                this.editBlock = block.id;
                this.editText = block.email;
            },
            doDeleteAction(index, item) {
                this.acls[index].items[item].active = 'd';
                this.acls[index].items[item].deleted = true;
                this.acls[index].items[item].visible = false;
                axios
                    .post(this.apiUrlAclSave, this.acls[index].items[item])
                    .then(response => (this._axiosResponse('acl-delete', response)))
                    .catch(error => (this._axiosResponse('acl-error', error)));
            },
            doSpamDeleteAction(index, item) {
                this.spams[index].items[item].active = 'd';
                this.spams[index].items[item].deleted = true;
                this.spams[index].items[item].visible = false;
                axios
                    .post(this.apiUrlSpamSave, this.spams[index].items[item])
                    .then(response => (this._axiosResponse('acl-delete', response)))
                    .catch(error => (this._axiosResponse('acl-error', error)));
            },
            resetRecord() {
                this.recordText = '';
            },
            resetRecordSpam() {
                this.recordSpamText = '';
            },
            resetAclSearchAction() {
                this.aclSearchText = '';
                if (this.acls.length && this.acls[this.aclTabSelected] !== undefined) {
                    this.acls[this.aclTabSelected].items.some(function (value) {
                        value.visible = true;
                        value.visible = !value.deleted;
                    });
                }
            },
            doLoad() {
                this.showPreloadSpamForm++;
                axios
                    .get(this.apiUrlAclModel)
                    .then(response => (this._axiosResponse('acl-load-model', response)));
                axios
                    .get(this.apiUrlDomains)
                    .then(response => (this._axiosResponse('acl-load-domain', response)));
                axios
                    .get(this.apiUrlSpamType)
                    .then(response => (this._axiosResponse('acl-load-spam-type', response)));
                axios
                    .get(this.apiUrlConformityModel)
                    .then(response => (this._axiosResponse('conformity-load-model', response)));
                axios
                    .get(this.apiUrlSpam)
                    .then(response => (this._axiosResponse('conformity-load-spam', response)));
            },
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

    .ui.segment.block {
        height: 84vh;
    }

    .ui.bottom.attached.active.tab {
        overflow: hidden;
        height: 410px;
    }

    .ui.block {
        overflow-x: hidden;
        overflow-y: auto;
        height: 353px;
    }

    .ui.bottom.attached.active.tab p {
        text-align: left;
    }

    .ui.teal.label {
        cursor: pointer;
    }

    .ui.input.focus.small {
        height: 10px;
    }

    .ui.grid > [class*="three wide"].column {
        width: 25.75% !important;
    }


    div.ui.spliter {
        height: 20px;
    }

    .resetRecordSpam {
        cursor: pointer;
    }
</style>