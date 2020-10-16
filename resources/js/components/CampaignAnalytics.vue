<template>
    <div class="p-1 campaign" v-if="campaign">
        <div class="cards statistics">
            <div class="card" v-if="campaign.communities >= 0">
                <div class="title">
                    <i class="fas fa-users egg-blue"></i>
                    <div class="numbers">
                        <h4>{{ campaign.communities >= 0 ? campaign.communities.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total size of activated communities</span>
                    </div>
                </div>
                <canvas id="communities-chart"></canvas>
                <span>Organic communities {{ nbr().abbreviate(campaign.organicCommunities) }} ({{ campaign.communities > 0 ? ((campaign.organicCommunities / campaign.communities) * 100).toFixed(2) : 0  }}%)</span>
            </div>
            <div class="card" v-if="campaign.impressions >= 0">
                <div class="title">
                    <i class="fas fa-bullhorn purple"></i>
                    <div class="numbers">
                        <h4>{{ campaign.impressions >= 0 ? campaign.impressions.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total estimated impressions</span>
                    </div>
                </div>
                <canvas id="impressions-chart"></canvas>
                <span>Organic impressions {{ nbr().abbreviate(campaign.organicImpressions) }} ({{ campaign.impressions > 0 ? ((campaign.organicImpressions / campaign.impressions) * 100).toFixed(2) : 0  }}%)</span>
            </div>
            <div class="card" v-if="campaign.views >= 0">
                <div class="title">
                    <i class="far fa-eye green"></i>
                    <div class="numbers">
                        <h4>{{ campaign.views >= 0 ? campaign.views.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total views</span>
                    </div>
                </div>
                <canvas id="views-chart"></canvas>
                <span>Organic views {{ nbr().abbreviate(campaign.organicViews) }} ({{ campaign.views > 0 ? ((campaign.organicViews / campaign.views) * 100).toFixed(2) : 0  }}%)</span>
            </div>
            <div class="card" v-if="campaign.engagements >= 0">
                <div class="title">
                    <i class="fas fa-thumbs-up blue"></i>
                    <div class="numbers">
                        <h4>{{ campaign.engagements >= 0 ? campaign.engagements.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total engagements</span>
                    </div>
                </div>
                <canvas id="engagements-chart"></canvas>
                <span>Organic engagements {{ nbr().abbreviate(campaign.organicEngagements) }} ({{ campaign.engagements > 0 ? ((campaign.organicEngagements / campaign.engagements) * 100).toFixed(2) : 0  }}%)</span>
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
                <h5>Top 3 emojis</h5>
                <ul>
                    <li>
                        🖤
                        <span>38.9%</span>
                    </li>
                    <li>
                        😍
                        <span>21.1%</span>
                    </li>
                    <li>
                        🙏
                        <span>40%</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="posts-section" v-if="campaign.data && campaign.data.posts_count > 0">
            <h4>Posts</h4>
            <p>There are {{ campaign.trackers_count ? campaign.trackers_count : 0 }} posts for this campaign.</p>
            <div class="campaign-posts">
                <a @mouseover="attrActive=tracker.post.id" @mouseleave="attrActive=null" class="campaign-posts-card" v-for="tracker in campaign.data.trackers" :key="tracker.id" :href="tracker.post.link" target="_blank" v-if="tracker.post">
                    <img :src="tracker.post.thumbnail_url" loading="lazy"/>
                    <div class="campaign-posts-card-icons">
                        <i v-if="tracker.platform === 'instagram'" class="fab fa-instagram"></i>
                        <i v-if="tracker.post.type === 'video' || tracker.post.type=== 'sidecar'" :class="'fas fa-' + (tracker.post.type === 'sidecar' ? 'images' : 'video')"></i>
                    </div>
                    <div :class="'campaign-posts-card-attr ' + (attrActive === tracker.post.id ? ' active' : '')">
                        <span v-if="tracker.post.video_views"><i class="fas fa-eye"></i>{{ nbr().abbreviate(tracker.post.video_views) }}</span>
                        <span v-if="tracker.post.likes"><i class="fas fa-heart"></i>{{ nbr().abbreviate(tracker.post.likes) }}</span>
                        <span v-if="tracker.post.comments"><i class="fas fa-comment"></i>{{ nbr().abbreviate(tracker.post.comments) }}</span>
                    </div>
                </a>
          </div>
        </div>
    </div>
</template>
<script>
import abbreviate from 'number-abbreviate';
import Chart from 'chart.js'

export default {
   props: {
       campaign: {
           type: Object,
           default: () => ({

           })
       }
   },
   methods: {
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
                20, 30, 50
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
            data: [this.campaign.communities],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    this.createDoughtnutChart('impressions-chart', {
        datasets: [{
            data: [this.campaign.impressions],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    this.createDoughtnutChart('views-chart', {
        datasets: [{
            data: [this.campaign.views],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    this.createDoughtnutChart('engagements-chart', {
        datasets: [{
            data: [this.campaign.engagements],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram']
    });
    
    this.createDoughtnutChart('posts-chart', {
        datasets: [{
            data: [this.campaign.data.posts_count],
            backgroundColor: ['#d93176']
        }],
        labels: ['Instagram: ' + (this.campaign.data.posts_count ? this.campaign.data.posts_count : 0) + ' including ' + (this.campaign.data.stories_count ? this.campaign.data.stories_count : 0) + ' stories']
    });
   },
   data: () => ({
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