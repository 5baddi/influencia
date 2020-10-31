<template>
<table :class="cssClasses">
    <thead ref="headercolumns">
        <th v-for="(column, index) in columns" :key="index">
            {{ (column.name ? column.name : " ") | headerColumn }}
            <!-- TODO: fix sotring -->
            <!-- <span v-show="column.sortable && this.sortKey == 'desc' && (this.sortColumn == column.name || this.sortColumn)" @click="sortBy(column)">
                        <i class="fas fa-sort-up"></i>
                    </span>
                    <span v-show="column.sortable && this.sortKey == 'asc' && (this.sortColumn == column.name || this.sortColumn)" @click="sortBy(column)">
                        <i class="fas fa-sort-down"></i>
                    </span> -->
        </th>
        <slot name="header"></slot>
    </thead>
    <tbody>
        <tr v-if="parsedData.length === 0">
            <td class="no-data" :colspan="getColumnsCount()">
                <span v-show="!isLoading"><i class="fas fa-exclamation-triangle"></i>&nbsp;No data found.</span>
                <span v-show="isLoading"><i class="fas fa-spinner fa-spin"></i>&nbsp;Loading...</span>
            </td>
        </tr>
        <tr v-show="parsedData.length > 0 && !isLoading" v-for="(obj, index) in parsedData" :key="index">
            <td v-for="(col, idx) in columns" :key="idx">
                <div v-if="typeof obj[col.field] !== 'undefined'" v-html="obj[col.field]"></div>
            </td>
            <slot name="body-row" :data="obj"></slot>
        </tr>
    </tbody>
    <tfoot v-if="data.length > 0 && !isLoading">
        <tr>
            <td :colspan="getColumnsCount()">
                Rows per page:
                <select ref="itemsPerPage" @change="perPageOnChange($event)">
                    <option v-for="value in rowPerPage" :key="value" :value="(value !== 'All') ? value : data.length" :selected="perPage == value">{{ value }}</option>
                </select>
                <span>{{ startIndex }} - {{ parsedData.length }} of {{ data.length }}</span>
                <button v-if="startIndex > perPage" @click="previousPage()">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button v-if="(data.length - perPage) > 0" @click="nextPage()">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
</template>

<style scoped>
table {
    background: #fff;
    border-radius: 4px;
    width: 100%;
    box-shadow: none;
    border: none;
    overflow-x: auto;
}

table thead th {
    color: rgba(0, 0, 0, 0.54);
    font-weight: 100;
    text-transform: uppercase;
    font-size: 0.7rem;
    padding: 0.8rem 0.6rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    text-align: left;
}

table thead th svg {
    margin-left: .2rem;
    cursor: pointer;
}

table thead th svg:hover {
    color: rgba(0, 0, 0, 0.7);
}

table tbody td {
    font-size: 0.8rem;
    padding: 0.8rem 0.6rem;
    color: rgba(0, 0, 0, 0.61);
}

table tfoot td {
    font-size: 0.8rem;
    padding: 0.8rem 0.6rem;
    color: rgba(0, 0, 0, 0.61);
    text-align: right;
    border-top: 1px solid rgba(0, 0, 0, 0.12);
}

table tfoot td>>>select {
    background-color: transparent;
    width: auto;
    padding: 0;
    border: 0;
    border-radius: 0;
    height: auto;
    margin-left: .2rem;
    outline: 0;
}

table tfoot td>>>span {
    margin: 0 1rem;
}

table tfoot td>>>button {
    color: rgba(0, 0, 0, .54);
    padding: 4px 8px;
    cursor: pointer;
    border: none;
}

table tfoot td>>>button:focus {
    color: rgba(0, 0, 0, .9) !important;
    border: none;
    outline: none;
}

table tfoot td>>>button:hover {
    color: rgba(0, 0, 0, .7) !important;
}

table tbody>>>img {
    max-width: 36px;
    border-radius: 50%;
}

table tbody>>>a {
    color: #039be5 !important;
}

.table-card {
    box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.14), 0 1px 3px 0 rgba(0, 0, 0, 0.12);
    border: 1px solid rgba(0, 0, 0, 0.12);
    margin: 1rem 0;
}

.no-data {
    text-align: center;
}

.no-data svg {
    margin-right: .2rem;
    color: rgba(0, 0, 0, 0.61);
}
</style>

<script>
import {
    mapGetters
} from "vuex";
import dayjs from "dayjs";
import abbreviate from 'number-abbreviate';

