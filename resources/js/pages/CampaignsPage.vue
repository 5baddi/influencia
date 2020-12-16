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
                <div class="number">{{ campaignsStatistics.campaigns_count | formatedNbr }}</div>
                <p class="description">NUMBER OF CAMPAIGNS</p>
            </div>
            <div class="card">
                <div class="number">{{ campaignsStatistics.trackers_count | formatedNbr }}</div>
                <p class="description">NUMBER OF TRACKERS</p>
            </div>
            <div class="card">
                <div class="number">{{ campaignsStatistics.impressions | formatedNbr }}</div>
                <p class="description">TOTAL ESTIMATED IMPRESSIONS</p>
            </div>
            <div class="card">
                <div class="number">{{ campaignsStatistics.communities | formatedNbr }}</div>
                <p class="description">TOTAL SIZE OF ACTIVATED COMMUNITIES</p>
            </div>
        </header>
        <div class="datatable-scroll" v-if="$can('list', 'campaign') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)">
            <DataTable ref="campaignsDT" :columns="columns" fetchMethod="fetchCampaigns" cssClasses="table-card">
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
                    field: "all_trackers_count"
                },
                {
                    name: "Influencers",
                    field: "influencers",
                    class: "avatars-list",
                    callback: function (row) {
                        if (row.influencers.length === 0)
                            return '-';

                        let html = '';
                        row.influencers.map(function (item, index) {
                            html += '<a href="/influencers/' + item.uuid + '" class="avatars-list" title="View influencer profile"><img src="' + item.pic_url + '"/>';
                        });

                        return html;
                    }
                },
                {
                    name: "Last update",
                    field: "last_update",
                }
            ]
        };
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.initData());
    },
    beforeRouteUpdate(to, from, next) {
        let routeUUID = to.params.uuid;
        if (typeof routeUUID !== 'undefined' && (this.campaign !== null && this.campaign.uuid !== routeUUID)) {
            this.$store.commit("setCampaign", {
                campaign: null
            });
            this.fetchCampaign();
        }

        next();
    },
    created() {
        this.initData();
    },
    watch: {
        $route: "initData"
    },
    filters: {
        formatedNbr: function(value){
            try{
                if(typeof value === "undefined" || value === 0 || value === null)
                return '---';

                return new Intl.NumberFormat('en-US').format(value.toFixed(2)).replace(/,/g, ' ');
            }catch(error){
                return '---';
            }
        }
    },
    methods: {
        initData() {
            this.$store.dispatch("fetchCampaignsStatistics").catch(error => {});
        },
        fetchCampaign() {
            // Load user by UUID
            if(typeof this.$route.params.uuid !== 'undefined'){
                this.$store.dispatch("fetchCampaignAnalytics", this.$route.params.uuid).catch(error => {});
            }else{
                this.$store.commit("setCampaign", {
                    campaign: null
                });
            }
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
            campaign.brand_id = this.$store.getters.activeBrand && this.$store.getters.activeBrand.id;

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
        ...mapGetters(["AuthenticatedUser", "activeBrand", "campaign", "campaignsStatistics"])
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
    }
};
</script>
