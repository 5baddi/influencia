<template>
<div class="campaign" v-if="campaign">
    <ul v-show="typeof campaign.influencers !== 'undefined' && campaign.influencers.length > 0" class="influencers-avatars">
        <h4>influencers</h4>
        <li v-for="influencer in campaign.influencers" :key="influencer.id">
            <router-link :to="{name : 'influencers', params: {uuid: influencer.uuid}}" class="icon-link" :title="influencer.username">
                <img :src="influencer.pic_url" loading="lazy" />
            </router-link>
        </li>
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
            <span>Organic communities {{ String(nbr().abbreviate(campaign.organic_communities)).toUpperCase() }} ({{ campaign.communities > 0 ? ((campaign.organic_communities / campaign.communities) * 100).toFixed(2) : 0  }}%)</span>
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
            <span>Organic impressions {{ String(nbr().abbreviate(campaign.organic_impressions)).toUpperCase() }} ({{ campaign.impressions > 0 ? ((campaign.organic_impressions / campaign.impressions) * 100).toFixed(2) : 0  }}%)</span>
        </div>
        <div class="card" v-if="campaign.views > 0">
            <div class="title">
                <i class="far fa-eye green"></i>
                <div class="numbers">
                    <h4>{{ campaign.views | formatedNbr }}</h4>
                    <span>Total videos views</span>
                </div>
            </div>
            <canvas id="views-chart"></canvas>
            <span>Organic videos views {{ String(nbr().abbreviate(campaign.organic_views)).toUpperCase() }} ({{ campaign.views > 0 ? ((campaign.organic_views / campaign.views) * 100).toFixed(2) : 0  }}%)</span>
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
            <span>Organic posts {{ String(nbr().abbreviate(campaign.organic_posts)).toUpperCase() }} ({{ campaign.posts_count > 0 ? ((campaign.organic_posts / campaign.posts_count) * 100).toFixed(2) : 0  }}%)</span>
        </div>
    </div>

    <div class="cards sentiments">
        <div class="card" v-if="campaign.comments_count > 0">
            <h5>Comments sentiment</h5>
            <canvas id="sentiments-chart"></canvas>
            <span>Based on {{ campaign.comments_count | formatedNbr }} comments</span>
        </div>
        <div class="card emojis" v-if="campaign.top_three_emojis">
            <h5>Top {{ campaign.top_three_emojis.top && Object.values(campaign.top_three_emojis.top).length > 1 ? Object.values(campaign.top_three_emojis.top).length + ' ' : '' }}emojis</h5>
            <ul>
                <li v-for="(emoji, index) in campaign.top_three_emojis.top" :key="index">
                    {{ emoji }}
                    <span>{{ ((index / (campaign.top_three_emojis.all ? campaign.top_three_emojis.all : 1))*100).toFixed(2) }}%</span>
                </li>
            </ul>
            <span>Based on {{ campaign.top_three_emojis.all | formatedNbr }} emojis</span>
        </div>
    </div>

    <div class="by-influencers">
        <h4>Performance breakdown by Influencer</h4>
        <DataTable ref="byInfluencer" :columns="influencersColumns" :nativeData="campaign.influencers" />
    </div>

    <div class="by-instagram-posts">
        <h4>Performance breakdown by post on Instagram</h4>
        <DataTable ref="byInstaPosts" :columns="instaPostsColumns" :nativeData="campaign.instagram_posts" />
    </div>

    <div class="by-influencers">
        <h4>List of trackers</h4>
        <DataTable ref="byTrackers" :columns="trackersColumns" :nativeData="campaign.trackers">
            <th slot="header">Actions</th>
            <td slot="body-row" slot-scope="row">
                <router-link v-if="$can('analytics', 'tracker') || (AuthenticatedUser && AuthenticatedUser.is_superadmin)" :to="{name : 'trackers', params: {uuid: row.data.original.uuid}}" class="icon-link" title="Statistics">
                    <i class="far fa-chart-bar"></i>
                </router-link>
            </td>
        </DataTable>
    </div>

    <div class="posts-section" v-if="campaign && campaign.posts_count > 0">
        <h4>Posts</h4>
        <p>There are {{ campaign && campaign.posts_count ? campaign.posts_count : 0 }} posts for this campaign.</p>
        <div class="campaign-posts">
            <a v-for="post in campaign.tracker_posts" :key="post.id" @mouseover="attrActive=post.id" @mouseleave="attrActive=null" class="campaign-posts-card" :href="post.link" target="_blank">
                <img :src="post.thumbnail_url" loading="lazy" />
                <div class="campaign-posts-card-icons">
                    <i class="fab fa-instagram"></i>
                    <i v-if="post.type === 'video' || post.type=== 'sidecar'" :class="'fas fa-' + (post.type === 'sidecar' ? 'images' : 'video')"></i>
                </div>
                <div :class="'campaign-posts-card-attr ' + (attrActive === post.id ? ' active' : '')">
                    <span v-if="post.video_views"><i class="fas fa-eye"></i>{{ String(nbr().abbreviate(post.video_views)).toUpperCase() }}</span>
                    <span v-if="post.likes"><i class="fas fa-heart"></i>{{ String(nbr().abbreviate(post.likes)).toUpperCase() }}</span>
                    <span v-if="post.comments"><i class="fas fa-comment"></i>{{ String(nbr().abbreviate(post.comments)).toUpperCase() }}</span>
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
    filters: {
        formatedNbr: function(value){
            if(value === 0 || value === null)
                return '---';

            return new Intl.NumberFormat('en-US').format(value.toFixed(2)).replace(/,/g, ' ');
        }
    },
    methods: {
        formatNbr(value)
        {
            if(value === 0 || value === null)
                return '---';

            return new Intl.NumberFormat('en-US').format(value.toFixed(2)).replace(/,/g, ' ');
        },
        nbr() {
            return new abbreviate();
        },
        createDoughtnutChart(id, data) {
            const chartEl = document.getElementById(id);
            const chart = new Chart(chartEl, {
                type: 'doughnut',
                data: data
            });
        }
    },
    computed: {
        ...mapGetters(["AuthenticatedUser"])
    },
    mounted() {
        // Comments sentiments
        if (typeof this.campaign.sentiments_positive === 'number' && typeof this.campaign.sentiments_neutral === 'number' && typeof this.campaign.sentiments_negative === 'number') {
            this.createDoughtnutChart('sentiments-chart', {
                datasets: [{
                    data: [
                        this.campaign.sentiments_positive.toFixed(2),
                        this.campaign.sentiments_neutral.toFixed(2),
                        this.campaign.sentiments_negative.toFixed(2)
                    ],
                    backgroundColor: [
                        "#AFD75C",
                        "#999999",
                        "#ED435A" //#d93176
                    ],
                }],
                labels: [
                    'Positive ' + this.campaign.sentiments_positive.toFixed(2),
                    'Neutral ' + this.campaign.sentiments_neutral.toFixed(2),
                    'Negative ' + this.campaign.sentiments_negative.toFixed(2),
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
        if (this.campaign.views && this.campaign.views > 0) {
            this.createDoughtnutChart('views-chart', {
                datasets: [{
                    data: [this.campaign.views],
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
                return '<p style="display: inline-flex; align-items: center;margin:0"><img src="' + row.pic_url + '"/>&nbsp;' + (row.name ? row.name : row.username) + '</p>';
            }
        }, {
            name: 'Number of posts',
            field: 'posts',
            isNbr: true
        }, {
            name: 'Size of activated communities',
            field: 'estimated_communities',
            isNbr: true
        }, {
            name: 'Estimated impressions',
            field: 'estimated_impressions',
            isNbr: true
        }, {
            name: 'Earned Media Value',
            field: 'earned_media_value',
            currency: '€'
        }],
        instaPostsColumns: [{
                name: 'Influencer',
                field: 'influencer_id',
                callback: function (row) {
                    return '<p style="display: inline-flex; align-items: center;margin:0"><img src="' + row.influencer.pic_url + '"/>&nbsp;' + (row.influencer.name ? row.influencer.name : row.influencer.username) + '</p>';
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
                isNbr: true
            }, {
                name: 'Estimated impressions',
                field: 'estimated_impressions',
                isNbr: true
            },
            {
                name: 'Engagements',
                field: 'engagements',
                isNbr: true
            }, {
                name: 'Organic impressions (declarative)',
                field: 'organic_impressions',
                isNbr: true
            }, {
                name: 'Engagements rate (reach)',
                field: 'engagement_rate',
                callback: function (row) {
                    return (row.influencer.engagement_rate && row.influencer.engagement_rate > 0) ? (row.influencer.engagement_rate * 100).toFixed(2) : '-';
                }
            }, {
                name: 'Likes',
                field: 'likes',
                isNbr: true
            }, {
                name: 'Views',
                field: 'video_views',
                isNbr: true
            }, {
                name: 'Comments',
                field: 'comments',
                isNbr: true
            }, {
                name: 'Impressions (first sequence)'
            }, {
                name: 'Story sequences'
            }, {
                name: 'Sequence impressions'
            }, {
                name: 'Posted at',
                field: 'published_at',
                isDate: true,
                format: 'DD/MM/YYYY'
            }, {
                name: 'Earned Media Value',
                field: 'earned_media_value',
                currency: '€'
            }
        ],
        trackersColumns: [{
            name: "type",
            field: "type",
            capitalize: true
        }, {
            name: "name",
            field: "name",
            capitalize: true
        }, {
            name: "status",
            field: "status",
            callback: function (row) {
                return row.status ? "Active" : "Inactive";
            }
        }, {
            name: "Created at",
            field: "created_at",
            isDate: true
        }, ],
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
