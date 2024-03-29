<template>
<div :class="cssClasses">
    <table>
        <thead>
            <tr>
                <th :colspan="getColumnsCount()" class="actions-header">
                    <input v-if="searchable" style="margin-right:0.3rem" type="text" @input="isTyping = true" v-model="searchQuery" :placeholder="'Search ' + (searchCols.length > 0 ? 'by ' + Object.values(searchCols).join(' or ') : '')"/>
                    <button class="btn icon-link" title="Reload all data" @click="reloadData()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button v-show="exportable" class="btn icon-link excel-btn" @click="exportToExcel()">
                        <i class="fas fa-file-excel"></i>&nbsp;Export to Excel
                    </button>
                    <slot name="custom-buttons"></slot>
                </th>
            </tr>
            <tr ref="headercolumns">
                <th v-for="(column, index) in formatedColumns" :key="index" :class="{'is-avatar': column.isAvatar}">
                    {{ (column.name ? column.name : " ") | headerColumn }}
                    <span v-if="column.sortable" @click="sort(column.field, index)">
                        <svg :class="{'is-sorting-column': isAsc && sortingColumn == column.id}" v-show="isAsc" data-v-4b997e69="" class="svg-inline--fa fa-sort-up fa-w-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M279 224H41c-21.4 0-32.1-25.9-17-41L143 64c9.4-9.4 24.6-9.4 33.9 0l119 119c15.2 15.1 4.5 41-16.9 41z"></path></svg>
                        <svg :class="{'is-sorting-column': !isAsc && sortingColumn == column.id}" v-show="!isAsc" data-v-4b997e69="" class="svg-inline--fa fa-sort-down fa-w-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z"></path></svg>
                    </span>
                </th>
                <slot name="header"></slot>
            </tr>
        </thead>
        <tbody>
            <tr v-if="formatedData.length === 0">
                <td class="no-data" :colspan="getColumnsCount()">
                    <span v-show="!loading"><i class="fas fa-exclamation-triangle"></i>&nbsp;No data found.</span>
                    <span v-show="loading"><i class="fas fa-spinner fa-spin"></i>&nbsp;Loading...</span>
                </td>
            </tr>
            <tr v-show="formatedData.length > 0 && !loading" v-for="(obj, index) in formatedData" :key="index">
                <td v-for="(col, idx) in formatedColumns" :key="idx" :class="{'is-avatar': col.isAvatar}">
                    <div v-if="typeof obj[col.field] !== 'undefined' && !col.isTimeAgo && !col.isImage && !col.isLink" :class="col.class" v-html="obj[col.field]"></div>
                    <timeago v-if="typeof obj[col.field] !== 'undefined' && col.isTimeAgo && !col.isImage && !col.isLink" :class="col.class" :datetime="Date.parse(obj[col.field])"></timeago>
                    <img v-if="typeof obj[col.field] !== 'undefined' && !col.isTimeAgo && col.isImage && !col.isLink" :class="col.class" :src="obj[col.field]" loading="lazy"/>
                    <router-link v-if="typeof obj[col.field] !== 'undefined' && !col.isTimeAgo && !col.isImage && col.isLink && obj[col.field].condition && obj[col.field].content" :v-show="obj[col.field].showIf" :to="obj[col.field].route" class="icon-link" :title="obj[col.field].title">
                        {{ obj[col.field].content }}
                    </router-link>
                </td>
                <slot name="body-row" :data="obj"></slot>
            </tr>
            <tr v-if="withTotalTab && formatedData.length > 0 && !loading">
                <td v-for="(col, idx) in formatedColumns" :key="idx">
                    <div v-if="typeof col.hasTotal === 'boolean' && col.hasTotal" v-html="formatData(col, calculateColumnSum(col.field))"></div>
                    <div v-if="idx === 0 && (typeof col.hasTotal !== 'boolean' || !col.hasTotal)" align="right" :colspan="colsSpan.total || 1">Total: </div>
                </td>
            </tr>
            <tr v-if="withTotalTab && formatedData.length > 0 && !loading">
                <td v-for="(col, idx) in formatedColumns" :key="idx">
                    <div v-if="typeof col.hasMedian === 'boolean' && col.hasMedian" v-html="formatData(col, calculateColumnMedian(col.field))"></div>
                    <div v-if="idx === 0 && (typeof col.hasMedian !== 'boolean' || !col.hasMedian)" align="right" :colspan="colsSpan.median || 1">Median: </div>
                </td>
            </tr>
            <tr v-if="withTotalTab && formatedData.length > 0 && !loading">
                <td v-for="(col, idx) in formatedColumns" :key="idx">
                    <div v-if="typeof col.hasAverage === 'boolean' && col.hasAverage" v-html="formatData(col, calculateColumnAverage(col.field))"></div>
                    <div v-if="idx === 0 && (typeof col.hasAverage !== 'boolean' || !col.hasAverage)" align="right" :colspan="colsSpan.average || 1">Average: </div>
                </td>
            </tr>
        </tbody>
        <tfoot v-if="data.length > 0 && !loading">
            <tr>
                <td :colspan="getColumnsCount()" v-if="withPagination">
                    Rows per page:
                    <select ref="itemsPerPage" @change="perPageOnChange($event)">
                        <option v-for="value in rowPerPage" :key="value" :value="(value !== 'All') ? value : data.length" :selected="perPage == value">{{ value }}</option>
                    </select>
                    <span>{{ startIndex }} - {{ formatedData.length }} of {{ data.length }}</span>
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
</div>
</template>

