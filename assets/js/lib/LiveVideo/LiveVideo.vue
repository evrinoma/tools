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
                                                <!--<div class="name" :class="'font_'+item.resolution">{{cam.title}}</div>-->
                                                <div class="liveWowza">
                                                    <div :id="wowzaLink+cam.id" :class="item.resolution">{{loadStreamWowza(cam.id, cam.stream, cam.start_play)}}</div>
                                                </div>
                                            </td>
                                            <td class="splitter">
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
                apiUrlLive: 'http://php72.tools/internal/live_video',
                apiUrlGroupClass: 'http://php72.tools/internal/live_video/class',
                apiUrlWowzaStream: 'http://php72.tools/internal/live_video/streaming_engine',
                group: null,
                groupClass: null,
                steamEngine: null,
                wowzaLink: "wowza_",
                showPreloadLiveVideo: 0,
                resolution: [
                    'resolution640x360',
                    'resolution640x360',
                    'resolution640x360',
                    'resolution384x216',
                    'resolution329x194',
                    'resolution288x162',
                    // {width: 640, height: 360,},//rows 1
                    // {width: 640, height: 360,},//rows 2
                    // {width: 384, height: 216,},//rows 3
                    // {width: 329, height: 194,},//rows 4
                    // {width: 288, height: 162,},//rows 5
                ],
                shows: [],
                update: false,
            }
        },
        mounted() {
            this.doLoad();
        },
        methods: {
            getResolution(maxColumn) {
                return this.resolution[maxColumn] !== undefined ? this.resolution[maxColumn] : this.resolution[this.resolution.length];
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
                                    row[count].push(cam);
                                    if (mod === (item.max_column - 1)) {
                                        count++;
                                    }
                                    self.shows[cam.id] = {id: cam.id, hidden: true};
                                });
                                while (mod !== (item.max_column - 1)) {
                                    row[count].push({});
                                    mod++;
                                }

                                item.live_streams = row;
                            });
                            this.group = group;
                        } else {
                            this.doLoadLiveVideo();
                        }
                        break;
                    case 'group-load-class':
                        this.groupClass = response.data;
                        break;
                    case 'wowza-steam-engine':
                        this.steamEngine = response.data;
                        this.doLoadLiveVideo();
                        break;
                    case 'wowza-load-stream':
                        this.initWowzaPlayer(this.wowzaLink + query.id, query.stream, query.start_play);
                        this.shows[query.id].hidden = false;
                        this.update = !this.update;
                        break;
                    case 'wowza-error-stream':
                        break;
                }
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
                        "uiQuickRewindSeconds": "30"
                    }
                );
            },
            doLoad() {
                axios
                    .get(this.apiUrlGroupClass)
                    .then(response => (this._axiosResponse('group-load-class', response)));
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

    .font_resolution640x360 {
    }

    .font_resolution384x216 {
        font-size: x-small;
    }

    .font_resolution329x194 {
        font-size: xx-small;
    }

    .font_resolution288x162 {
        font-size: xx-small;
    }

    .hidden {
        display: none;
    }

</style>