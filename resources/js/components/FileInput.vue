<template>
    <div class="custom-file-upload">
        <ul>
            <li v-for="(file, index) in files" :key="file.name">{{ file.name.split('.').slice(0, -1).join('.') }}&nbsp;<button class="btn-flat btn-flat-danger" @click="removeFile(index)"><i class="fas fa-times"></i></button></li>
        </ul>
        <button @click="preventFileInput()" class="btn btn-primary custom-file-input"><i :class="icon"></i>&nbsp;{{ label }}</button>
        <input :id="id" :ref="id" type="file" :accept="accept" @change="fileChanged" :multiple="multiple"/>
    </div>
</template>

<style scoped>
    .custom-file-upload > input[type=file]{
        display: none;
    }
    .custom-file-upload .btn{
        color: white;
        font-size: 8pt;
    }
    .custom-file-upload .btn-primary{
        background-color: #039be5;
    }
    .custom-file-upload .btn-flat{
        border: none;
        background-color: unset;
        cursor: pointer;
    }
    .custom-file-upload .btn-flat:hover, .custom-file-upload .btn-flat:focus{
        opacity: .7;
    }
    .custom-file-upload .btn-flat-danger{
        color: #f44336;
    }
    .custom-file-upload ul li{
        font-size: 10pt;
        font-weight: normal;
        padding: 12px;
    }
    .custom-file-upload .btn{
        display: initial !important;
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
        },
        fileChanged(){
            let ref = this.$refs[this.id];
            if(!ref.files[0])
                return;
            
            // Verify duplicate file then push the file
            let existsIndex = this.files.findIndex(i => i.name = ref.files[0].name);
            if(existsIndex === -1)
                this.files.push(ref.files[0]);
        },
        removeFile(index){
            this.files.splice(index, 1);
        }
    },
    data(){
        return {
            files: []
        }
    }
}
</script>