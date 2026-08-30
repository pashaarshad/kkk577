<!-- Commission  -->
<template>
  <div class='commission'>
    <div class='title'>Activitys</div>
    <div class='activity-list'>
      <!-- Card 1 -->
      <div class='activity-card'>
        <div class='card-left'>
          <span class='activity-id'>321321</span>
        </div>
        <div class='card-right'>
          <span class='amount positive'>+$9.00 USDT</span>
          <button class='action-btn arrow-btn' @click='router.push("/work")'>
            <span>New Tasks</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
          </button>
        </div>
      </div>
      <!-- Card 2 -->
      <div class='activity-card'>
        <div class='card-left'>
          <img :src='defaultGameLogo' alt='' class='activity-game-img'>
        </div>
        <div class='card-right'>
          <span class='amount positive'>+$9.00 USDT</span>
          <button class='action-btn arrow-btn' @click='router.push("/work")'>
            <span>New Tasks</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
          </button>
        </div>
      </div>
      <!-- Card 3 -->
      <div class='activity-card'>
        <div class='card-left'>
          <span class='activity-id'>&nbsp;</span>
        </div>
        <div class='card-right'>
          <span class='amount gold'>+$69.00 USDT</span>
          <button class='action-btn arrow-btn primary' @click='router.push("/work")'>
            <span>New Tasks</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
          </button>
        </div>
      </div>
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
.title {
  font-size: 20px;
  font-weight: 700 !important;
  margin-bottom: 14px;
  margin-top: 24px;
  color: var(--default-color);
}

.commission {
  width: 92%;
  margin: 10px auto;
  box-sizing: border-box;
  font-size: 13.2px;

  .activity-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .activity-card {
    background-color: var(--bg-color);
    border: 1px solid var(--second-color);
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);

    .card-left {
      font-size: 14px;
      font-weight: 700;
      color: var(--default-color);

      .activity-id {
        font-family: monospace;
        font-size: 14px;
      }

      .activity-game-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
      }
    }

    .card-right {
      display: flex;
      align-items: center;
      gap: 12px;

      .amount {
        font-size: 13px;
        font-weight: 700;
        
        &.positive {
          color: #00b25e;
        }

        &.gold {
          color: #f5a623;
        }
      }

      .action-btn {
        background: transparent;
        color: var(--main-color);
        border: 1px solid var(--main-color);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 2px;
        white-space: nowrap;

        &.arrow-btn {
          padding-right: 8px;
        }

        &.primary {
          background-color: var(--main-color);
          color: #000000;
        }
      }
    }
  }
}
</style>
