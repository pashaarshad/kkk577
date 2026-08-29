<template>
  <div class='id'>
    <NavBar v-if='$route.meta.navbarShow' />
    <router-view />
    <Tabbar v-if='$route.meta.tabbarShow' />
    <Loading />
  </div>
</template>

<script setup>
import Loading from '@/components/loading/index.vue'
import Tabbar from '@/components/tabbar/index.vue'
import NavBar from '@/components/navbar/index.vue'
</script>

<style lang='less' scoped>
.id {
  background: #ffffff;
}
</style>
