<template>
    <table :class="cssClasses">
        <thead ref="headercolumns">
                <th v-for="(column, index) in columns" :key="index">
                    {{ (column.name ? column.name : " ") | headerColumn }}
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
                    <button v-if="(data.length - startIndex) > 0" @click="nextPage()">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</template>
<style scoped>
    table{
        background: #fff;
        border-radius: 4px;
        width: 100%;
        box-shadow: none;
        border: none;
        overflow-x: auto;
    }
    table thead th{
        color: rgba(0, 0, 0, 0.54);
        font-weight: 100;
        text-transform: uppercase;
        font-size: 0.7rem;
        padding: 0.8rem 0.6rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        text-align: left;
    }
    table thead th svg{
        margin-left: .2rem;
        cursor: pointer;
    }
    table thead th svg:hover{
        color: rgba(0, 0, 0, 0.7);
    }
    table tbody td{
        font-size: 0.8rem;
        padding: 0.8rem 0.6rem;
        color: rgba(0, 0, 0, 0.61);
    }
    table tfoot td{
        font-size: 0.8rem;
        padding: 0.8rem 0.6rem;
        color: rgba(0, 0, 0, 0.61);
        text-align: right;
        border-top: 1px solid rgba(0, 0, 0, 0.12);
    }
    table tfoot td >>> select{
        background-color: transparent;
        width: auto;
        padding: 0;
        border: 0;
        border-radius: 0;
        height: auto;
        margin-left: .2rem;
        outline: 0;
    }
    table tfoot td >>> span{
        margin: 0 1rem;
    }
    table tfoot td >>> button{
        color: rgba(0,0,0,.54);
        padding: 4px 8px;
        cursor: pointer;
        border: none;
    }
    table tfoot td >>> button:focus{
        color: rgba(0,0,0,.9) !important;
        border: none;
        outline: none;
    }
    table tfoot td >>> button:hover{
        color: rgba(0,0,0,.7) !important;
    }
    table tbody >>> img{
        max-width: 36px;
        border-radius: 50%;
    }
    table tbody >>> a{
        color: #039be5 !important;
    }
    .table-card{
        box-shadow: 0 2px 1px -1px rgba(0, 0, 0, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.14), 0 1px 3px 0 rgba(0, 0, 0, 0.12);
        border: 1px solid rgba(0, 0, 0, 0.12);
        margin: 1rem 0;
    }
    .no-data{
        text-align: center;
    }
    .no-data svg{
        margin-right: .2rem;
        color: rgba(0, 0, 0, 0.61);
    }
</style>
<script>
import moment from "moment";

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
            required: true,
            type: String
        },
        responseField: {
            type: String
        }
    },
    filters: {
        headerColumn(text){
            return text.split('_').join(' ').toUpperCase();
        }
    },
    computed: {
        parsedData(){
            if(this.data.length === 0)
                return [];

            let vm = this;
            let parsedData = [];
            let _data = vm.data.slice(vm.startIndex - 1, vm.perPage);
            // TODO: fix pagination...
            _data.map(function(value, key){
                let rowData = value;

                vm.columns.map(function(item, key){
                    // Init sort
                    if(typeof vm.columns[key].sortable === "undefined")
                        vm.columns[key].sortable = true;

                    // Parse data
                    let val = value[item.field];
                    if(val !== "undefined"){
                        if(typeof item.callback === "function")
                            rowData[item.field] = item.callback.call(item, value);
                        else if(typeof item.isDate !== "undefined")
                            rowData[item.field] = moment(val, (typeof item.format !== "undefined") ? item.format : "DD MM YYYY");
                        else
                            rowData[item.field] = val;
                    }
                });

                parsedData.push(rowData);
            });

            return parsedData;
        },
    },
    methods: {
        getColumnsCount(){
            return typeof this.$refs.headercolumns !== "undefined" ? this.$refs.headercolumns.childElementCount : 1;
        },
        sortBy(column, key){
            if(this.sortColumn !== column.name)
                this.sortColumn = column.name;

            this.sortKey = key;
        },
        perPageOnChange(event){
            this.perPage = event.target.value;
        },
        nextPage(){
            this.startIndex = this.startIndex + this.perPage;
        },
        previousPage(){
            this.startIndex = this.startIndex - this.perPage;
        },
        reloadData(){
            this.$store.dispatch(this.fetchMethod).then(response => {
                if(response.success)
                    this.data = (typeof this.responseField === "undefined") ? [...response.content] : [...response.content[this.responseField]];
                else
                    this.data = [];

                this.isLoading = false;
            }).catch(error => {
                this.data = [];
                this.isLoading = false;
            });
        }
    },
    data(){
        return {
            isLoading: true,
            data: [],
            perPage: 10,
            rowPerPage: [10, 25, 50, 100, 'All'],
            startIndex: 1,
            endIndex: this.perPage,
            sortKey: 'asc',
            sortColumn: null
        }
    },
    created(){
        this.reloadData();
    }
}
</script>