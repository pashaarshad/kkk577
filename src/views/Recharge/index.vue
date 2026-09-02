<!-- recharge  -->
<template>
  <NavBar>
    <template #right>
      <van-icon :name='bill' size='20' @click='toBill' />
    </template>
  </NavBar>
  <div class='recharge'>
    <div class='title'>{{ $t('recharge.Deposit') }}</div>
    <div class='cell-title'>
      <van-cell is-link @click='onVanCell'>
        <!-- 使用 title 插槽来自定义标题 -->
        <template #title>
          <div class='cell-div'>
            <img :src='coin' alt=''>
            <span>{{ activeList.name }}</span>
          </div>
        </template>
      </van-cell>
    </div>
    <div class='tip'>
      <span>{{ $t('recharge.AmountLimit') }}</span>
      <span>{{ $t('main.money') }} {{ list.money_list[0] }} ~ {{ $t('main.money') }} {{ list.money_list[list.money_list.length - 1] }} </span>
    </div>
    <div v-show='!popupShow' class='inputList'>
      <van-field
        v-model='form.beneficiary'
        :label="$t('recharge.BeneficiaryBank')"
        :name="$t('recharge.BeneficiaryBank')"
        :placeholder="$t('recharge.BeneficiaryBank')"
        :rules="[{ required: true, message: $t('recharge.BeneficiaryBank') }]"
        class='btn'
        right-icon='newspaper-o'
        @click-right-icon="clickRightIcon($t('recharge.BeneficiaryBank'))"
      />
      <van-field
        v-model='form.paymentAccountNumber'
        :label="$t('recharge.PaymentAccountNumber')"
        :name="$t('recharge.PaymentAccountNumber')"
        :placeholder="$t('recharge.PaymentAccountNumber')"
        :rules="[{ required: true, message: $t('recharge.PaymentAccountNumber') }]"
        class='btn'
        right-icon='newspaper-o'
        @click-right-icon="clickRightIcon($t('recharge.PaymentAccountNumber'))"
      />
      <van-field
        v-model='form.paymentBank'
        :label="$t('recharge.PaymentBank')"
        :name="$t('recharge.PaymentBank')"
        :placeholder="$t('recharge.PaymentBank')"
        :rules="[{ required: true, message: $t('recharge.PaymentBank') }]"
        class='btn'
      />
      <van-field
        v-model='form.payer'
        :label="$t('recharge.Payer')"
        :name="$t('recharge.Payer')"
        :placeholder="$t('recharge.Payer')"
        :rules="[{ required: true, message: $t('recharge.Payer') }]"
        class='btn'
      />
      <van-field
        v-model='form.paymentAccount'
        :label="$t('recharge.PaymentAccount')"
        :name="$t('recharge.PaymentAccount')"
        :placeholder="$t('recharge.PaymentAccount')"
        :rules="[{ required: true, message: $t('recharge.PaymentAccount') }]"
        class='btn'
      />
    </div>
    <div class='amount'>
      <van-field
        v-model='money'
        :label="$t('recharge.RechargeAmount')"
        :name="$t('recharge.RechargeAmount')"
        :placeholder="$t('recharge.RechargeAmount')"
        :rules="[{ required: true, message: $t('recharge.RechargeAmount') }]"
        class='btn'
      >
        <template #right-icon>
          <span>{{ $t('main.money') }}</span>
        </template>
      </van-field>
    </div>
    <div class='moneyList'>
      <div v-for='(item, index) in list?.money_list' :class='{"moneyListActive": moneyIndex === index }'
           @click='onMoney(item,index)'>
        {{ item }}
      </div>
    </div>
    <div class='tip'>
      <span>{{ $t('recharge.ActualPayment') }}</span>
      <span>{{ $t('main.money') }} {{ money }} </span>
    </div>
    <div>
      <van-button class='item-btn' plain type='warning' @click='getPay'>
        {{ $t('main.submit') }}
      </van-button>
    </div>
  </div>

  <div>
    <van-popup
      v-model:show='showBottom'
      :style="{ height: '30%' }"
      position='bottom'
    >
      <div class='popup'>
        <div class='popup-title'>{{ $t('recharge.SelectChannel') }}</div>
        <div class='popup-list'>
          <template v-for='(item, index) in list?.pay'>
            <div :class='{"popupActive": popupIndex === index}' @click='onPopupClick(item,index)'>
              <img :src='coin' alt=''>
              <span>{{ item.name }}</span>
            </div>
          </template>
          <!--          <div :class='{"popupActive": popupShow}' @click='onPopupClick(true, $t("recharge.VodafoneCash"))'>-->
          <!--            <img :src='coin' alt=''>-->
          <!--            <span>{{ $t('recharge.VodafoneCash') }}</span>-->
          <!--          </div>-->
          <!--          <div :class='{"popupActive": !popupShow}' @click='onPopupClick(false, $t("recharge.Vodafone"))'>-->
          <!--            <img :src='coin' alt=''>-->
          <!--            <span>{{ $t('recharge.Vodafone') }}</span>-->
          <!--          </div>-->
        </div>
      </div>
    </van-popup>
  </div>
</template>

