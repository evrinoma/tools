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
                                    <div v-for="section in settings" class="field">
                                        <div class="ui compact menu">
                                            <div class="ui simple dropdown item">
                                                {{section.key}}
                                                <i class="dropdown icon"></i>
                                                <div class="menu">
                                                    <div v-for="selectValue in section.items" class="item">
                                                        <div class="ui slider checkbox">
                                                            <input type="checkbox" name="public" :checked="selectValue.active == 'a'">
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
            }
        },
        mounted() {
            this.doLoad();
        },
        methods: {
            _axiosResponse(type, response) {
                switch (type) {
                    case 'search-load':
                        // let settings = [];
                        // let keys = [];
                        // let count = 0;
                        // response.data.settings.some(function (value) {
                        //     let key = value.data.name.substr(0, value.data.name.indexOf('.'));
                        //     if (keys[key] === undefined) {
                        //         settings[count] = [];
                        //         keys[key] = count++;
                        //     }
                        //     settings[keys[key]].push(value);
                        //
                        // });
                        //
                        // this.settings = settings;

                        let settings = [];
                        let keys = [];
                        let count = 0;
                        response.data.settings.some(function (value) {
                            let key = value.data.name.substr(0, value.data.name.indexOf('.'));
                            if (keys[key] === undefined) {
                                settings[count] = {items: [], key: key};
                                keys[key] = count++;
                            }
                            settings[keys[key]].items.push(value);

                        });

                        this.settings = settings;


                        break;
                }
            },
            doSave() {
                // this.$events.fire('filter-set', this.filterText);
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