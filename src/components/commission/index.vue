<!-- Commission  -->
<template>
  <div class='commission'>
    <div class='title'>{{ $t('home.userTitle') }}</div>
    <div class='commission-content'>
      <van-swipe :autoplay='2000' :height='90' :show-indicators='false' style='height: 400px;' vertical>

        <template v-for='(item, index) in props.list'>
          <van-swipe-item class='commissionList'>
            <div class='commission-list'>
              <div class='commission-list-left'>
                <img :src='item.voucher || defaultLogo' alt='' class='voucher-img'>
                <div>{{ item.id }}</div>
              </div>
              <div>{{ $t('home.commission') }}</div>
              <div>Q{{ item.num }}</div>
            </div>
          </van-swipe-item>
        </template>
      </van-swipe>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { getAssetURL } from '@/utils/get_assets_img.js'

const props = defineProps({
  list: {
    type: Array
  }
})

const commissionList = ref([])

const defaultLogo = getAssetURL('main/logo.jpg')
</script>

<style lang='less' scoped>
.title {
  font-size: 22px;
  font-weight: 700 !important;
  margin-bottom: 20px;
  margin-top: 30px;
}

.commission {
  width: 92%;
  margin: 10px auto;
  box-sizing: border-box;
  font-size: 13.2px;

  .commissionList {
    margin-bottom: 00px;
  }

  .commission-list-left {
    display: flex;
    justify-content: space-between;
    align-items: center;

    .voucher-img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    div {
      margin-left: 20px;
    }
  }

  .commission-list {
    display: flex;
    justify-content: space-between;
    align-items: center;

    img {
      width: 60px;
      height: 60px;
    }
  }
}
</style>
