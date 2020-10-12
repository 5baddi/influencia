<template>
    <div class="p-1 campaign" v-if="campaign">
         <div class="cards sentiments">
            <div class="card">
                <h5>Comments sentiment</h5>
                <doughnut :chartdata="sentimentData"/>
            </div>
            <div class="card">
                <h5>Top 3 emojis</h5>
            </div>
         </div>
    </div>
</template>
<script>
import abbreviate from 'number-abbreviate';
import { Doughnut  } from 'vue-chartjs'

export default {
    components: {
        Doughnut
    },
    mixins: [Doughnut],
    mounted (){
        this.renderChart(this.sentimentData, {})
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