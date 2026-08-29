<!-- order  -->
<template>
  <div class='order'>
    <van-tabs v-model:active='active' color='#7a7a7a' @click-tab='onClickTab'>
      <template v-for='item in navList'>
        <van-tab :title='item.title'>
          <ItemList :id='item.id' />
        </van-tab>
      </template>
    </van-tabs>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Request from '@/services/index.js'
import ItemList from '@/views/Order/cpns/item-list.vue'
import { i18n } from '@/lang/index.js'

const { t } = i18n.global

const active = ref(0)
const currentPage = ref(1)
const pageCount = ref(1)

const navList = [
  {
    title: t('order.All'),
    id: 0
  },
  {
    title: t('order.submitted'),
    id: -1
  },
  {
    title: t('order.Completed'),
    id: 1
  }
]

const onClickTab = () => {
}

const list = ref([])
const getData = (status = null) => {
  Request.get({
    url: 'index/order/index?page=1&status=' + status
  }).then(res => {
    list.value = res.data.data
    pageCount.value = res.last_page
    currentPage.value = res.current_page
  })
}

getData()
</script>

<style lang='less' scoped>
.order {
  padding: 0 0 70px 0;
  background: var(--bg-second-color);
  min-height: 80vh;

  .list {
    padding: 16px;
  }

  :deep(.van-tabs__wrap) {
    height: 60px;
    background: var(--bg-color) !important;
    box-shadow: 0 3px 10px 0 rgba(0, 0, 0, .4);
    border-bottom: 1px solid var(--second-color);
  }

  :deep(.van-tabs__nav) {
    background: var(--bg-color) !important;
  }

  :deep(.van-tab) {
    color: var(--text-second);
  }

  :deep(.van-tab--active) {
    color: var(--main-color);
    font-weight: 700;
  }

  :deep(.van-tabs__line) {
    bottom: 25px;
    background-color: var(--main-color);
  }

  .pagination {
    padding: 0 0 30px 0;

    button:after {
      border: none;
    }
  }

}
</style>
