<template>
<div class="influencers">
    <div class="hero" v-if="!influencer">
        <div class="hero__intro">
            <h1>Influencers</h1>
            <ul class="breadcrumbs">
                <li>
                    <router-link :to="{name: 'dashboard'}">Dashboard</router-link>
                </li>
                <li>
                    <a href="#">Influencers</a>
                </li>
            </ul>
        </div>
        <div class="hero__actions">
            <button class="btn btn-success" @click="addInfluencer()">Add new influencer</button>
        </div>
    </div>
    <div class="p-1" v-if="!influencer">
        <header class="cards">
            <div class="card">
                <div class="number">{{ (influencers && influencers.length ) ? influencers.length : 0 }}</div>
                <p class="description">NUMBER OF INFLUENCERS</p>
            </div>
        </header>
        <div class="datatable-scroll">
            <DataTable ref="influencersDT" :columns="columns" fetchMethod="fetchInfluencers" cssClasses="table-card">
                <th slot="header">Actions</th>
                <td slot="body-row" slot-scope="row">
                    <router-link :to="{name : 'influencers', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Influencer details">
                        <i class="fas fa-eye"></i>
                    </router-link>
                    <button v-if="($can('delete', 'influencer') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))" :disabled="row.data.original.trackers_count > 0" class="btn icon-link" :title="row.data.original.trackers_count > 0 ? 'already associated with a tracker' : 'Delete influencer'" @click="deleteInfluencer(row.data.original)">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </DataTable>
        </div>
    </div>
    <InfluencerProfile v-if="influencer" :influencer="influencer" />
    <CreateInfluencerModal ref="influencerFormModal" @create="create" />
    <ConfirmationModal ref="confirmDeleteInfluencerModal" v-on:custom="deleteInfluencerAction" />
</div>
</template>

<script>
import InfluencerProfile from "../components/InfluencerProfile";
import CreateInfluencerModal from "../components/modals/CreateInfluencerModal";
import {
    mapGetters
} from "vuex";

export default {
    components: {
        InfluencerProfile,
        CreateInfluencerModal
    },
    data() {
        return {
            columns: [{
                    field: "pic_url",
                    callback: function (row) {
                        return '<img src="' + row.pic_url + '"/>';
                    },
                    sortable: false
                },
                {
                    name: "Full name",
                    field: "name",
                    callback: function (row) {
                        let $html = '';

                        if(row.platform === "instagram")
                            $html = '<a href="https://instagram.com/' + row.username + '" target="_blank">' + (row.name ? row.name : '@' + row.username) + '</a>';
                        else if(row.platform === "youtube")
                            $html = '<a href="https://www.youtube.com/channel/' + row.account_id + '" target="_blank">' + row.name + '</a>';
                    
                        return $html;
                    }
                },
                {
                    name: "Followers",
                    field: "followers",
                    isNbr: true
                },
                {
                    name: "Media",
                    field: "medias",
                    isNbr: true
                },
                {
                    name: "Platform",
                    field: "platform",
                    callback: function (row) {
                        let link = "";
                        let icon = "";

                        if (row.platform === "instagram") {
                            link = "https://instagram.com/";
                            icon = "<i class=\"fab fa-instagram\"></i>";
                        }else if(row.platform === "youtube"){
                            link = "https://youtube.com/";
                            icon = "<i class=\"fab fa-youtube\"></i>";
                        }

                        return '<a href="' + link + '" target="_blank" title="' + row.platform + '">' + icon + '</a>';
                    }
                },
                {
                    name: "Engagement rate",
                    field: "engagement_rate",
                    isNbr: true
                },
                {
                    name: "Analyzed",
                    field: "posts_count",
                    callback: function (row) {
                        return row.posts_count + ' of ' + row.medias;
                    }
                },
                {
                    name: "Last update",
                    field: "updated_at",
                    isDate: true,
                    format: "DD/MM/YYYY"
                }
            ]
        };
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.initData());
    },
    beforeRouteUpdate(to, from, next) {
        let routeUUID = to.params.uuid;
        if (typeof routeUUID !== 'undefined' && (this.influencer !== null && this.influencer.uuid !== routeUUID)) {
            this.$store.commit("setInfluencer", {
                influencer: null
            });
            this.fetchInfluencer();
        }

        next();
    },
    created() {
        this.initData();
    },
    watch: {
        '$route': 'initData'
    },
    methods: {
        addInfluencer(){
            this.$refs.influencerFormModal.open();
        },
        deleteInfluencer(influencer){
            this.$refs.confirmDeleteInfluencerModal.open("Are sure to delete this influencer?", influencer);
        },
        deleteInfluencerAction(influencer){
            if (typeof influencer.uuid === "undefined")
                this.showError();

            this.$store.dispatch("deleteInfluencer", influencer.uuid)
                .then(response => {
                    this.$refs.influencersDT.reloadData();
                    this.showSuccess({
                        message: "Successfully deleted influencer @" + influencer.username
                    });
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        create(influencer) {
            this.$store.dispatch("addInfluencer", influencer)
                .then(response => {
                    this.$refs.influencerFormModal.close();
                    this.showSuccess({
                        message: response.message
                    });
                }).catch(error => {
                    let errors = Object.values(error.response.data.errors);
                    if(typeof errors === "object" && errors.length > 0){
                        errors.forEach(element => {
                            this.showError({
                                message: element
                            });
                        });
                    }else{
                        this.showError({
                            message: error.response.data.message
                        });
                    }
                });
        },
        fetchInfluencer() {
            // Load user by UUID
            if (typeof this.$route.params.uuid !== 'undefined')
                this.$store.dispatch("fetchInfluencer", this.$route.params.uuid);
            else
                this.$store.commit("setInfluencer", {
                    influencer: null
                });
        },
        initData(){
            this.fetchInfluencer();
        }
    },
    computed: {
        ...mapGetters(["AuthenticatedUser", "influencers", "influencer"])
    },
    notifications: {
        showError: {
            type: "error",
            title: "Error",
            message: "Something going wrong! Please try again.."
        },
        showSuccess: {
            type: "success",
        }
    }
};
</script>
