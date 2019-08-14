<template>
    <div class="info-panel">
        <div class="ui huge header">Edit Row</div>
        <p></p>
        <div class="ui form">
            <div class="field">
                <label>Name:</label>
                <input type="text" v-model="nameText" class="three wide column" placeholder="name">
            </div>
            <div class="field">
                <label>Age:</label>
                <input type="text" v-model="ageText" class="three wide column" placeholder="age">
            </div>
            <div class="field">
                <label>Email:</label>
                <input type="text" v-model="emailText" class="three wide column" placeholder="email">
            </div>
            <div class="field">
                <label>NickName:</label>
                <input type="text" v-model="nickNameText" class="three wide column" placeholder="nickname">
            </div>
            <br>
            <div class="ui animated button" tabindex="0" @click="doSave">
                <div class="visible content">Save</div>
                <div class="hidden content">
                    <i class="right save icon"></i>
                </div>
            </div>
            <div class="ui animated button" tabindex="0" @click="doDelete">
                <div class="visible content">Delete</div>
                <div class="hidden content">
                    <i class="right trash icon"></i>
                </div>
            </div>
            <div class="ui vertical animated button" tabindex="0" @click="resetEdit">
                <div class="hidden content">Reset</div>
                <div class="visible content">
                    <i class="shop x icon"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueEvents from 'vue-events';

    Vue.use(VueEvents);

    export default {
        data() {
            return {
                nameText: '',
                ageText: '',
                emailText: '',
                nickNameText: '',
                id: '',
            }
        },
        mounted() {
            this.$events.$on('info-set', eventData => this.onSet(eventData));
        },
        methods: {
            _getData() {
                return {
                    name: this.nameText,
                    age: this.ageText,
                    email: this.emailText,
                    nickName: this.nickNameText,
                    id: this.id
                }
            },
            onSet(eventData) {
                this.nameText = eventData.name;
                this.ageText = eventData.age;
                this.emailText = eventData.email;
                this.nickNameText = eventData.nickname;
                this.id = eventData.id;
                Vue.nextTick(() => this.$parent.$refs.vuetable.refresh());
            },
            doSave() {
                this.$events.fire('info-save', this._getData());
            },
            doDelete() {
                this.$events.fire('info-delete', this._getData());
            },
            resetEdit() {
                this.nameText = '';
                this.ageText = '';
                this.emailText = '';
                this.nickNameText = '';
            }
        }
    }
</script>

<style scoped>

</style>