<template>
    <div class="ui segment" :class="{ 'loading' : showPreloadLiveVideo!==0}">
        <div class="ui segment block">
            <div v-if="groupClass && steamEngine && group">
                <div>
                    <template v-for="item in group">
                        <h2>{{item.name}}</h2>
                        <div>
                            <table class="livecameras">
                                <tbody>
                                <tr v-for="row in item.live_streams">
                                    <template v-for="cam in row">
                                        <template v-if="cam.stream !== undefined">
                                            <td class="camera" :identity="cam.id" :class="item.resolution">
                                                <div class="name" :udapte="update" :class="shows[cam.id].hidden === true ? 'font_'+item.resolution+' hidden':'font_'+item.resolution">{{cam.title}}</div>
                                                <div class="liveWowza">
                                                    <div :id="wowzaLink+cam.id" :class="item.resolution"></div>
                                                </div>
                                            </td>
                                            <td class="splitter">
                                                <template v-if="cam.control">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <button class="circular ui icon button" :class="cam.actions.disable.actionZoomIn!=0?'disabled':cam.actions.load.actionZoomIn!=0 ?'loading':''" @click="doAction(cam,cam.actions.actionZoomIn)">
                                                                    <i class="zoom in icon"></i>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button class="circular ui icon button" :class="cam.actions.disable.actionTop!=0?'disabled':cam.actions.load.actionTop!=0 ?'loading':''" @click="doAction(cam,cam.actions.actionTop)">
                                                                    <i class="icon arrow alternate circle up"></i>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button class="circular ui icon button" :class="cam.actions.disable.actionZoomOut!=0?'disabled':cam.actions.load.actionZoomOut!=0 ?'loading':''" @click="doAction(cam,cam.actions.actionZoomOut)">
                                                                    <i class="zoom out icon"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <button class="circular ui icon button" :class="cam.actions.disable.actionLeft!=0?'disabled':cam.actions.load.actionLeft!=0 ?'loading':''" @click="doAction(cam,cam.actions.actionLeft)">
                                                                    <i class="icon arrow alternate circle left"></i>
                                                                </button>
                                                            </td>
                                                            <td></td>
                                                            <td>
                                                                <button class="circular ui icon button" :class="cam.actions.disable.actionRight!=0?'disabled':cam.actions.load.actionRight!=0 ?'loading':''" @click="doAction(cam,cam.actions.actionRight)">
                                                                    <i class="icon arrow alternate circle right"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <button class="circular ui icon button" :class="cam.actions.disable.actionRight!=0?'disabled':cam.actions.load.actionBottom!=0?'loading':''" @click="doAction(cam,cam.actions.actionBottom)">
                                                                    <i class="icon arrow alternate circle down"></i>
                                                                </button>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </template>
                                            </td>
                                        </template>
                                    </template>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
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
        name: 'LiveVideo',
        components: {},
        data() {
            return {
                apiUrlLive: window.location.origin + '/internal/live_video',
                apiUrlGroupClass: window.location.origin + '/internal/live_video/class',
                apiUrlWowzaStream: window.location.origin + '/internal/live_video/streaming_engine',
                apiUrlControl: window.location.origin + '/internal/live_video/control',
                apiUrlControlClass: window.location.origin + '/internal/live_video/control/class',
                group: null,
                groupClass: null,
                controlClass: null,
                steamEngine: null,
                wowzaLink: "wowza_",
                showPreloadLiveVideo: 0,
                resolution: [
                    'resolution640x360',
                    'resolution640x360',
                    'resolution384x216',
                    'resolution329x194',
                    'resolution288x162',
                    'resolution226x130',
                    'resolution200x112',
                    'resolution165x93',
                    // {width: 640, height: 360,},//rows 1
                    // {width: 640, height: 360,},//rows 2
                    // {width: 384, height: 216,},//rows 3
                    // {width: 329, height: 194,},//rows 4
                    // {width: 288, height: 162,},//rows 5
                    // {width: 226, height: 130,},//rows 6
                    // {width: 200, height: 112,},//rows 7
                    // {width: 165, height: 93,},//rows 8
                ],
                shows: [],
                update: false,
                bufferSec: 30,
            }
        },
        mounted() {
            this.doLoad();
        },
        methods: {
            getResolution(maxColumn) {
                return this.resolution[maxColumn] !== undefined ? this.resolution[maxColumn] : this.resolution[this.resolution.length];
            },
            _getActions() {
                return {
                    load: {
                        actionTop: 0,
                        actionBottom: 0,
                        actionLeft: 0,
                        actionRight: 0,
                        actionZoomIn: 0,
                        actionZoomOut: 0,
                    },
                    disable: {
                        actionTop: 0,
                        actionBottom: 0,
                        actionLeft: 0,
                        actionRight: 0,
                        actionZoomIn: 0,
                        actionZoomOut: 0,
                    },
                    actionTop: 'actionTop',
                    actionBottom: 'actionBottom',
                    actionLeft: 'actionLeft',
                    actionRight: 'actionRight',
                    actionZoomIn: 'actionZoomIn',
                    actionZoomOut: 'actionZoomOut',
                    setLoad(action) {
                        this.load[action]++;
                    },
                    resetLoad(action) {
                        this.load[action]--;
                    },
                    setDisable(action) {
                        this.disable[action]++;
                    },
                }
            },
            _axiosResponse(type, response, query) {
                switch (type) {
                    case 'group-load':
                        let group = response.data;
                        if (group.length) {
                            let row = [];
                            let count = 0;
                            let mod = 0;
                            let self = this;
                            this.showPreloadLiveVideo = 0;
                            group.some(function (item) {
                                item.resolution = self.getResolution(item.max_column);
                                item.live_streams.some(function (cam, index) {
                                    mod = index % item.max_column;
                                    if (row[count] === undefined) {
                                        row[count] = [];
                                    }
                                    if (cam.control) {
                                        cam.actions = self._getActions();
                                    }
                                    row[count].push(cam);
                                    if (mod === (item.max_column - 1)) {
                                        count++;
                                    }
                                    self.shows[cam.id] = {id: cam.id, hidden: true};
                                    self.loadStreamWowza(cam.id, cam.stream, cam.start_play);
                                });
                                while (mod !== (item.max_column - 1)) {
                                    row[count].push({});
                                    mod++;
                                }

                                item.live_streams = row;
                            });
                            this.group = group;
                        }
                        break;
                    case 'group-load-class':
                        this.groupClass = response.data;
                        this.doLoadLiveVideo();
                        break;
                    case 'control-load-class':
                        this.controlClass = response.data;
                        break;
                    case 'wowza-steam-engine':
                        this.steamEngine = response.data;
                        break;
                    case 'wowza-load-stream':
                        this.shows[query.id].hidden = false;
                        this.initWowzaPlayer(this.wowzaLink + query.id, query.stream, query.start_play);
                        this.update = !this.update;
                        break;
                    case 'wowza-error-stream':
                        break;
                    case 'control-action':
                        setTimeout(this._resetLoad, (this.bufferSec + 5) * 1000, query.cam, query.action);
                        break;
                    case 'control-action-error':
                        query.cam.actions.resetLoad(query.action);
                        query.cam.actions.setDisable(query.action);
                        break;
                }
            },
            _resetLoad(cam, action) {
                cam.actions.resetLoad(action);
            },
            loadStreamWowza(id, stream, start_play) {
                if (this.shows[id].hidden === true) {
                    axios.get(this.steamEngine.host + "/" + stream + "/" + this.steamEngine.list, {errorHandle: false})
                        .then(response => (this._axiosResponse('wowza-load-stream', response, {id: id, stream: stream, start_play: start_play})))
                        .catch(error => (this._axiosResponse('wowza-error-stream', error, {id: id, stream: stream, start_play: start_play})));
                }
            },
            initWowzaPlayer(wowzaLive, stream, start_play) {
                WowzaPlayer.create(wowzaLive,
                    {
                        "license": "PLAY1-aZwaP-Dhhhw-9xeUz-8VHbb-npuEc",
                        "title": "",
                        "description": "",
                        "sourceURL": this.steamEngine.host + "/" + stream + "/" + this.steamEngine.list,
                        "autoPlay": start_play,
                        "volume": "75",
                        "mute": true,
                        "loop": false,
                        "audioOnly": false,
                        "uiShowQuickRewind": false,
                        "uiQuickRewindSeconds": 1
                    }
                );
            },
            doAction(cam, action) {
                cam.actions.setLoad(action);
                let query = {class: this.controlClass, action: action, live_streams: cam.stream, cam: cam};
                axios
                    .get(this.apiUrlControl, {params: query})
                    .then(response => (this._axiosResponse('control-action', response, query)))
                    .catch(error => (this._axiosResponse('control-action-error', error, query)));
            },
            doLoad() {
                axios
                    .get(this.apiUrlGroupClass)
                    .then(response => (this._axiosResponse('group-load-class', response)));
                axios
                    .get(this.apiUrlControlClass)
                    .then(response => (this._axiosResponse('control-load-class', response)));
                axios
                    .get(this.apiUrlWowzaStream)
                    .then(response => (this._axiosResponse('wowza-steam-engine', response)));
            },
            doLoadLiveVideo() {
                this.showPreloadLiveVideo++;
                let pathname = window.location.pathname;
                let alias = pathname.substr(pathname.lastIndexOf('/') + 1, pathname.length);
                axios
                    .get(this.apiUrlLive, {params: {class: this.groupClass, alias: alias}})
                    .then(response => (this._axiosResponse('group-load', response)));
            },
        }
    }
</script>

<style scoped>
    .ui.segment {
        height: 84vh;
    }

    .ui.segment.block {
        height: 80vh;
    }

    td.splitter {
        min-width: 5px;
    }


    .resolution640x360 {
        width: 640px;
        height: 360px;
    }

    .resolution384x216 {
        width: 384px;
        height: 216px;
    }

    .resolution329x194 {
        width: 329px;
        height: 194px;
    }

    .resolution288x162 {
        width: 288px;
        height: 162px;
    }

    .resolution226x130 {
        width: 226px;
        height: 130px;
    }

    .resolution200x112 {
        width: 200px;
        height: 112px;
    }

    .resolution165x93 {
        width: 165px;
        height: 93px;
    }

    .font_resolution640x360 {
    }

    .font_resolution384x216 {
        font-size: x-small;
    }

    .font_resolution329x194,
    .font_resolution288x162,
    .font_rresolution226x130,
    .font_rresolution200x112,
    .font_rresolution165x93 {
        font-size: xx-small;
    }


    .hidden {
        display: none;
    }

    /*.ui.button.circular {*/
    /*height: 10px;*/
    /*width: 10px;*/
    /*}*/

</style>