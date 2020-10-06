<template>
    <div class="p-1" v-if="compaign">

    </div>
</template>
<script>
import abbreviate from 'number-abbreviate';

export default {
   props: {
       compaign: {
           type: Object,
           default: () => ({})
       }
   },
   methods: {
       nbr(){
           return new abbreviate();
       },
   },
}
</script>