<!-- navbar  -->
<template>
  <van-sticky>
    <div class='navbar'>
      <!-- Home Route: Clean White Header with Official Shopping Cart Logo, Subtitle, US Flag & Bell -->
      <div v-if='$route.path === "/home"' class='navbar-left'>
        <img :src='officialLogo' alt='Logo' class='navbar-img'>
        <div class='brand-text-box'>
          <span class='brand-title'>环宇出海任务商城演示站</span>
          <span class='brand-sub'>Global Business • Global Success</span>
        </div>
      </div>

      <!-- Other Main Routes (Order, Mine) -->
      <div v-else-if='$route.path === "/order" || $route.path === "/mine"' class='navbar-left' @click='$router.go(-1)'>
        <img :src='officialLogo' alt='Logo' class='navbar-img'>
        <div class='page-title-text'>{{ $t('main.' + $route.name) }}</div>
      </div>

      <!-- Inner Sub-Pages (With Back Arrow) -->
      <div v-else class='navbar-left' @click='$router.go(-1)'>
        <van-icon name='arrow-left' size='20' color='#B83A2E' class='back-arrow' />
        <div class='page-title-text'>{{ $t('main.' + $route.name) }}</div>
      </div>

      <!-- Right Header Actions (US Flag Image + Bell Icon) -->
      <div class='navbar-right'>
        <slot name='right'>
          <img :src='langImg' alt='US Flag' class='flag-img' @click='showBottom = true'>
          <div class="bell-box" @click="onBellClick">
            <svg viewBox="0 0 24 24" class="bell-svg">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="red-badge"></span>
          </div>
        </slot>
      </div>
    </div>
  </van-sticky>

  <!-- Language Selection Modal -->
  <van-popup
    v-model:show='showBottom'
    :style="{ height: '42%' }"
    closeable
    position='bottom'
  >
    <div class='nation'>
      <div v-for='(item, index) in nationList' :key="index" class='nation-list' @click='clickNation(item, index)'>
        <div class='nation-left'>
          <img :src='item.icon' alt='' class=''>
          <span :style="nationIndex === index ? 'color: #B83A2E;' : ''">{{ item.title }}</span>
        </div>
        <div v-if='nationIndex === index'>
          <van-icon color='#B83A2E' name='success' size='26' />
        </div>
      </div>
    </div>
  </van-popup>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { getAssetURL } from '@/utils/get_assets_img.js'
import officialLogo from '@/assets/img/main/official_logo.png'

const router = useRouter()
const { t, locale } = useI18n()
const langImg = ref(getAssetURL('main/en-US.png'))
const nationIndex = ref(0)

const onBellClick = () => {
  const token = localStorage.getItem('token') || sessionStorage.getItem('token')
  if (!token) {
    router.push('/login')
    return
  }
  router.push('/message')
}

const nationList = [
  {
    title: 'English (US)',
    lang: 'en_US',
    icon: getAssetURL('main/en-US.png')
  }
]

if (localStorage.getItem('lang')) {
  const index = nationList.findIndex(item => item.lang === localStorage.getItem('lang'))
  if (index !== -1) {
    langImg.value = nationList[index].icon
    nationIndex.value = index
  }
} else {
  localStorage.setItem('lang', 'en_US')
}

const showBottom = ref(false)

const clickNation = (item, index) => {
  showBottom.value = false
  nationIndex.value = index
  langImg.value = item.icon
  changeLanguage(item.lang)
}

const changeLanguage = (lang) => {
  locale.value = lang
  localStorage.setItem('lang', lang)
  location.reload()
}
</script>

<style lang='less' scoped>
.navbar {
  position: sticky;
  z-index: 99;
  top: 0;
  width: 100%;
  height: 54px;
  background-color: #ffffff;
  border-bottom: 1px solid #fdece8;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 14px;
  box-sizing: border-box;
  box-shadow: 0 2px 8px rgba(184, 58, 46, 0.05);

  .navbar-left {
    display: flex;
    align-items: center;
    gap: 10px;

    .navbar-img {
      height: 38px;
      width: auto;
      max-width: 48px;
      object-fit: contain;
    }

    .brand-text-box {
      display: flex;
      flex-direction: column;

      .brand-title {
        font-size: 14px;
        font-weight: 800;
        color: #B83A2E;
        line-height: 1.2;
      }

      .brand-sub {
        font-size: 9.5px;
        color: #86909c;
        font-weight: 500;
      }
    }

    .page-title-text {
      font-size: 16px;
      font-weight: 700;
      color: #1f1a1a;
      margin-left: 4px;
    }

    .back-arrow {
      cursor: pointer;
    }
  }

  .navbar-right {
    display: flex;
    align-items: center;
    gap: 12px;

    .flag-img {
      width: 26px;
      height: 18px;
      object-fit: contain;
      cursor: pointer;
      border-radius: 2px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    .bell-box {
      position: relative;
      width: 32px;
      height: 32px;
      background: #fff9f8;
      border: 1px solid #fdece8;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;

      .bell-svg {
        width: 18px;
        height: 18px;
        stroke: #1f1a1a;
        fill: none;
        stroke-width: 2;
      }

      .red-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 6px;
        height: 6px;
        background-color: #ff3b30;
        border-radius: 50%;
      }
    }
  }
}

.nation {
  width: 380px;
  margin: 40px auto;

  .nation-list {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 54px;
    padding: 14px;
    margin-bottom: 12px;
    background-color: #ffffff;
    border: 1px solid #fdece8;
    border-radius: 10px;

    .nation-left {
      display: flex;
      align-items: center;
      font-size: 14px;

      img {
        width: 24px;
        height: 24px;
        object-fit: contain;
      }

      span {
        margin-left: 10px;
        font-weight: 600;
      }
    }
  }
}
</style>
