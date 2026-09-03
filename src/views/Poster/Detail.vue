<!-- PosterDetail  -->
<template>
  <div class='poster-detail'>
    <div v-if='detail.id' class='poster-detail-content'>
      <div class='poster-detail-title'>{{ detail.title }}</div>
      <div class='poster-detail-time'>{{ formatDate(detail.addtime) }}</div>
      <div class='poster-detail-body' v-html='detail.content'></div>
    </div>
    <div v-else class='poster-detail-empty'>No data</div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { formatDate } from '@/utils/format-date.js'

const route = useRoute()
const router = useRouter()
const token = localStorage.getItem('token') || sessionStorage.getItem('token')

if (!token) {
  router.replace('/login')
}

const detail = ref({})

const getDetail = () => {
  const currentToken = localStorage.getItem('token') || sessionStorage.getItem('token')
  if (!currentToken) {
    router.replace('/login')
    return
  }
  Request.get({ url: `index/index/get_msg?id=${route.params.id}` }).then(res => {
    detail.value = res.data || {}
  }).catch(() => {
    router.replace('/login')
  })
}

getDetail()
</script>

<style lang='less' scoped>
.poster-detail {
  min-height: 90vh;
  padding: 16px;
  background: var(--bg-second-color);
  box-sizing: border-box;

  .poster-detail-content {
    .poster-detail-title {
      font-size: 20px;
      font-weight: 700;
      color: var(--default-color);
      line-height: 1.4;
      margin-bottom: 12px;
    }

    .poster-detail-time {
      font-size: 13px;
      color: #999;
      margin-bottom: 20px;
    }

    .poster-detail-body {
      font-size: 15px;
      color: var(--default-color);
      line-height: 1.7;

      :deep(img) {
        max-width: 100%;
        height: auto;
      }

      :deep(p) {
        margin: 8px 0;
      }
    }
  }

  .poster-detail-empty {
    text-align: center;
    color: #999;
    padding-top: 60px;
    font-size: 14px;
  }
}
</style>