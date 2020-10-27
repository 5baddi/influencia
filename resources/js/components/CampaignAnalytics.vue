<template>
    <div class="p-1 campaign" v-if="campaign">
        <div class="cards statistics">
            <div class="card" v-if="campaign.data.communities >= 0">
                <div class="title">
                    <i class="fas fa-users egg-blue"></i>
                    <div class="numbers">
                        <h4>{{ campaign.data.communities >= 0 ? campaign.data.communities.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total size of activated communities</span>
                    </div>
                </div>
                <canvas id="communities-chart"></canvas>
                <span>Organic communities {{ nbr().abbreviate(campaign.data.organic_communities) }} ({{ campaign.data.communities > 0 ? ((campaign.data.organic_communities / campaign.data.communities) * 100).toFixed(2) : 0  }}%)</span>
            </div>
            <div class="card" v-if="campaign.data.impressions >= 0">
                <div class="title">
                    <i class="fas fa-bullhorn purple"></i>
                    <div class="numbers">
                        <h4>{{ campaign.data.impressions >= 0 ? campaign.data.impressions.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total estimated impressions</span>
                    </div>
                </div>
                <canvas id="impressions-chart"></canvas>
                <span>Organic impressions {{ nbr().abbreviate(campaign.data.organic_impressions) }} ({{ campaign.data.impressions > 0 ? ((campaign.data.organic_impressions / campaign.data.impressions) * 100).toFixed(2) : 0  }}%)</span>
            </div>
            <div class="card" v-if="campaign.data.views >= 0">
                <div class="title">
                    <i class="far fa-eye green"></i>
                    <div class="numbers">
                        <h4>{{ campaign.data.views >= 0 ? campaign.data.views.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total views</span>
                    </div>
                </div>
                <canvas id="views-chart"></canvas>
                <span>Organic views {{ nbr().abbreviate(campaign.data.organic_views) }} ({{ campaign.data.views > 0 ? ((campaign.data.organic_views / campaign.data.views) * 100).toFixed(2) : 0  }}%)</span>
            </div>
            <div class="card" v-if="campaign.data.engagements >= 0">
                <div class="title">
                    <i class="fas fa-thumbs-up blue"></i>
                    <div class="numbers">
                        <h4>{{ campaign.data.engagements >= 0 ? campaign.data.engagements.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total engagements</span>
                    </div>
                </div>
                <canvas id="engagements-chart"></canvas>
                <span>Organic engagements {{ nbr().abbreviate(campaign.data.organic_engagements) }} ({{ campaign.data.engagements > 0 ? ((campaign.data.organic_engagements / campaign.data.engagements) * 100).toFixed(2) : 0  }}%)</span>
            </div>
            <div class="card" v-if="campaign.data.posts_count >= 0">
                <div class="title">
                    <i class="fas fa-hashtag yellow"></i>
                    <div class="numbers">
                        <h4>{{ campaign.data.posts_count >= 0 ? campaign.data.posts_count.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total number of posts</span>
                    </div>
                </div>
                <canvas id="posts-chart"></canvas>
            </div>
        </div>

        <div class="cards sentiments">
            <div class="card">
                <h5>Comments sentiment</h5>
                <canvas id="sentiments-chart"></canvas>
            </div>
            <div class="card">
                <h5>Top emojis</h5>
                <ul>
                    <li v-for="(emoji, index) in campaign.data.top_three_emojis.top" :key="index">
                        {{ emoji }}
                        <span>{{ ((index / (campaign.data.top_three_emojis.all ? campaign.data.top_three_emojis.all : 1))*100).toFixed(2) }}%</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="by-influencers">
            <!-- <datatable :columns="columns" :data="rows"></datatable> -->
            <h4>Performance breakdown by Influencer</h4>
            <table class="table table-with-profile">
                <thead>
                    <tr class="row">
                        <th>Influencer</th>
                        <th>Number of posts</th>
                        <th>Size of activated communities</th>
                        <th>Estimated impressions</th>
                        <th>Earned Media Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-show="campaign.data.influencers.length > 0" v-for="influencer in campaign.data.influencers" :key="influencer.id">
                        <td>
                            <p style="display: inline-flex; align-items: center;"><img :src="influencer.pic_url"/>&nbsp;{{ influencer.name ? influencer.name : influencer.username }}</p>
                        </td>
                        <td>{{ influencer.posts }}</td>
                        <td>{{ influencer.estimated_communities }}</td>
                        <td>{{ influencer.estimated_impressions }}</td>
                        <td>--.-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="by-instagram-posts">
            <h4>Performance breakdown by post on Instagram</h4>
            <table class="table table-with-profile">
                <thead>
                    <tr class="row">
                        <th>Influencer</th>
                        <th width="20%">Post</th>
                        <th>Media type</th>
                        <th>Size of activated communities</th>
                        <th>Estimated impressions</th>
                        <th>Engagements</th>
                        <th>Organic impressions (declarative)</th>
                        <th>Engagements rate (reach)</th>
                        <th>Likes</th>
                        <th>Views</th>
                        <th>Comments</th>
                        <th>Impressions (first sequence)</th>
                        <th>Story sequences</th>
                        <th>Sequence impressions</th>
                        <th>Post date</th>
                        <th>Earne</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-show="campaign.data.instagram_posts.length > 0" v-for="post in campaign.data.instagram_posts" :key="post.id">
                        <td>
                            <p style="display: inline-flex; align-items: center;"><img :src="post.influencer.pic_url"/>&nbsp;{{ post.influencer.name ? post.influencer.name : post.influencer.username }}</p>
                        </td>
                        <td>
                            <a v-if="post.link && post.caption" :href="post.link" target="_blank">{{ post.caption.substr(1, 100) }}...</a>
                            <p v-else>---</p>
                        </td>
                        <td>
                            {{ post.type }}
                        </td>
                        <td>
                            {{ post.activated_communities }}
                        </td>
                        <td>
                            {{ post.estimated_impressions }}
                        </td>
                        <td>
                            {{ post.engagements }}
                        </td>
                        <td>
                            {{ post.organic_impressions ? post.organic_impressions : '-' }}
                        </td>
                        <td>
                            {{ (post.influencer.engagement_rate && post.influencer.engagement_rate > 0) ? (post.influencer.engagement_rate * 100).toFixed(2) : '-'}}
                        </td>
                        <td>{{ post.likes ? post.likes : '-' }}</td>
                        <td>{{ post.video_views ? post.video_views : '-' }}</td>
                        <td>{{ post.comments ? post.comments : '-' }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ post.published_at ? moment(post.published_at).format('DD/MM/YYYY') : '-' }}</td>
                        <td>{{ post.earned_media_value.toFixed(2) }} €</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="posts-section" v-if="campaign.data && campaign.data.posts_count > 0">
            <h4>Posts</h4>
            <p>There are {{ campaign.data && campaign.data.posts_count ? campaign.data.posts_count : 0 }} posts for this campaign.</p>
            <div class="campaign-posts" v-for="tracker in campaign.data.trackers" :key="tracker.id">
                <a @mouseover="attrActive=post.id" @mouseleave="attrActive=null" class="campaign-posts-card" v-for="post in tracker.posts" :key="post.id" :href="post.link" target="_blank">
                    <img :src="post.thumbnail_url" loading="lazy"/>
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
import moment from "moment";

export default {
   props: {
       campaign: {
           type: Object,
           default: () => ({

           })
       }
   },
   methods: {
       moment() {
         return moment();
        },
       nbr(){
           return new abbreviate();
       },
       createDoughtnutChart(id, data){
           const chartEl = document.getElementById(id);
           const chart = new Chart(chartEl, {
               type: 'doughnut',
               data: data
           });
       }
   },
   mounted(){
    this.createDoughtnutChart('sentiments-chart', {
        datasets: [{
            data: [
                this.campaign.data.sentiments_positive.toFixed(2),
                this.campaign.data.sentiments_neutral.toFixed(2),
                this.campaign.data.sentiments_negative.toFixed(2)
            ],
            backgroundColor: [
                "#AFD75C",
                "#999999",
                "#ED435A" //#d93176
            ],
        }],
        labels: [
            'Positive',
            'Neutral',
            'Negative',
        ]
    });
    
    this.createDoughtnutChart('communities-chart', {
        datasets: [{
            data: [this.campaign.data.communities],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    this.createDoughtnutChart('impressions-chart', {
        datasets: [{
            data: [this.campaign.data.impressions],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    this.createDoughtnutChart('views-chart', {
        datasets: [{
            data: [this.campaign.data.views],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    this.createDoughtnutChart('engagements-chart', {
        datasets: [{
            data: [this.campaign.data.engagements],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    let postsAndStoriesLabel = 'Instagram: ' + (this.campaign.data.posts_count ? this.campaign.data.posts_count : 0) + ' including ' + (this.campaign.data.stories_count ? this.campaign.data.stories_count : 0) + ' stories';
    this.createDoughtnutChart('posts-chart', {
        datasets: [{
            data: [this.campaign.data.posts_count],
            backgroundColor: ['#d93176']
        }],
        labels: [postsAndStoriesLabel]
    });
   },
   data: () => ({
        columns: [
            {label: 'Influencer', field: 'name'},
            {label: 'Number of posts', field: 'posts_count'},
            // {label: 'Address', representedAs: ({address, city, state}) => `${address}<br />${city}, ${state}`, interpolate: true}
        ],
        rows: [],
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