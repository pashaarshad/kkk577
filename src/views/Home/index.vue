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

    <!-- PROJECT HALL -->
    <section class="project-hall">
      <h3 class="section-title">Project hall</h3>
      <div class="project-list">
        <div v-for="item in vipList" :key="item.id" class="project-card" @click="toGrab(item)">
          <div class="project-thumb">
            <img :src="item.img" alt="Product" class="thumb-img">
          </div>
          <div class="project-info">
            <div class="metric-row">
              <span class="gold-text font-bold">${{ getProfit(item) }}</span>
              <span class="lbl-gray">The total profit</span>
            </div>
            <div class="metric-row">
              <span class="gold-text font-bold">${{ getPrice(item) }}</span>
              <span class="lbl-gray">Price</span>
            </div>
            <div class="desc-text">
              {{ item.id === 1 ? 'ELITE BOT' : '商城365天产品' }}
            </div>
          </div>
          <div class="project-arrow-bar">
            <span class="arrows-icon">>>></span>
          </div>
        </div>
      </div>
    </section>

    <!-- PLATFORM INTRODUCTION -->
    <section class="platform-intro">
      <h3 class="section-title">Platform Introduction</h3>
      <div class="intro-box">
        <p class="intro-desc">Welcome to the Platform. Complete daily interactive tasks, lock investments, and claim massive yield rewards instantly.</p>
        <div class="intro-video-mock">
          <div class="play-button-circle">
            <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z" fill="white"></path></svg>
          </div>
        </div>
      </div>
    </section>

    <!-- PARTNERS / REGULATORY AUTHORITY -->
    <section class="partner-section">
      <h3 class="section-title">Regulatory Authority</h3>
      <div class="partner-grid">
        <div v-for="(item, idx) in footList" :key="idx" class="partner-item">
          <img :src="item" alt="Partner">
        </div>
      </div>
    </section>

    <!-- USER COMMISSION DYNAMICS (Activities) -->
    <Commission :list="data.deposit_list" />

    <!-- FLOATING DRAGGABLE WHATSAPP BUTTON -->
    <div 
      class="whatsapp-float"
      :style="{ left: `${waPosition.x}px`, top: `${waPosition.y}px` }"
      @mousedown="onDragStart"
      @touchstart.passive="onDragStart"
      @click="onWaClick"
    >
      <svg viewBox="0 0 24 24" class="whatsapp-svg">
        <circle cx="12" cy="12" r="12" fill="#25d366" />
        <path d="M12.012 5.5a6.5 6.5 0 0 0-5.635 9.757l-.76 2.775 2.84-.745a6.5 6.5 0 1 0 3.555-11.787zm3.178 9.176c-.13.364-.753.694-1.037.738-.28.044-.564.07-.852.078a4.935 4.935 0 0 1-2.92-1.077c-1.12-.907-1.858-2.222-1.858-3.328 0-.58.175-1.01.503-1.328a.5.5 0 0 1 .373-.175c.088 0 .175.008.254.017.08.01.12.02.176.136.216.52.54 1.306.588 1.402a.25.25 0 0 1 .01.233c-.05.105-.1.17-.184.262-.07.088-.166.193-.245.27-.088.08-.184.167-.08.347.106.18.474.78.966 1.217.63.56 1.164.735 1.33.823.167.088.263.08.36-.032.096-.114.41-.482.525-.648a.25.25 0 0 1 .237-.097c.105.027.675.316.79.377.114.06.193.088.22.132.026.044.026.254-.105.618z" fill="white" />
      </svg>
    </div>

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

const toGrab = (item) => {
  router.push('/grab')
}

const getPrice = (item) => {
  if (item.id === 1) return '10.00'
  return (item.auto_vip_xu_num || item.num_min || 0).toFixed(2)
}

const getProfit = (item) => {
  if (item.id === 1) return '45.00'
  const price = item.auto_vip_xu_num || item.num_min || 0
  return (item.num - price).toFixed(2)
}

// ================= DRAGGABLE WHATSAPP BUTTON =================
const waPosition = ref({
  x: typeof window !== 'undefined' ? window.innerWidth - 64 : 320,
  y: typeof window !== 'undefined' ? window.innerHeight - 200 : 500
})

let isDragging = false
let dragStarted = false
let startX = 0
let startY = 0
let initialLeft = 0
let initialTop = 0

const onDragStart = (e) => {
  const clientX = e.touches ? e.touches[0].clientX : e.clientX
  const clientY = e.touches ? e.touches[0].clientY : e.clientY
  
  isDragging = true
  dragStarted = false
  startX = clientX
  startY = clientY
  initialLeft = waPosition.value.x
  initialTop = waPosition.value.y
  
  window.addEventListener('mousemove', onDragMove, { passive: false })
  window.addEventListener('mouseup', onDragEnd)
  window.addEventListener('touchmove', onDragMove, { passive: false })
  window.addEventListener('touchend', onDragEnd)
}

