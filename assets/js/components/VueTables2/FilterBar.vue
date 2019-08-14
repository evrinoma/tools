<template>
    <div class="filter-bar ui basic segment grid">
        <div class="ui form">
            <div class="inline field">
                <label>Search for:</label>
                <input type="text" v-model="filterText" class="three wide column" @keyup.enter="doFilter" placeholder="Domain or mx">

                <div class="ui animated button" tabindex="0" @click="doFilter">
                    <div class="visible content" >Go</div>
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
                <!--<button class="ui primary button" @click="doFilter">Go</button>-->
                <!--<button class="ui button" @click="resetFilter">Reset</button>-->

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                filterText: ''
            }
        },
        methods: {
            doFilter () {
                this.$events.fire('filter-set', this.filterText);
            },
            resetFilter () {
                this.filterText = '';
                this.$events.fire('filter-reset');
            }
        }
    }
</script>

<style scoped>

</style>