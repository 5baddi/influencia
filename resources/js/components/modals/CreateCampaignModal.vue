<template>
   <div class="modal" :class="{'show-modal' : show}">
      <div class="modal-content">
         <header>
            <h4 class="heading">{{ title }}</h4>
         </header>
         <div class="modal-form">
            <form>
               <div class="control">
                  <input type="hidden" :value="campaign.uuid" />
                  <input v-model="campaign.name" type="text" placeholder="Campaign name (e.g. #FashionWeek20)"/>
               </div>
               <div class="modal-form__actions">
                  <button class="btn btn-success" @click.prevent="submit()">{{ typeof campaign.uuid == "string" ? "Update" : "Create" }}</button>
                  <button class="btn btn-danger" @click.prevent="close()">Cancel</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
export default {
   data() {
      return {
         show: false,
            campaign: {
                uuid: null,
                name: null
            },
            title: "Add new campaign"
      };
   },
   created() {
      document.addEventListener("keydown", e => {
         if (e.key == "Escape" && this.show) {
            this.close();
         }
      });
   },
   methods: {
      open(campaign) {
         if (typeof campaign !== "undefined")
               this.campaign = campaign;

         if(typeof campaign !== "undefined" && typeof campaign.uuid == "string" && campaign.name !== null)
               this.title = "Update " + campaign.name.slice();

         this.show = true;
      },
      close() {
         this.show = false;

         this.campaign = {
               uuid: null,
               name: null
         };

         this.title = "Add new campaign";
      },
      submit(){
         let action = (typeof this.campaign.uuid === "undefined" || this.campaign.uuid === null) ? "create" : "update";

            // Set base campaign info
            let formData = {};
            formData.name = this.campaign.name;
            if(this.campaign.uuid !== null)
                formData.uuid = this.campaign.uuid;

            this.$emit(action, formData);

            this.close();
      }
   }
};
</script>

