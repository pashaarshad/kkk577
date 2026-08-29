<template>
  <div class="app-container" :class="{ 'is-desktop': isDesktop }">
    <!-- Desktop Layout -->
    <div v-if="isDesktop" class="desktop-layout">
      <!-- Sidebar -->
      <aside v-if="showSidebar" class="desktop-sidebar" :class="{ 'collapsed': isSidebarCollapsed }">
        <div class="sidebar-logo">
          <img src="@/assets/img/main/logo.jpg" class="logo-img" />
          <div class="logo-text" v-show="!isSidebarCollapsed">
            <h3>KKK577</h3>
            <span>EARN & GROW TOGETHER</span>
          </div>
        </div>
        
        <nav class="sidebar-menu">
          <div class="menu-section">
            <router-link to="/home" class="menu-item" active-class="active">
              <van-icon name="apps-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Dashboard</span>
            </router-link>
            <router-link to="/work" class="menu-item" active-class="active">
              <van-icon name="bar-chart-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Projects</span>
            </router-link>
            <router-link to="/order" class="menu-item" active-class="active">
              <van-icon name="orders-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Orders</span>
            </router-link>
            <router-link to="/team" class="menu-item" active-class="active">
              <van-icon name="friends-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Team</span>
            </router-link>
          </div>

          <div class="menu-group-title" v-show="!isSidebarCollapsed">WALLET</div>
          <div class="menu-section">
            <router-link to="/bankCard" class="menu-item" active-class="active">
              <van-icon name="card" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Wallet</span>
            </router-link>
            <router-link to="/recharge" class="menu-item" active-class="active">
              <van-icon name="gold-coin-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Recharge</span>
            </router-link>
            <router-link to="/withdraw" class="menu-item" active-class="active">
              <van-icon name="balance-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Withdraw</span>
            </router-link>
            <router-link to="/billList" class="menu-item" active-class="active">
              <van-icon name="bill-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Transactions</span>
            </router-link>
          </div>

          <div class="menu-group-title" v-show="!isSidebarCollapsed">ACCOUNT</div>
          <div class="menu-section">
            <router-link to="/mine" class="menu-item" active-class="active">
              <van-icon name="user-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Profile</span>
            </router-link>
            <router-link to="/password" class="menu-item" active-class="active">
              <van-icon name="setting-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Settings</span>
            </router-link>
            <router-link to="/message" class="menu-item" active-class="active">
              <van-icon name="chat-o" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Support</span>
            </router-link>
            <div @click="onLogout" class="menu-item logout-btn">
              <van-icon name="close" class="menu-icon" />
              <span v-show="!isSidebarCollapsed">Logout</span>
            </div>
          </div>
        </nav>

        <div class="invite-banner" v-show="!isSidebarCollapsed">
          <div class="invite-card">
            <h4>Invite Friends</h4>
            <p>Earn More Rewards</p>
            <router-link to="/home" class="invite-btn">Invite Now</router-link>
          </div>
        </div>

        <button class="collapse-toggle" @click="isSidebarCollapsed = !isSidebarCollapsed">
          <van-icon :name="isSidebarCollapsed ? 'arrow' : 'arrow-left'" />
          <span v-show="!isSidebarCollapsed">Collapse</span>
        </button>
      </aside>

      <!-- Main Panel -->
      <div class="desktop-main">
        <!-- Header -->
        <header v-if="showSidebar" class="desktop-header">
          <div class="header-left">
            <van-icon name="wap-nav" class="toggle-icon" @click="isSidebarCollapsed = !isSidebarCollapsed" />
            <h2 class="page-title">{{ currentPageTitle }}</h2>
          </div>
          <div class="header-right">
            <div class="lang-selector">
              <van-icon name="global" />
              <span>English</span>
              <van-icon name="arrow-down" />
            </div>
            <div class="notification-bell">
              <van-icon name="bell" badge="3" />
            </div>
            <div class="user-profile" v-if="userInfo">
              <img :src="userInfo.headpic || 'https://fastly.jsdelivr.net/npm/@vant/assets/cat.jpeg'" class="avatar" />
              <div class="user-meta">
                <span class="user-name">{{ userInfo.tel }}</span>
                <span class="vip-badge">VIP {{ userInfo.level }}</span>
              </div>
            </div>
          </div>
        </header>

        <!-- Page View Wrapper -->
        <main class="desktop-content" :class="{ 'full-screen': !showSidebar }">
          <div class="content-wrapper" :class="route.name === 'home' ? 'wide' : (showSidebar ? 'narrow' : 'login-box')">
            <router-view />
          </div>
        </main>

        <!-- Footer Crypto Ticker -->
        <footer v-if="showSidebar" class="desktop-footer">
          <div class="ticker-container">
            <div class="ticker-item"><span class="coin">BTC/USDT</span> <span class="price">67,892.41</span> <span class="change positive">+1.25%</span></div>
            <div class="ticker-item"><span class="coin">ETH/USDT</span> <span class="price">3,782.16</span> <span class="change positive">+0.85%</span></div>
            <div class="ticker-item"><span class="coin">TRX/USDT</span> <span class="price">0.1223</span> <span class="change positive">+1.10%</span></div>
            <div class="ticker-item"><span class="coin">BNB/USDT</span> <span class="price">610.54</span> <span class="change positive">+0.65%</span></div>
          </div>
          <div class="footer-copy">© 2026 KKKS77. All Rights Reserved.</div>
        </footer>
      </div>
    </div>

    <!-- Mobile Layout -->
    <div v-else class="mobile-layout">
      <NavBar v-if="$route.meta.navbarShow" />
      <router-view />
      <Tabbar v-if="$route.meta.tabbarShow" />
    </div>

    <Loading />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import Loading from '@/components/loading/index.vue'