const onDragMove = (e) => {
  if (!isDragging) return
  const clientX = e.touches ? e.touches[0].clientX : e.clientX
  const clientY = e.touches ? e.touches[0].clientY : e.clientY
  
  const deltaX = clientX - startX
  const deltaY = clientY - startY
  
  if (Math.hypot(deltaX, deltaY) > 5) {
    dragStarted = true
    if (e.cancelable) e.preventDefault()
  }
  
  if (dragStarted) {
    const maxX = window.innerWidth - 56
    const maxY = window.innerHeight - 56
    waPosition.value.x = Math.min(Math.max(10, initialLeft + deltaX), maxX)
    waPosition.value.y = Math.min(Math.max(10, initialTop + deltaY), maxY)
  }
}

const onDragEnd = () => {
  isDragging = false
  window.removeEventListener('mousemove', onDragMove)
  window.removeEventListener('mouseup', onDragEnd)
  window.removeEventListener('touchmove', onDragMove)
  window.removeEventListener('touchend', onDragEnd)
}

const onWaClick = (e) => {
  if (dragStarted) {
    e.preventDefault()
    e.stopPropagation()
    return
  }
  const link = data.value.chats_link || 'https://wa.me/553588236216?text=Hello'
  window.open(link, '_blank')
}
</script>

<style lang="less" scoped>
.Home {
  padding: 14px 10px 90px;
  background: #222222;
  min-height: 100vh;
  box-sizing: border-box;

  /* ================= COMMON ELEMENTS ================= */
  .section-title {
    font-size: 18px;
    font-weight: bold;
    color: #ffffff;
    margin: 25px 0 14px;
    padding-left: 2px;
  }

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
      height: 189px;
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

  /* ================= PROJECT HALL ================= */
  .project-hall {
    .project-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .project-card {
      background: #2c2a29;
      border-radius: 8px;
      display: flex;
      overflow: hidden;
      align-items: stretch;
      cursor: pointer;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
    }

    .project-thumb {
      width: 108px;
      height: 108px;
      flex-shrink: 0;
      position: relative;

      .thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }

    .project-info {
      flex: 1;
      padding: 12px 14px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 5px;

      .metric-row {
        display: flex;
        align-items: baseline;
        gap: 6px;
        font-size: 13px;
      }

      .gold-text {
        color: #f5ae48;
        font-size: 15px;
      }

      .font-bold {
        font-weight: bold;
      }

      .lbl-gray {
        color: #9b9b9b;
        font-size: 11px;
      }

      .desc-text {
        font-size: 11px;
        color: #9b9b9b;
        margin-top: 2px;
      }
    }

    .project-arrow-bar {
      width: 32px;
      background: #111111;
      display: flex;
      align-items: center;
      justify-content: center;

      .arrows-icon {
        color: #ffffff;
        font-weight: bold;
        font-size: 12px;
        letter-spacing: -2px;
      }
    }
  }

  /* ================= PLATFORM INTRODUCTION ================= */
  .platform-intro {
    .intro-box {
      background: #2c2a29;
      border-radius: 8px;
      padding: 14px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
    }

    .intro-desc {
      font-size: 12.5px;
      line-height: 1.5;
      color: #d7d7d7;
      margin-bottom: 12px;
    }

    .intro-video-mock {
      background: #444444;
      height: 130px;
      border-radius: 6px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      position: relative;
      overflow: hidden;

      &::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(0, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0.5) 100%);
      }

      .play-button-circle {
        position: relative;
        z-index: 2;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(245, 174, 72, 0.95);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);

        svg {
          width: 22px;
          height: 22px;
          margin-left: 2px;
        }
      }
    }
  }

  /* ================= PARTNERS ================= */
  .partner-section {
    margin-bottom: 20px;

    .partner-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
    }

    .partner-item {
      background: #ffffff;
      border-radius: 8px;
      height: 48px;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 6px 10px;
      box-sizing: border-box;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      transition: transform 0.2s ease, box-shadow 0.2s ease;

      &:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      }

      img {
        max-width: 95%;
        max-height: 32px;
        object-fit: contain;
      }
    }
  }

  /* ================= FLOATING BUTTONS ================= */
  .whatsapp-float {
    position: fixed;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    z-index: 9999;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: grab;
    user-select: none;
    touch-action: none;
    transition: transform 0.15s ease, box-shadow 0.15s ease;

    &:active {
      cursor: grabbing;
      transform: scale(1.08);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
    }

    .whatsapp-svg {
      width: 100%;
      height: 100%;
      display: block;
      pointer-events: none;
    }
  }

  .gift-float {
    position: fixed;
    right: 22px;
    bottom: 130px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #3c3937;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);

    svg {
      width: 20px;
      height: 20px;
      stroke: white;
      fill: none;
      stroke-width: 2;
    }
  }
}
</style>
