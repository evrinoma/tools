<template>
    <div>
        <div class="ui segment block">
            <h3 class="ui header">Email log viewer</h3>
            <div class="ui segment">
                <div class="ui two column very relaxed grid">
                    <div class="column">
                        <div class="ui form" :class="{ 'loading' : showPreloadSearch !== 0}">
                            <div class="inline field">
                                <b><label>Search for:</label></b>
                                <div class="ui icon input">
                                    <i class="search icon"></i>
                                    <input type="text" v-model="searchText" placeholder="Search...">
                                </div>
                                <div class="ui animated button" tabindex="0" @click="doFilter">
                                    <div class="visible content">Search</div>
                                    <div class="hidden content">
                                        <i class="right search icon"></i>
                                    </div>
                                </div>
                                <div class="ui vertical animated button" tabindex="0" @click="resetFilter">
                                    <div class="hidden content">Reset</div>
                                    <div class="visible content">
                                        <i class="shop x icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="html ui top attached segment">
                            <div class="ui top attached label">Settings</div>
                            <div class="ui form" :class="{ 'loading' : showPreloadSettings === true}">
                                <div class="inline fields">
                                    <label>Files:</label>
                                    <div v-for="(section, group) in settings" class="field">
                                        <div class="ui compact menu">
                                            <div class="ui simple dropdown item">
                                                {{section.key}}
                                                <i class="dropdown icon"></i>
                                                <div class="menu">
                                                    <div class="item">
                                                        <div class="ui slider checkbox">
                                                            <input type="checkbox" name="public" :checked="section.active === 'a'" @click="itemAction(section.active, group, undefined)">
                                                            <label>All</label>
                                                        </div>
                                                    </div>
                                                    <div v-for="(selectValue, index) in section.items" class="item">
                                                        <div class="ui slider checkbox">
                                                            <input type="checkbox" name="public" :checked="selectValue.active === 'a'" @click="itemAction(selectValue.active, group, index)">
                                                            <label>{{selectValue.data.name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui vertical animated button" tabindex="0" @click="doSave">
                                        <div class="hidden content">Save</div>
                                        <div class="visible content">
                                            <i class="shop save icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="ui header">Results</h3>
            <div class="ui tabular menu">
                <a class="item" :class="{ 'active' : tabSelected === selectValue.name}" v-for="selectValue in tabs" @click="tabAction(selectValue.name)">{{selectValue.name}}</a>
            </div>
            <div class="ui bottom attached active tab" v-if="tabSelected === selectValue.name" v-for="selectValue in tabs">
                <p v-for="block in selectValue.text">
                    <template v-for="string in block">
                        <span v-html="_highlight(string)"></span>
                        <br>
                    </template>
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
        name: 'search',
        components: {},
        data() {
            return {
                showPreloadSearch: 0,
                showPreloadSettings: false,
                searchText: '',
                searchQueryText: '',
                tabs: [],
                settings: {},
                tabSelected: '',
                apiUrlSearch: 'http://php72.tools/internal/log/search',
                apiUrlSettings: 'http://php72.tools/internal/log/settings',
                apiUrlSettingsSave: 'http://php72.tools/internal/log/settings/save',
            }
        },
        mounted() {
            this.doLoad();
        },
        methods: {
            _axiosResponse(type, response, file) {
                switch (type) {
                    case 'search-load':
                        this._setSettings(response);
                        break;
                    case 'search-settings-save':
                    case 'search-settings-error':
                        this.showPreloadSettings = false;
                        break;
                    case 'search-filter':
                        this.showPreloadSearch--;
                        let self = this;
                        response.data.search.some(function (value) {
                            if (self.tabSelected === '') {
                                self.tabSelected = value.file;
                            }
                            let tab = {name: value.file, text: value.messages};
                            self.tabs.push(tab);
                        });
                        break;
                }
            },
            tabAction(tabSelected) {
                this.tabSelected = tabSelected;
            },
            itemAction(active, group, index) {
                let newActive = (active === 'a') ? 'b' : 'a';
                if (index !== undefined) {
                    this.settings[group].items[index].active = newActive;
                } else {
                    this.settings[group].active = newActive;
                    this.settings[group].items.some(function (value) {
                        value.active = newActive;
                    });
                }
            },
            _highlight(string) {
                return decodeURI(encodeURI(string).replace(this.searchQueryText, '<span class="ui teal label">' + this.searchQueryText + '</span>'));
                //"<span class="ui teal label"><i class=\"large man icon\"></i>Male</span>"
            },
            _setSettings(response) {
                let settings = [];
                let keys = [];
                let count = 0;
                response.data.settings.some(function (value) {
                    let key = value.data.name.substr(0, value.data.name.indexOf('.'));
                    if (keys[key] === undefined) {
                        settings[count] = {items: [], key: key, active: 'a'};
                        keys[key] = count++;
                    }
                    settings[keys[key]].items.push(value);
                    settings[keys[key]].active = (value.active === 'a' & settings[keys[key]].active === 'a') ? 'a' : 'b';
                });

                this.settings = settings;
            },
            _getAddData() {
                let data = [];
                this.settings.some(function (group) {
                    group.items.some(function (value) {
                        data.push({id: value.id, active: value.active});
                    });
                });

                return {settings: data};
            },
            doSave() {
                this.showPreloadSettings = true;
                axios
                    .post(this.apiUrlSettingsSave, this._getAddData())
                    .then(response => (this._axiosResponse('search-settings-save', response)))
                    .catch(error => (this._axiosResponse('search-settings-error', error)));
            },
            doFilter() {
                this.tabs = [];
                this.tabSelected = '';
                this.searchQueryText = this.searchText;
                let self = this;
                this.settings.some(function (value) {
                    value.items.some(function (item) {
                        if (item.active === 'a') {
                            self.showPreloadSearch++;
                            axios
                                .get(self.apiUrlSearch, {params: {searchString: self.searchText, searchFile: item.data.name}})
                                .then(response => (self._axiosResponse('search-filter', response, item.data.name)));
                        }
                    });
                });
            },
            resetFilter() {
                this.searchText = '';
            },
            doLoad() {
                axios
                    .get(this.apiUrlSettings)
                    .then(response => (this._axiosResponse('search-load', response)));
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
        overflow: auto;
        height: 453px;
    }

    .ui.bottom.attached.active.tab p {
        text-align: left;
    }

</style>