import Tabbar from '@/components/tabbar/index.vue'
import NavBar from '@/components/navbar/index.vue'

const route = useRoute()
const router = useRouter()

const isDesktop = ref(window.innerWidth >= 992)
const isSidebarCollapsed = ref(false)
const userInfo = ref(null)

const handleResize = () => {
  isDesktop.value = window.innerWidth >= 992
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
  fetchUserInfo()
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})

const fetchUserInfo = () => {
  const token = sessionStorage.getItem('token')
  if (token) {
    fetch('/api/index/index/home', { credentials: 'include' })
      .then(res => res.json())
      .then(res => {
        if (res?.data?.user_info) {
          userInfo.value = res.data.user_info
        }
      })
      .catch(err => {
        console.log('Error fetching user info in App.vue:', err)
      })
  }
}

// Watch for route change to update user info in case they log in
router.afterEach(() => {
  fetchUserInfo()
})

const currentPageTitle = computed(() => {
  const name = route.name
  if (!name) return 'Dashboard'
  switch (name) {
    case 'home': return 'Dashboard'
    case 'work': return 'Projects'
    case 'order': return 'Orders'
    case 'team': return 'Team'
    case 'bankCard': return 'Wallet'
    case 'recharge': return 'Recharge'
    case 'withdraw': return 'Withdraw'
    case 'billList': return 'Transactions'
    case 'mine': return 'Profile'
    case 'password': return 'Settings'
    case 'message': return 'Support'
    default: return name.charAt(0).toUpperCase() + name.slice(1)
  }
})

const onLogout = () => {
  sessionStorage.removeItem('token')
  userInfo.value = null
  router.push('/login')
}

const showSidebar = computed(() => {
  return route.name !== 'login' && route.name !== 'register'
})
</script>

<style lang="less">
/* We use global styles to adjust body and #app behavior on desktop */
@media (min-width: 992px) {
  #app {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
  }
}
</style>

<style lang="less" scoped>
.app-container {
  min-height: 100vh;
  background-color: #f7f8fb;
}

