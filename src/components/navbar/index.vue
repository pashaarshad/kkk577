<!-- navbar  -->
<template>
  <van-sticky>
    <div class='navbar'>
      <div v-if='$route.path === "/home"' class='navbar-left'>
        <img :src='iconImg' alt='' class='navbar-img'>
        <div style='margin-left: 8px; font-weight: bold; font-size: 15px;'>环字出海任务商城演示站</div>
      </div>
      <div v-else-if='$route.path === "/order" || $route.path === "/mine" ' class='navbar-left'
           @click='$router.go(-1)'>
        <img :src='iconImg' alt='' class='navbar-img'>
        <div style='margin-left: 15px;'>{{ $t('main.' + $route.name) }}</div>
      </div>
      <div v-else class='navbar-left' @click='$router.go(-1)'>
        <van-icon :name='arrowLeft' size='20' />
        <div style='margin-left: 10px;'>{{ $t('main.' + $route.name) }}</div>
      </div>
      <div class='navber-right'>
        <slot name='right'>
          <img :src='langImg' alt='' class='langImg' @click='showBottom = true'>
		   <!-- badge='1' -->
          <van-icon class='clockImg' name='bell' size='24px' @click="$router.push('/message')" />
        </slot>
      </div>
    </div>
  </van-sticky>
  <van-popup
    v-model:show='showBottom'
    :style="{ height: '42%' }"
    closeable
    position='bottom'
  >
    <div class='nation'>
      <div v-for='(item, index) in nationList' class='nation-list' @click='clickNation(item, index)'>
        <div class='nation-left'>
          <img :src='item.icon' alt='' class=''>
          <span :style="nationIndex === index ? 'color: var(--main-color);' : ''">{{ item.title }}</span>
        </div>
        <div v-if='nationIndex === index'>
          <van-icon color='var(--main-color)' name='success' size='26' />
        </div>
      </div>
    </div>
  </van-popup>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import iconImg from '../../assets/img/main/fbdb7d08a0b0413fb4d95f214770967b_.jpg'
import { ref } from 'vue'
import arrowLeft from '@/assets/img/main/arrow-left.svg'
import { getAssetURL } from '@/utils/get_assets_img.js'


const { t, locale } = useI18n()

const langImg = ref(getAssetURL('main/en-US.png'))

const nationIndex = ref(2)

const nationList = [
  // {
  //   title: 'Guatemala',
  //   lang: 'es_GT',
  //   icon: getAssetURL('main/es-GT.png')
  // },
  {
    title: 'English',
    lang: 'en_US',
    icon: getAssetURL('main/en-US.png')
  },
  // {
  //   title: '简体中文',
  //   lang: 'zh_CN',
  //   icon: getAssetURL('main/zh-CN.png')
  // }
]

if (localStorage.getItem('lang')) {
  const index = nationList.findIndex(item => item.lang === localStorage.getItem('lang'))
  langImg.value = nationList[index].icon
  nationIndex.value = index
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

//切换语言
const changeLanguage = (lang) => {
  locale.value = lang
  localStorage.setItem('lang', lang)
  location.reload()
}

function setRem() {
  const scale = document.documentElement.clientWidth
  if (scale > 750) {
    document.documentElement.style.fontSize = '41.4px'
  }
}

// 初始化
setRem()

window.onresize = function() {
  setRem()
}

</script>

<style lang='less' scoped>
.navbar {
  position: sticky;
  z-index: 9;
  top: 0;
  width: 100%;
  height: 50px;
  background-color: #222222;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 12px;
  box-sizing: border-box;

  .navber-right {
    display: flex;
    align-items: center;
  }

  .navbar-img {
    width: 32px;
    height: 32px;
  }

  .langImg {
    width: 24px;
    height: 24px;
    object-fit: contain;
  }

  .clockImg {
    margin-left: 10px;
  }

  .navbar-left {
    display: flex;
    align-items: center;
    font-size: 17px;

  }
}

.nation {
  width: 380px;
  margin: 60px auto;

  .nation-list {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 58px;
    padding: 16px;
    margin-bottom: 15px;
    box-shadow: 0 4px 10px 0 rgba(0, 0, 0, .3);
    background-color: var(--bg-color);
    border: 1px solid var(--second-color);
    overflow: hidden;
    border-radius: 10px;
    box-sizing: border-box;

    .nation-left {
      display: flex;
      align-items: center;
      font-size: 13.2px;
    }

    img {
      width: 25px;
      height: 25px;
      object-fit: contain;
    }

    span {
      margin-left: 10px;
    }
  }

  :deep(.van-badge) {
    font-size: 8px !important;
  }
}


</style>
