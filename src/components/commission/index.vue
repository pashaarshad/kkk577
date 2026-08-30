<!-- Commission / Activities with Order Popout Arrow -->
<template>
  <div class='commission'>
    <h2 class='section-title'>Activitys</h2>

    <!-- ORDER CARD 1 -->
    <div class='order-card'>
      <div class='order-number'>321321</div>
      <div class='order-profit'>+$9.00 USDT</div>
      <button class='view-task' @click='router.push("/work")'>View Task</button>
      <div class='order-popout'></div>
    </div>

    <!-- ORDER CARD 2 -->
    <div class='order-card'>
      <div class='order-number'>
        <img :src='defaultGameLogo' alt='' class='order-img'>
      </div>
      <div class='order-profit'>+$9.00 USDT</div>
      <button class='view-task' @click='router.push("/work")'>New Tasks</button>
      <div class='order-popout'></div>
    </div>

    <!-- ORDER CARD 3 -->
    <div class='order-card'>
      <div class='order-number'>&nbsp;</div>
      <div class='order-profit gold'>+$69.00 USDT</div>
      <button class='view-task' @click='router.push("/work")'>New Tasks</button>
      <div class='order-popout'></div>
    </div>
  </div>
</template>

<script setup>
import { getAssetURL } from '@/utils/get_assets_img.js'
import { useRouter } from 'vue-router'

const router = useRouter()
const defaultGameLogo = getAssetURL('mine/ic_gift.png')
</script>

<style lang='less' scoped>
.commission {
  margin: 0 0 10px;

  .section-title {
    display: inline-block;
    position: relative;
    margin: 3px 0 9px;
    font-size: 15px;
    font-weight: normal;
    color: white;

    &::after {
      content: "";
      position: absolute;
      height: 4px;
      width: 100%;
      left: 0;
      bottom: -4px;
      background: #2760ae;
    }
  }

  .order-card {
    position: relative;
    min-height: 70px;
    padding: 14px;
    background: #382f28;
    border-radius: 7px;
    overflow: visible;
    margin-bottom: 28px;

    .order-number {
      font-size: 11px;
      font-weight: bold;
      margin-bottom: 12px;
      color: #ffffff;

      .order-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
      }
    }

    .order-profit {
      position: absolute;
      right: 15px;
      top: 12px;
      color: #65d69a;
      font-size: 11px;

      &.gold {
        color: #f5ae48;
      }
    }

    .view-task {
      position: absolute;
      right: 12px;
      top: 31px;
      border: none;
      padding: 8px 13px;
      border-radius: 16px;
      color: white;
      background: #f5ae48;
      font-size: 10px;
      cursor: pointer;
      font-weight: 600;
    }

    /* Pop-out arrow design */
    .order-popout {
      position: absolute;
      right: 12px;
      bottom: -16px;
      width: 35px;
      height: 32px;
      border-radius: 0 0 10px 10px;
      background: #382f28;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      z-index: 3;

      &::before {
        content: "";
        width: 8px;
        height: 8px;
        border-right: 2px solid white;
        border-bottom: 2px solid white;
        transform: rotate(45deg) translateY(-2px);
      }
    }
  }
}
</style>
