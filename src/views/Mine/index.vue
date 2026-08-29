<!-- Mine  -->
<template>
  <div class='Mine'>
    <div class='top'>
      <img alt='' class='photo' src='../../assets/img/mine/photo.png'>
      <div class='top-list'>
        <div>
          <div>{{ data.tel }}</div>
          <div class='vip'>{{ data.level_name }}</div>
        </div>
        <div class='top-list-bottom'>
          <span>{{ $t('mine.InvitationCode') }}：{{ data.invite_code }}</span>
          <img alt='' src='../../assets/img/mine/ic_gift.png'>
        </div>
      </div>
      <div class='credit-score'>
        <div class='credit-score-circle'>
          <div>{{ $t('mine.CreditScore') }}</div>
          <div>{{ data.credit_score }}</div>
        </div>
      </div>
    </div>

    <div class='bg-grey'>
      <div class='grey-list'>
        <span>{{ $t('mine.AccountBalance') }}</span>
        <div>
          <span>Q</span>
          <span class='mony'>{{ data.balance }}</span>
        </div>
      </div>
      <div class='grey-content'>
        <div>
          <span>{{ $t('mine.AvailableBalance') }}</span>
          <span class='money'>{{ $t('main.money') }} {{ data.balance }}</span>
        </div>
        <div>
          <span>{{ $t('mine.FrozenAmount') }}</span>
          <span class='money'>{{ $t('main.money') }} {{ data.freeze_balance }}</span>
        </div>
      </div>
    </div>

    <div class='nav'>
      <template v-for='item in navList'>
        <van-cell is-link @click='toViews(item.path)'>
          <template #title>
            <div class='nav-title'>
              <van-icon :name='item.icon' size='22' />
              <span class='custom-title'>{{ item.title }}</span>
            </div>
          </template>
        </van-cell>
      </template>
    </div>

    <div class='btn'>
      <van-button
        class='save-btn' type='primary' @click='goBack'>
        {{ $t('mine.signOut') }}
      </van-button>
    </div>

    <div class='foot'>
      <span>Copyright ©2011-2024</span>
      <span>marketing de mercado Pictures All Rights Reserved</span>
    </div>
  </div>
</template>

<script setup>
import { i18n } from '@/lang/index.js'
import { useRouter } from 'vue-router'
import { getAssetURL } from '@/utils/get_assets_img.js'
import Request from '@/services/index.js'
import { ref } from 'vue'
import { useMitt } from '@/utils/mitt.js'

const { t } = i18n.global
const navList = [
  {
    path: '/withdraw',
    icon: getAssetURL('mine/withdraw.png'),
    title: t('mine.Withdraw')
  },
  {
    path: '/team',
    icon: getAssetURL('mine/team.png'),
    title: t('mine.TeamReports')
  },
  {
    path: '/withdrawRecord',
    icon: getAssetURL('mine/withdraw_bill.png'),
    title: t('mine.WithdrawalsRecord')
  },
  {
    path: '/billList',
    icon: getAssetURL('mine/bill.png'),
    title: t('mine.AccountChangeRecords')
  },
  {
    path: '/information',
    icon: getAssetURL('mine/card.png'),
    title: t('mine.WithdrawalInformation')
  },
  {
    path: '/password',
    icon: 'setting-o',
    title: t('mine.ChangePassword')
  },
  {
    path: '/message',
    icon: getAssetURL('mine/message.png'),
    title: t('mine.Announcement')
  }
]

const router = useRouter()

const toViews = (path) => {
  router.push(path)
}

const data = ref({})
Request.get({ url: 'index/user/info' }).then(res => {
  data.value = res.info
})

const mitt = useMitt()
const goBack = () => {
  sessionStorage.clear()
  Request.get({ url: 'index/user/logout' }).then(res => {
    router.replace('/home')
    mitt.emit('goBack')
  })
}
</script>

<style lang='less' scoped>
.Mine {
  background: var(--bg-second-color);
  font-size: 13.2px;
  padding: 20px 0 80px 0;

  .top {
    padding: 16.5px;
    display: flex;
    justify-content: space-between;
    align-items: center;

    .credit-score {
      margin-left: auto;

      .credit-score-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 2px solid var(--main-color);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 13px;
        color: var(--default-color);
        line-height: 1.2;
        text-align: center;
        box-sizing: border-box;
        padding: 5px;
      }
    }

    .photo {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }

    .top-list {
      margin-left: 10px;

      .vip {
        padding: 0px 6px;
        height: 20px;
        color: #000000;
        background: var(--main-color);
        margin-left: 8px;
        text-align: center;
        border-radius: 4px;
        font-weight: 750;
      }

      div {
        display: flex;
        align-items: center;
      }

      .top-list-bottom {
        color: var(--gray-light-color);
        margin-top: 10px;

        img {
          width: 16px;
          height: 16px;
          margin-left: 10px;
        }
      }
    }
  }

  .bg-grey {
    width: 92%;
    margin: 0 auto 20px;
    border-radius: 12px;
    padding: 20px 16.5px;
    background: var(--bg-color);
    border: 1px solid var(--second-color);
    box-sizing: border-box;

    .grey-list {
      display: flex;
      justify-content: space-between;
      align-items: center;

      div {
        font-size: 22px;
        font-weight: 700 !important;
      }
    }

    .mony {
      color: var(--main-color);

    }
  }

  .grey-content {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;

    div {
      width: 50%
    }

    div:nth-child(1) {
      position: relative;
      display: flex;
      flex-direction: column;
    }

    div:nth-child(2):before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      padding-top: 20%;
      margin-top: 5%;
      border-left: 1px solid #d6d7d9;
      -webkit-transform: scaleX(.5);
      transform: scaleX(.5);
    }

    div:nth-child(2) {
      position: relative;
      display: flex;
      justify-content: center;
      flex-direction: column;
      text-align: center;
    }

    .money {
      font-weight: 700 !important;
      margin-top: 10px;
    }
  }

  .nav {
    padding: 0 16.5px;

    .nav-title {
      display: flex;
      align-items: center;
      color: var(--default-color);
      font-size: 14px;
      line-height: 24px;

      span {
        margin-left: 12px;
      }
    }

    :deep(.van-cell) {
      padding: 22px 0;
    }
  }

  .btn {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 10px;

    .save-btn {
      width: 120px;
      color: var(--main-color);
      background: none;
      border: 1px solid var(--main-color);

    }
  }

  .foot {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    padding: 33px 0;
  }

}
</style>
