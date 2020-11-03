<template>
<div class="dashboard__navigation--item">
    <template v-if="!is_switch">
        <button class="btn" @click="showDropdown = !showDropdown">
            <slot name="button"></slot>
        </button>
        <div class="dropdown" v-if="showDropdown">
            <slot name="dropdown"></slot>
        </div>
    </template>
    <template v-else>
        <button class="btn" @click="showDropdown = !showDropdown" v-if="activeBrand">
            <div class="avatar">
                <img :src="activeBrand.public_logo" alt />
            </div>
            <div class="text">
                <p>{{ activeBrand.name }}</p>
                <div class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" color="#000629" class="sc-fzqAbL fPXfOL">
                        <g fill="none" fill-rule="evenodd">
                            <circle cx="12" cy="12" r="12" />
                            <path fill="#000" d="M12.492 12.283L7.306 7 5 9.35 12.492 17 20 9.35 17.677 7z" />
                        </g>
                    </svg>
                </div>
            </div>
        </button>
        <div class="dropdown" v-if="showDropdown">
            <ul v-if="brands && brands.length > 0">
                <li v-for="(brand, index) in brands" :key="brand.id">
                    <a @click.prevent="switchBrand(brand, index)">
                        <div class="icon">
                            <img :src="brand.public_logo" />
                        </div>
                        <div class="text">{{ brand.name }}</div>
                    </a>
                </li>
            </ul>
        </div>
    </template>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
export default {
    props: {
        is_switch: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            showDropdown: false
        };
    },
    created() {
        // if (this.is_switch)
        //     this.$store.dispatch("setActiveBrand");
    },
    computed: {
        ...mapGetters(["AuthenticatedUser", "brands", "activeBrand"])
    },
    methods: {
        switchBrand(brand, index) {
            this.$store.dispatch("setActiveBrand", brand).then(() => {
                this.$store.dispatch("fetchCampaigns");
                this.showDropdown = false;
            });
        },
        hideDropdown(e) {
            if (!e.target.closest(".dashboard__navigation--item")) {
                this.showDropdown = false;
            }
        }
    },
    watch: {
        showDropdown: function (newValue, oldValue) {
            if (newValue && this.showDropdown) {
                document.body.addEventListener("click", this.hideDropdown);
            }
            if (!newValue) {
                document.body.removeEventListener("click", this.hideDropdown);
            }
        }
    }
};
</script>