<script setup>
import coin from '@/assets/img/mine/COIN.png'
import { ref } from 'vue'
import { i18n } from '@/lang/index.js'
import { showNotify } from 'vant'
import bill from '@/assets/img/mine/bill.png'
import NavBar from '@/components/navbar/index.vue'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { baseURL } from '@/services/config.js'

const { t } = i18n.global
const router = useRouter()

const money = ref(0)
const showBottom = ref(false)
const popupShow = ref(true)
const popupIndex = ref(0)

const activeList = ref([])

const title = ref(t('recharge.VodafoneCash'))
const form = ref({
  beneficiary: '',
  paymentAccountNumber: '',
  paymentBank: '',
  payer: '',
  paymentAccount: ''
})

const moneyList = [100, 200, 500, 1000, 2000, 5000, 10000, 20000, 30000]
const moneyIndex = ref()

const onMoney = (item, index) => {
  money.value = item
  moneyIndex.value = index
}

const onVanCell = () => {
  showBottom.value = true
}

const onPopupClick = (item, index) => {
  popupIndex.value = index
  activeList.value = item
}

const clickRightIcon = (text) => {
  navigator.clipboard.writeText(text)
  showNotify({ type: 'success', message: t('recharge.copy_success') })
}

const toBill = () => {
  router.push('/billList')
}

const list = ref()
Request.get({ url: 'index/ctrl/recharge' }).then(res => {
  list.value = res.data
  activeList.value = res.data.pay[0]
})

const getPay = () => {
  let param = new FormData()
  param.append('price', money.value)
  param.append('type', activeList.value.name2)
  Request.post({ url: 'index/ctrl/recharge_do_before', data: param }).then(res => {
    if (res.code === 0) {
      getQeapay(res.info.num)
    }
  })
}

const getQeapay = (num) => {
  if (!money.value || money.value <= 0) {
    showNotify({ type: 'warning', message: t('recharge.RechargeAmount') })
    return
  }

  const endpoint = activeList.value.url + `?num=${money.value}&type=${activeList.value.type}&id=${activeList.value.id}`
  Request.get({ url: endpoint }).then(res => {
    if (res && res.data && res.data.payInfo && res.data.payInfo.startsWith('http')) {
      window.location.href = res.data.payInfo
    } else {
      router.push({
        path: '/recharge-detail',
        query: {
          id: activeList.value.id,
          amount: money.value,
          sn: res?.data?.sn || ''
        }
      })
    }
  }).catch(() => {
    router.push({
      path: '/recharge-detail',
      query: {
        id: activeList.value.id,
        amount: money.value
      }
    })
  })
}
</script>

<style lang='less' scoped>
.recharge {
  min-height: 90vh;
  padding: 20px 16px 40px 16px;
  background: #FFFFFF;

  .title {
    font-weight: 700 !important;
    font-size: 22px;
  }

  .btn {
    width: 100%;
    background: #f7f8fa;
    border-radius: 30px;

    padding: 16px !important;
    margin-bottom: 20px;

    :deep(.van-cell) {
      padding: 20px !important;
    }

    :deep(.van-field__control) {
      color: var(--main-color);
    }

  }

  .cell-title {
    :deep(.van-cell) {
      background: #f7f8fa;
      padding: 16px;
      margin-bottom: 22px;
      border-radius: 30px;
      margin-top: 20px;
    }
  }

  .cell-div {
    display: flex;
    align-items: center;

    img {
      width: 24px;
      height: 24px;
    }

    span {
      margin-left: 10px;
      color: #a2a2a2;
    }
  }

  .tip {
    display: flex;
    justify-content: space-between;
    font-size: 13.2px;
    margin: 15px 0;

    span:nth-child(1) {
      color: #c8c8c8;
    }

    span:nth-child(2) {
      color: var(--main-color);
    }
  }

  .btn {
    width: 100%;
    background: #f7f8fa;
    border-radius: 30px;

    padding: 16px !important;
    margin-bottom: 20px;

    :deep(.van-cell) {
      padding: 20px !important;
    }

    :deep(.van-field__control) {
      color: var(--main-color);
    }

  }

  .moneyList {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(30%, 1fr));
    grid-gap: 10px;
    background: #FFFFFF;

    div {
      color: var(--main-color);
      background: none;
      border: 1px solid var(--main-color);
      text-align: center;
      height: 32px;
      line-height: 32px;
      font-size: 13.2px;
    }
  }

  .moneyListActive {
    background: var(--second-color) !important;
  }

  .item-btn {
    font-size: 12px;
    width: 100%;
    height: 44px;
    border-radius: 15px;
    background-color: var(--second-color);
    border: 0.05px solid var(--main-color);
    color: var(--main-color);
    margin-top: 15px;
  }
}

.popup {

  .popup-title {
    padding: 20px 16px;
    color: #969799;
    font-size: 14px;
    line-height: 30px;
    text-align: center;
    border-bottom: 1px solid #ebedf0;
  }

  .popup-list {
    padding: 0 16px;
    font-size: 13.2px;

    div {
      display: flex;
      align-items: center;
      padding: 22px;
      //color: var(--main-color);
      border: 1px solid transparent;
      border-radius: 15px;
      margin-top: 15px;
    }

    img {
      width: 24px;
      height: 24px;
    }

    span {
      margin-left: 10px;
    }
  }

  .popupActive {
    color: var(--main-color);
    border: 1px solid var(--main-color) !important;
  }
}
</style>
