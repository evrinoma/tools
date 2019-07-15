<template>
    <div>
        <h4>{{ headerTable }}</h4>
        <table class="simpleTable">
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
    </div>
</template>

<script>
    export default {
        name: "SimpleTable",
        props: {
            headerTable: String,
            rowsTable: Object,
            columnsTable: Array,
            deleteButton: Object,
        },
        data: function () {
            this.init();
            let columns = this.setColumns();
            let rows = this.setColumnRows();
            let sortOrders = {};
            columns.forEach(function (item) {
                sortOrders[item.name] = 1;
            });
            return {
                rows: rows,
                columns: columns,
                sortKey: '',
                sortOrders: sortOrders,
                isDeleted: false,
                dataLoad: this.rowsTable,
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
        methods: {
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

                if (this.currentRow > maxRowSizeInPage) {
                    this.currentRow = maxRowSizeInPage;
                }
                this.setRows(this.setColumnRows());
            },
        }
    };
</script>

<style>
    table.simpleTable {
        border: 2px solid #42b983;
        border-radius: 3px;
        background-color: #fff;
        display: inline-block;
    }

    .simpleTable th {
        background-color: #42b983;
        color: rgba(255, 255, 255, 0.66);
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .simpleTable td {
        background-color: #f9f9f9;
    }

    .simpleTable th:not(:first-child), .simpleTable td:not(:first-child) {
        min-width: 120px;
        padding: 10px 20px;
    }

    .simpleTable th.active {
        color: #fff;
    }

    .simpleTable th.active .arrow {
        opacity: 1;
    }

    .simpleTable .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: 0.66;
    }

    .simpleTable .arrow.asc {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-bottom: 4px solid #fff;
    }

    .simpleTable .arrow.dsc {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #fff;
    }

    .simpleTable div.delete_button {
        line-height: 19px;
        font-size: 13px;
        width: 20px;
        height: 20px;
        border-radius: 10px;
        cursor: pointer;
        text-align: center;
        position: relative;
        background: #FF6E7B;
        color: #2A3F54;
        margin-left: 115%;
        margin-top: -10%;
    }

    .simpleTable td.delete_row {
        box-shadow: inset 0 -2px 2px 0 #FF6E7B, inset 0 2px 2px 0 #FF6E7B;
        color: #FF6E7B;
    }

    .simpleTable div.hint {
        position: absolute;
        margin-left: 3px;
        margin-top: -10px;
        height: 40px;
        width: 75px;
        z-index: 1000;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        text-align: center;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        text-shadow: none;
        font-size: 11px;
        line-height: 15px;
    }

    .simpleTable .delete_row div.hint::after {
        color: #73879C;
        background: rgba(242, 245, 247, 0.75);
        border: 1px solid white;
        display: block;
        content: "Удалить документ";
        margin-left: 23px;
        margin-top: -3px;
    }

    .simpleTable .fa {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .simpleTable .delete_row .delete_button .fa {
        -webkit-animation: fa-spin 2s infinite linear;
        animation: fa-spin 2s infinite linear;
    }
</style>
