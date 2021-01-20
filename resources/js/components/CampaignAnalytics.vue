<template>
<div class="campaign" v-if="campaign">
    <ul v-show="fiveInfluencers.length > 0" class="influencers-avatars">
        <h4>influencers</h4>
        <li v-for="influencer in fiveInfluencers" :key="influencer.id">
            <router-link :to="{name : 'influencers', params: {uuid: influencer.uuid}}" class="icon-link" :title="influencer.username">
                <img :src="influencer.pic_url" loading="lazy" />
            </router-link>
        </li>
        <li v-if="campaign.influencers.length > 5">
            <a href="#" class="icon-link">
                <img src="@assets/img/more.png"/>
            </a>
        </li>
        <li>
            <span class="campaign-more-influencers">
                {{ campaign.influencers.length }} Influencers linked&nbsp;<router-link to="#byinfuencers" v-if="campaign.influencers.length > 5">See all</router-link>
            </span>
        </li>
        <div class="count-details">
            <span v-if="campaign.stories_count && campaign.stories_count > 0"><i class="far fa-clock"></i>&nbsp;{{ campaign.stories_count }}&nbsp;stories</span>
            <span v-if="campaign.videos_count && campaign.videos_count > 0"><i class="far fa-play-circle"></i>&nbsp;{{ campaign.videos_count }}&nbsp;videos</span>
            <span v-if="campaign.images_count && campaign.images_count > 0"><i class="far fa-images"></i>&nbsp;{{ campaign.images_count }}&nbsp;posts</span>
            <span v-if="campaign.links_count && campaign.links_count > 0"><i class="fas fa-link"></i>&nbsp;{{ campaign.links_count }}&nbsp;links</span>
        </div>
    </ul>
    <div class="cards statistics">
        <div class="card" v-if="campaign.communities > 0">
            <div class="title">
                <i class="fas fa-users egg-blue"></i>
                <div class="numbers">
                    <h4>{{ campaign.communities | formatedNbr }}</h4>
                    <span>Total size of activated communities</span>
                </div>
            </div>
            <canvas id="communities-chart"></canvas>
        </div>
        <div class="card" v-if="campaign.impressions > 0">
            <div class="title">
                <i class="fas fa-bullhorn purple"></i>
                <div class="numbers">
                    <h4>{{ campaign.impressions | formatedNbr }}</h4>
                    <span>Total estimated impressions</span>
                </div>
            </div>
            <canvas id="impressions-chart"></canvas>
            <!-- <span>Organic impressions {{ String(nbr().abbreviate(campaign.organic_impressions)).toUpperCase() }} ({{ campaign.impressions > 0 ? ((campaign.organic_impressions / campaign.impressions) * 100).toFixed(2) : 0  }}%)</span> -->
        </div>
        <div class="card" v-if="campaign.video_views > 0">
            <div class="title">
                <i class="far fa-eye green"></i>
                <div class="numbers">
                    <h4>{{ campaign.video_views | formatedNbr }}</h4>
                    <span>Total videos views</span>
                </div>
            </div>
            <canvas id="views-chart"></canvas>
            <span>Organic videos views {{ String(nbr().abbreviate(campaign.organic_video_views)).toUpperCase() }} ({{ campaign.video_views > 0 ? ((campaign.organic_video_views / campaign.video_views) * 100).toFixed(2) : 0  }}%)</span>
        </div>
        <div class="card" v-if="campaign.engagements > 0">
            <div class="title">
                <i class="fas fa-thumbs-up blue"></i>
                <div class="numbers">
                    <h4>{{ campaign.engagements | formatedNbr }}</h4>
                    <span>Total engagements</span>
                </div>
            </div>
            <canvas id="engagements-chart"></canvas>
            <span>Organic engagements {{ String(nbr().abbreviate(campaign.organic_engagements)).toUpperCase() }} ({{ campaign.engagements > 0 ? ((campaign.organic_engagements / campaign.engagements) * 100).toFixed(2) : 0  }}%)</span>
        </div>
        <div class="card" v-if="campaign.posts_count > 0">
            <div class="title">
                <i class="fas fa-hashtag yellow"></i>
                <div class="numbers">
                    <h4>{{ campaign.posts_count | formatedNbr }}</h4>
                    <span>Total number of posts</span>
                </div>
            </div>
            <canvas id="posts-chart"></canvas>
            <!-- <span>Organic posts {{ String(nbr().abbreviate(campaign.organic_posts)).toUpperCase() }} ({{ campaign.posts_count > 0 ? ((campaign.organic_posts / campaign.posts_count) * 100).toFixed(2) : 0  }}%)</span> -->
        </div>
    </div>

    <div class="cards sentiments">
        <div class="card" v-if="campaign.comments_count > 0">
            <h5>Comments sentiment</h5>
            <canvas id="sentiments-chart"></canvas>
            <span>Based on {{ campaign.comments_count | formatedNbr }} comments</span>
        </div>
        <div class="card emojis" v-if="campaign.top_emojis">
            <h5>Top {{ campaign.top_emojis.top && Object.values(campaign.top_emojis.top).length > 1 ? Object.values(campaign.top_emojis.top).length + ' ' : '' }}used emoji</h5>
            <ul>
                <li v-for="(count, emoji) in campaign.top_emojis.top" :key="count">
                    {{ emoji }}
                    <span>{{ ((count / (campaign.top_emojis.all ? campaign.top_emojis.all : 1))*100).toFixed(2) }}%</span>
                </li>
            </ul>
            <span>Based on {{ campaign.top_emojis.all | formatedNbr }} emoji</span>
        </div>
    </div>

    <div class="datatable-scroll">
        <h4>Performance breakdown by Influencer</h4>
        <DataTable cssClasses="table-card" ref="byInfluencer" :columns="influencersColumns" :nativeData="campaign.influencers" :withPagination="false" :withTotalTab="true" :exportable="true" />
    </div>

    <div class="datatable-scroll" id="byinfluencers">
        <h4>Performance breakdown by post on Instagram</h4>
        <DataTable cssClasses="table-card" ref="byInstaPosts" :columns="instaPostsColumns" :nativeData="campaign.instagram_media" :withPagination="false" :withTotalTab="true"/>
    </div>

    <div class="datatable-scroll">
        <h4>List of trackers</h4>
        <DataTable cssClasses="table-card" ref="byTrackers" :columns="trackersColumns" :nativeData="campaign.trackers">
            <router-link slot="custom-buttons" class="btn btn-success" :disabled="!campaigns || typeof campaigns.length === 'undefined' || campaigns.length === 0" :to="{name: 'new_tracker'}">
                <i class="fas fa-plus"></i>&nbsp;Add new tracker    
            </router-link>
            <th slot="header">Actions</th>
            <td slot="body-row" slot-scope="row">
                <router-link v-if="$can('analytics', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)" v-show="row.data.original.queued === 'finished'" :to="{name : 'trackers', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Statistics">
                    <i class="far fa-chart-bar"></i>
                </router-link>
            </td>
        </DataTable>
    </div>

    <div class="posts-section" v-if="campaign && campaign.posts_count > 0">
        <h4>Posts</h4>
        <p>There are {{ campaign && campaign.posts_count ? campaign.posts_count : 0 }} posts for this campaign.</p>
        <div class="campaign-posts">
            <a @mouseover="attrActive=media.uuid" @mouseleave="attrActive=null" class="campaign-posts-card" v-for="media in campaign.media" :key="media.uuid" :href="media.link" target="_blank">
                <img :src="media.thumbnail_url" loading="lazy" />
                <div class="campaign-posts-card-icons">
                    <i v-if="media.platform === 'instagram'" class="fab fa-instagram"></i>
                    <i v-if="media.type === 'video' || media.type=== 'sidecar'" :class="'fas fa-' + (media.type === 'sidecar' ? 'images' : 'video')"></i>
                </div>
                <div :class="'campaign-posts-card-attr ' + (attrActive === media.uuid ? ' active' : '')">
                    <span v-if="media.video_views"><i class="fas fa-eye"></i>{{ String(nbr().abbreviate(media.video_views)).toUpperCase() }}</span>
                    <span v-if="media.likes"><i class="fas fa-heart"></i>{{ String(nbr().abbreviate(media.likes)).toUpperCase() }}</span>
                    <span v-if="media.comments"><i class="fas fa-comment"></i>{{ String(nbr().abbreviate(media.comments)).toUpperCase() }}</span>
                </div>
            </a>
        </div>
    </div>
