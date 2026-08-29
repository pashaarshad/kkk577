<!-- Home  -->
<template>
  <div class='Home'>
    <div class='swipe'>
      <van-swipe :autoplay='3000' class='my-swipe' indicator-color='white'>
        <template v-for='item in data.banner'>
          <van-swipe-item>
            <img :src='item.image' alt='' class='swipe-img'>
          </van-swipe-item>
        </template>
      </van-swipe>
    </div>

    <div class='menu'>
      <div v-for='(item, index) in menu' class='menu-list' @click='onMenuClick(item.path)'>
        <div>{{ item.title }}</div>
        <div>
          <img :src='item.icon' alt=''>
        </div>
      </div>
    </div>

    <div class='notice'>
      <div class='notice-icon'>
        <div></div>
      </div>
      <div class='notice-content'>
        <van-notice-bar background='#ffffff' color='#a2a2a2'>
          la información de tu cuenta
        </van-notice-bar>
      </div>
    </div>

    <div v-show='loginShow' class='box'>
      <div class='box-title'>
        <span>{{ $t('home.user.name') }}</span>
        <span>{{ data.user_info?.tel }}</span>
      </div>
      <div class='box-title'>
        <span>{{ $t('home.user.code') }}</span>
        <span>{{ data.user_info?.invite_code }}</span>
      </div>
      <div class='box-mony'>
        <div class='box-mony-list'>
          <span>{{ $t('home.user.balance') }}</span>
          <div>{{ $t('main.money') }} {{ data?.user_info?.balance }}</div>
        </div>
        <div class='box-mony-list'>
          <span>{{ $t('home.user.task') }}</span>
          <div>{{ $t('main.money') }} {{ data?.user_info?.balance }}</div>
        </div>
      </div>
      <div class='line-divider'></div>
      <div class='box-day'>
        <div class='box-day-list'>
          <div>{{ $t('home.user.today') }}</div>
          <div>{{ $t('main.money') }} {{ data?.today_commission }}</div>
        </div>
        <div class='box-day-list'>
          <div>{{ $t('home.user.yesterday') }}</div>
          <div>{{ $t('main.money') }} {{ data?.yestarday_commission }}</div>
        </div>
        <div class='box-day-list'>
          <div>{{ $t('home.user.total') }}</div>
          <div>{{ $t('main.money') }} {{ data?.team_commission }}</div>
        </div>
        <div class='box-day-list'>
          <div>{{ $t('home.user.group') }}</div>
          <div>{{ $t('main.money') }} {{ data?.commission }}</div>
        </div>
      </div>
    </div>

    <Commission :list='data.deposit_list' />

    <div class='quick-entry'>
      <div v-for='item in quickEntries' :key='item.id' class='quick-entry-item' @click='onEntryClick(item.id)'>
        <img :src='item.icon' alt='' class='quick-entry-icon'>
        <div class='quick-entry-title'>{{ item.title }}</div>
      </div>
    </div>

    <div class='partner'>
      <div class='title'>{{ $t('home.partnerTitle') }}</div>
      <div class='partner-list'>
        <div v-for='item in footList' class='partner-item'>
          <img :src='item' alt=''>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { i18n } from '@/lang'
import Commission from '@/components/commission/index.vue'
import { getAssetURL } from '@/utils/get_assets_img.js'
import Request from '@/services/index.js'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const { t } = i18n.global
const router = useRouter()

const menu = [
  {
    title: t('home.recharge'),
    icon: getAssetURL('home/ic_recharge.png'),
    path: '/recharge'
  },
  {
    title: t('home.embody'),
    icon: getAssetURL('home/ic_withdraw.png'),
    path: '/withdraw'
  },
  {
    title: t('home.invite'),
    icon: getAssetURL('home/ic_invite.png'),
    path: '/'
  }
]

const footList = [
  getAssetURL('home/1.png'),
  getAssetURL('home/2.png'),
  getAssetURL('home/3.png'),
  getAssetURL('home/4.png'),
  getAssetURL('home/5.png'),
  getAssetURL('home/6.png')
]

const quickEntries = [
  {
    title: t('home.companyProfile'),
    icon: getAssetURL('home/ic-company.png'),
    id: 12
  },
  {
    title: t('home.ruleDescription'),
    icon: getAssetURL('home/ic-rule.png'),
    id: 13
  },
  {
    title: t('home.agentCooperation'),
    icon: getAssetURL('home/ic-agent.png'),
    id: 14
  },
  {
    title: t('home.companyQualifications'),
    icon: getAssetURL('home/ic-cert.png'),
    id: 15
  }
]

