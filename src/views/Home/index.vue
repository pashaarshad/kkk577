<!-- Home  -->
<template>
  <div class="Home">
    <!-- Banner Swipe -->
    <div class="swipe">
      <van-swipe :autoplay="3000" class="my-swipe" indicator-color="white">
        <template v-for="item in data.banner" :key="item.id">
          <van-swipe-item>
            <img :src="item.image" alt="" class="swipe-img">
          </van-swipe-item>
        </template>
      </van-swipe>
    </div>

    <!-- Scrolling Notice -->
    <div class="notice">
      <div class="notice-icon">
        <div></div>
      </div>
      <div class="notice-content">
        <van-notice-bar background="var(--bg-color)" color="var(--text-second)">
          service accounts, other unofficial customer service accounts are all scammers.
        </van-notice-bar>
      </div>
    </div>

    <!-- User Profile Card -->
    <div v-show="loginShow" class="box user-profile-card">
      <div class="profile-header">
        <div class="profile-header-left">
          <span class="phone-number">{{ data.user_info?.tel }}</span>
        </div>
        <div class="profile-header-right" @click="copyInviteCode">
          <van-icon name="share-o" class="copy-icon" />
        </div>
      </div>
      <div class="balance-container">
        <div class="balance-pill">
          <span class="label">Balance</span>
          <span class="divider">|</span>
          <span class="val">$ {{ data.user_info?.balance || '0' }}</span>
        </div>
      </div>
    </div>

    <!-- Quick Menu Icons (3-2 grid) -->
    <div class="menu">
      <div v-for="(item, index) in menu" :key="index" class="menu-item" @click="onMenuClick(item.path)">
        <div class="menu-icon-wrapper">
          <img :src="item.icon" alt="" class="menu-icon-img">
        </div>
        <div class="menu-title">{{ item.title }}</div>
      </div>
    </div>

    <!-- Activities Deck -->
    <Commission :list="data.deposit_list" />

    <!-- Project Hall Section -->
    <div class="project-hall">
      <div class="section-title">Project hall</div>
      <div class="project-list">
        <div v-for="item in vipList.slice(0, 3)" :key="item.id" class="project-card" @click="router.push('/work')">
          <img :src="item.img" alt="" class="project-img">
          <div class="project-details">
            <div class="profit-row">
              <span class="val">$ {{ (item.num * 3.6).toFixed(2) }}</span>
              <span class="lbl">The total profit</span>
            </div>
            <div class="price-row">
              <span class="val">$ {{ (item.num_min || item.num).toFixed(2) }}</span>
              <span class="lbl">Price</span>
            </div>
            <div class="vip-tag-wrapper">
              <span class="vip-tag">{{ item.name }}</span>
            </div>
          </div>
          <div class="project-arrow">
            <van-icon name="arrow" />
          </div>
        </div>
      </div>
    </div>

    <!-- Platform Introduction -->
    <div class="platform-intro">
      <div class="section-title">Platform Introduction</div>
      <div class="video-wrapper">
        <video controls width="100%" class="intro-video" poster="https://xiongmao002.com/api//file/cfg/202312/14/96566d7cf790464587998b55e4ef1aa8_.jpg">
          <source src="" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>

    <!-- Member List -->
    <div class="member-list-section">
      <div class="section-title">Member list</div>
      <div class="member-grid">
        <div class="member-card">
          <span class="val">+$ 3.00</span>
          <span class="phone">+855******1187</span>
        </div>
        <div class="member-card">
          <span class="val">+$ 3.00</span>
          <span class="phone">+233******3392</span>
        </div>
        <div class="member-card">
          <span class="val">+$ 20.00</span>
          <span class="phone">gus******@gma.com</span>
        </div>
        <div class="member-card">
          <span class="val">+$ 20.00</span>
          <span class="phone">sal******@icloud.com</span>
        </div>
      </div>
    </div>

    <!-- Regulatory Authority -->
    <div class="regulatory-section">
      <div class="section-title">Regulatory Authority</div>
      <div class="regulatory-grid">
        <div class="regulatory-card cftc-logo">
          <div class="logo-title">CFTC</div>
          <div class="logo-desc">Commodity Futures Trading Commission</div>
        </div>
        <div class="regulatory-card finra-logo">
          <div class="logo-title">finra</div>
          <div class="logo-desc">Financial Industry Regulatory Authority</div>
        </div>
        <div class="regulatory-card framework-logo bg-blue-dark">
          <div class="logo-title">U.S. Financial</div>
          <div class="logo-desc">Regulatory Framework</div>
        </div>
        <div class="regulatory-card framework-logo bg-navy-dark">
          <div class="logo-title">U.S. Financial</div>
          <div class="logo-desc">Regulatory Framework</div>
        </div>
      </div>
    </div>

    <!-- Partner Grid -->
    <div class="partner">
      <div class="section-title">{{ $t('home.partnerTitle') }}</div>
      <div class="partner-list">
        <div v-for="(item, index) in footList" :key="index" class="partner-item">
          <img :src="item" alt="">
        </div>
      </div>
    </div>

    <!-- Floating Accessories -->
    <div class="floating-whatsapp" @click="openWhatsApp">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
    </div>
    <div class="floating-actions-right">
      <div class="floating-btn gift" @click="router.push('/work')">
        <van-icon name="gift-o" />
      </div>
      <div class="floating-btn email" @click="router.push('/message')">
        <van-icon name="envelop-o" />
      </div>
    </div>
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

