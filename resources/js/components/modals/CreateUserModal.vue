<template>
   <div class="modal" :class="{'show-modal' : show}">
      <div class="modal-content">
         <header>
            <h4 class="heading">Add new user</h4>
         </header>
         <div class="modal-form">
            <form>
               <div class="control">
                  <input v-model="name" type="text" placeholder="User name" required />
               </div>
               <div class="control">
                  <input v-model="email" type="email" placeholder="email" required />
               </div>
               <div class="control">
                  <input v-model="password" type="text" placeholder="Password" required />
               </div>
               <div class="control">
                  <label for="brand">Brand</label>
                  <select id="brand" v-model="brand">
                     <option value selected disabled>select a brand</option>
                     <option
                        :value="brand.id"
                        v-for="brand in brands"
                        :key="brand.id"
                     >{{brand.name}}</option>
                  </select>
               </div>
               <div class="radio-group">
                  <label for="role_brand">
                     <input type="radio" id="role_brand" value="BRAND_OWNER" v-model="role" />
                     <span>Brand owner</span>
                  </label>
                  <label for="role_admin">
                     <input type="radio" id="role_admin" value="SUPER_ADMIN" v-model="role" />
                     <span>Super Admin</span>
                  </label>
               </div>
               <div class="modal-form__actions">
                  <button class="btn btn-success" @click.prevent="submit" type="button">Create</button>
                  <button class="btn btn-danger" @click.prevent="dismiss" type="button">Cancel</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
   props: {
      show: {
         default: false,
         type: Boolean
      }
   },
   data() {
      return {
         email: "",
         password: "",
         name: "",
         role: "BRAND_OWNER",
         brand: null
      };
   },
   created() {
      document.addEventListener("keydown", e => {
         if (e.key == "Escape" && this.show) {
            this.dismiss();
         }
      });
   },
   methods: {
      dismiss() {
         this.$emit("dismiss");
         return;
      },
      submit() {
         this.$emit("create", {
            name: this.name,
            password: this.password,
            email: this.email,
            brand_id: this.brand,
            role: this.role
         });
      }
   },
   computed: {
      ...mapGetters(["brands"])
   }
};
</script>

<style scoped>
.radio-group {
   display: flex;
   align-items: center;
   margin: 1.2rem 0;
}

.radio-group > label + label {
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