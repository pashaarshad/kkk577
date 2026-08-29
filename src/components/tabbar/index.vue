<!-- tabbar  -->
<template>
  <div class='tabbars'>
    <div id='tabbar' :style='{width:boxHeight}' class='tabbar'>
      <div v-for='(item, index) in list' :class="'list'+index" class='tabbar-list' @click='onTabbar(item, index)'>
        <img v-if='tabbarIndex !== index' :class="'icon'+index" :src='item.icon' alt=''>
        <img v-else :class="'icon'+index" :src='item.icon_active' alt=''>
        <span :class="tabbarIndex !== index ? '' : 'tabbar-title'">{{ item?.title }}</span>
      </div>
    </div>
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
    path: '/grab',
    icon: getAssetURL('main/grab.png'),
    icon_active: getAssetURL('main/grab.png')
  },
  {
    title: t('main.order'),
    path: '/order',
    icon: getAssetURL('main/orders.png'),
    icon_active: getAssetURL('main/orders-sel.png')
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

// 设置 rem 函数
function setRem() {
  // 当前页面宽度相对于 375 宽的缩放比例，可根据自己需要修改。
  // const scale = document.documentElement.clientWidth / 375
  // // 设置页面根节点字体大小
  // document.documentElement.style.fontSize = (baseSize * Math.min(scale, 2)) + 'px'
  const scale = document.documentElement.clientWidth
  if (scale > 750) {
    document.documentElement.style.fontSize = '41.4px'
  }
}

// 初始化
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

.tabbar {
  display: flex;
  position: fixed;
  bottom: 0;
  justify-content: space-between;
  padding: 15px 0px 15px 0px;
  box-sizing: border-box;
  background-color: var(--bg-color);
  box-shadow: 0 -1px 8px 0 rgba(0, 0, 0, .4);
  border-top: 1px solid var(--second-color);
}

.tabbar-list {
  width: 22%;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  color: var(--text-second);


  img {
    width: 21px;
    height: 24px;
  }

  span {
    margin-top: 8px;
    font-size: 12px;
    word-wrap: break-word;
    word-break: normal;
    text-align: center;
  }

  .list2 {
    //width: 82px;

    img {
      width: 52px;
      height: 52px;
      position: absolute;
      top: -15px;
    }
  }

  .icon2 {
    width: 47px;
    height: 47px;
    position: absolute;
    top: -10px;
  }

  .tabbar-title {
    color: var(--main-color);
  }
}

</style>
