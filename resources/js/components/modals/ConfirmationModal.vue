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