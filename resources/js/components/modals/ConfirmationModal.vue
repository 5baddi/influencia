<template>
   <div class="modal" v-if="show">
      <div class="modal-content">
         <header>
            <h4 class="heading">{{ title }}</h4>
         </header>
         <div class="modal-form">
            <div class="modal-form__actions">
                <!-- <button class="btn btn-success" @click.prevent="submit" type="submit">{{ brand.id ? "Update" : "Create" }}</button> -->
                <!-- <button class="btn btn-danger" @click.prevent="dismiss" type="button">Cancel</button> -->
            </div>
         </div>
      </div>
   </div>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            default: "Are you sure?"
        }
    },
    methods: {
        closeModal(){
            this.show = false;
        },
        openModal(){
            this.show = true;
        }
    },
    data(){
        return {
            show: false
        }
    }
}
</script>