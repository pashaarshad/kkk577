<!-- Home  -->
<template>
  <div class="Home">
    <!-- USER WELCOME & VIP MEMBER BADGE BANNER -->
    <section class="welcome-banner" v-if="loginShow">
      <div class="user-info-left">
        <div class="avatar-circle">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </div>
        <div class="user-text-col">
          <span class="welcome-label">Welcome back,</span>
          <strong class="user-phone">{{ data.user_info?.tel || '13312341234' }}</strong>
        </div>
      </div>

      <div class="vip-badge-right" @click="router.push('/vip')">
        <div class="crown-icon-small">👑</div>
        <div class="vip-text-col">
          <span class="vip-title">VIP Member</span>
          <span class="vip-sub">Enjoy exclusive benefits</span>
        </div>
      </div>
    </section>

    <!-- RED GRADIENT CURVED BALANCE & 5 ACTION BUTTON CARD -->
    <section class="main-card">
      <!-- Balance Curved Banner -->
      <div class="balance-curved-banner">
        <div class="balance-col">
          <span class="bal-label">Total Balance</span>
          <h1 class="bal-amount">$ {{ loginShow ? (data.user_info?.balance || '133,176.65') : '133,176.65' }}</h1>
        </div>
        <div class="wallet-icon-box">
          <svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="13" rx="2"></rect><path d="M16 10h5v4h-5z"></path></svg>
        </div>
      </div>

      <!-- 5 Action Buttons Container (Curved Shape) -->
      <div class="five-action-container">
        <div class="action-grid">
          <a class="action-btn" @click="onMenuClick('/recharge')">
            <div class="action-icon-circle">
              <svg viewBox="0 0 24 24"><rect x="5" y="7" width="14" height="13" rx="2"></rect><path d="M8 7V5a4 4 0 0 1 8 0v2"></path><path d="M12 11v5"></path><path d="M10 13h4"></path></svg>
            </div>
            <span>Recharge</span>
          </a>

          <a class="action-btn" @click="onMenuClick('/withdraw')">
            <div class="action-icon-circle">
              <svg viewBox="0 0 24 24"><rect x="4" y="6" width="11" height="12" rx="2"></rect><path d="M14 10h6v8a2 2 0 0 1-2 2h-7"></path><path d="M11 9l3 3-3 3"></path></svg>
            </div>
            <span>Withdraw</span>
          </a>

          <a class="action-btn" @click="onMenuClick('/poster/detail/12')">
            <div class="action-icon-circle">
              <svg viewBox="0 0 24 24"><path d="M6 4h9l3 3v13H6z"></path><path d="M15 4v4h4"></path><path d="M9 12h6"></path><path d="M9 16h5"></path></svg>
            </div>
            <span>Company Profile</span>
          </a>

          <a class="action-btn" @click="onMenuClick('/poster/detail/13')">
            <div class="action-icon-circle">
              <svg viewBox="0 0 24 24"><rect x="4" y="6" width="10" height="12" rx="2"></rect><path d="M14 10h6v8a2 2 0 0 1-2 2h-7"></path><path d="M11 9l3 3-3 3"></path></svg>
            </div>
            <span>Invite Friends</span>
          </a>

          <a class="action-btn" @click="onMenuClick('/poster/detail/14')">
            <div class="action-icon-circle">
              <svg viewBox="0 0 24 24"><path d="M5 5h10l4 4v10H5z"></path><path d="M15 5v4h4"></path><path d="M8 12h2"></path><path d="M12 12h4"></path><path d="M8 16h2"></path><path d="M12 16h4"></path></svg>
            </div>
            <span>Agency Cooperation</span>
          </a>
        </div>
      </div>
    </section>

    <!-- GO SHOPPING BANNER SLIDER -->
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
      <div class="section-header">
        <h3 class="section-title">Project hall</h3>
        <span class="view-all" @click="router.push('/vip')">View all &gt;</span>
      </div>

      <div class="project-list">
        <div v-for="(item, idx) in vipList" :key="item.id" class="project-card" @click="toGrab(item)">
          <div class="project-thumb">
            <img :src="item.img" alt="Product" class="thumb-img">
            <span class="member-badge">{{ idx === 0 ? 'VIP1' : (item.name || ('VIP' + idx)) }}</span>
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
              {{ idx === 0 ? 'ELITE BOT' : (item.name || ('VIP' + idx)) }}
            </div>
          </div>
          <div class="project-arrow-bar">
            <span class="arrows-icon">&rarr;</span>
          </div>
        </div>
      </div>
    </section>

    <!-- PLATFORM INTRODUCTION -->
    <section class="platform-intro">
      <h3 class="section-title">{{ data.intro_title || 'Platform Introduction' }}</h3>
      <div class="intro-box">
        <p class="intro-desc">{{ data.intro_desc || 'Welcome to the Platform. Complete daily interactive tasks, lock investments, and claim massive yield rewards instantly.' }}</p>
        <div class="intro-video-wrapper" :style="computedVideoStyle">
          <iframe 
            v-if="isYoutubeVideo" 
            :src="youtubeEmbedUrl" 
            class="video-9-16-player"
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
          ></iframe>
          <video 
            v-else
            ref="videoPlayer"
            :src="data.intro_video || 'https://www.w3schools.com/html/mov_bbb.mp4'" 
            class="video-9-16-player"
            autoplay
            muted
            loop
            playsinline
            @loadedmetadata="onVideoLoaded"
          ></video>
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

    <!-- USER COMMISSION DYNAMICS (Member List) -->
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
import { ref, computed } from 'vue'
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

