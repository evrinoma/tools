<template>
    <div>
        <div class="ui segment block">
            <h3 class="ui header">Email log viewer</h3>
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
            <div class="ui section divider"></div>
            <h3 class="ui header">Results</h3>
            <div class="ui tabular menu">
                <a class="item" v-for="selectValue in tabs" :active="tabSelected === tabs.name">{{tabs.name}}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'search',
        components: {},
        data() {
            return {
                filterText: '',
                tabs: {},
                tabSelected: false,
            }
        },
        methods: {
            doFilter () {
               // this.$events.fire('filter-set', this.filterText);
            },
            resetFilter () {
                this.filterText = '';
            }
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