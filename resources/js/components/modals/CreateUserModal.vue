<template>
<div class="modal" :class="{'show-modal' : show}">
    <div class="modal-content">
        <header>
            <h4 class="heading">{{ title }}</h4>
        </header>
        <div class="modal-form">
            <input type="hidden" name="id" v-model="user.id" />
            <div class="control" v-show="!resetPassword">
                <input v-model="user.name" type="text" placeholder="User name" required />
            </div>
            <div class="control" v-show="!resetPassword">
                <input v-model="user.email" type="email" placeholder="Email" required />
            </div>
            <div class="control">
                <input v-model="user.password" type="text" placeholder="Password" required />
            </div>
            <div class="control" ref="userBrand" v-show="!resetPassword">
                <label for="brand">Brand</label>
                <select id="brand" v-model="user.brand_id">
                    <option value="-1" :selected="user.brand_id">Select a brand</option>
                    <option :value="item.id" :selected="user.brand_id" v-for="item in brands" :key="item.id">{{item.name}}</option>
                </select>
            </div>
            <div class="control" v-show="!resetPassword">
                <label for="role">Role</label>
                <select id="role" v-model="user.role">
                    <option value="-1" :selected="user.role">Select a role</option>
                    <option value="super" :selected="user.role">Super Admin</option>
                    <option :value="role.id" :selected="user.role" v-for="role in roles" :key="role.id">{{ role.name }}</option>
                </select>
            </div>
            <div class="modal-form__actions">
                <button class="btn btn-success" @click.prevent="submit()">{{ typeof user.id === "number" ? "Update" : "Create" }}</button>
                <button class="btn btn-danger" @click.prevent="close()">Cancel</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
export default {
    data() {
        return {
            show: false,
            user: {
                id: null,
                name: null,
                email: null,
                password: null,
                brand_id: -1,
                role: -1
            },
            resetPassword: false,
            title: "Add new user"
        };
    },
    created() {
        document.addEventListener("keydown", e => {
            if (e.key == "Escape" && this.show) {
                this.dismiss();
            }
        });

        // Load roles
        this.$store.dispatch("fetchRoles");
    },
    methods: {
        open(user, resetPassword) {
            if (typeof user !== "undefined")
                this.user = user;

            if (typeof user !== "undefined" && typeof user.id !== "undefined" && typeof resetPassword === "undefined")
                this.title = "Edit " + user.name.toUpperCase();

            if (typeof user !== "undefined" && typeof user.id !== "undefined" && typeof resetPassword !== "undefined") {
                this.title = "Reset password for " + user.name.toUpperCase();
                this.resetPassword = true;
            }

            // Ignore password
            this.user.password = null;

            // Set role
            if (typeof this.user.role_id === "number")
                this.user.role = this.user.role_id;
            else
                this.user.role = -1;

            if (this.is_superadmin)
                this.user.role = 'super';

            this.show = true;
        },
        close() {
            this.show = false;
            this.user = {
                id: null,
                name: null,
                email: null,
                password: null,
                brand_id: -1,
                role: -1
            };
            this.resetPassword = false;
        },
        submit() {
            let action = this.user.id !== null ? "update" : "create";

            this.$emit(this.resetPassword ? "custom" : action, this.user);
            this.close();
        }
    },
    computed: {
        ...mapGetters(["brands", "roles"])
    }
};
</script>

<style scoped>
.radio-group {
    display: flex;
    align-items: center;
    margin: 1.2rem 0;
}

.radio-group>label+label {
    margin-left: 0.5rem;
}

.radio-group label {
    display: flex;
    align-items: center;
}

.radio-group label span {
    margin-left: 0.3rem;
}

.radio-group span {
    font-weight: 100;
    font-size: 0.8rem;
}
</style>
