<!-- work  -->
<template>
  <div>
    <div class='work'>
      <div class='work-list'>
        <div v-for='(item, index) in list' class='work-item' @click='toGrab(item)'>
          <span class='tag'>{{ item.name }}</span>
          <img :src='item.img' alt=''>
          <div class='work-item-content'>
            <div>{{ $t('Minimum') }}</div>
            <div>{{ $t('main.money') }}{{ item.num_min }}</div>
            <div class='work-item-content-foot'>
              <div>{{ $t('Commission') }}</div>
              <van-button class='work-btn' type='primary'>{{ (item.bili * 100).toFixed(2) }}%</van-button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Commission :list='data.reward_list' />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Commission from '@/components/commission/index.vue'
import Request from '@/services/index.js'
import { useRouter } from 'vue-router'

const list = ref([])
Request.get({ url: 'index/user/vip' }).then(res => {
  list.value = res.data
})

const data = ref({})
Request.get({ url: 'index/index/home' }).then(res => {
  data.value = res.data
})

const userVip = ref({})
Request.get({ url: 'index/user/info' }).then(res => {
  userVip.value = res.info.level
})

const router = useRouter()
const toGrab = (item) => {
	router.push('/grab')
  // if (item.id <= userVip.value) {
  //   router.push('/grab')
  // } else {
  //   router.push('/pay')
  // }
}
</script>

<style lang='less' scoped>
.work {
  padding: 0 16px;
  box-sizing: border-box;

  .work-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 20px;

    .work-item {
      position: relative;
      width: 182px;
      height: 280px;
      border: 1px solid #e0e1e2;
      margin-bottom: 10px;

      img {
        height: 182px;
        width: 182px;
        object-fit: cover;
      }

      .tag {
        position: absolute;
        left: 0;
        right: 0;
        background: var(--default-color);
        color: var(--yellow-color);
        width: 66px;
        height: 24px;
        line-height: 25px;
        text-align: center;
        font-weight: 700;
        font-size: 13.2px;
      }
    }

    .work-item-content {
      padding: 10px;
      font-size: 13px;
      line-height: 1.5;

      .work-item-content-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
      }

      .work-btn {
        width: 63px;
        height: 24px;
        background-color: var(--red-color);
        border: none;
        border-radius: 2px;
        color: #fff;
        font-size: 13px;
      }
    }
  }
}
</style>
