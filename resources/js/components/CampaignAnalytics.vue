<template>
    <div class="p-1 campaign" v-if="campaign">
        <div class="cards statistics">
            <div class="card">
                <div class="title">
                    <i class="fas fa-users egg-blue"></i>
                    <div class="numbers">
                        <h4>{{ campaign.communities ? campaign.communities.toLocaleString().replace(/,/g, ' ') : '---' }}</h4>
                        <span>Total size of activated communities </span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="title">
                    
                </div>
            </div>
            <div class="card">
                <div class="title">
                    
                </div>
            </div>
            <div class="card">
                <div class="title">
                    
                </div>
            </div>
            <div class="card">
                <div class="title">
                    
                </div>
            </div>
        </div>
        <div class="posts-section">
            <h4>Posts</h4>
            <p>There are {{ campaign.data.posts_count ? campaign.data.posts_count : 0 }} posts for this campaign.</p>
            <div class="campaign-posts">
                <div @mouseover="attrActive=tracker.post.id" @mouseleave="attrActive=null" class="campaign-posts-card" v-for="tracker in campaign.data.trackers" :key="tracker.id">
                    <img :src="tracker.post.thumbnail_url" loading="lazy"/>
                    <div class="campaign-posts-card-icons">
                        <i v-if="tracker.platform === 'instagram'" class="fab fa-instagram"></i>
                        <i v-if="tracker.post.type === 'video' || tracker.post.type=== 'sidecar'" :class="'fas fa-' + (tracker.post.type === 'sidecar' ? 'images' : 'video')"></i>
                    </div>
                    <div :class="'campaign-posts-card-attr ' + (attrActive === tracker.post.id ? ' active' : '')">
                        <i class="fas fa-heart"></i>{{ nbr().abbreviate(tracker.post.likes) }}
                        <i class="fas fa-comment"></i>{{ nbr().abbreviate(tracker.post.comments) }}
                    </div>
                    <!-- <a href="#" class="btn">View statistics</a> -->
                </div>
          </div>
        </div>

         <!-- <div class="cards sentiments">
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
         </div> -->
    </div>
</template>
<script>
import abbreviate from 'number-abbreviate';
import Chart from 'chart.js'

export default {
    mounted (){
        // this.renderChart(this.sentimentData, {})
    },
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
       createSentimentsChart(id){
           const sentimentsChartEl = document.getElementById(id);
           const sentimentsChart = new Chart(sentimentsChartEl, {
               type: 'doughnut',
               data: {
                   datasets: [{
                       data: [
                        //    (this.campaign.comments.positive * 100).toFixed(2),
                        //    (this.campaign.comments.neutral * 100).toFixed(2),
                        //    (this.campaign.comments.negative * 100).toFixed(2),
                       ],
                       backgroundColor: [
                            "#AFD75C",
                            "#999999",
                            "#ED435A"
                        ],
                   }],
                   labels: [
                        'Positive',
                        'Neutral',
                        'Negative',
                    ]
               }
           });
       }
   },
   mounted(){
       this.createSentimentsChart('sentiments-chart');
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