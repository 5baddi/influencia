<template>
   <div class="users" v-if="!isLoading">
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
            <button
               class="btn btn-success"
               @click="showAddUserModal = !showAddUserModal"
            >Add new user</button>
         </div>
      </div>
      <div class="p-1">
         <div class="datatable-scroll">
            <table class="table campagins-table">
               <thead>
                  <tr class="row">
                     <td>Name</td>
                     <td>Email</td>
                     <td>Account type</td>
                     <td>Brand</td>
                     <td>Last login</td>
                     <td>Created on</td>
                  </tr>
               </thead>
               <tbody>
                  <tr v-for="user in users" :key="user.id">
                     <td>
                        <p>{{ user.name }}</p>
                     </td>
                     <td>
                        <p>{{user.email}}</p>
                     </td>
                     <td>
                        <p>
                           <span class="badge badge-success">{{ user.role }}</span>
                        </p>
                     </td>
                     <td>
                        <p v-if="!user.brands">-</p>
                        <ul v-else>
                           <li v-for="brand in user.brands" :key="brand.id">
                              <span class="badge badge-info">{{ brand.name }}</span>
                           </li>
                        </ul>
                     </td>
                     <td>
                        <p
                           v-if="user.last_login"
                        >{{ moment(user.last_login).format('DD/MM/YYYY h:mm') }}</p>
                        <p v-else>-</p>
                     </td>
                     <td>
                        <p
                           v-if="user.created_at"
                        >{{ moment(user.created_at).format('DD/MM/YYYY h:mm') }}</p>
                        <p v-else>-</p>
                     </td>
                  </tr>
                  <tr v-show="!users">
                     <td colspan="6" class="text-center">No data!</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <CreateUserModal :show="showAddUserModal" @create="create" @dismiss="dismissAddUserModal" />
   </div>
</template>
<script>
import CreateUserModal from "../components/modals/CreateUserModal";
import { mapGetters } from "vuex";
import moment from "moment";
export default {
   components: {
      CreateUserModal
   },
   data() {
      return {
         showAddUserModal: false,
         isLoading: true
      };
   },
   created() {
      if (!this.$store.getters.users) {
         this.$store.dispatch("fetchUsers").then(() => (this.isLoading = false));
      }
      this.isLoading = false;
   },
   methods: {
      moment() {
         return moment();
      },
      dismissAddUserModal() {
         this.showAddUserModal = false;
      },
      create(payload) {
         this.$store
            .dispatch("addNewUser", payload)
            .then(response => {
               this.dismissAddUserModal();
               this.createUserSuccess({ message: `user ${response.data.name} created successfuly!` });
            })
            .catch(error => {
               this.createUserErrors({ title: "Error", message: `${error.response.data.message}` });
            });
      }
   },
   computed: {
      ...mapGetters(["users"])
   },
   notifications: {
      createUserErrors: {
         type: "error"
      },
      createUserSuccess: {
         type: "success"
      }
   }
};
</script>
