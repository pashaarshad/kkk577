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
  width: 100%;
  max-width: 480px;
  margin: 0 auto;
  min-height: 100vh;
  background: #fff9f8;
  position: relative;
  box-shadow: 0 0 25px rgba(0, 0, 0, 0.06);
}
</style>