<style scoped>
ul {
    padding: 0 1rem;
    float: right;
}

ul li>>>a {
    color: white;
    font-size: 10pt;
    padding: .5rem 2rem;
    border-radius: 2px;
}

.btn-excel {
    background-color: #1D6F42;
    border: 1px solid #1D6F42;
}

table {
    background: #fff;
    border-radius: 4px;
    width: 100%;
    box-shadow: none;
    border: none;
    overflow-x: auto;
}

table thead>>>.actions-header{
    /* border-bottom: none; */
    text-align: right;
}
table thead>>>.actions-header .btn{
    display: initial;
    padding: .5rem;
    margin: unset;
    font-size: 8pt !important;
}
table thead>>>.actions-header input[type='text']{
    min-width: 300px;
    min-height: 32px;
    border: 1px solid #e0e0e0;
    padding: 0 0.6rem;
    border-radius: 4px;
    outline: none;
    transition: all 0.3s ease-in-out;
    font-size: 0.9rem;
    font-weight: 100;
    color: #212121;
}
table thead>>>.actions-header input[type='text']::placeholder{
    color: #e0e0e0;
}
table thead>>>.actions-header input[type='text']:active{
    border-color: #2d323e;
}
table thead>>>.actions-header input[type='text']:hover{
    border-color: #a9b0c1;
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
    min-width: 100px;
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
    max-height: 36px;
    border-radius: 50%;
}

table tbody>>>a {
    color: #039be5;
}

.table-card {
    box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.14), 0 1px 3px 0 rgba(0, 0, 0, 0.12);
    border: 1px solid rgba(0, 0, 0, 0.12);
    margin: 1rem 0;
    overflow-x: auto;
}

.no-data {
    text-align: center;
}

.no-data svg {
    margin-right: .2rem;
    color: rgba(0, 0, 0, 0.61);
}

.is-avatar{
    width: 36px !important;
    min-width: 36px !important;
}

.is-sorting-column{
    color: rgba(0, 0, 0, 0.9);
}
.excel-btn{
    background-color: #1D6F42 !important;
    color: white !important;
}
</style>

