<template>
<div class="brands">
    <div class="hero">
        <div class="hero__intro">
            <h1>Brands</h1>
            <ul class="breadcrumbs">
                <li>
                    <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
                </li>
                <li>
                    <a href="#">Brands</a>
                </li>
            </ul>
        </div>
        <div class="hero__actions">
            <button class="btn btn-success" @click="addBrand()">Add new Brand</button>
        </div>
    </div>
    <div class="p-1">
        <header class="cards">
            <div class="card">
                <div class="number">{{ brands && typeof brands.length !== "undefined" ? brands.length : 0 }}</div>
                <p class="description">NUMBER OF BRANDS</p>
            </div>
        </header>
        <div class="datatable-scroll" v-if="$can('list', 'brand') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <DataTable ref="brandsDT" :nativeData="brands" fetchMethod="fetchBrands" :columns="columns" cssClasses="table-card">
                <th slot="header">Actions</th>
                <td slot="body-row" slot-scope="row">
                    <button v-if="($can('edit', 'brand') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))" class="btn icon-link" title="Edit brand" @click="editBrand(row.data.original)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button v-if="($can('delete', 'brand') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)) && row.data.original.campaigns_count === 0 && row.data.original.trackers_count === 0" class="btn icon-link" title="Delete brand" @click="deleteBrand(row.data.original)">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </DataTable>
        </div>
    </div>
    <CreateBrandModal ref="brandFormModal" @create="create" @update="update" />
    <ConfirmationModal ref="confirmDeleteBrandModal" v-on:custom="deleteBrandAction" />
</div>
</template>

<script>
import CreateBrandModal from "../components/modals/CreateBrandModal";
import {
    mapGetters
} from "vuex";
import moment from "moment";
export default {
    components: {
        CreateBrandModal
    },
    data() {
        return {
            columns: [{
                field: "pic_url",
                callback: function (row) {
                    return '<img src="' + row.public_logo + '"/>';
                },
                sortable: false
            }, {
                name: "name",
                field: "name"
            }, {
                name: "Number of users",
                field: "users_count",
                isNbr: true
            }, {
                name: 'users',
                field: 'users',
                callback: function (row) {
                    if (!row.users)
                        return '-';

                    let html = '';
                    row.users.map(function (item, index) {
                        // html += '<li>' + item.name.toUpperCase() + '</li>';
                        html += '<span class="badge badge-success">' + item.name.toUpperCase() + '</span>';
                    });

                    return html;
                }
            }, {
                name: "Number of campaigns",
                field: "campaigns_count",
                isNbr: true
            }, {
                name: "Number of trackers",
                field: "trackers_count",
                isNbr: true
            }, {
                name: "Created at",
                field: "created_at",
                isData: true,
                format: "DD/MM/YYYY"
            }]
        };
    },
    created() {
        this.$store.dispatch("fetchBrands").catch(error => {});
    },
    methods: {
        addBrand() {
            this.$refs.brandFormModal.open();
        },
        editBrand(brand) {
            this.$refs.brandFormModal.open(Object.assign({}, brand));
        },
        deleteBrand(brand) {
            this.$refs.confirmDeleteBrandModal.open("Are sure to delete this brand?", brand);
        },
        deleteBrandAction(brand) {
            if (typeof brand.uuid === "undefined")
                this.showError();

            this.$store.dispatch("deleteBrand", brand.uuid)
                .then(response => {
                    // Reload datatable
                    this.$refs.brandsDT.reloadData();
                    // Switch selected brand
                    this.$store.dispatch("setActiveBrand", this.activeBrand ?? null).catch(error => {});
                    // Show success notification
                    this.showSuccess({
                        message: "Successfully deleted brand '" + brand.name + "'"
                    });
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        create(brand) {
            this.$store.dispatch("addBrand", brand)
                .then(response => {
                    this.$refs.brandsDT.reloadData();
                    this.$refs.brandFormModal.close();
                    // Set new brand as active brand
                    if(response.content)
                        this.$store.dispatch("setActiveBrand", response.content);

                    this.showSuccess({
                        message: "Brand created successfully"
                    });
                }).catch(error => {
                    let errors = Object.values(error.response.data.errors);
                    if(typeof errors === "object" && errors.length > 0){
                        errors.forEach(element => {
                            this.showError({
                                message: element
                            });
                        });
                    }else{
                        this.showError({
                            message: error.response.data.message
                        });
                    }
                });
        },
        update(brand) {
            this.$store.dispatch("updateBrand", brand)
                .then(response => {
                    this.$refs.brandsDT.reloadData();
                    this.$refs.brandFormModal.close();
                    this.showSuccess({
                        message: response.message
                    });
                }).catch(error => {
                    let errors = Object.values(error.response.data.errors);
                    if(typeof errors === "object" && errors.length > 0){
                        errors.forEach(element => {
                            this.showError({
                                message: element
                            });
                        });
                    }else{
                        this.showError({
                            message: error.response.data.message
                        });
                    }
                });
        }
    },
    computed: {
        ...mapGetters(["brands", "AuthenticatedUser"])
    },
    notifications: {
        showError: {
            type: "error",
            title: "Error",
            message: "Something going wrong! Please try again.."
        },
        showSuccess: {
            type: "success",
        }
    }
};
</script>

<style scoped>
td img {
    max-width: 36px;
    border-radius: 50%;
}
</style>
