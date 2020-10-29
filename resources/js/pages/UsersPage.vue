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
            <button
               class="btn btn-success"
               @click="showAddUserModal = !showAddUserModal"
            >Add new user</button>
         </div>
      </div>
      <div class="p-1">
         <div class="datatable-scroll">
            <DataTable fetchMethod="fetchUsers" :columns="columns" cssClasses="table-card"/>
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
         columns: [
            {
               name: 'name',
               field: 'name'
            },{
               name: 'email',
               field: 'email'
            },{
               name: 'account type',
               field: 'is_superadmin',
               callback: function(row){
                  return row.is_superadmin ? 'Super Admin' : row.role.name.toUpperCase();
               }
            },
            {
               name: 'brands',
               field: 'brands',
               callback: function(row){
                  if(!row.brands)
                     return '-';
                  
                  let html = '<ul style="list-style: square;">';
                  row.brands.map(function(item, index){
                     html += '<li>' + item.name.toUpperCase() + '</li>';
                  });

                  return html += '</ul>';
               }
            },{
               name: 'last login',
               field: 'last_login',
               isDate: true,
               format: 'DD-MMMM-YYYY HH:mm'
            },{
               name: 'Joined at',
               field: 'created_at',
               isDate: true
            },
         ],
         showAddUserModal: false,
      };
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
