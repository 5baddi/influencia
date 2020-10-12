<template>
    <div class="p-1 campaign" v-if="campaign">
         <div class="cards sentiments">
            <div class="card">
                <h5>Comments sentiment</h5>
                <canvas id="sentiments-chart"></canvas>
                <span>Based on {{ nbr().abbreviate(campaign.comments.count) }} comments</span>
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
                           (this.campaign.comments.positive * 100).toFixed(2),
                           (this.campaign.comments.neutral * 100).toFixed(2),
                           (this.campaign.comments.negative * 100).toFixed(2),
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