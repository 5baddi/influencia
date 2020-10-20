<template>
   <div class="modal" :class="{'show-modal': show}"> 
      <div class="modal-content">
         <header>
            <h4 class="heading">Update influencer</h4>
         </header>
         <div class="modal-form">
            <form>
               <div class="control">

               </div>
               <div class="modal-form__actions">
                  <button class="btn btn-success" @click.prevent="submit">Update</button>
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
      influencer: {
         default: (() => {}),
         type: Object
      }
   },
   data() {
      return {
          show: true
      };
   },
   created() {
       this.show = true;
       document.addEventListener("keydown", e => {
            if(e.key == "Escape" && this.show){
                this.dismiss();
            }
        });
   },
   methods: {
      dismiss(){
          this.show = false;
          this.$emit('dismissEditInfluencerModal');
      },
      submit() {
         this.$emit("update", {
            // name: this.name
         });
      }
   }
};
</script>