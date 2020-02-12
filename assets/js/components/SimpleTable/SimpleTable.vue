<template>
    <div>
        <div class="ui segment block">
            <template v-if="filter !== undefined">
                <h3 class="ui header">Settings</h3>
                <div class="ui segment">
                    <div class="ui eight column very relaxed grid">
                        <template v-if="filter.selector !== undefined">
                            <div class="column">
                                <b><label>Object:</label></b>
                                <div class="ui simple dropdown item" :class="lock ? 'disabled' : ''">
                                    {{ _getFilterSelectValue() }}
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item" v-for="(object,index) in objects" @click="setFilterSelectValueAction(index)">
                                            {{object}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="filter.update !== undefined">
                            <div class="column">
                                <b><label>Auto update:</label></b>
                                <div class="ui left floated compact segment">
                                    <div class="ui fitted slider checkbox">
                                        <input type="checkbox" :checked="update" @click="setFilterUpdateAction()">
                                        <label></label>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="filter.date !== undefined">
                            <div class="column">
                                <b><label>Date:</label></b>
                                <date-picker v-model="datePickerValue"
                                             valueType="format"
                                             @change="setFilterDateValue"
                                             :format="datePickerFormat"
                                             :disabled-date="setFilterDisabledDates"
                                             :disabled="lock"
                                >
                                </date-picker>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            <h3 class="ui header">{{ headerTable }}</h3>
            <div>
                <table class="pagination">
                    <tbody>
                    <tr>
                        <td>
                            <div class="begin_button" @click="clickBeginButton()">
                                <button style="font-size:24px"><i class="fa fa-home"></i></button>
                            </div>
                        </td>
                        <td>
                            <div class="prev_button" @click="clickPrevButton()">
                                <button style="font-size:24px"><i class="fa fa-arrow-left"></i></button>
                            </div>
                        </td>
                        <td>
                            <div class="next_button" @click="clickNextButton()">
                                <button style="font-size:24px"><i class="fa fa-arrow-right"></i></button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="ui celled table">
                    <thead>
                    <tr>
                        <th v-for="item in columns"
                            @click="sortBy(item.name)"
                            :class="{ active: sortKey == item.name }">
                            {{ item.header | capitalize }}
                            <span class="arrow" :class="sortOrders[item.name] > 0 ? 'asc' : 'dsc'"></span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(entry, key) in filteredRows">
                        <td v-for="item in columns" v-bind:class="getClasses(item.name, key)">
                            {{entry[item.name]}}
                            <span v-if="typeof item.delete_button !== 'undefined'">
                                <div class="delete_button" @click="clickDeleteButton(entry.id)" @mouseover="mouseoverDeleteButton(item.name, key)" @mouseout="mouseoutDeleteButton(item.name, key)">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    <div class="hint"></div>
                                </div>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        components: {DatePicker},
        name: "SimpleTable",
        props: {
            filter: Object,
            headerTable: String,
            rowsTable: Object,
            columnsTable: Array,
            deleteButton: Object,
            date: String,
        },
        data: function () {
            this.init();
            let columns = this.setColumns();
            let rows = this.setColumnRows();
            let sortOrders = {};
            let isUpdate = false;
            columns.forEach(function (item) {
                sortOrders[item.name] = 1;
            });
            if (this.filter !== undefined && this.filter.update !== undefined && this.filter.update.isUpdate !== undefined && this.filter.update.isUpdate === true) {
                isUpdate = true;
                this._setUpdateTimer();
            }
            return {
                rows: rows,
                columns: columns,
                sortKey: '',
                sortOrders: sortOrders,
                isDeleted: false,
                dataLoad: this.rowsTable,
                objects: null,
                objectSelect: null,
                lock: false,
                interval: undefined,
                update: isUpdate,
                datePickerValue: (this.filter !== undefined && this.filter.date !== undefined && this.filter.date.value !== undefined) ? this.filter.date.value : '',
                datePickerFormat: (this.filter !== undefined && this.filter.date !== undefined && this.filter.date.format !== undefined) ? this.filter.date.format : '',
                datePickerFormatRange: (this.filter !== undefined && this.filter.date !== undefined && this.filter.date.range !== undefined) ? this.filter.date.range : undefined,
            }
        },
        computed: {
            filteredRows: function () {
                let sortKey = this.sortKey;
                let order = this.sortOrders[sortKey] || 1;
                let rows = this.rows;
                if (sortKey) {
                    rows = rows.slice().sort(function (a, b) {
                        a = a[sortKey];
                        b = b[sortKey];
                        return (a === b ? 0 : a > b ? 1 : -1) * order
                    })
                }
                return rows
            }
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
        },
        mounted() {
            this.doLoad();
        },
        beforeDestroy() {
            clearInterval(this.interval)
        },
        methods: {
            setFilterDateValue() {
                this.setLock();
                this.filter.date.callBack();
            },
            getFilterDateValue() {
                return this.datePickerValue;
            },
            setFilterDisabledDates(date) {
                if (this.datePickerFormatRange !== undefined) {
                    return date > this.datePickerFormatRange;
                }
            },
            _getFilterSelectValue() {
                return (this.objects === null || this.objects[this.objectSelect] === undefined) ? 'Select Object' : this.objects[this.objectSelect];
            },
            getFilterSelectValue() {
                let selected = this._getFilterSelectValue();
                return selected === 'Select Object' ? undefined : selected;
            },
            setFilterSelectValueAction(index) {
                this.objectSelect = index;
                this.setLock();
                this.filter.selector.callBack();
            },
            setFilterUpdateAction() {
                this.update = !this.update;
                (this.update) ? this._setUpdateTimer() : this._resetUpdateTimer();
            },
            _axiosResponse(type, response) {
                switch (type) {
                    case 'load-objects':
                        this.objects = response.data;
                        break;
                }
            },
            _setUpdateTimer() {
                this.interval = setInterval(this.filter.update.callBack, this.filter.update.interval);
            },
            _resetUpdateTimer() {
                this.interval = undefined;
                clearInterval(this.interval);
            },
            setLock() {
                this.lock = true;
            },
            setUnLock() {
                this.lock = false;
            },
            doLoad() {
                if (this.filter !== undefined && this.filter.selector !== undefined) {
                    axios
                        .get(this.filter.selector.route)
                        .then(response => (this._axiosResponse('load-objects', response)));
                }
            },
            sortBy: function (key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },
            getClasses: function (name, key) {
                let classes = {};
                if (this.rows[key].classesRow[name] !== undefined) {
                    if (this.rows[key].classesRow[name].delete_row) {
                        classes['delete_row'] = true;
                    }
                }
                return classes;
            },
            clickDeleteButton: function (id) {
                let del = undefined;
                this.rows.filter(
                    function (item, key) {
                        if (item.id === id) {
                            del = key;
                            return false;
                        }
                    }
                );
                if (del !== undefined) {
                    this.deleteButton.callBack(id, this.deleteButton.route);
                    this.rows.splice(del, 1);
                }
            },
            mouseoverDeleteButton: function (name, key) {
                this.rows[key].classesRow[name]['delete_row'] = true;
            },
            mouseoutDeleteButton: function (name, key) {
                this.rows[key].classesRow[name]['delete_row'] = false;
            },
            setColumns: function () {
                let columns = [{name: 'rowNum', header: '№'}];

                return columns.concat(this.columnsTable);
            },
            init: function () {
                this.maxRow = 10;
                this.currentRow = 0;
                this.dataLoad = this.rowsTable;
            },
            setColumnRows: function () {
                let rows = [];
                let maxRow = this.currentRow + this.maxRow;
                for (let number = this.currentRow; number < maxRow; number++) {
                    if (this.dataLoad[number] !== undefined && rows.length < this.maxRow) {
                        this.dataLoad[number]['rowNum'] = number;
                        let classes = {};
                        let defaultClasses = {delete_row: false};
                        this.columns.forEach(function (item) {
                            if (item.hasClasses !== undefined && item.hasClasses) {
                                let value = item.name;
                                classes[value] = defaultClasses;
                            }
                        });
                        this.dataLoad[number]['classesRow'] = classes;
                        rows.push(this.dataLoad[number]);
                    } else {
                        break;
                    }
                }

                return rows;
            },
            setDataLoad: function (dataLoad) {
                this.dataLoad = dataLoad;

                return this;
            },
            setRows: function (rows) {
                this.rows = rows;

                return this;
            },
            updateRows: function (dataLoad) {
                this.setDataLoad(dataLoad).setRows(this.setColumnRows());
            },
            clickBeginButton: function () {
                this.currentRow = 0;
                this.setRows(this.setColumnRows());
            },
            clickPrevButton: function () {
                this.currentRow = this.currentRow - this.maxRow;
                if (this.currentRow < 0) {
                    this.currentRow = 0;
                }
                this.setRows(this.setColumnRows());
            },
            clickNextButton: function () {
                this.currentRow = this.currentRow + this.maxRow;
                let maxRowSizeInPage = ~~(this.dataLoad.length / this.maxRow);

                if (this.currentRow > (maxRowSizeInPage * this.maxRow)) {
                    this.currentRow = maxRowSizeInPage;
                }
                this.setRows(this.setColumnRows());
            },
        }
    };
</script>

<style>
    .ui.segment.block {
        height: 84vh;
    }
</style>
