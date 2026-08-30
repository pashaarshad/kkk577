<!-- item-list  -->
<template>
  <div v-if='list.length > 0' class='item-list'>
    <div v-for='item in list' class='list'>
      <Item :list='item'></Item>
    </div>
    <van-pagination v-model='currentPage' :next-text='$t("main.next")' :page-count='pageCount'
                    :prev-text='$t("main.last")' class='pagination'
                    mode='simple'
                    @change='pageChange' />
  </div>
  <div v-else>
    <van-empty
      :description='$t("order.nullMsg")'
      :image='emptyImage'
      image-size='80'
    />
  </div>
</template>

<script setup>
import Item from '@/views/Order/cpns/item.vue'
import { ref } from 'vue'
import Request from '@/services/index.js'
import emptyImage from '@/assets/img/empty-image-default.png'

const props = defineProps({
  id: Number
})

const currentPage = ref(1)
const pageCount = ref(1)
const list = ref([])

const getData = () => {
  Request.get({
    url: 'index/order/index?page=' + currentPage.value + '&status=' + props?.id
  }).then(res => {
    list.value = res.data.data
    pageCount.value = res.data.last_page
    currentPage.value = res.data.current_page
  })
}

getData()

const pageChange = () => {
  getData()
}
</script>

<style lang='less' scoped>
.item-list {
  .list {
    padding: 16px;
  }

  :deep(.van-tabs__wrap) {
    height: 60px;
    background: #ffffff !important;
  }

  :deep(.van-tabs__wrap) {
    box-shadow: 0 3px 5px 0 rgba(191, 199, 221, .251);
  }

  :deep(.van-tabs__line) {
    bottom: 25px
  }

  .pagination {
    padding: 0 0 30px 0;

    button:after {
      border: none;
    }
  }
}
</style>