const onEntryClick = (id) => {
  router.push(`/poster/detail/${id}`)
}

const data = ref({})
Request.get({ url: 'index/index/home' }).then(res => {
  data.value = res.data
})

const token = sessionStorage.getItem('token')
const loginShow = ref(false)
if (token) {
  loginShow.value = true
}

const onMenuClick = (path) => {
  router.push(path)
}
</script>

<style lang='less' scoped>
.Home {
  padding-bottom: 60px;
  background: #ffffff;

  .my-swipe .van-swipe-item {
    color: #fff;
    font-size: 20px;
    line-height: 150px;
    text-align: center;
    background-color: #39a9ed;
    height: 243px;
  }

  .swipe-img {
    width: 100%;
    height: 100%;
    object-fit: fill;
  }

  .menu {
    display: flex;
    justify-content: space-between;
    padding: 16px;

    .menu-list {
      flex: 1;
      //position: relative;
      width: 120px;
      //height: 58px;
      font-weight: 700;
      color: #ad4f37;
      border: 0.01rem solid #c28170;
      background: rgba(226, 84, 73, .102);
      border-radius: 3px;
      padding: 10px 10px 10px 10px;
      box-sizing: border-box;
      display: flex;
      font-size: 13px;
      line-height: 1.5;
      flex-direction: column;
      justify-content: space-between;
      flex: 1;
      margin-right: 10px;


      img {
        //position: absolute;
        float: right;
        right: 10px;
        bottom: 10px;
        width: 16px;
        height: 16px;
        object-fit: cover;
      }
    }
  }

  .notice {
    display: flex;
    padding: 0px 16px;

    .notice-icon {
      display: flex;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      background: #000;

      div {
        width: 20px;
        height: 20px;
        background: url("../../assets/img/home/ic_notice.png") no-repeat 100%/cover;
      }
    }

    .notice-content {
      width: 100%;
      border: 1px solid #e0e1e2;
      color: #a2a2a2;

      .van-notice-bar {
        height: 100%;
        color: #a2a2a2;
      }
    }
  }

  .box {
    width: 92%;
    border-radius: 10px;
    padding: 10px 16px 0 16px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, .1);
    overflow: hidden;
    box-sizing: border-box;
    margin: 20px auto;
    font-size: 14px;

    .box-title {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .box-mony {
      display: flex;
      margin-top: 10px;

      .box-mony-list {
        width: 50%;

        span:nth-child(1) {
          font-size: 16.5px;
          height: 25px;
        }

        div:nth-child(2) {
          color: var(--red-color);
          font-weight: 700 !important;
          margin-top: 2px;
          font-size: 16.5px;
        }
      }
    }

    .line-divider {
      position: relative;
      margin-top: 18px;
    }

    .line-divider:before {
      content: "";
      position: absolute;
      top: 50%;
      left: 0;
      width: 100%;
      -webkit-transform: scaleY(.5);
      transform: scaleY(.5);
      border: 1px dashed #e0e1e2;
    }

    .box-day {
      display: flex;
      flex-wrap: wrap;
      margin-top: 40px;

      .box-day-list {
        width: 50%;
        margin-bottom: 15px;

        div:nth-child(1) {
          font-size: 14.5px;
          height: 20px;
        }

        div:nth-child(2) {
          font-weight: 700 !important;
          font-size: 16.5px;
          margin-top: 2px;
        }
      }
    }
  }

  .quick-entry {
    display: flex;
    justify-content: space-between;
    width: 92%;
    margin: 20px auto 10px;

    .quick-entry-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      flex: 1;
      cursor: pointer;

      .quick-entry-icon {
        width: 60px;
        height: 60px;
        object-fit: contain;
      }

      .quick-entry-title {
        margin-top: 8px;
        font-size: 13px;
        color: #333;
        text-align: center;
        line-height: 1.3;
      }
    }
  }

  .title {
    font-size: 22px;
    font-weight: 700 !important;
    margin-bottom: 20px;
    margin-top: 30px;
  }

  .partner {
    width: 92%;
    margin: 10px auto;


    .partner-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;

      .partner-item {
        width: 33%;
        margin-bottom: 40px;
      }

      .partner-item:nth-child(3n+3) {
        flex-basis: 33%;
        align-items: flex-end;

        img {
          float: right !important;
        }
      }

      .partner-item:nth-child(2) {
        img {
          width: 127px;
        }
      }

      img {
        height: 24px;
      }
    }
  }
}
</style>
