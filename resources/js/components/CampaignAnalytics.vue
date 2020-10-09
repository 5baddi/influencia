<template>
    <div class="p-1" v-if="campaign">

    </div>
</template>
<script>
import abbreviate from 'number-abbreviate';

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
   }
}
</script>