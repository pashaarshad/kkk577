<!-- recharge  -->
<template>
  <div class="recharge-page-container">
    <NavBar>
      <template #right>
        <van-icon :name="bill" size="20" @click="toBill" />
      </template>
    </NavBar>

    <div class="recharge">
      <div class="title">{{ $t('recharge.Deposit') || 'Deposit' }}</div>

      <!-- Currency Channel Selector Row -->
      <div class="cell-title">
        <van-cell is-link @click="onVanCell">
          <template #title>
            <div class="cell-div">
              <img :src="coin" alt="Coin">
              <span>{{ activeList?.name || 'Select Currency Channel' }}</span>
            </div>
          </template>
        </van-cell>
      </div>

      <!-- Amount Limit Info -->
      <div class="tip">
        <span>{{ $t('recharge.AmountLimit') || 'Amount limit' }}</span>
        <span>$ {{ list?.money_list?.[0] || 30 }} ~ $ {{ list?.money_list?.[list?.money_list?.length - 1] || 30000 }}</span>
      </div>

      <!-- Amount Input Field -->
      <div class="amount">
        <van-field
          v-model="money"
          type="number"
          :label="$t('recharge.RechargeAmount') || 'Recharge amount'"
          :placeholder="$t('recharge.RechargeAmount') || 'Please enter recharge amount'"
          class="btn"
        >
          <template #right-icon>
            <span>$</span>
          </template>
        </van-field>
      </div>

      <!-- Preset Quick Amount Buttons -->
      <div class="moneyList">
        <div 
          v-for="(item, index) in (list?.money_list || defaultMoneyList)" 
          :key="index"
          :class="{'moneyListActive': money === item}"
          @click="onMoney(item, index)"
        >
          {{ item }}
        </div>
      </div>

      <!-- Coupon / Promo Code Voucher Box -->
      <div v-if="userCouponStatus" class="coupon-box">
        <div class="coupon-header">
          <div class="coupon-title">
            <van-icon name="coupon" class="coupon-icon" />
            <span>{{ $t('recharge.haveCoupon') || 'Have a Promo Code / Coupon?' }}</span>
          </div>
          <span v-if="appliedCoupon" class="coupon-badge-success">
            +${{ appliedCoupon.bonus_value }} bonus applied
          </span>
        </div>
        <div class="coupon-input-row">
          <input 
            v-model="couponCode" 
            type="text" 
            placeholder="Enter promo code (e.g. WELCOME50)" 
            class="coupon-input"
            :disabled="appliedCoupon !== null"
          />
          <button 
            v-if="!appliedCoupon"
            class="apply-btn" 
            :disabled="!couponCode || couponLoading"
            type="button"
            @click="onApplyCoupon"
          >
            {{ couponLoading ? 'Checking...' : 'Apply' }}
          </button>
          <button 
            v-else 
            class="remove-btn" 
            type="button"
            @click="onRemoveCoupon"
          >
            Remove
          </button>
        </div>
        <div v-if="couponMessage" :class="['coupon-msg', couponSuccess ? 'msg-success' : 'msg-error']">
          {{ couponMessage }}
        </div>
      </div>

      <!-- Actual Payment Summary -->
      <div class="tip actual-tip">
        <span>{{ $t('recharge.ActualPayment') || 'Actual payment' }}</span>
        <div class="payment-calc">
          <span v-if="appliedCoupon" class="bonus-tag">Bonus: +${{ appliedCoupon.bonus_value }}</span>
          <span class="actual-val">$ {{ money || 0 }}</span>
        </div>
      </div>

      <!-- Submit Action Button -->
      <div class="action-wrap">
        <button class="submit-action-btn" @click="getPay">
          {{ $t('main.submit') || 'Submit' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import coin from '@/assets/img/mine/COIN.png'
import { ref, computed, onMounted } from 'vue'
import { i18n } from '@/lang/index.js'
import { showNotify, showToast } from 'vant'
import bill from '@/assets/img/mine/bill.png'
import NavBar from '@/components/navbar/index.vue'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'

const { t } = i18n.global
const router = useRouter()
const token = localStorage.getItem('token') || sessionStorage.getItem('token')

if (!token) {
  router.replace('/login')
}

const defaultMoneyList = [30, 50, 100, 300, 500, 1000, 3000, 5000, 10000, 30000]
const money = ref(30)
const activeList = ref({ name: 'USDT / Crypto & Payment Gateways' })

const list = ref({
  money_list: defaultMoneyList,
  pay: []
})

// Coupon / Promo voucher state
const userCouponStatus = ref(true)
const couponCode = ref('')
const appliedCoupon = ref(null)
const couponMessage = ref('')
const couponSuccess = ref(false)
const couponLoading = ref(false)

const onApplyCoupon = async () => {
  if (!couponCode.value.trim()) {
    showToast('Please enter a coupon code')
    return
  }
  couponLoading.value = true
  couponMessage.value = ''
  try {
    const res = await Request.post({
      url: 'index/user/apply_coupon',
      data: {
        code: couponCode.value.trim(),
        recharge_amount: money.value || 30
      }
    })
    if (res && res.code === 0) {
      appliedCoupon.value = res.data
      couponSuccess.value = true
      couponMessage.value = res.info || 'Coupon verified successfully!'
      showToast('Coupon verified successfully!')
    } else {
      appliedCoupon.value = null
      couponSuccess.value = false
      couponMessage.value = (res && res.info) || 'Invalid coupon code'
    }
  } catch (err) {
    couponSuccess.value = false
    couponMessage.value = 'Failed to verify coupon'
  } finally {
    couponLoading.value = false
  }
}

const onRemoveCoupon = () => {
  appliedCoupon.value = null
  couponCode.value = ''
  couponMessage.value = ''
  couponSuccess.value = false
}

const onMoney = (item) => {
  money.value = item
}

const onVanCell = () => {
  router.push({
    path: '/select-currency',
    query: {
      amount: money.value || 30
    }
  })
}

const toBill = () => {
  router.push('/billList')
}

const getPay = () => {
  if (!money.value || Number(money.value) <= 0) {
    showNotify({ type: 'warning', message: t('recharge.RechargeAmount') || 'Please enter recharge amount' })
    return
  }
  router.push({
    path: '/select-currency',
    query: {
      amount: money.value,
      coupon_code: appliedCoupon.value ? appliedCoupon.value.code : ''
    }
  })
}

onMounted(() => {
  Request.get({ url: 'index/ctrl/recharge' }).then(res => {
    if (res && res.data) {
      list.value = res.data
      if (res.data.pay && res.data.pay.length > 0) {
        activeList.value = res.data.pay[0]
      }
    }
  }).catch(err => {
    console.warn('Recharge config fallback loaded:', err)
  })

  // Check coupon module status from user info
  Request.get({ url: 'index/user/info' }).then(res => {
    if (res && res.info && res.info.user_coupon_status !== undefined) {
      userCouponStatus.value = res.info.user_coupon_status
    }
  }).catch(() => {})
})
</script>

<style lang="less" scoped>
.recharge-page-container {
  min-height: 100vh;
  background: #FFF9F8;
}

.recharge {
  min-height: 90vh;
  padding: 16px 16px 40px;
  background: #FFF9F8;

  .title {
    font-weight: 800 !important;
    font-size: 24px;
    color: #1F1A1A;
    margin-bottom: 16px;
  }

  .cell-title {
    margin-bottom: 16px;

    :deep(.van-cell) {
      border-radius: 14px;
      padding: 14px 16px;
      background: #FFFFFF;
      box-shadow: 0 2px 8px rgba(184, 58, 46, 0.06);
      align-items: center;
    }

    .cell-div {
      display: flex;
      align-items: center;
      gap: 10px;

      img {
        width: 28px;
        height: 28px;
        object-fit: contain;
      }

      span {
        font-size: 15px;
        font-weight: 700;
        color: #1F1A1A;
      }
    }
  }

  .tip {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #86909C;
    margin-bottom: 12px;
    padding: 0 4px;

    span:last-child {
      font-weight: 700;
      color: #B83A2E;
    }

    &.actual-tip {
      margin-top: 18px;
      margin-bottom: 24px;
      font-size: 14px;

      .actual-val {
        font-size: 18px;
        font-weight: 800;
        color: #B83A2E;
      }
    }
  }

  .amount {
    margin-bottom: 16px;

    .btn {
      width: 100%;
      background: #FFFFFF;
      border-radius: 14px;
      padding: 14px 16px;
      box-shadow: 0 2px 8px rgba(184, 58, 46, 0.06);

      :deep(.van-field__control) {
        font-size: 18px;
        font-weight: 700;
        color: #B83A2E;
      }

      :deep(.van-field__right-icon) {
        font-size: 18px;
        font-weight: 800;
        color: #B83A2E;
      }
    }
  }

  .moneyList {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 16px;

    div {
      background: #FFFFFF;
      border: 1.5px solid #FDECE8;
      border-radius: 10px;
      padding: 12px 0;
      text-align: center;
      font-size: 15px;
      font-weight: 700;
      color: #1F1A1A;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
      transition: all 0.2s ease;

      &.moneyListActive {
        border-color: #B83A2E;
        background: #FFF0ED;
        color: #B83A2E;
        box-shadow: 0 2px 8px rgba(184, 58, 46, 0.15);
      }
    }
  }

  /* Coupon / Promo Code Voucher Box */
  .coupon-box {
    background: #FFFFFF;
    border: 1.5px solid #fed7aa;
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(234, 88, 12, 0.06);

    .coupon-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;

      .coupon-title {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #1F1A1A;

        .coupon-icon {
          color: #ea580c;
          font-size: 16px;
        }
      }

      .coupon-badge-success {
        background: #ecfdf5;
        color: #059669;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 8px;
        border: 1px solid #a7f3d0;
      }
    }

    .coupon-input-row {
      display: flex;
      gap: 8px;

      .coupon-input {
        flex: 1;
        background: #FFF9F8;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 9px 12px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        outline: none;

        &:focus {
          border-color: #B83A2E;
        }

        &:disabled {
          background: #f1f5f9;
          color: #64748b;
          border-color: #e2e8f0;
        }
      }

      .apply-btn {
        background: linear-gradient(135deg, #B83A2E, #E86C3F);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 0 16px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;

        &:disabled {
          opacity: 0.6;
          cursor: not-allowed;
        }
      }

      .remove-btn {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0 14px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
      }
    }

    .coupon-msg {
      margin-top: 8px;
      font-size: 12px;
      font-weight: 500;

      &.msg-success {
        color: #059669;
      }

      &.msg-error {
        color: #dc2626;
      }
    }
  }

  .payment-calc {
    display: flex;
    align-items: center;
    gap: 8px;

    .bonus-tag {
      font-size: 11.5px;
      color: #059669;
      background: #ecfdf5;
      padding: 2px 6px;
      border-radius: 6px;
      font-weight: 600;
    }
  }

  .action-wrap {
    margin-top: 20px;

    .submit-action-btn {
      width: 100%;
      height: 48px;
      border-radius: 12px;
      background: linear-gradient(135deg, #B83A2E, #E86C3F);
      color: #FFFFFF;
      font-size: 16px;
      font-weight: 700;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(184, 58, 46, 0.25);
      transition: transform 0.1s ease;

      &:active {
        transform: scale(0.98);
      }
    }
  }
}
</style>
