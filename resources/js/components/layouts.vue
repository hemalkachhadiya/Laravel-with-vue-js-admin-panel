<template>
   <div class="wrapper">
    <vueheader></vueheader>
    <vuesidebar></vuesidebar>
    <router-view/>
    <vuefooter></vuefooter>
   </div>
</template>
                    
<script>

import vuesidebar from "./Sidebar";
import vuecontainer from "./Container";
import vuefooter from "./Footer";
import vueheader from "./Header";


export default {
    name: 'layouts',
		props: ['app'],
		components: {
			vuesidebar,
			vuecontainer,
            vuefooter,
            vueheader
		},
    
};
</script>
