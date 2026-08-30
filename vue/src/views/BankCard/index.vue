<!-- withdraw  -->
<template>
  <div v-if='!show' class='withdraw'>
    <van-empty :description='$t("withdraw.NoMoreData")' />
    <van-button class='item-btn' plain type='warning' @click='showBottom = true'>
      {{ $t('withdraw.AddAccount') }}
    </van-button>
    <van-popup
      v-model:show='showBottom'
      :style="{ height: '75%' }"
      position='bottom'
    >
      <div class='popup-div'>
        <!--        <div class='popup-div-list'>-->
        <!--          <div class='popup-div-list-title'>{{ $t('withdraw.CardMumberType') }}</div>-->
        <!--          <div class='popup-div-list-right'>-->
        <!--            <van-radio-group v-model='checked'>-->
        <!--              <van-radio icon-size='14' name='1'>cuenta de ahorro</van-radio>-->
        <!--              <van-radio icon-size='14' name='2'>Cuenta Monetaria</van-radio>-->
        <!--            </van-radio-group>-->
        <!--          </div>-->
        <!--        </div>-->
        <div class='popup-div-list'>
          <div class='popup-div-list-title'>{{ $t('withdraw.AccountOpeningName') }}</div>
          <div class='popup-div-list-right'>
            <van-field v-model='username' :placeholder="$t('withdraw.AccountOpeningNameTitle')" />
          </div>
        </div>
        <!--        <div class='popup-div-list'>-->
        <!--          <div class='popup-div-list-title'>{{ $t('withdraw.PhoneNumber') }}</div>-->
        <!--          <div class='popup-div-list-right'>-->
        <!--            <van-field v-model='value' :placeholder="$t('withdraw.PhoneNumberTitle')" />-->
        <!--          </div>-->
        <!--        </div>-->
        <div class='popup-div-list'>
          <div class='popup-div-list-title'>{{ $t('withdraw.identity') }}</div>
          <div class='popup-div-list-right'>
            <van-field v-model='id_number' :placeholder="$t('withdraw.identityTitle')" />
          </div>
        </div>
        <div class='popup-div-list'>
          <div class='popup-div-list-title'>{{ $t('withdraw.BankName') }}</div>
          <div class='popup-div-list-right'>
            <van-field v-model='bank_name' :placeholder="$t('withdraw.BankNameTitle')" @focus='showBankName' />
          </div>
        </div>
        <div class='popup-div-list'>
          <div class='popup-div-list-title'>{{ $t('withdraw.BankAccount') }}</div>
          <div class='popup-div-list-right'>
            <van-field v-model='bank_num' :placeholder="$t('withdraw.BankAccountTitle')" />
          </div>
        </div>
        <div class='popup-div-list'>
          <div class='popup-div-list-title'>{{ $t('withdraw.WithdrawalPassword') }}</div>
          <div class='popup-div-list-right'>
            <van-field v-model='paypassword' :placeholder="$t('withdraw.WithdrawalPasswordTitle')" type='password' />
          </div>
        </div>
        <van-button class='item-btn' plain type='warning' @click='submit'>
          {{ $t('main.submit') }}
        </van-button>
      </div>
    </van-popup>
  </div>
  <div v-if='show' class='withdraw'>
    <div class='withdraw-title'>取款</div>
    <div>
      <!--      <van-field v-model='value' is-link label='文本' placeholder='请输入用户名' @click='showPopup' />-->
    </div>
  </div>
  <van-popup v-model:show='bankShow' position='bottom' round>
    <van-picker
      :columns='bankList'
      @cancel='bankShow = false'
      @confirm='bankClick'
    />
  </van-popup>
</template>

<script setup>

import { ref } from 'vue'
import { i18n } from '@/lang/index.js'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { showSuccessToast } from 'vant'

const router = useRouter()
const show = ref(false)
const showBottom = ref(false)
const { t } = i18n.global

const bank_code = ref()
const bank_name = ref()

const bank_num = ref('')
const username = ref('')
const id_number = ref('')
const paypassword = ref('')


const bankShow = ref(false)
const showBankName = () => {
  bankShow.value = true
}

const bankList = ref([])
Request.get({ url: 'index/my/bank_list' }).then(res => {
  for (const i in res.data) {
    bankList.value.push({ text: res.data[i], value: i })
  }
})

const bankClick = (val) => {
  bank_code.value = val.selectedValues[0]
  bank_name.value = val.selectedOptions[0].text
  bankShow.value = false
  console.log(val)
}

const submit = () => {
  let param = new FormData()
  param.append('bank_code', bank_code.value)
  param.append('username', username.value)
  param.append('id_number', id_number.value)
  param.append('paypassword', paypassword.value)

  Request.post({ url: 'index/my/bind_bank', data: param }).then(res => {
    showSuccessToast(res.info)
    router.go(-1)
  })
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
    font-weight: 700 !important;
    margin-top: 20px;
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
}
</style>
