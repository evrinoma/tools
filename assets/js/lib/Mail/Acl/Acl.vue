<template>
    <div>
        <div class="ui segment block">
            <h3 class="ui header">Acl Editor</h3>
            <div class="ui segment">
                <div class="ui two column very relaxed grid">
                    <div class="column">
                        <div class="ui form" :class="{ 'loading' : showPreloadForm !== 0}">
                            <div class="inline field">
                                <b><label>Domain:</label></b>
                                <div class="ui simple dropdown item">
                                    {{ _getDomain() }}
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item" v-for="(domain,index) in domains" :class="{ 'active blue' : _initDomain(index)}" @click="_domainAction(index)">
                                            {{domain.domain}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inline field">
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
                                    <button class="ui button" :class="{ 'active blue' : _initList(section)}" @click="_listAction(section)">{{section}}</button>
                                    <div class="or" v-if="index < (aclModel.length-1)"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="column">-->
                    <!--<div class="html ui top attached segment">-->
                    <!--<div class="ui top attached label">Settings</div>-->
                    <!--<div class="ui form" :class="{ 'loading' : showPreloadSettings === true}">-->
                    <!--<div class="inline fields">-->
                    <!--<label>Files:</label>-->
                    <!--<div v-for="(section, group) in settings" class="field">-->
                    <!--<div class="ui compact menu">-->
                    <!--<div class="ui simple dropdown item">-->
                    <!--{{section.key}}-->
                    <!--<i class="dropdown icon"></i>-->
                    <!--<div class="menu">-->
                    <!--<div class="item">-->
                    <!--<div class="ui slider checkbox">-->
                    <!--<input type="checkbox" name="public" :checked="section.active === 'a'" @click="itemAction(section.active, group, undefined)">-->
                    <!--<label>All</label>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--<div v-for="(selectValue, index) in section.items" class="item">-->
                    <!--<div class="ui slider checkbox">-->
                    <!--<input type="checkbox" name="public" :checked="selectValue.active === 'a'" @click="itemAction(selectValue.active, group, index)">-->
                    <!--<label>{{selectValue.data.name}}</label>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--<div class="ui vertical animated button" tabindex="0" @click="doSave">-->
                    <!--<div class="hidden content">Save</div>-->
                    <!--<div class="visible content">-->
                    <!--<i class="shop save icon"></i>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                </div>
            </div>
            <h3 class="ui header">Results</h3>

            <div class="ui tabular menu">
                <a class="item" :class="{ 'active' : _initTab(index)}" v-for="(selectValue, index) in acls" @click="_tabAction(index)">{{selectValue.type}}</a>
            </div>
            <table class="ui celled table">
                <div class="ui bottom attached active tab" v-if="tabSelected === index" v-for="(selectValue, index) in acls">
                    <div class="html ui top attached segment">-->
                        <div class="ui top attached label">
                            <b>List:</b>
                            <div class="ui input focus">
                                <input type="text" v-model="localSearchText" @input="localSearchAction" placeholder="Local search...">
                            </div>
                            <div class="ui vertical animated button" tabindex="0" @click="resetLocalSearch">
                                <div class="hidden content">Reset</div>
                                <div class="visible content">
                                    <i class="shop x icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="ui block">
                            <div class="ui grid" v-for="(block, item) in selectValue.items">
                                <template v-if="block.visible">
                                    <div class="three column">{{block.id}}</div>
                                    <div class="three wide column">
                                        <template v-if="_isEditBlock(block.id)">
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
                showPreloadForm: 0,
                recordText: '',
                apiUrlAclModel: 'http://php72.tools/internal/acl/model',
                apiUrlDomains: 'http://php72.tools/internal/domain/domain',
                apiUrlAcl: 'http://php72.tools/internal/acl/acl',
                apiUrlAclSave: 'http://php72.tools/internal/acl/save',

                aclModel: null,
                aclModelSelect: '',
                domains: null,
                domainSelect: null,
                acls: [],
                tabSelected: null,
                localSearchText: '',
                editText: '',
                editBlock: null,
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
                    case 'acl-load-domain':
                        this.domains = response.data;
                        break;
                    case 'acl-load-acl':
                        this.showPreloadForm--;
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
                        break;
                    case 'acl-add':
                        //push to
                    case 'acl-save':
                    case 'acl-delete':
                        this.$forceUpdate();
                        break;
                    case 'acl-error':
                        break;

                    case 'search-filter':
                }
            },
            _initList(select) {
                if (this.aclModelSelect === '') {
                    this.aclModelSelect = select;
                }
                return this.aclModelSelect === select;
            },
            _listAction(select) {
                this.aclModelSelect = select;
            },
            _isEditBlock(id) {
                return (this.editBlock === id);
            },
            _getDomain() {
                return (this.domains === null || this.domains[this.domainSelect] === undefined) ? 'Select Domain' : this.domains[this.domainSelect].domain;
            },
            _initDomain(index) {
                return (this.domainSelect !== null) ? (this.domainSelect === index) : false;
            },
            _domainAction(index) {
                this.domainSelect = index;
                this.showPreloadForm++;
                this.acls = [];
                this.resetLocalSearch();
                this.tabSelected = null;
                axios
                    .get(this.apiUrlAcl, {params: {domain: this.domains[this.domainSelect]}})
                    .then(response => (this._axiosResponse('acl-load-acl', response)));

            },
            _initTab(index) {
                if (this.tabSelected === null) {
                    this.tabSelected = index;
                }
                return this.tabSelected === index;
            },
            _tabAction(index) {
                this.tabSelected = index;
                this._filterAcls();
            },
            localSearchAction() {
                if (this.localSearchText.length % 3 === 0) {
                    this._filterAcls();
                }
            },
            _filterAcls() {
                let self = this;
                this.acls[this.tabSelected].items.some(function (value) {
                    if (value.email.indexOf(self.localSearchText) !== -1) {
                        value.visible = true;
                        value.visible = !value.deleted;
                    } else {
                        value.visible = false;
                    }
                });
            },
            doAdd() {
                let data = {
                    type: this.aclModelSelect,
                    email: this.recordText,
                    domain: this.domains[this.domainSelect]
                };
                axios
                    .post(this.apiUrlAclSave, data)
                    .then(response => (this._axiosResponse('acl-save', response)))
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
            resetRecord() {
                this.recordText = '';
            },
            resetLocalSearch() {
                this.localSearchText = '';
                if (this.acls.length && this.acls[this.tabSelected] !== undefined) {
                    this.acls[this.tabSelected].items.some(function (value) {
                        value.visible = true;
                        value.visible = !value.deleted;
                    });
                }
            },
            doLoad() {
                axios
                    .get(this.apiUrlAclModel)
                    .then(response => (this._axiosResponse('acl-load-model', response)));
                axios
                    .get(this.apiUrlDomains)
                    .then(response => (this._axiosResponse('acl-load-domain', response)));
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
        height: 400px;
    }

    .ui.block {
        overflow-x: hidden;
        overflow-y: auto;
        height: 336px;
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
</style>