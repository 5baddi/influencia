<template>
    <div>
        <button @click="preventFileInput()" class="btn btn-primary custom-file-input"><i :class="icon"></i>&nbsp;{{ label }}</button>
        <input :id="id" :ref="id" type="file" :accept="accept"/>
    </div>
</template>

<style scoped>
    input[type=file]{
        display: none;
    }
</style>

<script>
export default {
    props: {
        id: {
            type: String,
            default: "Upload-file"
        },
        label: {
            type: String,
            default: "Upload file"
        },
        accept: {
            type: String,
            default: "*"
        },
        multiple: {
            type: Boolean,
            default: false
        },
        icon: {
            type: String,
            default: null
        }
    },
    methods: {
        preventFileInput(){
            let ref = this.$refs[this.id];
            if(ref !== 'undefined'){
                ref.click();
            }
        }
    }
}
</script>