export default {
    name: 'DataTable',
    props: {
        cssClasses: {
            type: String,
            default: null
        },
        columns: {
            required: true,
            type: Array
        },
        fetchMethod: {
            type: String
        },
        responseField: {
            type: String
        },
        endPoint: {
            type: String
        },
        nativeData: {
            type: Array
        }
    },
    filters: {
        headerColumn(text) {
            return text.split('_').join(' ').toUpperCase();
        }
    },
    computed: {
        ...mapGetters(["Token"]),

        parsedData() {
            if (this.data.length === 0)
                return [];

            let _data = this.data.slice(this.startIndex - 1, this.perPage);
            // TODO: fix pagination...
            let vm = this;
            let parsedData = [];
            _data.map(function (value, key) {
                let rowData = {
                    original: value
                };

                vm.columns.map(function (item, key) {
                    // Init sort
                    if (typeof vm.columns[key].sortable === "undefined")
                        vm.columns[key].sortable = true;

                    // Parse data
                    let val = value[item.field];
                    if (val !== "undefined") {
                        // DataTime format
                        if (typeof item.isDate === "boolean" && item.isDate) {
                            let date = dayjs(val).format(item.format !== "undefined" ? item.format : 'DD/MM/YYYY');

                            // if (date.isValid())
                            //     rowData[item.field] = date.toString();
                        }

                        // Callback
                        if (typeof item.callback === "function")
                            rowData[item.field] = item.callback.call(item, value);
                        // Currency symbol
                        else if (typeof item.currency === "string" && item.currency !== '')
                            rowData[item.field] = val.toFixed(2) + ' ' + item.currency;
                        // Format number to K
                        else if (typeof item.isNbr === "boolean" && item.isNbr)
                            rowData[item.field] = String(abbreviate(val)).toUpperCase();
                        else
                            rowData[item.field] = val;

                        // Ignore zero or empty
                        if ((val == null || val == 0) && typeof item.callback === "undefined")
                            rowData[item.field] = '-';
                    }
                });

                parsedData.push(rowData);
            });

            return parsedData;
        },
    },
    notifications: {
        // showError: {
        //     type: "error",
        //     title: "Error",
        //     message: "Something going wrong! Please try again.."
        // }
    },
    methods: {
        setupStream() {
            if (typeof this.endPoint === "undefined")
                return;

            // Init Event source
            this.es = new EventSource(this.endPoint);

            // Listen to data
            this.es.onmessage = function (event) {
                this.data = JSON.parse(event.data);
            };

            // Catch error
            this.es.addEventListener('error', event => {
                if (event.readyState == EventSource.CLOSED)
                    this.showError({
                        message: 'lost connection... giving up!'
                    });
            }, false);

            // Close
            this.es.addEventListener('close', event => {
                this.es.close();
            }, false);

            this.isLoading = false;
        },
        getColumnsCount() {
            return typeof this.$refs.headercolumns !== "undefined" ? this.$refs.headercolumns.childElementCount : this.columns.length;
        },
        sortBy(column, key) {
            if (this.sortColumn !== column.name)
                this.sortColumn = column.name;

            this.sortKey = key;
        },
        perPageOnChange(event) {
            this.perPage = event.target.value;
        },
        nextPage() {
            this.startIndex = this.startIndex + this.perPage;
        },
        previousPage() {
            this.startIndex = this.startIndex - this.perPage;
        },
        reloadData() {
            // Using native data
            if (typeof this.nativeData !== "undefined") {
                this.isLoading = false;

                return this.data = this.nativeData;
            }
            // Using Event source
            // if (typeof this.endPoint !== "undefined" && this.es === null)
            // return this.setupStream();

            // Using vuex
            if (typeof this.fetchMethod === "undefined")
                return;

            this.$store.dispatch(this.fetchMethod).then(response => {
                if (response.success)
                    this.data = (typeof this.responseField === "undefined") ? response.content : response.content[this.responseField];
                else
                    this.data = [];

                this.isLoading = false;
            }).catch(error => {
                console.log("DataTable Error: ");
                console.log(error);
                this.data = [];
                this.isLoading = false;
            });
        }
    },
    data() {
        return {
            isLoading: true,
            es: null,
            data: [],
            perPage: 10,
            rowPerPage: [10, 25, 50, 100, 'All'],
            startIndex: 1,
            endIndex: this.perPage,
            sortKey: 'asc',
            sortColumn: null
        }
    },
    created() {
        // Load data via vuex
        this.reloadData();
    },
    destroyed() {
        if (this.es !== null)
            this.es.close();
    }
}
</script>
