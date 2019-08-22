<template>
    <div>
        <div class="ui segment block">
            <h3 class="ui header">Email log viewer</h3>
            <div class="ui segment">
                <div class="ui two column very relaxed grid">
                    <div class="column">
                        <div class="inline field">
                            <b><label>Search for:</label></b>
                            <div class="ui icon input">
                                <i class="search icon"></i>
                                <input type="text" v-model="filterText" placeholder="Search...">
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
                    <div class="column">
                        <div class="html ui top attached segment">
                            <div class="ui top attached label">Settings</div>
                            <div class="ui form">
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
                <a class="item" v-for="selectValue in tabs" :active="tabSelected === tabs.name">{{tabs.name}}</a>
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
                filterText: '',
                tabs: {},
                settings: {},
                tabSelected: false,
                apiUrlSettings: 'http://php72.tools/internal/log/settings',
                apiUrlSettingsSave: 'http://php72.tools/internal/log/settings/save',
            }
        },
        mounted() {
            this.doLoad();
        },
        methods: {
            _axiosResponse(type, response) {
                switch (type) {
                    case 'search-load':
                        this._setSettings(response);

                        break;
                }
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
                axios
                    .post(this.apiUrlSettingsSave, this._getAddData())
                    .then(response => (this._axiosResponse('search-settings-save', response)))
                    .catch(error => (this._axiosResponse('search-settings-error', error)));
            },
            doFilter() {
                // this.$events.fire('filter-set', this.filterText);
            },
            resetFilter() {
                this.filterText = '';
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
</style>