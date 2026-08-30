<!-- item-list  -->
<template>
  <div v-if='list.length > 0' class='item-list'>
      <div v-for='item in list' class="box u-m-t-10">
      	<div class="flex-between u-font-14">
      		<span v-if="item.type === 1"> {{ $t('bill.txt.recharge') }}</span>
      		<span v-else-if="item.type === 2"> {{ $t('bill.txt.deal') }}</span>
      		<span v-else-if="item.type === 3"> {{ $t('bill.txt.commision') }}</span>
      		<span v-else-if="item.type === 7"> {{ $t('bill.txt.withdraw') }}</span>
			<span v-else> {{ $t('bill.txt.system') }}</span>
      		<span v-if="item.status === 1" class="text-green">+{{ $t('main.money')}}{{item.num}}</span>
      		<span v-if="item.status === 2" class="text-red">-{{ $t('main.money')}}{{item.num}}</span>
      	</div>
      	<div class="flex-between">
      		<span class="opacity-40">{{ formatDate(item.addtime)}}</span>
      		<!-- <span class="opacity-40">After：Q1,273.79</span> -->
      	</div>
      </div>
    <van-pagination v-model='currentPage' :next-text='$t("main.next")' :page-count='pageCount'
                    :prev-text='$t("main.last")' class='pagination'
                    mode='simple'
                    @change='pageChange' />
  </div>
  <div v-else>
    <van-empty
      :description='$t("order.nullMsg")'
      :image="emptyImage"
      image-size='80'
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Request from '@/services/index.js'
import { formatDate } from '@/utils/format-date.js'
import emptyImage from '@/assets/img/empty-image-default.png'

const props = defineProps({
  id: Number
})

console.log(props)
const currentPage = ref(1)
const pageCount = ref(1)
const list = ref([])

const getData = () => {
  Request.get({
    url: 'index/my/caiwu?page=' + currentPage.value + '&type=' + props?.id
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
	padding: 0 .4rem;
	font-size: .32rem;
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
  .box {
      width: 95%;
      border-radius: 0.2667rem;
      padding: 0.4rem .2rem;
      -webkit-box-shadow: 0 0 0.267rem 0 rgba(0,0,0,.1);
      box-shadow: 0 0 0.267rem 0 rgba(0,0,0,.1);
      overflow: hidden;
  }
  .flex-between {
      -webkit-box-pack: justify!important;
      -ms-flex-pack: justify!important;
      justify-content: space-between!important;
  }
  .flex-between, .flex-center {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
  }
  .u-m-t-10 {
      margin-top: 0.26667rem!important;
  }
  .text-red {
      color: var(--red-color);
  }
  .text-green {
      color: var(--green-color);
  }
  .opacity-40 {
      opacity: .4;
  }
  .u-font-14 {
      font-size: .37333rem!important;
  }
}
</style>