/* Desktop styles */
.desktop-layout {
  display: flex;
  min-height: 100vh;
  background-color: #f8fafc;
  color: #1e293b;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
  
  .desktop-sidebar {
    width: 260px;
    background-color: #ffffff;
    border-right: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    padding: 24px 16px;
    transition: width 0.3s ease;
    flex-shrink: 0;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.02);
    position: sticky;
    top: 0;
    height: 100vh;
    box-sizing: border-box;

    &.collapsed {
      width: 80px;
      padding: 24px 8px;
      align-items: center;
      
      .menu-item {
        justify-content: center;
        padding: 12px 0;
      }
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 32px;
      padding: 0 8px;

      .logo-img {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        object-fit: contain;
        flex-shrink: 0;
      }

      .logo-text {
        h3 {
          margin: 0;
          font-size: 18px;
          font-weight: 700;
          letter-spacing: 0.5px;
          color: #0f172a;
        }
        span {
          font-size: 9px;
          color: #64748b;
          font-weight: 600;
          letter-spacing: 0.2px;
        }
      }
    }

    .sidebar-menu {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 16px;
      overflow-y: auto;

      .menu-group-title {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 1px;
        margin-top: 16px;
        padding: 0 12px;
      }

      .menu-section {
        display: flex;
        flex-direction: column;
        gap: 6px;
      }

      .menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 8px;
        color: #64748b;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;

        &:hover {
          background-color: #f1f5f9;
          color: #0f172a;
        }

        &.active {
          background-color: #eff6ff;
          color: #2563eb;
        }

        .menu-icon {
          font-size: 20px;
          flex-shrink: 0;
        }
      }

      .logout-btn {
        color: #ef4444;
        &:hover {
          background-color: #fee2e2;
          color: #ef4444;
        }
      }
    }

    .invite-banner {
      margin-top: auto;
      padding: 8px;

      .invite-card {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border: 1px dashed #bfdbfe;
        border-radius: 12px;
        padding: 16px;
        text-align: center;

        h4 {
          margin: 0;
          font-size: 14px;
          color: #1e3a8a;
          font-weight: 700;
        }
        p {
          margin: 4px 0 12px;
          font-size: 11px;
          color: #3b82f6;
        }
        .invite-btn {
          display: inline-block;
          background-color: #2563eb;
          color: white;
          padding: 8px 16px;
          border-radius: 6px;
          font-size: 12px;
          font-weight: 600;
          text-decoration: none;
          transition: background 0.2s;
          &:hover {
            background-color: #1d4ed8;
          }
        }
      }
    }

    .collapse-toggle {
      background: none;
      border: none;
      display: flex;
      align-items: center;
      gap: 12px;
      color: #94a3b8;
      font-size: 13px;
      font-weight: 600;
      padding: 12px;
      cursor: pointer;
      width: 100%;
      border-top: 1px solid #e2e8f0;
      margin-top: 16px;
      
      &:hover {
        color: #475569;
      }
    }
  }

  .desktop-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
    
    .desktop-header {
      background-color: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 32px;
      position: sticky;
      top: 0;
      z-index: 10;

      .header-left {
        display: flex;
        align-items: center;
        gap: 16px;

        .toggle-icon {
          font-size: 20px;
          color: #64748b;
          cursor: pointer;
          &:hover {
            color: #0f172a;
          }
        }

        .page-title {
          margin: 0;
          font-size: 20px;
          font-weight: 700;
          color: #0f172a;
        }
      }

      .header-right {
        display: flex;
        align-items: center;
        gap: 24px;

        .lang-selector {
          display: flex;
          align-items: center;
          gap: 6px;
          font-size: 14px;
          color: #64748b;
          cursor: pointer;
          padding: 6px 12px;
          border: 1px solid #e2e8f0;
          border-radius: 20px;
          &:hover {
            background-color: #f8fafc;
          }
        }

        .notification-bell {
          font-size: 20px;
          color: #64748b;
          cursor: pointer;
          position: relative;
          display: flex;
          align-items: center;
        }

        .user-profile {
          display: flex;
          align-items: center;
          gap: 12px;

          .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eff6ff;
          }

          .user-meta {
            display: flex;
            flex-direction: column;

            .user-name {
              font-size: 14px;
              font-weight: 600;
              color: #0f172a;
            }

            .vip-badge {
              font-size: 10px;
              font-weight: 700;
              color: #d97706;
              background-color: #fef3c7;
              padding: 1px 6px;
              border-radius: 4px;
              align-self: flex-start;
              margin-top: 2px;
            }
          }
        }
      }
    }

    .desktop-content {
      flex: 1;
      padding: 32px;
      overflow-y: auto;
      background-color: #f8fafc;
      display: flex;
      flex-direction: column;
      
      &.full-screen {
        min-height: 100vh;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        padding: 0;
      }
      
      .content-wrapper {
        margin: 0 auto;
        width: 100%;
        
        &.wide {
          max-width: 1200px;
        }
        
        &.narrow {
          max-width: 600px;
          background-color: #ffffff;
          border-radius: 16px;
          padding: 24px;
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
          border: 1px solid #e2e8f0;
          box-sizing: border-box;
          min-height: calc(100vh - 200px);
        }
        
        &.login-box {
          max-width: 450px;
          background-color: #ffffff;
          border-radius: 20px;
          padding: 32px;
          box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
          border: 1px solid #e2e8f0;
          box-sizing: border-box;
        }
      }
    }

    .desktop-footer {
      background-color: #ffffff;
      border-top: 1px solid #e2e8f0;
      padding: 16px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      color: #64748b;

      .ticker-container {
        display: flex;
        gap: 24px;
        overflow-x: auto;

        .ticker-item {
          display: flex;
          align-items: center;
          gap: 6px;

          .coin {
            font-weight: 700;
            color: #475569;
          }
          .price {
            font-weight: 600;
            color: #0f172a;
          }
          .change {
            font-size: 11px;
            font-weight: 700;
            &.positive {
              color: #10b981;
            }
          }
        }
      }

      .footer-copy {
        font-weight: 550;
      }
    }
  }
}
</style>
