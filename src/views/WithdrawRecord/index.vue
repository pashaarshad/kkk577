<template>
  <div class="withdraw-record-page">
    <div class="header">
      <van-icon name="arrow-left" size="20" color="#fff" @click="router.back()" class="back-btn" />
      <h3 class="title">{{ $t('mine.withdrawalRecord') || 'Withdrawal History' }}</h3>
    </div>

    <!-- Summary Banner -->
    <div class="summary-card">
      <div class="summary-content">
        <div class="summary-label">Total Withdrawn / 累计提现</div>
        <div class="summary-amount">$ {{ Number(totalDeposit).toFixed(2) }}</div>
      </div>
      <div class="summary-icon">
        <van-icon name="balance-o" size="36" color="#ffffff" />
      </div>
    </div>

    <!-- Record List -->
    <div v-if="list.length > 0" class="item-list">
      <div v-for="item in list" :key="item.id" class="box u-m-t-10">
        <div class="flex-between top-row">
          <span class="order-id" @click="copyText(item.id)">
            {{ item.id }}
            <van-icon name="filter-o" size="13" class="copy-icon" />
          </span>
          <span class="amount-text">-${{ Number(item.num || 0).toFixed(2) }}</span>
        </div>

        <div class="flex-between mid-row">
          <span class="address-tag">{{ item.usdt || 'USDT Wallet' }}</span>
          <van-tag v-if="item.status === 1" type="warning" size="medium" round>
            <van-icon name="clock-o" /> Pending / 审核中
          </van-tag>
          <van-tag v-else-if="item.status === 2" type="success" size="medium" round>
            <van-icon name="success" /> Approved / 已出款
          </van-tag>
          <van-tag v-else-if="item.status === 3" type="danger" size="medium" round>
            <van-icon name="cross" /> Refunded / 已退回
          </van-tag>
          <van-tag v-else type="default" size="medium" round>Unknown</van-tag>
        </div>

        <div class="flex-between bot-row">
          <span class="time-text">{{ formatDate(item.addtime) }}</span>
          <span v-if="item.status === 2 && item.endtime" class="time-text">
            Done: {{ formatDate(item.endtime) }}
          </span>
        </div>
      </div>

      <van-pagination
        v-if="pageCount > 1"
        v-model="currentPage"
        :page-count="pageCount"
        :prev-text="$t('main.last') || 'Prev'"
        :next-text="$t('main.next') || 'Next'"
        mode="simple"
        class="pagination"
        @change="pageChange"
      />
    </div>

    <!-- Empty State -->
    <div v-else class="empty-state">
      <van-empty :image="emptyImage" description="No withdrawal records yet" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { formatDate } from '@/utils/format-date.js'
import { showSuccessToast, showToast } from 'vant'
import emptyImage from '@/assets/img/empty-image-default.png'

const router = useRouter()
const currentPage = ref(1)
const pageCount = ref(1)
const list = ref([])
const totalDeposit = ref(0)

const getData = () => {
  Request.get({
    url: 'index/ctrl/deposit_admin?page=' + currentPage.value
  }).then(res => {
    if (res && res.data) {
      list.value = res.data.data || []
      pageCount.value = res.data.last_page || 1
      currentPage.value = res.data.current_page || 1
    }
    if (res && res.total_deposit !== undefined) {
      totalDeposit.value = res.total_deposit
    } else {
      totalDeposit.value = list.value.filter(i => i.status === 2).reduce((sum, cur) => sum + Number(cur.num || 0), 0)
    }
  }).catch(err => {
    console.error('Failed to load withdrawal history:', err)
  })
}

const pageChange = () => {
  getData()
}

const copyText = (text) => {
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(text).then(() => {
      showSuccessToast('Order ID copied!')
    }).catch(() => {
      showToast(text)
    })
  } else {
    showToast(text)
  }
}

onMounted(() => {
  getData()
})
</script>

<style lang="less" scoped>
.withdraw-record-page {
  padding: 0 0 70px 0;
  background: #f7f8fa;
  min-height: 100vh;
  font-size: 14px;

  .header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: #fff;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 99;

    .back-btn {
      cursor: pointer;
      margin-right: 15px;
    }

    .title {
      margin: 0;
      font-size: 18px;
      font-weight: 600;
    }
  }

  .summary-card {
    margin: 16px;
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-radius: 12px;
    padding: 20px 24px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 6px 16px rgba(30, 60, 114, 0.25);

    .summary-label {
      font-size: 13px;
      opacity: 0.9;
      margin-bottom: 6px;
    }

    .summary-amount {
      font-size: 26px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }

    .summary-icon {
      background: rgba(255, 255, 255, 0.2);
      width: 54px;
      height: 54px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  }

  .item-list {
    padding: 0 16px;
  }

  .box {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    border: 1px solid #f0f0f0;

    .top-row {
      margin-bottom: 10px;

      .order-id {
        font-size: 13px;
        color: #666;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;

        .copy-icon {
          color: #999;
        }
      }

      .amount-text {
        font-size: 17px;
        font-weight: 700;
        color: #ff5722;
      }
    }

    .mid-row {
      margin-bottom: 10px;
      align-items: center;

      .address-tag {
        background: #f4f6f8;
        color: #555;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        max-width: 170px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
    }

    .bot-row {
      border-top: 1px dashed #f0f0f0;
      padding-top: 8px;
      font-size: 12px;
      color: #999;
    }
  }

  .flex-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .pagination {
    margin-top: 20px;
    margin-bottom: 20px;
  }

  .empty-state {
    padding-top: 40px;
  }
}
</style>
