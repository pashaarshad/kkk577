<!-- work  -->
<template>
  <div class="work-view">
    <!-- Header panel -->
    <div class="work-header">
      <div class="header-top-row">
        <span class="title-text">Project</span>
        <span class="history-link" @click="router.push('/order')">Purchase History &gt;</span>
      </div>
      
      <div class="stats-card">
        <div class="stats-left">
          <div class="stat-item">
            <div class="lbl">Current investment total</div>
            <div class="val">0.00 USDT</div>
          </div>
          <div class="stat-item">
            <div class="lbl">Interest can be collected</div>
            <div class="val">0.00 USDT</div>
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
                <span class="val profit-text">{{ (Number(item.num || 0) * 3.6).toFixed(2) }} USDT</span>
              </div>
              <div class="metric-item">
                <span class="lbl">Invest cycle</span>
                <span class="val cycle-text">90 Day</span>
              </div>
            </div>
            <div class="limits-info">
              <div>Number of investments available per day: <span class="dark-text">Unlimited</span></div>
              <div>Total number of investments available: <span class="dark-text">Unlimited</span></div>
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
          $ {{ Number(item.num_min || Number(item.num || 0) / 2 || 0).toFixed(2) }} - {{ Number(item.num || 0).toFixed(2) }} USDT Buy now
        </button>
      </div>
    </div>

    <!-- Orders list visible inside Project Page -->
    <div class="investment-orders-section">
      <div class="section-title">Investment Records</div>
      <ItemList :id="0" />
    </div>
  </div>
</template>

<script setup>
import { showSuccessToast } from 'vant'
import { ref } from 'vue'
import Request from '@/services/index.js'
import { useRouter } from 'vue-router'
import ItemList from '@/views/Order/cpns/item-list.vue'

const router = useRouter()

if (!sessionStorage.getItem('token')) {
  router.replace('/login')
}

const list = ref([])
if (sessionStorage.getItem('token')) {
  Request.get({ url: 'index/user/vip' }).then(res => {
    list.value = res.data
  }).catch(() => {
    router.replace('/login')
  })
}

const toGrab = (item) => {
  if (!sessionStorage.getItem('token')) {
    router.replace('/login')
    return
  }
  router.push('/grab')
}

const collectInterest = () => {
  showSuccessToast('Successfully collected interest')
}
</script>

<style lang="less" scoped>
.work-view {
  background: #fff9f8;
  min-height: 100vh;
  padding: 16px 14px 90px;
  box-sizing: border-box;

  .work-header {
    margin-bottom: 20px;

    .header-top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 14px;

      .title-text {
        font-size: 20px;
        font-weight: 800;
        color: #1f1a1a;
      }

      .history-link {
        font-size: 13px;
        color: #B83A2E;
        font-weight: 600;
        cursor: pointer;
      }
    }

    .stats-card {
      background: linear-gradient(135deg, #B83A2E, #E86C3F);
      border-radius: 14px;
      padding: 18px 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 14px rgba(184, 58, 46, 0.2);
      color: #ffffff;

      .stats-left {
        display: flex;
        flex-direction: column;
        gap: 10px;

        .stat-item {
          .lbl {
            font-size: 11px;
            opacity: 0.85;
            margin-bottom: 2px;
          }
          .val {
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
          }
        }
      }

      .collect-btn {
        background-color: #ffffff;
        color: #B83A2E;
        border: none;
        padding: 10px 22px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      }
    }
  }

  .project-hall-list {
    display: flex;
    flex-direction: column;
    gap: 14px;

    .project-card-item {
      background-color: #ffffff;
      border: 1.5px solid #E86C3F;
      border-radius: 14px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      box-shadow: 0 2px 10px rgba(184, 58, 46, 0.08);

      .card-body-row {
        display: flex;
        gap: 14px;

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
            background: linear-gradient(135deg, #ff8c00, #B83A2E);
            color: #ffffff;
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
            color: #1f1a1a;
          }

          .metrics-grid {
            display: flex;
            gap: 20px;

            .metric-item {
              display: flex;
              flex-direction: column;
              gap: 2px;

              .lbl {
                font-size: 10px;
                color: #86909c;
              }

              .val {
                font-size: 13px;
                font-weight: 700;

                &.profit-text {
                  color: #E86C3F;
                }
                &.cycle-text {
                  color: #B83A2E;
                }
              }
            }
          }

          .limits-info {
            font-size: 10px;
            color: #86909c;
            display: flex;
            flex-direction: column;
            gap: 2px;

            .dark-text {
              color: #1f1a1a;
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
          background-color: #fdece8;
          border-radius: 3px;
          overflow: hidden;

          .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #E86C3F, #B83A2E);
            border-radius: 3px;
          }
        }

        .progress-val {
          font-size: 11px;
          color: #B83A2E;
          font-weight: 700;
        }
      }

      .buy-button {
        width: 100%;
        background: linear-gradient(135deg, #B83A2E, #E86C3F);
        color: #ffffff;
        border: none;
        padding: 11px 0;
        border-radius: 24px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 4px 10px rgba(184, 58, 46, 0.25);
      }
    }
  }

  .investment-orders-section {
    margin-top: 26px;
    
    .section-title {
      font-size: 18px;
      font-weight: 800;
      color: #1f1a1a;
      margin-bottom: 14px;
    }
  }
}
</style>
