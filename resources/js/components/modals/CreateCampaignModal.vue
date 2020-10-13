<template>
   <div class="modal" :class="{'show-modal' : show}">
      <div class="modal-content">
         <header>
            <h4 class="heading">Add new campaign</h4>
         </header>
         <div class="modal-form">
            <form>
               <div class="control">
                  <input
                     v-model="name"
                     type="text"
                     placeholder="Campaign name (e.g. #FashionWeek20)"
                  />
               </div>
               <div class="modal-form__actions">
                  <button class="btn btn-success" @click.prevent="submit">Create</button>
                  <button class="btn btn-danger" @click.prevent="dismiss" type="button">Cancel</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
export default {
   props: {
      show: {
         default: false,
         type: Boolean
      }
   },
   data() {
      return {
         name: ""
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
      },
      submit() {
         this.$emit("create", {
            name: this.name
         });
      }
   }
};
</script>

