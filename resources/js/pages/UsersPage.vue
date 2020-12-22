<template>
<div class="users">
    <div class="hero">
        <div class="hero__intro">
            <h1>Users</h1>
            <ul class="breadcrumbs">
                <li>
                    <router-link :to="{ name : 'dashboard'}">Dashboard</router-link>
                </li>
                <li>
                    <a href="#">Users</a>
                </li>
            </ul>
        </div>
        <div class="hero__actions">
            <button class="btn btn-success" @click="addUser()">Add new user</button>
        </div>
    </div>
    <div class="p-1">
        <div class="datatable-scroll" v-if="$can('list', 'user') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <DataTable ref="usersDT" :nativeData="users" fetchMethod="fetchUsers" :columns="columns" cssClasses="table-card">
                <th slot="header">Actions</th>
                <td slot="body-row" slot-scope="row">
                    <button v-if="($can('edit', 'user') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)) && AuthenticatedUser.id !== row.data.original.id" class="btn icon-link" title="Reset user password" @click="resetUserPassword(row.data.original)">
                        <i class="fas fa-key"></i>
                    </button>
                    <button v-if="($can('edit', 'user') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)) && AuthenticatedUser.id !== row.data.original.id" class="btn icon-link" title="Edit user" @click="editUser(row.data.original)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button v-if="($can('ban', 'user') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)) && AuthenticatedUser.id !== row.data.original.id" class="btn icon-link" title="Ban user" @click="banUser(row.data.original)">
                        <svg v-show="row.data.original.banned" data-v-4b997e69="" class="svg-inline--fa fa-redo-alt fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="redo-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M256.455 8c66.269.119 126.437 26.233 170.859 68.685l35.715-35.715C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.75c-30.864-28.899-70.801-44.907-113.23-45.273-92.398-.798-170.283 73.977-169.484 169.442C88.764 348.009 162.184 424 256 424c41.127 0 79.997-14.678 110.629-41.556 4.743-4.161 11.906-3.908 16.368.553l39.662 39.662c4.872 4.872 4.631 12.815-.482 17.433C378.202 479.813 319.926 504 256 504 119.034 504 8.001 392.967 8 256.002 7.999 119.193 119.646 7.755 256.455 8z"></path>
                        </svg>
                        <svg v-show="!row.data.original.banned" data-v-4b997e69="" class="svg-inline--fa fa-ban fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ban" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor" d="M256 8C119.034 8 8 119.033 8 256s111.034 248 248 248 248-111.034 248-248S392.967 8 256 8zm130.108 117.892c65.448 65.448 70 165.481 20.677 235.637L150.47 105.216c70.204-49.356 170.226-44.735 235.638 20.676zM125.892 386.108c-65.448-65.448-70-165.481-20.677-235.637L361.53 406.784c-70.203 49.356-170.226 44.736-235.638-20.676z"></path>
                        </svg>
                    </button>
                    <button v-if="($can('delete', 'user') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)) && AuthenticatedUser.id !== row.data.original.id" class="btn icon-link" title="Delete user" @click="deleteUser(row.data.original)">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </DataTable>
        </div>
    </div>
    <CreateUserModal ref="userFormModal" @create="create" @update="update" v-on:custom="resetPassword" />
    <ConfirmationModal ref="confirmDeleteUserModal" v-on:custom="deleteUserAction" />
    <ConfirmationModal ref="confirmBanUserModal" v-on:custom="banUserAction" />
</div>
</template>

<script>
import CreateUserModal from "../components/modals/CreateUserModal";
import {
    mapGetters
} from "vuex";
export default {
    components: {
        CreateUserModal,
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
    },
    computed: {
        ...mapGetters(["users", "AuthenticatedUser"])
    },
    methods: {
        loadUsers(){
            this.$store.dispatch("fetchUsers").catch(error => {});
        },
        addUser() {
            this.$refs.userFormModal.open();
        },
        editUser(user) {
            this.$refs.userFormModal.open(Object.assign({}, user));
        },
        deleteUser(user) {
            this.$refs.confirmDeleteUserModal.open("Are sure to delete this user?", user);
        },
        banUser(user) {
            this.$refs.confirmBanUserModal.open("Are sure to " + (user.banned ? "unban" : "ban") + " this user?", user);
        },
        resetUserPassword(user) {
            this.$refs.userFormModal.open(user, true);
        },
        deleteUserAction(user) {
            if (typeof user.uuid === "undefined")
                this.showError();

            this.$store.dispatch("deleteUser", user.uuid)
                .then(response => {
                    this.$refs.usersDT.reloadData();
                    this.showSuccess({
                        message: "Successfully deleted user '" + user.name + "'"
                    });
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        banUserAction(user) {
            this.$store.dispatch("banUser", user.uuid)
                .then(response => {
                    this.$refs.usersDT.reloadData();
                    this.showSuccess({
                        message: response.message
                    });
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        create(user) {
            this.$store
                .dispatch("addNewUser", user)
                .then(response => {
                    if (response.success) {
                        this.$refs.usersDT.reloadData();
                        this.showSuccess({
                            message: `user ${response.content.name} created successfuly!`
                        });
                    } else {
                        throw new Error("Something going wrong!");
                    }
                })
                .catch(error => {
                    this.showError({
                        title: "Error",
                        message: `${error.response.data.message}`
                    });
                });
        },
        update(user) {
            this.$store.dispatch("editUser", user)
                .then(response => {
                    this.$refs.usersDT.reloadData();
                    this.showSuccess({
                        message: `user ${response.content.name} updated successfuly!`
                    });
                })
                .catch(error => {
                    this.showError({
                        title: "Error",
                        message: `${error.response.data.message}`
                    });
                });
        },
        resetPassword(user) {
            this.$store.dispatch("resetUser", user)
                .then(response => {
                    this.$refs.usersDT.reloadData();
                    this.showSuccess({
                        message: `Password for user ${response.content.name} reseted successfuly!`
                    });
                })
                .catch(error => {
                    this.showError({
                        title: "Error",
                        message: `${error.response.data.message}`
                    });
                });
        }
    },
    mounted(){
        // Load users
        if(Object.values(this.users).length === 0)
            this.loadUsers();
    },
    data() {
        return {
            columns: [{
                    name: 'name',
                    field: 'name'
                }, {
                    name: 'email',
                    field: 'email'
                }, {
                    name: 'account type',
                    field: 'is_superadmin',
                    callback: function (row) {
                        return row.is_superadmin && row.role == null ? 'Super Admin' : row.role.name.toUpperCase();
                    }
                },
                {
                    name: 'brands',
                    field: 'brands',
                    callback: function (row) {
                        if (!row.brands)
                            return '-';

                        let html = '';
                        row.brands.map(function (item, index) {
                            // html += '<li>' + item.name.toUpperCase() + '</li>';
                            html += '<span class="badge badge-success">' + item.name.toUpperCase() + '</span>';;
                        });

                        return html;
                    }
                }, {
                    name: 'last login',
                    field: 'last_login',
                    isDate: true,
                    format: 'DD-MMMM-YYYY HH:mm'
                }, {
                    name: 'Joined at',
                    field: 'created_at',
                    isDate: true
                },
            ],
            showAddUserModal: false,
        };
    }
};
</script>