const youtubeEmbedUrl = computed(() => {
  const url = data.value?.intro_video
  if (!url) return null
  const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|shorts\/)([^#\&\?]*).*/
  const match = url.match(regExp)
  const videoId = (match && match[2].length === 11) ? match[2] : null
  if (!videoId) return null
  return `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&controls=0&modestbranding=1&rel=0&iv_load_policy=3&playsinline=1&loop=1&playlist=${videoId}`
})

const isYoutubeVideo = computed(() => !!youtubeEmbedUrl.value)

const detectedRatio = ref(null)

const onVideoLoaded = (e) => {
  const video = e.target
  if (video && video.videoWidth && video.videoHeight) {
    if (video.videoHeight > video.videoWidth) {
      detectedRatio.value = '9-16'
    } else {
      detectedRatio.value = '16-9'
    }
  }
}

const computedVideoStyle = computed(() => {
  const adminRatio = data.value?.intro_ratio || 'auto'
  const activeRatio = (adminRatio === 'auto') ? (detectedRatio.value || '9-16') : adminRatio

  if (activeRatio === '16-9') {
    return {
      aspectRatio: '16 / 9',
      maxHeight: '280px'
    }
  }
  return {
    aspectRatio: '9 / 16',
    maxHeight: '520px'
  }
})

const token = sessionStorage.getItem('token')
const loginShow = ref(false)
if (token) {
  loginShow.value = true
}

const onMenuClick = (path) => {
  if (!sessionStorage.getItem('token')) {
    router.push('/login')
    return
  }
  router.push(path)
}

const toGrab = (item) => {
  if (!sessionStorage.getItem('token')) {
    router.push('/login')
    return
  }
  router.push('/grab')
}

const getPrice = (item) => {
  if (item.id === 1) return '45.00'
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
  padding: 10px 12px 90px;
  background: #fff9f8;
  min-height: 100vh;
  box-sizing: border-box;

  /* ================= TOP BRAND HEADER ================= */
  .top-brand-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 4px 14px;

    .header-brand-left {
      display: flex;
      align-items: center;
      gap: 10px;

      .brand-logo-img {
        width: 38px;
        height: 38px;
        object-fit: contain;
      }

      .brand-title-box {
        display: flex;
        flex-direction: column;

        .brand-name {
          font-size: 15px;
          font-weight: 800;
          color: #B83A2E;
          margin: 0;
          line-height: 1.2;
        }

        .brand-subtitle {
          font-size: 10px;
          color: #86909c;
          font-weight: 500;
        }
      }
    }

    .header-right-tools {
      display: flex;
      align-items: center;
      gap: 10px;

      .flag-icon {
        font-size: 22px;
      }

      .bell-icon-box {
        position: relative;
        width: 32px;
        height: 32px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);

        .bell-svg {
          width: 18px;
          height: 18px;
          stroke: #1f1a1a;
          fill: none;
          stroke-width: 2;
        }

        .red-dot {
          position: absolute;
          top: 6px;
          right: 6px;
          width: 6px;
          height: 6px;
          background: #ff3b30;
          border-radius: 50%;
        }
      }
    }
  }

  /* ================= WELCOME BANNER ================= */
  .welcome-banner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff0ed;
    border-radius: 12px;
    padding: 10px 14px;
    margin-bottom: 12px;

    .user-info-left {
      display: flex;
      align-items: center;
      gap: 10px;

      .avatar-circle {
        width: 34px;
        height: 34px;
        background: #B83A2E;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;

        svg {
          width: 20px;
          height: 20px;
          stroke: #ffffff;
          fill: none;
          stroke-width: 2;
        }
      }

      .user-text-col {
        display: flex;
        flex-direction: column;

        .welcome-label {
          font-size: 11px;
          color: #86909c;
        }

        .user-phone {
          font-size: 14px;
          font-weight: 700;
          color: #1f1a1a;
        }
      }
    }

    .vip-badge-right {
      display: flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 20px;
      padding: 5px 12px;
      border: 1px solid #fdece8;
      cursor: pointer;

      .crown-icon-small {
        font-size: 16px;
      }

      .vip-text-col {
        display: flex;
        flex-direction: column;

        .vip-title {
          font-size: 12px;
          font-weight: 700;
          color: #E86C3F;
        }

        .vip-sub {
          font-size: 9px;
          color: #86909c;
        }
      }
    }
  }

  /* ================= MAIN CARD (Curved Balance & 5 Icons) ================= */
  .main-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 16px;
    box-shadow: 0 4px 14px rgba(184, 58, 46, 0.1);
    border: 1px solid #fdece8;

    .balance-curved-banner {
      background: linear-gradient(135deg, #B83A2E, #E86C3F);
      padding: 20px 18px 30px;
      color: #ffffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      border-bottom-left-radius: 50% 15px;
      border-bottom-right-radius: 50% 15px;

      .balance-col {
        display: flex;
        flex-direction: column;

        .bal-label {
          font-size: 13px;
          opacity: 0.9;
        }

        .bal-amount {
          font-size: 26px;
          font-weight: 800;
          margin: 4px 0 0;
          letter-spacing: -0.5px;
        }
      }

      .wallet-icon-box {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;

        svg {
          width: 26px;
          height: 26px;
          stroke: #ffffff;
          fill: none;
          stroke-width: 2;
        }
      }
    }

    .five-action-container {
      padding: 16px 12px 14px;

      .action-grid {
        display: flex;
        justify-content: space-around;
        align-items: center;

        .action-btn {
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 6px;
          text-decoration: none;
          cursor: pointer;

          .action-icon-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff0ed;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #fdece8;
            transition: transform 0.15s ease;

            svg {
              width: 22px;
              height: 22px;
              stroke: #B83A2E;
              fill: none;
              stroke-width: 2;
            }
          }

          &:active .action-icon-circle {
            transform: scale(1.1);
            background: #B83A2E;
            svg { stroke: #ffffff; }
          }

          span {
            font-size: 10px;
            font-weight: 600;
            color: #1f1a1a;
            text-align: center;
            max-width: 60px;
            line-height: 1.2;
          }
        }
      }
    }
  }

  /* ================= BANNERS ================= */
  .banners {
    margin: 14px 0 18px;

    .banner-swipe {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      height: 145px;
    }

    .banner {
      width: 100%;
      height: 100%;
      background: #eee;

      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
  }

  /* ================= PROJECT HALL ================= */
  .project-hall {
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 18px 0 10px;

      .section-title {
        font-size: 16px;
        font-weight: 800;
        color: #1f1a1a;
        margin: 0;
      }

      .view-all {
        font-size: 12px;
        color: #86909c;
        cursor: pointer;
      }
    }

    .project-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .project-card {
      background: #ffffff;
      border: 1.5px solid #E86C3F;
      border-radius: 12px;
      display: flex;
      overflow: hidden;
      align-items: stretch;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(184, 58, 46, 0.06);

      .project-thumb {
        width: 100px;
        height: 100px;
        flex-shrink: 0;
        position: relative;

        .thumb-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        .member-badge {
          position: absolute;
          top: 6px;
          left: 6px;
          background: linear-gradient(135deg, #ff8c00, #B83A2E);
          color: #ffffff;
          font-weight: 700;
          font-size: 10px;
          padding: 2px 7px;
          border-radius: 4px;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
      }

      .project-info {
        flex: 1;
        padding: 10px 12px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 4px;

        .metric-row {
          display: flex;
          align-items: baseline;
          gap: 6px;

          .gold-text {
            color: #E86C3F;
            font-size: 15px;
            font-weight: 800;
          }

          .lbl-gray {
            color: #86909c;
            font-size: 11px;
          }
        }

        .desc-text {
          font-size: 12px;
          font-weight: 700;
          color: #1f1a1a;
          margin-top: 2px;
        }
      }

      .project-arrow-bar {
        width: 32px;
        background: #fff5f3;
        display: flex;
        align-items: center;
        justify-content: center;

        .arrows-icon {
          color: #B83A2E;
          font-weight: bold;
          font-size: 16px;
        }
      }
    }
  }

  /* ================= PLATFORM INTRODUCTION ================= */
  .platform-intro {
    margin-top: 18px;

    .section-title {
      font-size: 16px;
      font-weight: 800;
      color: #1f1a1a;
      margin-bottom: 10px;
    }

    .intro-box {
      background: #ffffff;
      border: 1px solid #fdece8;
      border-radius: 12px;
      padding: 14px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .intro-desc {
      font-size: 12px;
      line-height: 1.5;
      color: #4e5969;
      margin-bottom: 12px;
    }

    .intro-video-wrapper {
      width: 100%;
      aspect-ratio: 9 / 16;
      max-height: 520px;
      border-radius: 12px;
      overflow: hidden;
      background: #000000;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
      display: flex;
      justify-content: center;
      align-items: center;

      .video-9-16-player {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
        display: block;
      }
    }
  }

  /* ================= PARTNERS ================= */
  .partner-section {
    margin: 18px 0;

    .section-title {
      font-size: 16px;
      font-weight: 800;
      color: #1f1a1a;
      margin-bottom: 10px;
    }

    .partner-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }

    .partner-item {
      background: #ffffff;
      border-radius: 8px;
      height: 44px;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 4px 8px;
      border: 1px solid #f0f0f0;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);

      img {
        max-width: 90%;
        max-height: 28px;
        object-fit: contain;
      }
    }
  }

  /* ================= FLOATING BUTTONS ================= */
  .whatsapp-float {
    position: fixed;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    z-index: 9999;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: grab;
    user-select: none;
    touch-action: none;
  }

  .gift-float {
    position: fixed;
    right: 18px;
    bottom: 120px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #B83A2E;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99;
    color: white;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(184, 58, 46, 0.4);
    border: none;

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
