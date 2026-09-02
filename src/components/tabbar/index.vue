<!-- tabbar -->
<template>
  <div class='tabbars'>
    <nav :style='{width:boxHeight}' class='bottom-nav'>
      <a v-for='(item, index) in list' :key='index'
         :class="['nav-item', { active: tabbarIndex === index, isVip: item.path === '/vip' }]"
         @click='onTabbar(item, index)'>
        <!-- Home icon -->
        <svg v-if="item.path === '/home'" viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path></svg>
        <!-- Task icon -->
        <svg v-if="item.path === '/work'" viewBox="0 0 24 24"><rect x="5" y="4" width="14" height="16"></rect><path d="M8 8h8"></path><path d="M8 12h8"></path><path d="M8 16h5"></path></svg>
        <!-- VIP icon -->
        <svg v-if="item.path === '/vip'" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
        <!-- Team icon -->
        <svg v-if="item.path === '/team'" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"></circle><path d="M5 21a7 7 0 0 1 14 0"></path></svg>
        <!-- Me icon -->
        <svg v-if="item.path === '/mine' || item.path === '/login'" viewBox="0 0 24 24"><path d="M20 12a8 8 0 1 1-16 0"></path><path d="M12 4v8l3 2"></path></svg>
        <span>{{ item?.title }}</span>
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
    title: t('main.work') || 'Task',
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
    height: 56px;
    background-color: #00b983;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
    width: 100% !important;

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

      &.isVip.active {
        svg {
          fill: #ffeb3b;
          stroke: #ffffff;
        }
      }
    }
  }
}
</style>
