import Vue from "vue";

// Numbers filter
Vue.filter("formatedNbr", nbr => {
    try{
        if(typeof nbr === "undefined" || nbr === 0 || nbr === null)
        return '---';

        return new Intl.NumberFormat('en-US').format(nbr.toFixed(2)).replace(/,/g, ' ');
    }catch(error){
        return '---';
    }
});