<script>
import {
    mapState
} from "vuex";
import dayjs from "dayjs";
import abbreviate from 'number-abbreviate';
import exportFromJSON from 'export-from-json';

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
        nativeData: {
            type: Array
        },
        fetchMethod: {
            type: String
        },
        responseField: {
            type: String
        },
        searchable: {
            type: Boolean,
            default: false
        },
        searchCols: {
            type: Array,
            default: () => {
                return [];
            }
        },
        withPagination: {
            type: Boolean,
            default: true
        },
        withTotalTab: {
            type: Boolean,
            default: false
        },
        defaultSorting: {
            type: String,
            default: "desc"
        },
        exportable: {
            type: Boolean,
            default: false
        },
        fileName: {
            type: String,
            default: "DataTable as Excel"
        },
        exportableFields: {
            type: Array,
            default: () => {
                return [];
            }
        }
    },
    filters: {
        headerColumn(text) {
            return text.split('_').join(' ').toUpperCase();
        }
    },
    watch: {
        nativeData: "loadData",
        searchQuery: function(){
            this.debounceSearchQuery();
        },
        isTyping: function(value){
            if(!value)
                this.search(this.searchQuery);
        }
    }, 
    computed: {
        ...mapState("Loader", ["loading"]),

        formatedColumns(){
            let vm = this;
            let columns = [];
            vm.columns.map(function(value, key){
                if(!vm.columns[key].field || typeof vm.columns[key].field === "undefined")
                    return;
                    
                // Init sort
                if (typeof vm.columns[key].sortable === "undefined")
                    vm.columns[key].sortable = true;

                // Handle custom css clasees
                if(typeof vm.columns[key].class !== "string")
                    vm.columns[key].class = '';

                // Set ID
                vm.columns[key].id = Math.random().toString(36).substr(2, 9);

                // Total cols span
                if(typeof value.hasTotal !== "boolean" || !value.hasTotal)
                    vm.colsSpan['total'] += 1;
                    
                // Average cols span
                if(typeof value.hasAverage !== "boolean" || !value.hasAverage)
                    vm.colsSpan['average'] += 1;
                    
                // Median cols span
                if(typeof value.hasMedian !== "boolean" || !value.hasMedian)
                    vm.colsSpan['median'] += 1;

                columns.push(vm.columns[key]);
            });

            return columns;
        },
        formatedData() {
            if (this.data.length === 0)
                return [];

            // Paginate data
            if(this.withPagination)
                this.paginateData();

            let vm = this;
            let _parsedData = [];
            this.data.map(function (value, key) {
                let rowData = {
                    original: value
                };

                vm.columns.map(function (item, key) {
                    // Parse data
                    let val = value[item.field];

                    // Callback
                    if (typeof item.callback === "function")
                        val = item.callback.call(item, value);
                        
                    if (typeof val !== "undefined" && val !== null) {
                        val = vm.formatData(item, val);

                        rowData[item.field] = val;
                    }else{
                        rowData[item.field] = "---";
                    }
                });

                _parsedData.push(rowData);
            });

            // Update parsed data
            this.parsedData = _parsedData;

            return this.parsedData;
        },
    },
    methods: {
        formatData(item, val){
            // Rounded number 
            if(typeof item.isRounded === "boolean" && item.isRounded)
                val = Math.round(val);
                
            // Currency symbol
            if (typeof item.currency === "string" && item.currency !== ''){
                val = val.toFixed(2);
                val = new Intl.NumberFormat('en-US').format(val).replace(/,/g, ' ') + ' ' + item.currency;
            }
            
            // Format number to K
            if (typeof item.isNbr === "boolean" && item.isNbr && (typeof item.isNativeNbr === "undefined" || !item.isNativeNbr))
                val = String(abbreviate(val)).toUpperCase();
            if(typeof item.isNativeNbr === "boolean" && item.isNativeNbr)
                val = new Intl.NumberFormat('en-US').format(val).replace(/,/g, ' ');

            // Percentage
            if(typeof item.isPercentage === "boolean" && item.isPercentage){
                val *= 100;
                val = val.toFixed(2);
                val = new Intl.NumberFormat('en-US').format(val).replace(/,/g, ' ') + '%';
            }

            // Capitalize string
            if (typeof val === "string" && typeof item.capitalize === "boolean" && item.capitalize)
                val = val.charAt(0).toUpperCase() + val.slice(1);

            // Re-format link
            if(typeof item.isLink === "boolean" && item.isLink){
                val = {
                    condition: typeof val.condition !== "undefined" ? val.condition : true,
                    showIf: typeof val.showIf !== "undefined" ? val.showIf : true,
                    content: typeof val.content !== "undefined" ? val.content : null,
                    route: typeof val.route !== "undefined" ? val.route : null,
                    title: typeof val.title !== "undefined" ? val.title : null,
                };
            }

            // Ignore zero or empty
            if (val == null || val == 0 || val == '')
                val = '-';

            return val;
        },
        calculateColumnSum(field){
            let total = 0;
            try{
                this.parsedData.map(function(value, index){
                    if(value !== '' && value !== '-' && value !== '---'){
                        let formatedValue = value[field].replace( /[^\d\.]*/g, '');
                        total += Number(formatedValue) || 0;
                    }
                });
            }catch(e){}

            return total;
        },
        calculateColumnAverage(field){
            let values = [];
            
            try{
                this.parsedData.map(function(value, index){
                    if(value !== '' && value !== '-' && value !== '---'){
                        let formatedValue = value[field].replace( /[^\d\.]*/g, '');
                        values.push(Number(formatedValue) || 0);
                    }
                });
            }catch(e){}

            return values.reduce((a, b) => a + b, 0) / values.length;
        },
        calculateColumnMedian(field){
            let values = [];
            
            try{
                this.parsedData.map(function(value, index){
                    if(value !== '' && value !== '-' && value !== '---'){
                        let formatedValue = value[field].replace( /[^\d\.]*/g, '');
                        values.push(Number(formatedValue) || 0);
                    }
                });
            }catch(e){}

            if(values.length ===0) return 0;

            values.sort(function(a,b){
                return a - b;
            });

            var half = Math.floor(values.length / 2);

            if (values.length % 2)
                return values[half];

            return (values[half - 1] + values[half]) / 2.0;
        },
        getColumnsCount() {
            return typeof this.$refs.headercolumns !== "undefined" ? this.$refs.headercolumns.childElementCount : this.columns.length;
        },
        search(val){
            // Ignore empty query
            if(this.searchQuery === "")
                return;

            // Remote search
            this.searchBy(val);
        },
        sort(col, index){
            // Ignore when no index set
            if(typeof index === "undefined")
                return;

            // Sort data
            this.data.sort(this.sortBy(col, this.isAsc));

            // Update column sort icon
            this.isAsc = !this.isAsc
            this.sortingColumn = col.id;
        },
        sortBy(field, isAsc) {
            return function(a, b){
                // Init 
                let result = 0;

                // Verify array has field property
                if(!a.hasOwnProperty(field) || !b.hasOwnProperty(field))
                    return result;

                // Parse data for each type
                let dataA = (typeof a[field] === "string") ? a[field].toUpperCase() : a[field];
                let dataB = (typeof b[field] === "string") ? b[field].toUpperCase() : b[field];

                // Compare
                if(dataA > dataB)
                    result = 1;
                else if(dataA < dataB)
                    result = -1;

                return result * (isAsc ? 1 : -1);
            };
        },
        perPageOnChange(event) {
            this.perPage = event.target.value;
        },
        nextPage() {
            this.startIndex = this.startIndex + this.perPage;

            // Paginate data
            this.paginateData();
        },
        previousPage() {
            this.startIndex = this.startIndex - this.perPage;

            // Paginate data
            this.paginateData();
        },
        paginateData(){
            // TODO: fix pagination
            this.data = _.slice(this.nativeData, this.startIndex - 1, this.perPage);
        },
        loadData(){
            // Set native data
            if (typeof this.nativeData !== "undefined")
                this.data = this.nativeData;
        },
        reloadData() {
            // Using vuex
            if (typeof this.fetchMethod === "undefined")
                return;

            this.$store.dispatch(this.fetchMethod).then(response => {
                if (response.success)
                    this.data = (typeof this.responseField === "undefined") ? response.content : response.content[this.responseField];
                else
                    this.data = [];
            }).catch(error => {
                console.log("DataTable Error: ");
                console.log(error);
                this.data = [];
            }).finally(() => {
                this.searchQuery = null;
            });
        },
        searchBy(query) {
            // Using vuex
            if (typeof this.fetchMethod === "undefined")
                return;

            this.$store.dispatch(this.fetchMethod + 'By', query).then(response => {
                if (response.success)
                    this.data = (typeof this.responseField === "undefined") ? response.content : response.content[this.responseField];
                else
                    this.data = [];
            }).catch(error => {
                console.log("DataTable search error: ");
                console.log(error);
                this.data = [];
            });
        },
        exportToExcel(){
            // Init
            let exportableData = [];
            let exportName = this.fileName;
            let exportType = 'xls';

            let vm = this;
            this.data.map(function(value, idx){
                let row = {};
                vm.exportableFields.map(function(field, index){
                    if(value.hasOwnProperty(field)){
                        let item = vm.columns.find((col) => col.field === field);
                        row[field] = vm.formatData((typeof item !== "undefined" && item !== null) ? item : {}, value[field]);
                    }
                });

                exportableData.push(row);
            });

            // Export 
            exportFromJSON({ data: exportableData, fileName: exportName, exportType: exportType });
        }
    },
    data() {
        return {
            data: [],
            parsedData: [],
            perPage: 10,
            rowPerPage: [10, 25, 50, 100, 'All'],
            startIndex: 1,
            endIndex: this.perPage,
            isAsc: String(this.defaultSorting).toLowerCase() === 'asc',
            sortingColumn: null,
            searchQuery: null,
            isTyping: false,
            debounceSearchQuery: null,
            colsSpan: {
                'total': 0,
                'median': 0,
                'avarage': 0
            }
        }
    },
    mounted(){        
        // Init Data
        if(typeof this.nativeData === "undefined" || this.nativeData === null || Object.values(this.nativeData).length > 0)
            this.loadData();
    },
    created() {
        // Init debounce instance
        this.debounceSearchQuery = _.debounce(function(){
            this.isTyping = false;
        }, 1000);
    }
}
</script>