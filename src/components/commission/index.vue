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
          <span class='amount positive'>+20.00 USDT</span>
          <button class='action-btn' @click='router.push("/work")'>View Tasks</button>
        </div>
      </div>
      <!-- Card 2 -->
      <div class='activity-card'>
        <div class='card-left'>
          <img :src='defaultGameLogo' alt='' class='activity-game-img'>
        </div>
        <div class='card-right'>
          <span class='amount positive'>+10.00 USDT</span>
          <button class='action-btn' @click='router.push("/work")'>View Tasks</button>
        </div>
      </div>
      <!-- Card 3 -->
      <div class='activity-card'>
        <div class='card-left-empty'>
          <!-- Spacer to align right side elements -->
        </div>
        <div class='card-right'>
          <span class='amount positive'>+90.00 USDT</span>
          <button class='action-btn primary' @click='router.push("/work")'>Check In</button>
        </div>
      </div>
      <!-- Card 4 -->
      <div class='activity-card flex-col-wrap'>
        <div class='activity-card-top'>
          <div class='card-left'>
            <span class='invited-text'>Invitedfriend</span>
          </div>
          <div class='card-right'>
            <span class='amount positive'>+90.00 USDT</span>
            <button class='action-btn' @click='router.push("/mine")'>0 / 1</button>
          </div>
        </div>
        <div class='activity-card-bottom'>
          <div class='progress-bar-wrapper'>
            <div class='progress-bar-inner' style='width: 30%;'></div>
          </div>
          <span class='progress-text'>30%</span>
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

  .activity-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .activity-card {
    background-color: var(--bg-color);
    border: 1px solid var(--second-color);
    border-radius: 12px;
    padding: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box;

    &.flex-col-wrap {
      flex-direction: column;
      align-items: stretch;
      gap: 12px;
    }

    .activity-card-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }

    .activity-card-bottom {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;

      .progress-bar-wrapper {
        flex: 1;
        height: 6px;
        background-color: var(--second-color);
        border-radius: 3px;
        overflow: hidden;

        .progress-bar-inner {
          height: 100%;
          background-color: var(--main-color);
        }
      }

      .progress-text {
        font-size: 11px;
        color: var(--text-second);
      }
    }

    .card-left {
      font-size: 14px;
      font-weight: 700;
      color: var(--default-color);

      .activity-id {
        font-family: monospace;
      }

      .activity-game-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
      }

      .invited-text {
        font-size: 13px;
        color: var(--default-color);
      }
    }

    .card-right {
      display: flex;
      align-items: center;
      gap: 16px;

      .amount {
        font-size: 14px;
        font-weight: 700;
        
        &.positive {
          color: #00b25e;
        }
      }

      .action-btn {
        background: transparent;
        color: var(--main-color);
        border: 1px solid var(--main-color);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;

        &.primary {
          background-color: var(--main-color);
          color: #000000;
        }
      }
    }
  }
}
</style>
