<!-- withdraw  -->
<template>
  <NavBar>
    <template #right>
      <van-icon :name='bill' size='20' @click='toBill' />
    </template>
  </NavBar>
  <div v-if='!show' class='withdraw'>
    <van-empty :description='$t("withdraw.NoMoreData")' />
    <van-button class='item-btn' plain type='warning' @click='showBottom = true'>
      {{ $t('withdraw.AddAccount') }}
    </van-button>
  </div>
  <div v-if='show' class='withdraw'>
    <div class='withdraw-title'>{{ $t('withdraw.WithdrawMoney') }}</div>
    <div>
      <div class='btns'>
        <van-field
          v-model='bankinfo.title'
          :label="$t('withdraw.WithdrawalAccount')"
          :name="$t('withdraw.WithdrawalAccount')"
          :placeholder="$t('withdraw.WithdrawalAccount')"
          :rules="[{ required: true, message: $t('withdraw.WithdrawalAccount') }]"
          class='btn'
          is-link
          readonly @click='onVanCell'
        />
        <van-field
          v-model='amount'
          :label="$t('withdraw.WithdrawalAmount')"
          :name="$t('withdraw.WithdrawalAmount')"
          :placeholder="$t('withdraw.WithdrawalAmount')"
          :rules="[{ required: true, message: $t('withdraw.WithdrawalAmount') }]"
          class='btn'
        />
        <van-field
          v-model='password'
          :label="$t('withdraw.WithdrawalPassword')"
          :name="$t('withdraw.WithdrawalPassword')"
          :placeholder="$t('withdraw.WithdrawalPassword')"
          :rules="[{ required: true, message: $t('withdraw.WithdrawalPassword') }]"
          class='btn'
          type='password'
        />

      </div>
      <van-button class='item-btn' plain type='warning' @click='submit'>
        {{ $t('main.submit') }}
      </van-button>
      <div style='margin-top: 20px'>
        <div class='footer'>
          <span>{{ $t('withdraw.HandlingFee') }}</span>
          <span>{{ $t('main.money') }} {{ Number(amount) }} (10%) </span>
        </div>
        <div class='footer'>
          <span>{{ $t('withdraw.ActualArrival') }}</span>
          <span>{{ $t('main.money') }} {{ (Number(amount) * 0.9).toFixed(0) }}</span>
        </div>
      </div>
    </div>
  </div>

  <van-popup
    v-model:show='vanCellShow'
    :style="{ height: '50%' }"
    position='bottom'
  >
    <div class='popup'>
      <div class='popup-title'>{{ $t('recharge.SelectChannel') }}</div>
      <div class='popup-list'>
        <template v-for='(item, index) in list'>
          <div :class='{"popupActive": popupIndex === index}' @click='onPopupClick(item,index)'>
            <span>{{ item.title }}</span>
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
</template>

<script setup>

import { ref } from 'vue'
import { showConfirmDialog, showSuccessToast } from 'vant'
import { i18n } from '@/lang/index.js'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import NavBar from '@/components/navbar/index.vue'
import bill from '@/assets/img/mine/bill.png'

const router = useRouter()
const show = ref(false)
const showBottom = ref(false)
const { t } = i18n.global

const dialogClick = () => {
  showConfirmDialog({
    message: t('withdraw.title'),
    confirmButtonText: t('withdraw.Cancel'),
    cancelButtonText: t('withdraw.Confirm'),
    confirmButtonColor: '#ad4f37'
  })
    .then(() => {
      router.push('/bankCard')
    })
    .catch(() => {
      router.go(-1)
    })
}

const showPicker = ref(false)
const showBankName = () => {
  showPicker.value = true
}

const bankinfo = ref([])
const list = ref([])
Request.get({ url: 'index/ctrl/bankinfo' }).then(res => {
  list.value = res.data.map(item => {
    item.title = '(' + item.bankname + ')' + '      ' + item.cardnum
    return item
  })
  bankinfo.value = list.value[0]

  if (res.data[0] !== null) {
    show.value = true
  } else {
    dialogClick()
  }
})


const amount = ref(0)
const password = ref()

const submit = () => {
  let param = new FormData()
  param.append('num', amount.value)
  param.append('paypassword', password.value)

  Request.post({ url: 'index/ctrl/do_deposit', data: param }).then(res => {
    showSuccessToast(res.info)
  })
}

const toBill = () => {
  router.push('/withdrawRecord')
}

const vanCellShow = ref(false)
const popupIndex = ref(0)
const onVanCell = () => {
  vanCellShow.value = true
}

const onPopupClick = (item, index) => {
  popupIndex.value = index
  bankinfo.value = item
  vanCellShow.value = false
}
</script>

<style lang='less' scoped>
.withdraw {
  width: 100%;
  height: 94vh;
  padding: 0 16px;
  box-sizing: border-box;

  .withdraw-title {
    color: var(--main-color);
    font-size: 22px;
    font-weight: 700 !important;
    margin-top: 30px;
  }

  .popup-div {
    padding: 20px;
    font-size: 14px;
    color: #646566;

    .popup-div-list {
      background: #f7f8fa;
      color: #a2a2a2;
      padding: 17px;
      margin-bottom: 22px;
      border-radius: 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;

      .popup-div-list-title {
        width: 90px;
      }

      .popup-div-list-right {
        flex: 1;
        margin-left: 10px;
      }

      .van-cell {
        background: transparent;
      }
    }
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

  .btns {
    width: 100%;
    margin: 20px auto;
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

  .footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13.2px;
    margin-top: 12px;

    span:nth-child(1) {
      color: #c8c8c8;
    }

    span:nth-child(2) {
      color: var(--main-color);
    }
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
