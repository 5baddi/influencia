<template>
   <div class="modal" :class="{'show-modal' : show}">
      <div class="modal-content">
         <header>
            <h4 class="heading">{{ brand.id ? "Update " + brand.name : "Add new " }} brand</h4>
         </header>
         <div class="modal-form">
            <form>
               <!-- <input type="hidden" v-model="brand.id"/> -->
               <div class="control">
                  <input v-model="newName" type="text" placeholder="Brand name" />
               </div>
               <div class="control">
                  <input type="file" ref="image" @change="handleImageUpload" />
               </div>
               <div class="modal-form__actions">
                  <button class="btn btn-success" @click.prevent="submit" type="submit">{{ brand.id ? "Update" : "Create" }}</button>
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
      brand: {
         type: Object,
         default: () => ({
            id: {
               type: Number,
               default: null
            },
            name: {
               type: string,
               default: null
            },
            image: {
               type: object,
               default: () => ({})
            }
         })
      },
      show: {
         default: false,
         type: Boolean
      }
   },
   data(){
      return {
         newName: null,
         newImage: null,
      }
   },
   created() {
      document.addEventListener("keydown", e => {
         if (e.key == "Escape" && this.show) {
            this.dismiss();
         }
      });
   },
   methods: {
      handleImageUpload() {
         this.newImage = this.$refs.image.files[0];
      },
      dismiss() {
         this.$emit("dismiss");
      },
      submit() {
         this.$emit((this.brand.id !== null)  ? "update" : "create", {
            id: (this.brand.id !== null) ? this.brand.id : null,
            name: this.newName,
            image: this.newImage
         });
      }
   }
};
</script>

