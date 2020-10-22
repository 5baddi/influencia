<template>
    <table :class="cssClasses">
        <thead ref="headercolumns">
                <th v-for="(column, index) in columns" :key="index">{{ (column.name ? column.name : " ") | headerColumn }}</th>
                <slot name="header"></slot>
        </thead>
        <tbody>
            <tr v-if="parsedData.length === 0 && !isLoading">
                <td class="no-data" :colspan="getColumnsCount()"><i class="fas fa-exclamation-triangle"></i>&nbsp;No data found.</td>
            </tr>
            <tr v-if="isLoading">
                <!-- <i class="fas fa-spinner fa-spin"></i>&nbsp; -->
                <td class="no-data" :colspan="columns.length">Loading...</td>
            </tr>
            <tr v-show="parsedData.length > 0 && !isLoading" v-for="(obj, index) in parsedData" :key="index">
                <td v-for="(col, idx) in columns" :key="idx">
                    <div v-if="typeof obj[col.field] !== 'undefined'" v-html="obj[col.field]"></div>
                </td>
                <slot name="body-row" :data="obj"></slot>
            </tr>
        </tbody>
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
    table tbody td{
        font-size: 0.8rem;
        padding: 0.8rem 0.6rem;
        color: rgba(0, 0, 0, 0.61);
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
            vm.data.map(function(value, key){
                let rowData = value;

                vm.columns.map(function(item, key){
                    let val = value[item.field];
                    if(val !== "undefined"){
                        if(typeof item.callback === "function")
                            rowData[item.field] = item.callback.call(item, value);
                        else
                            rowData[item.field] = val;
                    }
                });

                parsedData.push(rowData);
            });

            return parsedData;
        }
    },
    methods: {
        getColumnsCount(){
            return typeof this.$refs.headercolumns.childElementCount !== "undefined" ? this.$refs.headercolumns.childElementCount : 1;
        }
    },
    data(){
        return {
            isLoading: true,
            data: []
        }
    },
    created(){
        this.$store.dispatch(this.fetchMethod).then(response => {
            if(response.success)
                this.data = response.content;
            else
                this.data = [];

            this.isLoading = false;
        }).catch(error => {
            this.data = [];
            this.isLoading = false;
        });
    }
}
</script>