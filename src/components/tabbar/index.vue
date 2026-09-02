<!-- tabbar -->
<template>
  <div class='tabbars'>
    <nav :style='{width:boxHeight}' class='bottom-nav'>
      <a v-for='(item, index) in list' :key='index'
         :class="['nav-item', { active: tabbarIndex === index, isVip: item.path === '/vip' }]"
         @click='onTabbar(item, index)'>
        
        <!-- Standard Tab Item -->
        <template v-if="item.path !== '/vip'">
          <!-- Home icon -->
          <svg v-if="item.path === '/home'" viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path></svg>
          <!-- Task icon -->
          <svg v-if="item.path === '/work'" viewBox="0 0 24 24"><rect x="5" y="4" width="14" height="16"></rect><path d="M8 8h8"></path><path d="M8 12h8"></path><path d="M8 16h5"></path></svg>
          <!-- Team icon -->
          <svg v-if="item.path === '/team'" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"></circle><path d="M5 21a7 7 0 0 1 14 0"></path></svg>
          <!-- Me icon -->
          <svg v-if="item.path === '/mine' || item.path === '/login'" viewBox="0 0 24 24"><path d="M20 12a8 8 0 1 1-16 0"></path><path d="M12 4v8l3 2"></path></svg>
          <span>{{ item?.title }}</span>
        </template>

        <!-- Premium Elevated Middle VIP Crown Tab -->
        <template v-else>
          <div class="vip-crown-btn">
            <svg viewBox="0 0 24 24" class="crown-svg">
              <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z" fill="white" />
            </svg>
          </div>
          <span class="vip-label">{{ item?.title }}</span>
        </template>

      </a>
    </nav>
  </div>
</template>

<script setup>
import { i18n } from '@/lang'
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getAssetURL } from '@/utils/get_assets_img.js'
import { useMitt } from '@/utils/mitt.js'

const { t } = i18n.global

const tabbarIndex = ref(0)
const router = useRouter()
const route = useRoute()

const list = ref([
  {
    title: t('main.home') || 'Home',
    path: '/home',
    icon: getAssetURL('main/home.png'),
    icon_active: getAssetURL('main/home-active.png')
  },
  {
    title: t('main.work') || 'Project',
    path: '/work',
    icon: getAssetURL('main/work.png'),
    icon_active: getAssetURL('main/work-sel.png')
  },
  {
    title: 'VIP',
    path: '/vip',
    icon: getAssetURL('main/work.png'),
    icon_active: getAssetURL('main/work-sel.png')
  },
  {
    title: t('main.team') || 'Team',
    path: '/team',
    icon: getAssetURL('main/team.png'),
    icon_active: getAssetURL('main/team-sel.png')
  },
  {
    title: t('main.mine') || 'Me',
    path: '/mine',
    icon: getAssetURL('main/mine.png'),
    icon_active: getAssetURL('main/mine-sel.png')
  }
])

const token = sessionStorage.getItem('token')
if (!token) {
  list.value[list.value.length - 1].title = t('main.login') || 'Login'
  list.value[list.value.length - 1].path = '/login'
}

const mitt = useMitt()
mitt.on('goBack', () => {
  list.value[list.value.length - 1].title = t('main.login') || 'Login'
  list.value[list.value.length - 1].path = '/login'
  tabbarIndex.value = 0
})

watch(() => route.fullPath, (newPath) => {
  const idx = list.value.findIndex(item => newPath.startsWith(item.path))
  if (idx !== -1) tabbarIndex.value = idx
}, { immediate: true })

const onTabbar = (item, index) => {
  tabbarIndex.value = index
  router.push(item.path)
}

function setRem() {
  const scale = document.documentElement.clientWidth
  if (scale > 750) {
    document.documentElement.style.fontSize = '41.4px'
  }
}
setRem()

const boxHeight = ref(document.getElementById('app')?.offsetWidth ? document.getElementById('app').offsetWidth + 'px' : '100%')
window.onresize = function() {
  setRem()
  if (document.getElementById('app')) {
    boxHeight.value = document.getElementById('app').offsetWidth + 'px'
  }
}
</script>

<style lang='less' scoped>
.tabbars {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  z-index: 99;
  width: 100%;
  max-width: 480px;

  .bottom-nav {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 60px;
    background-color: #B83A2E;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    box-shadow: 0 -3px 12px rgba(184, 58, 46, 0.25);
    width: 100% !important;
    position: relative;

    .nav-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: rgba(255, 255, 255, 0.75);
      font-size: 11px;
      text-decoration: none;
      cursor: pointer;
      flex: 1;

      svg {
        width: 22px;
        height: 22px;
        stroke: rgba(255, 255, 255, 0.75);
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        transition: all 0.2s ease;
      }

      span {
        margin-top: 2px;
        font-weight: 500;
      }

      &.active {
        color: #ffffff;
        font-weight: 700;

        svg {
          stroke: #ffffff;
          fill: rgba(255, 255, 255, 0.2);
          transform: scale(1.1);
        }
      }

      &.isVip {
        position: relative;
        top: -14px;

        .vip-crown-btn {
          width: 52px;
          height: 52px;
          border-radius: 50%;
          background: linear-gradient(135deg, #ff8c00, #B83A2E);
          border: 3px solid #ffffff;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
          display: flex;
          align-items: center;
          justify-content: center;
          transition: transform 0.2s ease;

          .crown-svg {
            width: 26px;
            height: 26px;
            stroke: none;
            fill: #ffffff;
          }
        }

        .vip-label {
          color: #ffffff;
          font-weight: 700;
          font-size: 11px;
          margin-top: 2px;
        }

        &.active .vip-crown-btn {
          transform: scale(1.1);
          box-shadow: 0 6px 16px rgba(255, 140, 0, 0.5);
          background: linear-gradient(135deg, #ffaa00, #e63946);
        }
      }
    }
  }
}
</style>
