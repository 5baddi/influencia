<template>
<div class="modal" :class="{'show-modal' : show}">
    <div class="modal-content">
        <header>
            <h4 class="heading">{{ title }}</h4>
        </header>
        <div class="modal-form">
            <input type="hidden" :value="brand.uuid" />
            <div class="control">
                <input v-model="brand.name" type="text" placeholder="Brand name" />
            </div>
            <div class="control">
                <div style="width:100%;text-align:center;" v-show="brand.image === null && brand.public_logo">
                    <img :src="brand.public_logo" style="width:240px;height:auto;" />
                </div>
                <FileInput v-on:custom=" handleImageUpload" v-bind:id="'image'" v-bind:label="'Upload brand image'" v-bind:accept="'image/*'" v-bind:isImage="true" v-bind:icon="'fas fa-plus'" v-bind:multiple="false"></FileInput>
            </div>
            <div class="modal-form__actions">
                <button class="btn btn-success" @click.prevent="submit()">{{ typeof brand.uuid == "string" ? "Update" : "Create" }}</button>
                <button class="btn btn-danger" @click.prevent="close()">Cancel</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import FileInput from '../FileInput';

export default {
    components: {
        FileInput
    },
    data() {
        return {
            show: false,
            brand: {
                uuid: null,
                name: null,
                image: null
            },
            title: "Add new brand"
        }
    },
    created() {
        document.addEventListener("keydown", e => {
            if (e.key == "Escape" && this.show) {
                this.close();
            }
        });
    },
    methods: {
        handleImageUpload(files) {
            if (typeof files[0] === "undefined")
                return;

            this.brand.image = files[0];
        },
        open(brand) {
            if (typeof brand !== "undefined")
                this.brand = brand;

            if(typeof brand !== "undefined" && typeof brand.uuid == "string" && brand.name !== null)
                this.title = "Update " + brand.name.slice();

            this.show = true;
        },
        close() {
            this.show = false;

            this.brand = {
                uuid: null,
                name: null,
                image: null
            };

            this.title = "Add new brand";
        },
        submit() {
            let action = (typeof this.brand.uuid === "undefined" || this.brand.uuid === null) ? "create" : "update";

            // Set base brand info
            let formData = new FormData();
            formData.append("name", this.brand.name);
            if(typeof this.brand.image !== "undefined")
                formData.append("logo", this.brand.image);
            if(this.brand.uuid !== null)
                formData.append("uuid", this.brand.uuid);

            this.$emit(action, formData);

            this.close();
        }
    }
};
</script>
