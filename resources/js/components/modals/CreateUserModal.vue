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
                  <input v-model="email" type="email" placeholder="Email" required />
               </div>
               <div class="control">
                  <input v-model="password" type="text" placeholder="Password" required />
               </div>
               <div class="control">
                  <label for="brand">Brand</label>
                  <select id="brand" v-model="brand">
                     <option value="-1" :selected="brand">Select a brand</option>
                     <option :value="item.id" :selected="brand" v-for="item in brands" :key="item.id">{{item.name}}</option>
                  </select>
               </div>
               <div class="control">
                  <label for="role">Role</label>
                  <select id="role" v-model="role">
                     <option value="-1" :selected="role">Select a role</option>
                     <option value="super" :selected="role">Super Admin</option>
                     <option :value="role.id" :selected="role" v-for="role in roles" :key="role.id">{{ role.name }}</option>
                  </select>
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
         role: -1,
         brand: -1,
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