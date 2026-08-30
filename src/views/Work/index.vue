<!-- work  -->
<template>
  <div class="work-view">
    <!-- Header panel -->
    <div class="work-header">
      <div class="header-top-row">
        <span class="title-text">Project</span>
        <span class="history-link" @click="router.push('/order')">Purchase History</span>
      </div>
      
      <div class="stats-card">
        <div class="stats-left">
          <div class="stat-item">
            <div class="lbl">Current investment total</div>
            <div class="val">0 USDT</div>
          </div>
          <div class="stat-item">
            <div class="lbl">Interest can be collected</div>
            <div class="val">0 USDT</div>
          </div>
        </div>
        <button class="collect-btn" @click="collectInterest">Receive</button>
      </div>
    </div>

    <!-- Project List -->
    <div class="project-hall-list">
      <div v-for="(item, index) in list" :key="item.id" class="project-card-item">
        <div class="card-body-row">
          <div class="img-wrapper">
            <img :src="item.img" alt="" class="goods-img">
            <span class="vip-level-badge">{{ item.name }}</span>
          </div>
          <div class="details-column">
            <div class="title-row">商城365天产品</div>
            <div class="metrics-grid">
              <div class="metric-item">
                <span class="lbl">The total profit</span>
                <span class="val green-text">{{ (item.num * 3.6).toFixed(2) }} USDT</span>
              </div>
              <div class="metric-item">
                <span class="lbl">Invest cycle</span>
                <span class="val green-text">90Day</span>
              </div>
            </div>
            <div class="limits-info">
              <div>Number of investments available per day: <span class="white-text">Unlimited</span></div>
              <div>Total number of investments available: <span class="white-text">Unlimited</span></div>
            </div>
          </div>
        </div>
        
        <!-- Progress bar -->
        <div class="progress-section">
          <div class="progress-bar-container">
            <div class="progress-bar-fill" :style="{ width: (60 + index * 10) + '%' }"></div>
          </div>
          <span class="progress-val">{{ 60 + index * 10 }}.00%</span>
        </div>

        <!-- Buy button -->
        <button class="buy-button" @click="toGrab(item)">
          $ {{ (item.num_min || item.num / 2).toFixed(2) }} - {{ item.num.toFixed(2) }} USDT Buy now
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { showSuccessToast } from 'vant'
import { ref } from 'vue'
import Request from '@/services/index.js'
import { useRouter } from 'vue-router'

const list = ref([])
Request.get({ url: 'index/user/vip' }).then(res => {
  list.value = res.data
})

const router = useRouter()
const toGrab = (item) => {
  router.push('/grab')
}

const collectInterest = () => {
  showSuccessToast('Successfully collected interest')
}
</script>

<style lang="less" scoped>
.work-view {
  background: var(--bg-second-color);
  min-height: 100vh;
  padding: 16px 16px 90px 16px;
  box-sizing: border-box;

  .work-header {
    margin-bottom: 20px;

    .header-top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;

      .title-text {
        font-size: 20px;
        font-weight: 700;
        color: var(--default-color);
      }

      .history-link {
        font-size: 13px;
        color: var(--main-color);
        font-weight: 600;
        cursor: pointer;
      }
    }

    .stats-card {
      background-color: var(--bg-color);
      border: 1px solid var(--second-color);
      border-radius: 12px;
      padding: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

      .stats-left {
        display: flex;
        flex-direction: column;
        gap: 12px;

        .stat-item {
          .lbl {
            font-size: 11px;
            color: var(--text-second);
            margin-bottom: 2px;
          }
          .val {
            font-size: 15px;
            font-weight: 750;
            color: var(--main-color);
          }
        }
      }

      .collect-btn {
        background-color: var(--main-color);
        color: #000000;
        border: none;
        padding: 10px 24px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
      }
    }
  }

  .project-hall-list {
    display: flex;
    flex-direction: column;
    gap: 16px;

    .project-card-item {
      background-color: var(--bg-color);
      border: 1px solid var(--second-color);
      border-radius: 12px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

      .card-body-row {
        display: flex;
        gap: 16px;

        .img-wrapper {
          position: relative;
          width: 80px;
          height: 80px;
          flex-shrink: 0;

          .goods-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
          }

          .vip-level-badge {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: var(--main-color);
            font-size: 9px;
            font-weight: 700;
            text-align: center;
            padding: 2px 0;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
          }
        }

        .details-column {
          flex: 1;
          display: flex;
          flex-direction: column;
          gap: 6px;

          .title-row {
            font-size: 15px;
            font-weight: 700;
            color: var(--default-color);
          }

          .metrics-grid {
            display: flex;
            gap: 24px;

            .metric-item {
              display: flex;
              flex-direction: column;
              gap: 2px;

              .lbl {
                font-size: 10px;
                color: var(--text-second);
              }

              .val {
                font-size: 13px;
                font-weight: 700;

                &.green-text {
                  color: #00b25e;
                }
              }
            }
          }

          .limits-info {
            font-size: 10px;
            color: var(--text-second);
            display: flex;
            flex-direction: column;
            gap: 2px;

            .white-text {
              color: var(--default-color);
              font-weight: 600;
            }
          }
        }
      }

      .progress-section {
        display: flex;
        align-items: center;
        gap: 12px;

        .progress-bar-container {
          flex: 1;
          height: 6px;
          background-color: var(--bg-second-color);
          border-radius: 3px;
          overflow: hidden;

          .progress-bar-fill {
            height: 100%;
            background-color: var(--main-color);
            border-radius: 3px;
          }
        }

        .progress-val {
          font-size: 11px;
          color: var(--main-color);
          font-weight: 700;
        }
      }

      .buy-button {
        width: 100%;
        background-color: var(--main-color);
        color: #000000;
        border: none;
        padding: 10px 0;
        border-radius: 24px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      }
    }
  }
}
</style>
