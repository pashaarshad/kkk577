<template>
  <div class='bill'>
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
import ItemList from '@/views/BillList/item-list.vue'
import { i18n } from '@/lang/index.js'

const { t } = i18n.global

const active = ref(0)
const currentPage = ref(1)
const pageCount = ref(1)

const navList = [
  {
    title: t('bill.All'),
    id: 0
  },
  {
    title: t('bill.DepositHistory'),
    id: 1
  },
  {
    title: t('bill.WithdrawalHistory'),
    id: 2
  }
]

const onClickTab = () => {
}

const list = ref([])
const getData = (type = null) => {
  Request.get({
    url: 'index/my/caiwu?page=1&type=' + type
  }).then(res => {
    list.value = res.data.data
    pageCount.value = res.last_page
    currentPage.value = res.current_page
  })
}

getData()
</script>

<style lang='less' scoped>
.bill {
  padding: 0 0 70px 0;
  background: #ffffff;
  min-height: 80vh;

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