</div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import abbreviate from 'number-abbreviate';
import Chart from 'chart.js';

export default {
    props: {
        campaign: {
            type: Object,
            default: () => ({

            })
        }
    },
    methods: {
        nbr() {
            return new abbreviate();
        },
        createDoughtnutChart(id, data) {
            const chartEl = document.getElementById(id);

            try{
                const chart = new Chart(chartEl, {
                    type: 'doughnut',
                    data: data
                });
            }catch(e){
                chartEl.style.display = "none !important";
            }
        }
    },
    computed: {
        ...mapGetters(["AuthenticatedUser", "campaigns"]),
        fiveInfluencers(){
            // Get five influencers
            if(this.campaign && typeof this.campaign.influencers !== 'undefined' && this.campaign.influencers.length > 0){
                return this.campaign.influencers.slice(0, 5);
            }

            return [];
        }
    },
    mounted(){
        // Comments sentiments
        if(this.campaign.sentiments_positive && this.campaign.sentiments_neutral && this.campaign.sentiments_negative){
            this.createDoughtnutChart('sentiments-chart', {
                datasets: [{
                    data: [
                        (this.campaign.sentiments_positive * 100).toFixed(2),
                        (this.campaign.sentiments_neutral * 100).toFixed(2),
                        (this.campaign.sentiments_negative * 100).toFixed(2)
                    ],
                    backgroundColor: [
                        "#AFD75C",
                        "#999999",
                        "#ED435A" //#d93176
                    ],
                }],
                labels: [
                    'Positive ' + (this.campaign.sentiments_positive * 100).toFixed(2),
                    'Neutral ' + (this.campaign.sentiments_neutral * 100).toFixed(2),
                    'Negative ' + (this.campaign.sentiments_negative * 100).toFixed(2),
                ]
            });
        }

        // Communities
        if (this.campaign.communities && this.campaign.communities > 0) {
            this.createDoughtnutChart('communities-chart', {
                datasets: [{
                    data: [this.campaign.communities.toFixed(2)],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Impressions
        if (this.campaign.impressions && this.campaign.impressions > 0) {
            this.createDoughtnutChart('impressions-chart', {
                datasets: [{
                    data: [this.campaign.impressions.toFixed(2)],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Videos views
        if (this.campaign.video_views && this.campaign.video_views > 0) {
            this.createDoughtnutChart('views-chart', {
                datasets: [{
                    data: [this.campaign.video_views],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Engagements
        if (this.campaign.engagements && this.campaign.engagements > 0) {
            this.createDoughtnutChart('engagements-chart', {
                datasets: [{
                    data: [this.campaign.engagements.toFixed(2)],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Posts
        if (this.campaign.posts_count && this.campaign.posts_count > 0) {
            let postsAndStoriesLabel = 'Instagram: ' + (this.campaign.posts_count ? this.campaign.posts_count : 0) + ' including ' + (this.campaign.stories_count ? this.campaign.stories_count : 0) + ' stories';
            this.createDoughtnutChart('posts-chart', {
                datasets: [{
                    data: [this.campaign.posts_count.toFixed(2)],
                    backgroundColor: ['#d93176']
                }],
                labels: [postsAndStoriesLabel]
            });
        }
    },
    data: () => ({
        influencersColumns: [{
            name: 'Influencer',
            field: 'id',
            callback: function (row) {
                return '<p style="display: inline-flex; align-items: center;margin:0"><img src="' + row.pic_url + '" style="margin-right:0.2rem"/>&nbsp;' + (row.name ? row.name : row.username) + '</p>';
            }
        },
        {
            name: 'Number of posts',
            field: 'campaign_media',
            isNbr: true,
            isRounded: true,
            hasTotal: true,
            hasAverage: true,
            hasMedian: true
        },
        {
            name: 'Size of activated communities',
            field: 'estimated_communities',
            isNativeNbr: true,
            isRounded: true,
            hasTotal: true,
            hasAverage: true,
            hasMedian: true
        }, 
        {
            name: 'Estimated impressions',
            field: 'campaign_impressions',
            isNativeNbr: true,
            isRounded: true,
            hasTotal: true,
            hasAverage: true,
            hasMedian: true
        }, 
        {
            name: 'Earned Media Value',
            field: 'earned_media_value',
            currency: '€',
            hasTotal: true,
            hasAverage: true,
            hasMedian: true
        }],
        instaPostsColumns: [{
                name: 'Influencer',
                field: 'influencer',
                callback: function (row) {
                    return '<p style="display: inline-flex; align-items: center;margin:0"><img style="margin-right:0.2rem" src="' + row.influencer.pic_url + '"/>&nbsp;' + (row.influencer.parsed_name ? row.influencer.parsed_name : row.influencer.username) + '</p>';
                }
            }, {
                name: 'Post',
                field: 'link',
                callback: function (row) {
                    if (!row.link || !row.caption)
                        return '<p>---</p>';

                    return '<a href="' + row.link + '" target="_blank">' + row.caption.substr(1, 100) + '...</a>';
                }
            }, {
                name: 'Media type',
                field: 'type',
                capitalize: true
            },
            {
                name: 'Size of activated communities',
                field: 'activated_communities',
                isNativeNbr: true,
                isRounded: true,
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            }, {
                name: 'Estimated impressions',
                field: 'estimated_impressions',
                isNativeNbr: true,
                isRounded: true,
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            },
            {
                name: 'Engagements',
                field: 'engagements',
                isNativeNbr: true,
                isRounded: true,
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            }, 
            {
                name: 'Organic impressions (declarative)',
                field: 'organic_impressions',
                isNativeNbr: true,
                isRounded: true,
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            },
            //  {
            //     name: 'Engagements rate (reach)',
            //     field: 'engagement_rate',
            //     callback: function (row) {
            //         return (row.influencer.engagement_rate && row.influencer.engagement_rate > 0) ? (row.influencer.engagement_rate * 100).toFixed(2) : '-';
            //     }
            // },
             {
                name: 'Likes',
                field: 'likes',
                isNativeNbr: true,
                isRounded: true,
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            }, {
                name: 'Views',
                field: 'video_views',
                isNativeNbr: true,
                isRounded: true,
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            }, {
                name: 'Comments',
                field: 'comments',
                isNativeNbr: true,
                isRounded: true,
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            }, {
                name: 'Impressions (first sequence)'
            }, {
                name: 'Story sequences'
            }, {
                name: 'Sequence impressions'
            },
            {
                name: 'Earned Media Value',
                field: 'earned_media_value',
                currency: '€',
                hasTotal: true,
                hasAverage: true,
                hasMedian: true
            },
            // {
            //     name: 'Tags',
            //     field: 'tags',
            //     callback: function(row){
            //         if(row.tags && row.tags.length > 0){
            //             let html = "<ul>";
            //             row.tags.map(function(item, index){
            //                 html += '<a href="https://www.instagram.com/explore/tags/' + item + '" tagert="_blank">' + item + '</a>&nbsp;&nbsp;';
            //             });

            //             return html + "</ul>";
            //         }

            //         return '-';
            //     }
            // },
            {
                name: 'Posted at',
                field: 'published_at'
            }
        ],
        trackersColumns: [
            {
                name: "name",
                field: "name",
                capitalize: true
            },
            {
                name: "Platform",
                field: "platform",
                callback: function (row) {
                    let link = "";
                    let icon = "";

                    if (row.platform === "instagram") {
                        link = "https://instagram.com/";
                        icon = "<i class=\"fab fa-instagram instagram-icon\"></i>";
                    }else if(row.platform === "youtube"){
                        link = "https://youtube.com/";
                        icon = "<i class=\"fab fa-youtube youtube-icon\"></i>";
                    }

                    return '<a href="' + link + '" target="_blank" title="' + row.platform + '" class="icon-link">' + icon + '</a>';
                }
            },
            {
                name: "type",
                field: "type",
                capitalize: true
            }, 
            {
                name: "Status",
                field: "status",
                sortable: false,
                callback: function (row) {
                    return '<span class="status status-' + (row.status ? 'success' : 'danger') + '" title="' + (row.status ? 'Enabled' : 'Disabled') + '">' + (row.queued.charAt(0).toUpperCase() + row.queued.slice(1)) + '</span>';
                }
            },
            {
                name: "Created at",
                field: "created_at",
                isTimeAgo: true
            },
        ],
        attrActive: null,
        sentimentData: {
            labels: [
                'Positive',
                'Neutral',
                'Negative',
            ],
            backgroundColor: [
                "#AFD75C",
                "#999999",
                "#ED435A"
            ],
        }
    })
}
</script>
