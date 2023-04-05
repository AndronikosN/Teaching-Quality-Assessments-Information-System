<template>
  <CSidebar 
    fixed 
    :minimize="minimize"
    :show="show"
    @update:show="(value) => $store.commit('set', ['sidebarShow', value])"
   >
    <CSidebarBrand class="d-md-down-none" to="/">
    <!--
      <CIcon 
        class="c-sidebar-brand-full" 
        name="logo" 
        size="custom-size" 
        :height="35" 
        viewBox="0 0 556 134"
      />
      -->
      <img width="90%" fluid src="../images/logotr.png" />
      
      <CIcon 
        class="c-sidebar-brand-minimized" 
        name="logo" 
        size="custom-size" 
        :height="35" 
        viewBox="0 0 110 134"
      />
    </CSidebarBrand>

    <p v-if="t_type === '0'">
    <CRenderFunction   
     flat :content-to-render="$options.navprof"
    />  
    </p>

    <p v-if="t_type === '1'">
    <CRenderFunction   
     flat :content-to-render="$options.navmodip"
    /> 

    <p v-if="t_type === '2'">
    <CRenderFunction   
     flat :content-to-render="$options.navomea"
    />

    <p v-if="t_type === '3'">
    <CRenderFunction   
     flat :content-to-render="$options.navstudent"
    />
   </p>
  <!--
    <CSidebarMinimizer
      class="d-md-down-none"
      @click.native="$store.commit('set', ['sidebarMinimize', !minimize])"
    />
-->
  </CSidebar>


</template>

<script>
import navmodip from './_navmodip'
import navprof from './_navprof'
import navomea from './_navomea'
import navstudent from './_navstudent'

export default {
  name: 'TheSidebar',
  navmodip,navprof,navomea,navstudent,
  data() {
        return {

             t_type:'',
      }
    },
  computed: {
    show () {
      return this.$store.state.sidebarShow 
    },
    minimize () {
      return this.$store.state.sidebarMinimize 
    }
  },
  mounted(){
    if(localStorage.type) {
      this.t_type=localStorage.type;
    }
  }
}

</script>
