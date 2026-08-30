<!-- Home  -->
<template>
  <div class="Home">
    <!-- Scrolling Notice -->
    <div class="notice">
      <span class="notice-icon">♧</span>
      <div class="notice-text">
        <van-notice-bar background="transparent" color="#d7d7d7">
          Telegram customer service 1: @hykafa1 Telegram customer service 2: @hykafa2
        </van-notice-bar>
      </div>
    </div>

    <!-- PROFILE / QUICK ACTION CARD -->
    <section v-show="loginShow" class="main-card">
      <div class="phone-row">{{ data.user_info?.tel }}</div>

      <!-- BALANCE -->
      <div class="balance">
        <span>Balance</span>
        <strong>$ {{ data.user_info?.balance || '0' }}</strong>
      </div>

      <!-- ACTIONS -->
      <div class="actions">
        <a class="action" @click="onMenuClick('/recharge')">
          <div class="action-icon">
            <svg viewBox="0 0 24 24"><rect x="5" y="7" width="14" height="13" rx="2"></rect><path d="M8 7V5a4 4 0 0 1 8 0v2"></path><path d="M12 11v5"></path><path d="M10 13h4"></path></svg>
          </div>
          <span>Recharge</span>
        </a>

        <a class="action" @click="onMenuClick('/withdraw')">
          <div class="action-icon">
            <svg viewBox="0 0 24 24"><rect x="4" y="6" width="11" height="12" rx="2"></rect><path d="M14 10h6v8a2 2 0 0 1-2 2h-7"></path><path d="M11 9l3 3-3 3"></path></svg>
          </div>
          <span>Withdraw</span>
        </a>

        <a class="action" @click="onMenuClick('/poster/detail/12')">
          <div class="action-icon">
            <svg viewBox="0 0 24 24"><path d="M6 4h9l3 3v13H6z"></path><path d="M15 4v4h4"></path><path d="M9 12h6"></path><path d="M9 16h5"></path></svg>
          </div>
          <span>Company Profile</span>
        </a>

        <a class="action" @click="onMenuClick('/poster/detail/13')">
          <div class="action-icon">
            <svg viewBox="0 0 24 24"><rect x="4" y="6" width="10" height="12" rx="2"></rect><path d="M14 10h6v8a2 2 0 0 1-2 2h-7"></path><path d="M11 9l3 3-3 3"></path></svg>
          </div>
          <span>Invite Friends</span>
        </a>

        <a class="action" @click="onMenuClick('/poster/detail/14')">
          <div class="action-icon">
            <svg viewBox="0 0 24 24"><path d="M5 5h10l4 4v10H5z"></path><path d="M15 5v4h4"></path><path d="M8 12h2"></path><path d="M12 12h4"></path><path d="M8 16h2"></path><path d="M12 16h4"></path></svg>
          </div>
          <span>Agency Cooperation</span>
        </a>
      </div>
    </section>

    <!-- BANNER IMAGES (carousel) -->
    <section class="banners">
      <van-swipe :autoplay="3000" class="banner-swipe" indicator-color="white">
        <van-swipe-item v-for="item in data.banner" :key="item.id">
          <div class="banner">
            <img :src="item.image" alt="Banner">
          </div>
        </van-swipe-item>
      </van-swipe>
    </section>

    <!-- Activities / Orders -->
    <Commission :list="data.deposit_list" />

    <!-- Floating Gift -->
    <button class="gift-float" @click="router.push('/work')">
      <svg viewBox="0 0 24 24"><rect x="4" y="9" width="16" height="11" rx="2"></rect><path d="M3 9h18v4H3z"></path><path d="M12 9v11"></path><path d="M12 9S7 8 7 5.5A2.5 2.5 0 0 1 12 5z"></path><path d="M12 9s5-1 5-3.5A2.5 2.5 0 0 0 12 5z"></path></svg>
    </button>
  </div>
</template>

<script setup>
import { showSuccessToast } from 'vant'
import { i18n } from '@/lang'
import Commission from '@/components/commission/index.vue'
import { getAssetURL } from '@/utils/get_assets_img.js'
import Request from '@/services/index.js'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const { t } = i18n.global
const router = useRouter()

const footList = [
  getAssetURL('home/1.png'),
  getAssetURL('home/2.png'),
  getAssetURL('home/3.png'),
  getAssetURL('home/4.png'),
  getAssetURL('home/5.png'),
  getAssetURL('home/6.png')
]

const vipList = ref([])
Request.get({ url: 'index/user/vip' }).then(res => {
  vipList.value = res.data
})

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

<style lang="less" scoped>
.Home {
  padding: 14px 10px 90px;
  background: #222222;
  min-height: 100vh;

  /* ================= NOTICE ================= */
  .notice {
    display: flex;
    align-items: center;
    gap: 9px;
    overflow: hidden;
    white-space: nowrap;
    margin-bottom: 20px;
    color: #d7d7d7;
    font-size: 12px;

    .notice-icon {
      font-size: 15px;
      flex-shrink: 0;
    }

    .notice-text {
      overflow: hidden;
      flex: 1;

      :deep(.van-notice-bar) {
        padding: 0;
        height: auto;
      }
    }
  }

  /* ================= MAIN CARD ================= */
  .main-card {
    position: relative;
    overflow: hidden;
    background: #382f28;
    border-radius: 8px;
    padding: 14px 0 10px;
    margin-bottom: 14px;

    /* Background decorative circles */
    &::before {
      content: "";
      position: absolute;
      width: 220px;
      height: 220px;
      left: -110px;
      bottom: -130px;
      border-radius: 50%;
      background: rgba(0, 0, 0, 0.09);
    }

    &::after {
      content: "";
      position: absolute;
      width: 200px;
      height: 200px;
      right: -130px;
      bottom: -130px;
      border-radius: 50%;
      background: rgba(0, 0, 0, 0.13);
    }

    .phone-row {
      position: relative;
      z-index: 2;
      padding: 0 14px 12px;
      color: #9b9b9b;
      font-size: 11px;
    }

    /* ================= BALANCE ================= */
    .balance {
      position: relative;
      z-index: 2;
      margin: 0 12px 8px;
      height: 40px;
      background: #1d1f21;
      border-radius: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      font-size: 13px;
      color: #ffffff;

      strong {
        color: #f5ae48;
        font-size: 16px;
      }
    }

    /* ================= ACTION GRID ================= */
    .actions {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px 8px;
      padding: 0 25px;
    }

    .action {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 7px;
      color: white;
      text-decoration: none;
      font-size: 11px;
      font-weight: 500;
      cursor: pointer;
    }

    .action-icon {
      width: 39px;
      height: 39px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f5ae48;
      color: white;
      box-shadow: 0 5px 12px rgba(0, 0, 0, 0.18);

      svg {
        width: 21px;
        height: 21px;
        stroke: white;
        fill: none;
        stroke-width: 2.2;
      }
    }
  }

  /* ================= BANNERS ================= */
  .banners {
    margin: 14px 0 18px;

    .banner-swipe {
      border-radius: 7px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      height: 116px;
    }

    .banner {
      position: relative;
      width: 100%;
      height: 100%;
      background: #333;
      display: block;

      img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
      }
    }
  }

  /* ================= FLOATING GIFT ================= */
  .gift-float {
    position: fixed;
    right: 16px;
    bottom: 130px;
    width: 33px;
    height: 33px;
    border-radius: 50%;
    background: #3c3937;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border: none;
    color: white;
    cursor: pointer;

    svg {
      width: 18px;
      height: 18px;
      stroke: white;
      fill: none;
      stroke-width: 2;
    }
  }
}
</style>
