<template>
<div class="campaigns">
    <div class="hero">
        <div class="hero__intro">
            <h1>{{ (campaign && campaign.name) ? campaign.name.toUpperCase() : 'campaigns' }}</h1>
            <ul class="breadcrumbs">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Campaigns</a>
                </li>
            </ul>
        </div>
        <div class="hero__actions" v-if="($can('create', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)) && !campaign">
            <button :disabled="!activeBrand" class="btn btn-success" @click="addCampaign()">Add new campaign</button>
        </div>
    </div>
    <div class="p-1" v-if="!campaign">
        <header class="cards" v-if="$can('analytics', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <div class="card">
                <div class="number">{{ campaigns.length | formatedNbr }}</div>
                <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
        </header>
        <div class="datatable-scroll" v-if="$can('list', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <DataTable ref="campaignsDT" :columns="columns" :searchable="true" :searchCols="['name', 'influencer']" :nativeData="parsedCampaigns" fetchMethod="fetchCampaigns" cssClasses="table-card">
                <th slot="header">Actions</th>
                <td slot="body-row" slot-scope="row">
                    <router-link v-if="$can('analytics', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)" v-show="row.data.original.trackers_count > 0" :to="{name : 'campaigns', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Statistics">
                        <i class="far fa-chart-bar datatable-icon"></i>
                    </router-link>
                    <button v-if="($can('edit', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))" class="btn icon-link" title="Edit campaign" @click="editCampaign(row.data.original)">
                        <i class="fas fa-pen datatable-icon"></i>
                    </button>
                    <!-- <button class="btn icon-link" @click="disableCampaign(row)" title="Stop tracking" v-if="$can('start-stop-tracking', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
                     <i class="far fa-stop-circle datatable-icon"></i>
                  </button> -->
                    <button v-if="($can('delete', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin))" class="btn icon-link" title="Delete campaign" @click="deleteCampaign(row.data.original)">
                        <i class="far fa-trash-alt datatable-icon"></i>
                    </button>
                </td>
            </DataTable>
        </div>
    </div>
    <CreateCampaignModal ref="campaignFormModal" @create="create" @update="update"/>
    <CampaignAnalytics v-if="campaign" :campaign="campaign" />
    <ConfirmationModal ref="confirmDeleteCampaignModal" v-on:custom="deleteCampaignAction" />
</div>
</template>

<script>
import CreateCampaignModal from "../components/modals/CreateCampaignModal";
import CampaignAnalytics from "../components/CampaignAnalytics";
import {
    mapGetters
} from "vuex";
import DataTableVue from '../components/DataTable.vue';
export default {
    components: {
        CreateCampaignModal,
        CampaignAnalytics
    },
    notifications: {
        showError: {
            type: "error",
            title: "Error",
            message: "Something going wrong! Please try again.."
        },
        showSuccess: {
            type: "success",
        },
        createCampaignErrors: {
            type: "error"
        },
        createCampaignSuccess: {
            type: "success"
        }
    },
    methods: {
        loadCampaigns() {            
            // Load campaigns
            if(Object.values(this.campaigns).length === 0)
                this.$store.dispatch("fetchCampaigns").catch(error => {});
        },
        fetchCampaign() {
            // Load campaign analytics by UUID
            this.$store.dispatch("fetchCampaignAnalytics", this.$route.params.uuid).catch(error => {});
        },
        addCampaign() {
            this.$refs.campaignFormModal.open();
        },
        editCampaign(campaign) {
            this.$refs.campaignFormModal.open(Object.assign({}, campaign));
        },
        deleteCampaign(campaign) {
            this.$refs.confirmDeleteCampaignModal.open("Are sure to delete this campaign?", campaign);
        },
        deleteCampaignAction(campaign) {
            if (typeof campaign.uuid === "undefined")
                this.showError();

            this.$store.dispatch("deleteCampaign", campaign.uuid)
                .then(response => {
                    this.$refs.campaignsDT.reloadData();
                    this.showSuccess({
                        message: "Successfully deleted campaign '" + campaign.name + "'"
                    });
                }).catch(error => {
                    this.showError({
                        message: error.message
                    });
                });
        },
        create(campaign) {
            // Set brand ID
            campaign.brand_id = this.AuthenticatedUser.selected_brand;

            this.$store.dispatch("addNewCampaign", campaign)
                .then(response => {
                    this.$refs.campaignsDT.reloadData();
                    this.showSuccess({
                        message: response.message
                    });
                }).catch(error => {
                    this.showError({
                        message: error.response.data.message
                    })
                });
        },
        update(campaign) {
            this.$store.dispatch("updateCampaign", campaign)
                .then(response => {
                    this.$refs.campaignsDT.reloadData();
                    this.showSuccess({
                        message: response.message
                    });
                }).catch(error => {
                    this.showError({
                        message: error.response.data.message
                    })
                });
        }
    },
    computed: {
        ...mapGetters(["AuthenticatedUser", "campaigns", "campaign"]),
        parsedCampaigns(){
            return this.campaigns;
        },
        activeBrand(){
            if(this.AuthenticatedUser.selected_brand)
                return this.AuthenticatedUser.selected_brand;

            return null;
        }
    },
    watch: {
        "$route.params.uuid": function(value){
            // Load campaign analytics or unset campaign state
            if(typeof value !== "undefined")
                this.fetchCampaign();
            else
                this.$store.commit("setCampaign", {campaign: null});
        }
    },
    mounted(){
        // Load campaign analytics
        if(typeof this.$route.params.uuid !== "undefined"){
            this.fetchCampaign();
        }else{
            // Unset campaign state
            this.$store.commit("setCampaign", {campaign: null});

            // Load campaigns
            if(typeof this.campaigns === "undefined" || this.campaigns === null || Object.values(this.campaigns).length === 0)
                this.loadCampaigns();
        }
    },
    data() {
        return {
            columns: [
                {
                    name: "Campaign name",
                    field: "name"
                },
                {
                    name: "Status",
                    field: "status",
                    sortable: false,
                    callback: function (row) {
                        return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Running' : 'Paused') + '">' + (row.status ? 'Running' : 'Paused') + '</span>';
                    }
                },
                {
                    name: "Activated communities",
                    field: "communities",
                    isNbr: true
                },
                {
                    name: "Number of trackers",
                    field: "trackers_count",
                    isNbr: true
                },
                {
                    name: "Influencers",
                    field: "influencers",
                    class: "avatars-list",
                    sortable: false,
                    callback: function (row) {
                        if (row.influencers.length === 0)
                            return '-';

                        let html = '';
                        row.influencers.map(function (item, index) {
                            html += '<a href="/influencers/' + item.uuid + '" class="avatars-list" title="View ' + (item.name ? item.name : item.username) + ' profile"><img src="' + item.pic_url + '"/>';
                        });

                        return html;
                    }
                },
                {
                    name: "Last update",
                    field: "updated_at",
                    isTimeAgo: true
                }
            ]
        };
    }
};
</script>
