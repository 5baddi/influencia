<template>
    <div class="custom-file-upload">
        <ul v-show="isList">
            <li v-for="(file, index) in files" :key="file.name">{{ file.name.split('.').slice(0, -1).join('.') }}&nbsp;<button type="button" class="btn-flat btn-flat-danger" @click="removeFile(index)"><i class="fas fa-times"></i></button></li>
        </ul>
        <div v-show="isImage && files.length === 1" class="custom-file-preview">
            <button type="button" class="btn-flat btn-flat-danger" @click="removeImage"><i class="fas fa-times"></i></button>
            <img ref="img_src"/>
        </div>
        <button type="button" @click="preventFileInput()" class="btn btn-primary custom-file-input"><i :class="icon"></i>&nbsp;{{ label }}</button>
        <input :id="id" :ref="id" type="file" :accept="accept" @change="fileChanged" :multiple="multiple"/>
    </div>
</template>

<style scoped>
    .custom-file-upload{
        width: 100%;
        height: auto;
        overflow: hidden;
        margin: 1rem 0;
    }
    .custom-file-upload > input[type=file]{
        display: none;
    }
    .custom-file-upload .btn{
        width: 100%;
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
    .custom-file-preview button{
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(-50%, 50%);
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
        isList: {
            type: Boolean,
            default: false
        },
        isImage: {
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
            let existsIndex = this.files.findIndex(i => i.name === ref.files[0].name);
            if(existsIndex === -1){
                if(this.multiple){
                    let vm = this;
                    Array.from(ref.files).forEach(file => {
                        vm.files.push(file);
                    });
                }else{
                    this.files = [ref.files[0]];
                }

                // Is image
                if(this.isImage){
                    let vm = this;
                    let reader = new FileReader();
                    reader.onload = function(e){
                        vm.$refs.img_src.src = e.target.result;
                    }

                    reader.readAsDataURL(ref.files[0]);
                }
            }

            // Emit on change method
            this.$emit("custom", this.files);
        },
        removeFile(index){
            this.files.splice(index, 1);
        },
        removeImage(){
            this.files = [];
        }
    },
    data(){
        return {
            files: [],
            imgSrc: null
        }
    }
}
</script>