<template>
   <div class="modal" :class="{'show-modal': show}">
      <div class="modal-content">
        <h4 class="heading">{{ title }}</h4>
        <div class="modal-form">
            <button class="btn btn-success" @click.prevent="confirm" type="submit">Yes</button>
            <button class="btn btn-danger" @click.prevent="close" type="button">Cancel</button>
        </div>
      </div>
   </div>
</template>
<style scoped>
    .modal .modal-content{
        padding: 1rem !important;
    }
    .modal .heading{
        border-bottom: none !important;
    }
    .modal .modal-form{
        float: right;
    }
    .modal .modal-form button{
        display: inline;
        font-size: 0.6rem !important;
    }
</style>
<script>
export default {
    props: {
        
    },
    methods: {
        close(){
            this.show = false;
            this.title = null;
        },
        open(title){
            this.show = true;
            this.title = title;
        },
        confirm(){
            this.close();

            // Emit on change method
            this.$emit("action", this.files);
        }
    },
    data(){
        return {
            show: false,
            title: null
        }
    }
}
</script>