const menu = [
  {
    title: 'Recharge',
    icon: getAssetURL('home/ic_recharge.png'),
    path: '/recharge'
  },
  {
    title: 'Withdraw',
    icon: getAssetURL('home/ic_withdraw.png'),
    path: '/withdraw'
  },
  {
    title: 'Company Profile',
    icon: getAssetURL('home/ic-company.png'),
    path: '/poster/detail/12'
  },
  {
    title: 'Invite Friends',
    icon: getAssetURL('home/ic_invite.png'),
    path: '/poster/detail/13'
  },
  {
    title: 'Agency Cooperation',
    icon: getAssetURL('home/ic-agent.png'),
    path: '/poster/detail/14'
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

const copyInviteCode = () => {
  const code = data.value.user_info?.invite_code || ''
  navigator.clipboard.writeText(code)
  showSuccessToast('Copy invite code successfully: ' + code)
}

const openWhatsApp = () => {
  window.open('https://wa.me/', '_blank')
}

const onMenuClick = (path) => {
  router.push(path)
}
</script>

<style lang="less" scoped>
.Home {
  padding-bottom: 90px;
  background: var(--bg-second-color);

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
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 16px 8px;
    background-color: var(--bg-color);
    border-radius: 12px;
    width: 92%;
    margin: 10px auto;
    box-sizing: border-box;
    border: 1px solid var(--second-color);

    .menu-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 30%;
      margin-bottom: 12px;
      cursor: pointer;

      .menu-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: var(--second-color);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
        border: 1px solid var(--main-color);

        .menu-icon-img {
          width: 24px;
          height: 24px;
          object-fit: contain;
        }
      }

      .menu-title {
        font-size: 12px;
        color: var(--default-color);
        text-align: center;
        font-weight: 600;
      }
    }
  }

  .notice {
    display: flex;
    padding: 0px 16px;
    margin-top: 10px;

    .notice-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      background: #000;
      border-radius: 8px 0 0 8px;

      div {
        width: 20px;
        height: 20px;
        background: url("../../assets/img/home/ic_notice.png") no-repeat 100%/cover;
      }
    }

    .notice-content {
      width: 100%;
      border: 1px solid var(--second-color);
      border-left: none;
      color: var(--text-second);
      background-color: var(--bg-color);
      border-radius: 0 8px 8px 0;

      .van-notice-bar {
        height: 100%;
        color: var(--text-second);
      }
    }
  }

  .user-profile-card {
    width: 92%;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.3);
    background-color: var(--bg-color);
    border: 1px solid var(--second-color);
    box-sizing: border-box;
    margin: 20px auto;
    display: flex;
    flex-direction: column;
    gap: 14px;

    .profile-header {
      display: flex;
      justify-content: space-between;
      align-items: center;

      .phone-number {
        font-size: 15px;
        font-weight: 700;
        color: var(--default-color);
      }

      .copy-icon {
        font-size: 20px;
        color: var(--main-color);
        cursor: pointer;
      }
    }

    .balance-container {
      display: flex;
      justify-content: center;

      .balance-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: var(--bg-second-color);
        padding: 8px 32px;
        border-radius: 30px;
        border: 1px solid var(--second-color);

        .label {
          font-size: 14px;
          color: var(--text-second);
          font-weight: 600;
        }

        .divider {
          color: var(--second-color);
        }

        .val {
          font-size: 16px;
          color: var(--main-color);
          font-weight: 750;
        }
      }
    }
  }

  .section-title {
    font-size: 20px;
    font-weight: 700 !important;
    margin: 30px 0 16px;
    color: var(--default-color);
  }

  .project-hall {
    width: 92%;
    margin: 0 auto;

    .project-list {
      display: flex;
      flex-direction: column;
      gap: 12px;

      .project-card {
        background-color: var(--bg-color);
        border: 1px solid var(--second-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        overflow: hidden;
        cursor: pointer;
        height: 100px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);

        .project-img {
          width: 80px;
          height: 80px;
          object-fit: cover;
          margin-left: 10px;
          border-radius: 8px;
        }

        .project-details {
          flex: 1;
          padding: 10px 16px;
          display: flex;
          flex-direction: column;
          gap: 4px;

          .profit-row, .price-row {
            display: flex;
            align-items: baseline;
            gap: 6px;

            .val {
              font-size: 14px;
              font-weight: 700;
            }

            .lbl {
              font-size: 10px;
              color: var(--text-second);
            }
          }

          .profit-row .val {
            color: var(--main-color);
          }

          .price-row .val {
            color: var(--red-color);
          }

          .vip-tag-wrapper {
            margin-top: 2px;
            .vip-tag {
              background-color: #000;
              color: var(--main-color);
              font-size: 10px;
              font-weight: 700;
              padding: 2px 8px;
              border-radius: 4px;
            }
          }
        }

        .project-arrow {
          background-color: var(--main-color);
          width: 32px;
          height: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #000;
          font-size: 20px;
          font-weight: bold;
        }
      }
    }
  }

  .platform-intro {
    width: 92%;
    margin: 0 auto;

    .video-wrapper {
      background-color: var(--bg-color);
      border: 1px solid var(--second-color);
      border-radius: 12px;
      overflow: hidden;
      padding: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);

      .intro-video {
        border-radius: 8px;
        display: block;
      }
    }
  }

  .member-list-section {
    width: 92%;
    margin: 0 auto;

    .member-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;

      .member-card {
        background-color: var(--bg-color);
        border: 1px solid var(--main-color);
        border-radius: 12px;
        padding: 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);

        .val {
          font-size: 15px;
          font-weight: 700;
          color: var(--main-color);
        }

        .phone {
          font-size: 11px;
          color: var(--text-second);
        }
      }
    }
  }

  .regulatory-section {
    width: 92%;
    margin: 0 auto;

    .regulatory-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;

      .regulatory-card {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 16px;
        height: 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-sizing: border-box;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);

        .logo-title {
          font-size: 20px;
          font-weight: bold;
          line-height: 1.1;
        }

        .logo-desc {
          font-size: 8px;
          margin-top: 4px;
          line-height: 1.2;
        }

        &.cftc-logo {
          border-left: 6px solid #b22234;
          .logo-title {
            color: #1a365d;
          }
          .logo-desc {
            color: #4a5568;
          }
        }

        &.finra-logo {
          border-left: 6px solid #00a4e4;
          .logo-title {
            color: #0b2265;
            font-style: italic;
          }
          .logo-desc {
            color: #4a5568;
          }
        }

        &.bg-blue-dark {
          background-color: #1a365d;
          color: #ffffff;
          border: 1px solid #2a4365;
          .logo-title {
            color: #ffffff;
          }
          .logo-desc {
            color: #cbd5e0;
          }
        }

        &.bg-navy-dark {
          background-color: #0b2265;
          color: #ffffff;
          border: 1px solid #1a365d;
          .logo-title {
            color: #ffffff;
          }
          .logo-desc {
            color: #cbd5e0;
          }
        }
      }
    }
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
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
      }

      img {
        height: 24px;
        max-width: 90%;
        object-fit: contain;
      }
    }
  }

  /* Floating bubble accessories */
  .floating-whatsapp {
    position: fixed;
    bottom: 80px;
    left: 16px;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: #25d366;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99;
    cursor: pointer;
    transition: transform 0.2s;

    &:hover {
      transform: scale(1.1);
    }

    img {
      width: 28px;
      height: 28px;
    }
  }

  .floating-actions-right {
    position: fixed;
    bottom: 80px;
    right: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    z-index: 99;

    .floating-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: var(--bg-color);
      border: 1px solid var(--second-color);
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--main-color);
      font-size: 20px;
      cursor: pointer;
      transition: transform 0.2s;

      &:hover {
        transform: scale(1.1);
      }
    }
  }
}
</style>
