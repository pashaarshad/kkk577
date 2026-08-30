<!-- information  -->
<template>
  <div class='information'>
    <div class='title'>{{ $t('information.WithdrawalAccount') }}</div>
    <template v-for='item in bankinfo'>
      <div class='card'>
        <div>
          <span>{{ $t('information.CardNumberType') }}:</span>
          <span class='card-right'>{{ item?.cardnum }}</span>
        </div>
        <div>
          <span>{{ $t('information.AccountOpeningName') }}:</span>
          <span class='card-right'>{{ item?.username }}</span>
        </div>
        <div>
          <span>{{ $t('information.WalletAddress') }}:</span>
          <span class='card-right'>{{ item?.uid }}</span>
        </div>
        <div>
          <span>{{ $t('information.WalletAddress') }}:</span>
          <span class='card-right'>{{ item?.uid }}</span>
        </div>
      </div>
    </template>
    <van-button class='item-btn' plain type='warning' @click='showBottom = true'>
      {{ $t('withdraw.AddAccount') }}
    </van-button>
  </div>

  <van-popup
    v-model:show='showBottom'
    :style="{ height: '70%' }"
    position='bottom'
  >
    <!--    <div class='popup'>-->
    <!--      <van-field-->
    <!--        v-model='form.accountOpeningName'-->
    <!--        :label="$t('withdraw.AccountOpeningName')"-->
    <!--        :name="$t('withdraw.AccountOpeningName')"-->
    <!--        :placeholder="$t('withdraw.AccountOpeningNameTitle')"-->
    <!--        :rules="[{ required: true, message: $t('withdraw.AccountOpeningNameTitle') }]"-->
    <!--        class='btn'-->
    <!--      />-->
    <!--      <van-field-->
    <!--        v-model='form.vodafone'-->
    <!--        :label="$t('recharge.Vodafone')"-->
    <!--        :name="$t('recharge.Vodafone')"-->
    <!--        :placeholder="$t('recharge.Vodafone')"-->
    <!--        :rules="[{ required: true, message: $t('recharge.Vodafone') }]"-->
    <!--        class='btn'-->
    <!--      />-->
    <!--      <van-field-->
    <!--        v-model='form.WithdrawalPassword'-->
    <!--        :label="$t('withdraw.WithdrawalPassword')"-->
    <!--        :name="$t('withdraw.WithdrawalPassword')"-->
    <!--        :placeholder="$t('withdraw.WithdrawalPasswordTitle')"-->
    <!--        :rules="[{ required: true, message: $t('withdraw.WithdrawalPasswordTitle') }]"-->
    <!--        class='btn'-->
    <!--      />-->
    <!--      <van-field-->
    <!--        v-model='form.bank_name'-->
    <!--        :label="$t('withdraw.BankName')"-->
    <!--        :name="$t('withdraw.BankName')"-->
    <!--        :placeholder="$t('withdraw.BankNameTitle')"-->
    <!--        class='btn'-->
    <!--        @focus='showBankNames'-->
    <!--      />-->
    <!--      <van-button class='item-btn' plain type='warning' @click='submit'>-->
    <!--        {{ $t('main.submit') }}-->
    <!--      </van-button>-->
    <!--    </div>-->
    <div class='popup-div'>
      <div class='popup-div-list'>
        <div class='popup-div-list-title'>{{ $t('withdraw.AccountOpeningName') }}</div>
        <div class='popup-div-list-right'>
          <van-field v-model='username' :placeholder="$t('withdraw.AccountOpeningNameTitle')" />
        </div>
      </div>
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
import Request from '@/services/index.js'
import { useRouter } from 'vue-router'
import { showSuccessToast } from 'vant'

const showBottom = ref(false)
const form = ref({
  accountOpeningName: '',
  Vodafone: '',
  WithdrawalPassword: '',
  bank_name: '',
  bank_code: ''
})

const bankShow = ref(false)
const bankList = ref([])
Request.get({ url: 'index/my/bank_list' }).then(res => {
  for (const i in res.data) {
    bankList.value.push({ text: res.data[i], value: i })
  }
})

const showBankName = () => {
  bankShow.value = true
}

const bankClick = (val) => {
  bank_code.value = val.selectedValues[0]
  bank_name.value = val.selectedOptions[0].text
  bankShow.value = false
}


const bankinfo = ref([])
const getBankinfo = () => {
  Request.get({ url: 'index/ctrl/bankinfo' }).then(res => {
    bankinfo.value = res.data
  })
}

const router = useRouter()

const bank_code = ref()
const bank_name = ref()

const bank_num = ref('')
const username = ref('')
const id_number = ref('')
const paypassword = ref('')
const submit = () => {
  let param = new FormData()
  param.append('bank_code', bank_code.value)
  param.append('username', username.value)
  param.append('id_number', id_number.value)
  param.append('paypassword', paypassword.value)

  Request.post({ url: 'index/my/bind_bank', data: param }).then(res => {
    showSuccessToast(res.info)
    getBankinfo()
    showBottom.value = false
  })
}

getBankinfo()
</script>

<style lang='less' scoped>
.information {
  min-height: 90vh;
  padding: 0 16px;

  .title {
    font-size: 20px;
    margin: 20px 0;
  }

  .card {
    width: 100%;
    border-radius: 8px;
    padding: 16px;
    -webkit-box-shadow: 0 0 9px 0 rgba(0, 0, 0, .1);
    box-shadow: 0 0 9px 0 rgba(0, 0, 0, .1);
    overflow: hidden;
    box-sizing: border-box;
    font-size: 13.2px;
    margin-top: 5px;

    div {
      margin-bottom: 5px;
    }

    .card-right {
      margin-left: 5px;
    }
  }

}

.popup {
  padding: 22px;
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
  border-radius: 19px;
  background-color: var(--second-color);
  border: 0.05px solid var(--main-color);
  color: var(--main-color);
  margin-top: 15px;
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
</style>
