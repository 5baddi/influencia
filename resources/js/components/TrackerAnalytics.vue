<template>
<div class="campaign" v-if="tracker">
    <ul v-show="typeof tracker.influencers !== 'undefined' && tracker.influencers.length > 0" class="influencers-avatars">
        <h4>influencers</h4>
        <li v-for="influencer in tracker.influencers" :key="influencer.id">
            <router-link :to="{name : 'influencers', params: {uuid: influencer.uuid}}" class="icon-link" :title="influencer.username">
                <img :src="influencer.pic_url" loading="lazy" />
            </router-link>
        </li>
    </ul>
    <div class="cards statistics">
        <div class="card" v-if="tracker.communities > 0">
            <div class="title">
                <i class="fas fa-users egg-blue"></i>
                <div class="numbers">
                    <h4>{{ tracker.communities >= 0 ? tracker.communities.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                    <span>Total size of activated communities</span>
                </div>
            </div>
            <canvas id="communities-chart"></canvas>
            <span>Organic communities {{ nbr().abbreviate(tracker.organic_communities) }} ({{ tracker.communities > 0 ? ((tracker.organic_communities / tracker.communities) * 100).toFixed(2) : 0  }}%)</span>
        </div>
        <div class="card" v-if="tracker.impressions > 0">
            <div class="title">
                <i class="fas fa-bullhorn purple"></i>
                <div class="numbers">
                    <h4>{{ tracker.impressions >= 0 ? tracker.impressions.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                    <span>Total estimated impressions</span>
                </div>
            </div>
            <canvas id="impressions-chart"></canvas>
            <span>Organic impressions {{ nbr().abbreviate(tracker.organic_impressions) }} ({{ tracker.impressions > 0 ? ((tracker.organic_impressions / tracker.impressions) * 100).toFixed(2) : 0  }}%)</span>
        </div>
        <div class="card" v-if="tracker.views > 0">
            <div class="title">
                <i class="far fa-eye green"></i>
                <div class="numbers">
                    <h4>{{ tracker.views >= 0 ? tracker.views.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                    <span>Total videos views</span>
                </div>
            </div>
            <canvas id="views-chart"></canvas>
            <span>Organic videos views {{ nbr().abbreviate(tracker.organic_views) }} ({{ tracker.views > 0 ? ((tracker.organic_views / tracker.views) * 100).toFixed(2) : 0  }}%)</span>
        </div>
        <div class="card" v-if="tracker.engagements > 0">
            <div class="title">
                <i class="fas fa-thumbs-up blue"></i>
                <div class="numbers">
                    <h4>{{ tracker.engagements >= 0 ? tracker.engagements.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                    <span>Total engagements</span>
                </div>
            </div>
            <canvas id="engagements-chart"></canvas>
            <span>Organic engagements {{ nbr().abbreviate(tracker.organic_engagements) }} ({{ tracker.engagements > 0 ? ((tracker.organic_engagements / tracker.engagements) * 100).toFixed(2) : 0  }}%)</span>
        </div>
        <div class="card" v-if="tracker.posts_count > 0">
            <div class="title">
                <i class="fas fa-hashtag yellow"></i>
                <div class="numbers">
                    <h4>{{ tracker.posts_count >= 0 ? tracker.posts_count.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                    <span>Total number of posts</span>
                </div>
            </div>
            <canvas id="posts-chart"></canvas>
            <span>Organic posts {{ nbr().abbreviate(tracker.organic_posts) }} ({{ tracker.posts_count > 0 ? ((tracker.organic_posts / tracker.posts_count) * 100).toFixed(2) : 0  }}%)</span>
        </div>
    </div>

    <div class="cards sentiments">
        <div class="card" v-if="tracker.comments_count > 0">
            <h5>Comments sentiment</h5>
            <canvas id="sentiments-chart"></canvas>
            <span>Based on {{ tracker.comments_count }} comments</span>
        </div>
        <div class="card emojis" v-if="tracker.top_three_emojis">
            <h5>Top {{ tracker.top_three_emojis.top && Object.values(tracker.top_three_emojis.top).length > 1 ? Object.values(tracker.top_three_emojis.top).length + ' ' : '' }}emojis</h5>
            <ul>
                <li v-for="(emoji, index) in tracker.top_three_emojis.top" :key="index">
                    {{ emoji }}
                    <span>{{ ((index / (tracker.top_three_emojis.all ? tracker.top_three_emojis.all : 1))*100).toFixed(2) }}%</span>
                </li>
            </ul>
            <span>Based on {{ tracker.top_three_emojis.all }} emojis</span>
        </div>
    </div>

    <div class="by-influencers">
        <h4>Performance breakdown by Influencer</h4>
        <DataTable ref="byInfluencer" :columns="influencersColumns" :nativeData="tracker.influencers" />
    </div>

    <div class="by-instagram-posts" v-if="tracker.platform === 'instagram'">
        <h4>Performance breakdown by post on Instagram</h4>
        <DataTable ref="byInstaPosts" :columns="instaPostsColumns" :nativeData="tracker.posts" />
    </div>

    <div class="posts-section" v-if="tracker && tracker.posts_count > 0">
        <h4>Posts</h4>
        <p>There are {{ tracker && tracker.posts_count ? tracker.posts_count : 0 }} posts for this tracker.</p>
        <div class="campaign-posts">
            <a @mouseover="attrActive=post.id" @mouseleave="attrActive=null" class="campaign-posts-card" v-for="post in tracker.posts" :key="post.id" :href="post.link" target="_blank">
                <img :src="post.thumbnail_url" loading="lazy" />
                <div class="campaign-posts-card-icons">
                    <i v-if="tracker.platform === 'instagram'" class="fab fa-instagram"></i>
                    <i v-if="post.type === 'video' || post.type=== 'sidecar'" :class="'fas fa-' + (post.type === 'sidecar' ? 'images' : 'video')"></i>
                </div>
                <div :class="'campaign-posts-card-attr ' + (attrActive === post.id ? ' active' : '')">
                    <span v-if="post.video_views"><i class="fas fa-eye"></i>{{ nbr().abbreviate(post.video_views) }}</span>
                    <span v-if="post.likes"><i class="fas fa-heart"></i>{{ nbr().abbreviate(post.likes) }}</span>
                    <span v-if="post.comments"><i class="fas fa-comment"></i>{{ nbr().abbreviate(post.comments) }}</span>
                </div>
            </a>
        </div>
    </div>
</div>
</template>

<script>
import abbreviate from 'number-abbreviate';
import Chart from 'chart.js';

export default {
    props: {
        tracker: {
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
            const chart = new Chart(chartEl, {
                type: 'doughnut',
                data: data
            });
        }
    },
    mounted() {
        // Comments sentiments
        if (typeof this.tracker.sentiments_positive === 'number' && typeof this.tracker.sentiments_neutral === 'number' && typeof this.tracker.sentiments_negative === 'number') {
            this.createDoughtnutChart('sentiments-chart', {
                datasets: [{
                    data: [
                        this.tracker.sentiments_positive.toFixed(2),
                        this.tracker.sentiments_neutral.toFixed(2),
                        this.tracker.sentiments_negative.toFixed(2)
                    ],
                    backgroundColor: [
                        "#AFD75C",
                        "#999999",
                        "#ED435A" //#d93176
                    ],
                }],
                labels: [
                    'Positive ' + this.tracker.sentiments_positive.toFixed(2),
                    'Neutral ' + this.tracker.sentiments_neutral.toFixed(2),
                    'Negative ' + this.tracker.sentiments_negative.toFixed(2),
                ]
            });
        }

        // Communities
        if (this.tracker.communities && this.tracker.communities > 0) {
            this.createDoughtnutChart('communities-chart', {
                datasets: [{
                    data: [this.tracker.communities],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Impressions
        if (this.tracker.impressions && this.tracker.impressions > 0) {
            this.createDoughtnutChart('impressions-chart', {
                datasets: [{
                    data: [this.tracker.impressions],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Videos views
        if (this.tracker.views && this.tracker.views > 0) {
            this.createDoughtnutChart('views-chart', {
                datasets: [{
                    data: [this.tracker.views],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Engagements
        if (this.tracker.engagements && this.tracker.engagements > 0) {
            this.createDoughtnutChart('engagements-chart', {
                datasets: [{
                    data: [this.tracker.engagements],
                    backgroundColor: ['#d93176']
                }],
                labels: ['Instagram']
            });
        }

        // Posts
        if (this.tracker.posts_count && this.tracker.posts_count > 0) {
            let postsAndStoriesLabel = 'Instagram: ' + (this.tracker.posts_count ? this.tracker.posts_count : 0) + ' including ' + (this.tracker.stories_count ? this.tracker.stories_count : 0) + ' stories';
            this.createDoughtnutChart('posts-chart', {
                datasets: [{
                    data: [this.tracker.posts_count],
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
