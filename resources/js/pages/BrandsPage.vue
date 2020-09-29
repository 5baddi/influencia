<template>
   <div class="brands" v-if="!isLoading">
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
            <button class="btn btn-success" @click="showAddBrandModal = !showAddBrandModal">Add new Brand</button>
         </div>
      </div>
      <div class="p-1">
         <header class="cards">
            <div class="card">
               <div class="number">{{ brands.length ? brands.length : 0 }}</div>
               <p class="description">NUMBER OF BRANDS</p>
            </div>
         </header>
         <div class="datatable-scroll">
            <table class="table campagins-table">
               <thead>
                  <tr class="row">
                     <td>&nbsp;</td>
                     <td>Brand name</td>
                     <td>Number of users</td>
                     <td>Users</td>
                     <td>Number of campaigns</td>
                     <td>Number of trackers</td>
                     <td>Created on</td>
                     <td>Actions</td>
                  </tr>
               </thead>
               <tbody>
                  <tr v-show="brands.length > 0" v-for="brand in brands" :key="brand.id">
                     <td>
                        <img :src="brand.logo" />
                     </td>
                     <td>
                        <p>{{ brand.name }}</p>
                     </td>
                     <td>
                        <p>{{ brand.users_count}}</p>
                     </td>
                     <td>
                        <ul v-if="brand.users">
                           <li v-for="user in brand.users" :key="user.id">
                              <span class="badge badge-success">{{ user.name }}</span>
                           </li>
                        </ul>
                        <p v-else>-</p>
                     </td>
                     <td>
                        <p>0</p>
                     </td>
                     <td>
                        <p>0</p>
                     </td>
                     <td>
                        <p>{{ moment(brand.created_at).format('DD/MM/YYYY') }}</p>
                     </td>
                     <td class="text-center">
                        <a href="javascript:void(0);" v-show="brand.id" class="icon-link" title="Edit" @click="showEditBrandModal(brand)"><i class="fas fa-pen"></i></a>
                        <a href="javascript:void(0);" class="icon-link" title="Delete"><i class="fas fa-trash"></i></a>
                     </td>
                  </tr>
                  <tr v-show="!brands || brands.length == 0">
                     <td colspan="7">
                        <p class="info">Looks like you don't have a brand record, start creating one.</p>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <CreateBrandModal :show="showAddBrandModal" :brand="brand" @create="create" @dismiss="dismissAddBrandModal" />
   </div>
</template>
<script>
import CreateBrandModal from "../components/modals/CreateBrandModal";
import { mapGetters } from "vuex";
import moment from "moment";
export default {
   components: {
      CreateBrandModal
   },
   data() {
      return {
         showAddBrandModal: false,
         brand: {},
         isLoading: true
      };
   },
   created() {
      if (!this.$store.getters.brands) {
         this.$store.dispatch("fetchBrands").then(response => {
            this.isLoading = false;
         });
         return;
      }
      this.isLoading = false;
   },
   methods: {
      moment() {
         return moment();
      },
      dismissAddBrandModal(id) {
         this.showAddBrandModal = false;
         this.brand = {};
      },
      create(payload) {
         let formData = new FormData();
         if(typeof payload.brand.id !== "undefined")
            formData.append("id", payload.brand.id);
            
         formData.append("logo", payload.brand.image);
         formData.append("name", payload.brand.name);
         this.$store.dispatch("addBrand", formData).then(() => {
            this.createBrandSuccess({ message: "Brand created successfully." });
         });
         this.dismissAddBrandModal();

         this.brand = {};
      },
      showEditBrandModal(brand){
         this.showAddBrandModal = true;
         this.brand = {...brand} ?? {};
      }
   },
   computed: {
      ...mapGetters(["brands"])
   },
   notifications: {
      createBrandErrors: {
         type: "error"
      },
      createBrandSuccess: {
         type: "success"
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