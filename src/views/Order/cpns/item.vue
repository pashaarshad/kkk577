<!-- item  -->
<template>
  <div class='item'>
    <div class='flex-between'>
      <div>{{ formatDate(list?.addtime) }}</div>
      <div>{{ list?.id }}</div>
    </div>
    <div class='item-content'>
      <img :src='list?.goods_pic' alt=''>
      <div class='item-content-right'>
        <div>{{ list?.goods_name }}</div>
        <div>{{ $t('main.money') }} {{ list?.goods_price }}* {{ list?.goods_count }}</div>
		<van-button v-if='list.status == 1' class='item-btn' plain type='success'>{{ $t('order.Submitted') }}
		</van-button>
		<van-button v-if='list.status == 0' class='item-btn' plain type='warning'>
		  {{ $t('order.Undone') }}
		</van-button>
      </div>
    </div>
    <div class='item-footer'>
      <div>
        <span>{{ $t('order.OrderTotal') }}</span>
        <span class='foot-q'>{{ $t('main.money') }}{{ list?.num }}</span>
      </div>
      <div>
        <span>{{ $t('order.Commission') }}</span>
        <span class='foot-q'>{{ $t('main.money') }}{{ list?.commission }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>

import { formatDate } from '@/utils/format-date.js'

const props = defineProps({
  list: {
    type: Object
  }
})
</script>

<style lang='less' scoped>
.item {
  width: 100%;
  border-radius: 8px;
  box-shadow: 0 0 10px 0 rgba(0, 0, 0, .1);
  padding: 0px 0 10px 0;
  background: #FFFFFF;
  font-size: 13.2px;

  .flex-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13.2px;

    div:nth-child(1) {
      border-top-left-radius: 8px;
      font-weight: 700 !important;
      padding: 9px;
      color: var(--main-color);
      background: var(--gray-color);
    }

    div:nth-child(2) {
      border-top-left-radius: 8px;
      padding: 9px;
    }
  }

  .item-content {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 11px;

    .item-content-right {
      margin-left: 16.5px;

      div:nth-child(1) {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
      }

      div:nth-child(2) {
        color: var(--red-color);
        margin: 6px 0;
      }

      .item-btn {
        height: 24px;
        font-size: 13px;
      }
    }

    img {
      width: 110px;
      height: 110px;
    }
  }

  .item-footer {
    padding: 11px;
    background: var(--gray-color);
    margin-bottom: 6px;

    div {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    div:nth-child(2) {
      margin-top: 6px;
    }

    .foot-q {
      font-weight: 700 !important;
    }
  }
}
</style>
