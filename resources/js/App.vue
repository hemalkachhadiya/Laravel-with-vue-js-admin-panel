<template>
   
           <router-view :app="this"/>
  
</template>

<script>

import layouts from './components/layouts.vue';
export default {
  components: { layouts },
    name: 'app',
    	data(){
            return{

            }
		},

};
</script>

<style>

</style>