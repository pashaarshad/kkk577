<!-- tabbar  -->
<template>
  <div class='tabbars'>
    <nav :style='{width:boxHeight}' class='bottom-nav'>
      <a v-for='(item, index) in list' :key='index'
         :class="['nav-item', { active: tabbarIndex === index }]"
         @click='onTabbar(item, index)'>
        <!-- Home icon -->
        <svg v-if="index === 0" viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5"></path><path d="M5 9.5V21h14V9.5"></path></svg>
        <!-- Project icon -->
        <svg v-if="index === 1" viewBox="0 0 24 24"><rect x="5" y="4" width="14" height="16"></rect><path d="M8 8h8"></path><path d="M8 12h8"></path><path d="M8 16h5"></path></svg>
        <!-- Team icon -->
        <svg v-if="index === 2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"></circle><path d="M5 21a7 7 0 0 1 14 0"></path></svg>
        <!-- Me icon -->
        <svg v-if="index === 3" viewBox="0 0 24 24"><path d="M20 12a8 8 0 1 1-16 0"></path><path d="M12 4v8l3 2"></path></svg>
        <span>{{ item?.title }}</span>
      </a>
    </nav>
  </div>
</template>

<script setup>
import { i18n } from '@/lang'
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getAssetURL } from '@/utils/get_assets_img.js'
import { useMitt } from '@/utils/mitt.js'

const { t } = i18n.global

const tabbarIndex = ref(0)

const router = useRouter()
const route = useRoute()

const list = ref([
  {
    title: t('main.home'),
    path: '/home',
    icon: getAssetURL('main/home.png'),
    icon_active: getAssetURL('main/home-active.png')
  },
  {
    title: t('main.work'),
    path: '/work',
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
    title: t('main.mine'),
    path: '/mine',
    icon: getAssetURL('main/mine.png'),
    icon_active: getAssetURL('main/mine-sel.png')
  }
])

const token = sessionStorage.getItem('token')
if (!token) {
  list.value[list.value.length - 1].title = t('main.login')
  list.value[list.value.length - 1].path = '/login'
}

const mitt = useMitt()
mitt.on('goBack', () => {
  list.value[list.value.length - 1].title = t('main.login')
  list.value[list.value.length - 1].path = '/login'
  tabbarIndex.value = 0
})

if (route.fullPath) {
  tabbarIndex.value = list.value.findIndex(item => route.fullPath === item.path)
}

const onTabbar = (item, index) => {
  tabbarIndex.value = index
  router.push(item.path)
}

const baseSize = 50

function setRem() {
  const scale = document.documentElement.clientWidth
  if (scale > 750) {
    document.documentElement.style.fontSize = '41.4px'
  }
}

setRem()

const boxHeight = ref(document.getElementById('app').offsetWidth + 'px')
window.onresize = function() {
  setRem()
  boxHeight.value = document.getElementById('app').offsetWidth + 'px'
}
</script>

<style lang='less' scoped>
.tabbars {
  position: relative;
  width: 100%;
  bottom: 0;
}

.bottom-nav {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  position: fixed;
  bottom: 0;
  height: 64px;
  background: #382f28;
  border-radius: 6px 6px 0 0;
  z-index: 100;
}

.nav-item {
  text-decoration: none;
  color: #a9a9a9;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 4px;
  font-size: 10px;
  cursor: pointer;

  &.active {
    color: #f5ae48;
  }

  svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
    fill: none;
    stroke-width: 2;
  }

  span {
    font-size: 10px;
  }
}
</style>
