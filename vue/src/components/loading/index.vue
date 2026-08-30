<!-- loading  -->
<template>
  <div v-if='mainStore.isLoading' class='loading' @click='clickLoading'>
    <van-loading class='Loadings' color='#1989fa' type='spinner' />
  </div>
</template>

<script setup>
import { useMainStore } from '@/store/modules/main.js'

const mainStore = useMainStore()

const clickLoading = () => {
  mainStore.isLoading = false
}
</script>

<style lang='less' scoped>
.loading {
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 100%;
  background: rgba(0, 0, 0, 0.9);
  z-index: 999;

  .Loadings {
    margin-top: -20%;
  }
}
</style>
