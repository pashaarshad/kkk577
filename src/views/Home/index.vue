<!-- Home  -->
<template>
  <div class="Home">
    <!-- Desktop Dashboard View -->
    <div v-if="isDesktop" class="desktop-home-container">
      <div class="desktop-welcome-banner">
        <div class="welcome-text">
          <h2>Welcome back, {{ data.user_info?.tel || 'User' }}! 👋</h2>
          <p>Here's what's happening with your account today.</p>
        </div>
        <div class="datetime-card">
          <van-icon name="clock-o" class="clock-icon" />
          <span>{{ currentDateTime }}</span>
        </div>
      </div>

      <div class="desktop-stats-grid">
        <!-- Card 1: Balance -->
        <div class="stat-card card-blue">
          <div class="card-left">
            <span class="card-title">Total Balance</span>
            <h3 class="card-value">{{ $t('main.money') }} {{ data.user_info?.balance || '0.00' }}</h3>
            <span class="card-subtitle">Available for withdrawal</span>
          </div>
          <van-icon name="card" class="card-icon" />
        </div>

        <!-- Card 2: Today's Earnings -->
        <div class="stat-card card-green">
          <div class="card-left">
            <span class="card-title">Today's Earnings</span>
            <h3 class="card-value">{{ $t('main.money') }} {{ data.today_commission || '0.00' }}</h3>
            <span class="card-subtitle positive">+12.5% vs yesterday</span>
          </div>
          <van-icon name="chart-trending-o" class="card-icon" />
        </div>

        <!-- Card 3: Total Earnings -->
        <div class="stat-card card-purple">
          <div class="card-left">
            <span class="card-title">Total Earnings</span>
            <h3 class="card-value">{{ $t('main.money') }} {{ data.commission || '0.00' }}</h3>
            <span class="card-subtitle">All time income</span>
          </div>
          <van-icon name="balance-o" class="card-icon" />
        </div>

        <!-- Card 4: Team Benefits -->
        <div class="stat-card card-yellow">
          <div class="card-left">
            <span class="card-title">Team Benefits</span>
            <h3 class="card-value">{{ $t('main.money') }} {{ data.team_commission || '0.00' }}</h3>
            <span class="card-subtitle">Total team income</span>
          </div>
          <van-icon name="star-o" class="card-icon" />
        </div>
      </div>

      <div class="desktop-quick-actions">
        <h3>Quick Actions</h3>
        <div class="actions-grid">
          <div class="action-item" @click="router.push('/recharge')">
            <div class="action-icon bg-blue"><van-icon name="gold-coin-o" /></div>
            <div class="action-text">
              <h4>Recharge</h4>
              <p>Add funds to account</p>
            </div>
          </div>
          <div class="action-item" @click="router.push('/withdraw')">
            <div class="action-icon bg-green"><van-icon name="balance-o" /></div>
            <div class="action-text">
              <h4>Withdraw</h4>
              <p>Request withdrawal</p>
            </div>
          </div>
          <div class="action-item" @click="router.push('/home')">
            <div class="action-icon bg-purple"><van-icon name="share-o" /></div>
            <div class="action-text">
              <h4>Invite Friends</h4>
              <p>Grow your team</p>
            </div>
          </div>
          <div class="action-item" @click="router.push('/team')">
            <div class="action-icon bg-yellow"><van-icon name="friends-o" /></div>
            <div class="action-text">
              <h4>Team Report</h4>
              <p>View team analytics</p>
            </div>
          </div>
        </div>
      </div>

      <div class="desktop-columns">
        <!-- Left Column: Chart -->
        <div class="column-left">
          <div class="panel-header">
            <h3>Earnings Overview</h3>
          </div>
          <div class="panel-body chart-panel">
            <svg viewBox="0 0 500 200" class="chart-svg">
              <line x1="50" y1="20" x2="480" y2="20" stroke="#f1f5f9" stroke-width="1" />
              <line x1="50" y1="60" x2="480" y2="60" stroke="#f1f5f9" stroke-width="1" />
              <line x1="50" y1="100" x2="480" y2="100" stroke="#f1f5f9" stroke-width="1" />
              <line x1="50" y1="140" x2="480" y2="140" stroke="#f1f5f9" stroke-width="1" />
              <line x1="50" y1="170" x2="480" y2="170" stroke="#cbd5e1" stroke-width="1.5" />
              <path d="M 50 150 Q 120 100, 190 120 T 330 80 T 480 40" fill="none" stroke="#2563eb" stroke-width="3" />
              <path d="M 50 150 Q 120 100, 190 120 T 330 80 T 480 40 L 480 170 L 50 170 Z" fill="url(#chart-gradient)" opacity="0.1" />
              <circle cx="50" cy="150" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
              <circle cx="120" cy="108" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
              <circle cx="190" cy="120" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
              <circle cx="260" cy="98" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
              <circle cx="330" cy="80" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
              <circle cx="400" cy="58" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
              <circle cx="480" cy="40" r="5" fill="#2563eb" stroke="#ffffff" stroke-width="1.5" />
              <defs>
                <linearGradient id="chart-gradient" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#2563eb" />
                  <stop offset="100%" stop-color="#2563eb" stop-opacity="0" />
                </linearGradient>
              </defs>
            </svg>
            <div class="chart-labels">
              <span>23 May</span>
              <span>24 May</span>
              <span>25 May</span>
              <span>26 May</span>
              <span>27 May</span>
              <span>28 May</span>
              <span>29 May</span>
            </div>
          </div>
        </div>

        <!-- Middle Column: Recent Activities -->
        <div class="column-middle">
          <div class="panel-header">
            <h3>Recent Activities</h3>
            <router-link to="/billList" class="view-all-link">View All</router-link>
          </div>
          <div class="panel-body list-panel">
            <div v-for="item in data.deposit_list?.slice(0, 5)" :key="item.id" class="activity-item">
              <div class="activity-icon bg-green-light"><van-icon name="success" /></div>
              <div class="activity-text">
                <h4>Recharge Successful</h4>
                <p>ID: {{ item.id }}</p>
              </div>
              <span class="activity-amount positive">+{{ $t('main.money') }} {{ item.num }}</span>
            </div>
            <div v-if="!data.deposit_list || data.deposit_list.length === 0" class="empty-state">
              No recent activities found.
            </div>
          </div>
        </div>

        <!-- Right Column: Top Projects -->
        <div class="column-right">
          <div class="panel-header">
            <h3>Top Projects</h3>
            <router-link to="/work" class="view-all-link">View All</router-link>
          </div>
          <div class="panel-body list-panel">
            <div v-for="item in vipList?.slice(0, 4)" :key="item.id" class="project-item">
              <img :src="item.img" class="project-img" />
              <div class="project-info">
                <h4>{{ item.name }}</h4>
                <p>Daily Profit: {{ (item.bili * 100).toFixed(2) }}% • Min: {{ $t('main.money') }} {{ item.num_min }}</p>
              </div>
              <button class="invest-btn" @click="router.push('/work')">Invest Now</button>
            </div>
            <div v-if="!vipList || vipList.length === 0" class="empty-state">
              No projects found.
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Home View (Original) -->
    <div v-else class="mobile-home-container">
      <div class='swipe'>
        <van-swipe :autoplay='3000' class='my-swipe' indicator-color='white'>
          <template v-for='item in data.banner'>
            <van-swipe-item>
              <img :src='item.image' alt='' class='swipe-img'>
            </van-swipe-item>
          </template>
        </van-swipe>
      </div>

      <div class='menu'>
        <div v-for='(item, index) in menu' class='menu-list' @click='onMenuClick(item.path)'>
          <div>{{ item.title }}</div>
          <div>
            <img :src='item.icon' alt=''>
          </div>
        </div>
      </div>

      <div class='notice'>
        <div class='notice-icon'>
          <div></div>
        </div>
        <div class='notice-content'>
          <van-notice-bar background='#ffffff' color='#a2a2a2'>
            la información de tu cuenta
          </van-notice-bar>
        </div>
      </div>

      <div v-show='loginShow' class='box'>
        <div class='box-title'>
          <span>{{ $t('home.user.name') }}</span>
          <span>{{ data.user_info?.tel }}</span>
        </div>
        <div class='box-title'>
          <span>{{ $t('home.user.code') }}</span>
          <span>{{ data.user_info?.invite_code }}</span>
        </div>
        <div class='box-mony'>
          <div class='box-mony-list'>
            <span>{{ $t('home.user.balance') }}</span>
            <div>{{ $t('main.money') }} {{ data?.user_info?.balance }}</div>
          </div>
          <div class='box-mony-list'>
            <span>{{ $t('home.user.task') }}</span>
            <div>{{ $t('main.money') }} {{ data?.user_info?.balance }}</div>
          </div>
        </div>
        <div class='line-divider'></div>
        <div class='box-day'>
          <div class='box-day-list'>
            <div>{{ $t('home.user.today') }}</div>
            <div>{{ $t('main.money') }} {{ data?.today_commission }}</div>
          </div>
          <div class='box-day-list'>
            <div>{{ $t('home.user.yesterday') }}</div>
            <div>{{ $t('main.money') }} {{ data?.yestarday_commission }}</div>
          </div>
          <div class='box-day-list'>
            <div>{{ $t('home.user.total') }}</div>
            <div>{{ $t('main.money') }} {{ data?.team_commission }}</div>
          </div>
          <div class='box-day-list'>
            <div>{{ $t('home.user.group') }}</div>
            <div>{{ $t('main.money') }} {{ data?.commission }}</div>
          </div>
        </div>
      </div>

      <Commission :list='data.deposit_list' />

      <div class='quick-entry'>
        <div v-for='item in quickEntries' :key='item.id' class='quick-entry-item' @click='onEntryClick(item.id)'>
          <img :src='item.icon' alt='' class='quick-entry-icon'>
          <div class='quick-entry-title'>{{ item.title }}</div>
        </div>
      </div>

      <div class='partner'>
        <div class='title'>{{ $t('home.partnerTitle') }}</div>
        <div class='partner-list'>
          <div v-for='item in footList' class='partner-item'>
            <img :src='item' alt=''>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { i18n } from '@/lang'
import Commission from '@/components/commission/index.vue'
import { getAssetURL } from '@/utils/get_assets_img.js'
import Request from '@/services/index.js'
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const { t } = i18n.global
const router = useRouter()

const isDesktop = ref(window.innerWidth >= 992)
const currentDateTime = ref('')
let datetimeTimer = null

const handleResize = () => {
  isDesktop.value = window.innerWidth >= 992
}

const updateDateTime = () => {
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true }
  currentDateTime.value = new Date().toLocaleString('en-US', options)
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
  updateDateTime()
  datetimeTimer = setInterval(updateDateTime, 1000)
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
  if (datetimeTimer) clearInterval(datetimeTimer)
})

const menu = [
  {
    title: t('home.recharge'),
    icon: getAssetURL('home/ic_recharge.png'),
    path: '/recharge'
  },
  {
    title: t('home.embody'),
    icon: getAssetURL('home/ic_withdraw.png'),
    path: '/withdraw'
  },
  {
    title: t('home.invite'),
    icon: getAssetURL('home/ic_invite.png'),
    path: '/'
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

const quickEntries = [
  {
    title: t('home.companyProfile'),
    icon: getAssetURL('home/ic-company.png'),
    id: 12
  },
  {
    title: t('home.ruleDescription'),
    icon: getAssetURL('home/ic-rule.png'),
    id: 13
  },
  {
    title: t('home.agentCooperation'),
    icon: getAssetURL('home/ic-agent.png'),
    id: 14
  },
  {
    title: t('home.companyQualifications'),
    icon: getAssetURL('home/ic-cert.png'),
    id: 15
  }
]

const onEntryClick = (id) => {
  router.push(`/poster/detail/${id}`)
}

const data = ref({})
Request.get({ url: 'index/index/home' }).then(res => {
  data.value = res.data
})

const vipList = ref([])
Request.get({ url: 'index/user/vip' }).then(res => {
  vipList.value = res.data
})

const token = sessionStorage.getItem('token')
const loginShow = ref(false)
if (token) {
  loginShow.value = true
}

const onMenuClick = (path) => {
  router.push(path)
}
</script>

<style lang='less' scoped>
.Home {
  padding-bottom: 60px;
  background: transparent;

  /* Desktop Home styling */
  .desktop-home-container {
    display: flex;
    flex-direction: column;
    gap: 32px;
    background-color: transparent;
    padding-bottom: 0;

    .desktop-welcome-banner {
      display: flex;
      justify-content: space-between;
      align-items: center;

      .welcome-text {
        h2 {
          margin: 0;
          font-size: 28px;
          font-weight: 800;
          color: #0f172a;
        }
        p {
          margin: 6px 0 0;
          font-size: 15px;
          color: #64748b;
        }
      }

      .datetime-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #475569;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);

        .clock-icon {
          font-size: 18px;
          color: #2563eb;
        }
      }
    }

    .desktop-stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;

      .stat-card {
        background-color: #ffffff;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
        transition: transform 0.2s, box-shadow 0.2s;

        &:hover {
          transform: translateY(-2px);
          box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-left {
          display: flex;
          flex-direction: column;
          gap: 6px;

          .card-title {
            font-size: 14px;
            font-weight: 650;
            color: #64748b;
          }

          .card-value {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
          }

          .card-subtitle {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 600;

            &.positive {
              color: #10b981;
            }
          }
        }

        .card-icon {
          font-size: 40px;
          padding: 12px;
          border-radius: 14px;
        }

        &.card-blue {
          border-left: 5px solid #2563eb;
          .card-icon {
            color: #2563eb;
            background-color: #eff6ff;
          }
        }
        &.card-green {
          border-left: 5px solid #10b981;
          .card-icon {
            color: #10b981;
            background-color: #ecfdf5;
          }
        }
        &.card-purple {
          border-left: 5px solid #8b5cf6;
          .card-icon {
            color: #8b5cf6;
            background-color: #f5f3ff;
          }
        }
        &.card-yellow {
          border-left: 5px solid #f59e0b;
          .card-icon {
            color: #f59e0b;
            background-color: #fffbeb;
          }
        }
      }
    }

    .desktop-quick-actions {
      background-color: #ffffff;
      border-radius: 16px;
      padding: 24px;
      border: 1px solid #f1f5f9;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);

      h3 {
        margin: 0 0 20px;
        font-size: 18px;
        font-weight: 850;
        color: #0f172a;
      }

      .actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;

        .action-item {
          display: flex;
          align-items: center;
          gap: 16px;
          padding: 16px;
          border: 1px solid #f1f5f9;
          border-radius: 12px;
          cursor: pointer;
          transition: all 0.2s;

          &:hover {
            border-color: #bfdbfe;
            background-color: #f8fafc;
            transform: translateY(-1px);
          }

          .action-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;

            &.bg-blue { color: #2563eb; background-color: #eff6ff; }
            &.bg-green { color: #10b981; background-color: #ecfdf5; }
            &.bg-purple { color: #8b5cf6; background-color: #f5f3ff; }
            &.bg-yellow { color: #f59e0b; background-color: #fffbeb; }
          }

          .action-text {
            h4 {
              margin: 0;
              font-size: 14px;
              font-weight: 700;
              color: #0f172a;
            }
            p {
              margin: 2px 0 0;
              font-size: 11px;
              color: #64748b;
            }
          }
        }
      }
    }

    .desktop-columns {
      display: grid;
      grid-template-columns: 1.5fr 1fr 1fr;
      gap: 24px;

      .column-left, .column-middle, .column-right {
        background-color: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        overflow: hidden;
      }

      .panel-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;

        h3 {
          margin: 0;
          font-size: 16px;
          font-weight: 800;
          color: #0f172a;
        }

        .view-all-link {
          font-size: 13px;
          color: #2563eb;
          font-weight: 600;
          text-decoration: none;
          &:hover {
            text-decoration: underline;
          }
        }
      }

      .panel-body {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 16px;

        &.chart-panel {
          justify-content: center;
        }

        .chart-svg {
          width: 100%;
          height: auto;
        }

        .chart-labels {
          display: flex;
          justify-content: space-between;
          padding: 0 10px;
          font-size: 11px;
          color: #94a3b8;
          font-weight: 600;
          margin-top: 10px;
        }

        .activity-item {
          display: flex;
          align-items: center;
          gap: 14px;
          padding-bottom: 14px;
          border-bottom: 1px solid #f8fafc;

          &:last-child {
            padding-bottom: 0;
            border-bottom: none;
          }

          .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;

            &.bg-green-light {
              color: #10b981;
              background-color: #ecfdf5;
            }
          }

          .activity-text {
            flex: 1;
            h4 {
              margin: 0;
              font-size: 13px;
              font-weight: 700;
              color: #334155;
            }
            p {
              margin: 2px 0 0;
              font-size: 11px;
              color: #94a3b8;
            }
          }

          .activity-amount {
            font-size: 14px;
            font-weight: 700;

            &.positive {
              color: #10b981;
            }
          }
        }

        .project-item {
          display: flex;
          align-items: center;
          gap: 12px;
          justify-content: space-between;
          padding-bottom: 16px;
          border-bottom: 1px solid #f8fafc;

          &:last-child {
            padding-bottom: 0;
            border-bottom: none;
          }

          .project-img {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            background-color: #f1f5f9;
            flex-shrink: 0;
          }

          .project-info {
            flex: 1;
            h4 {
              margin: 0;
              font-size: 13px;
              font-weight: 700;
              color: #334155;
            }
            p {
              margin: 4px 0 0;
              font-size: 11px;
              color: #64748b;
            }
          }

          .invest-btn {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            &:hover {
              background-color: #1d4ed8;
            }
          }
        }

        .empty-state {
          text-align: center;
          font-size: 13px;
          color: #94a3b8;
          padding: 24px 0;
        }
      }
    }
  }

  /* Mobile Home View (Original) styling */
  .mobile-home-container {
    background-color: #ffffff;
    
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
      justify-content: space-between;
      padding: 16px;

      .menu-list {
        flex: 1;
        width: 120px;
        font-weight: 700;
        color: #ad4f37;
        border: 0.01rem solid #c28170;
        background: rgba(226, 84, 73, .102);
        border-radius: 3px;
        padding: 10px;
        box-sizing: border-box;
        display: flex;
        font-size: 13px;
        line-height: 1.5;
        flex-direction: column;
        justify-content: space-between;
        margin-right: 10px;

        img {
          float: right;
          right: 10px;
          bottom: 10px;
          width: 16px;
          height: 16px;
          object-fit: cover;
        }
      }
    }

    .notice {
      display: flex;
      padding: 0 16px;

      .notice-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: #000;

        div {
          width: 20px;
          height: 20px;
          background: url("../../assets/img/home/ic_notice.png") no-repeat 100%/cover;
        }
      }

      .notice-content {
        width: 100%;
        border: 1px solid #e0e1e2;
        color: #a2a2a2;

        .van-notice-bar {
          height: 100%;
          color: #a2a2a2;
        }
      }
    }

    .box {
      width: 92%;
      border-radius: 10px;
      padding: 10px 16px 0 16px;
      box-shadow: 0 0 10px 0 rgba(0, 0, 0, .1);
      overflow: hidden;
      box-sizing: border-box;
      margin: 20px auto;
      font-size: 14px;

      .box-title {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
      }

      .box-mony {
        display: flex;
        margin-top: 10px;

        .box-mony-list {
          width: 50%;

          span:nth-child(1) {
            font-size: 16.5px;
            height: 25px;
          }

          div:nth-child(2) {
            color: var(--red-color);
            font-weight: 700 !important;
            margin-top: 2px;
            font-size: 16.5px;
          }
        }
      }

      .line-divider {
        position: relative;
        margin-top: 18px;
      }

      .line-divider:before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        transform: scaleY(.5);
        border: 1px dashed #e0e1e2;
      }

      .box-day {
        display: flex;
        flex-wrap: wrap;
        margin-top: 40px;

        .box-day-list {
          width: 50%;
          margin-bottom: 15px;

          div:nth-child(1) {
            font-size: 14.5px;
            height: 20px;
          }

          div:nth-child(2) {
            font-weight: 700 !important;
            font-size: 16.5px;
            margin-top: 2px;
          }
        }
      }
    }

    .quick-entry {
      display: flex;
      justify-content: space-between;
      width: 92%;
      margin: 20px auto 10px;

      .quick-entry-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        cursor: pointer;

        .quick-entry-icon {
          width: 60px;
          height: 60px;
          object-fit: contain;
        }

        .quick-entry-title {
          margin-top: 8px;
          font-size: 13px;
          color: #333;
          text-align: center;
          line-height: 1.3;
        }
      }
    }

    .title {
      font-size: 22px;
      font-weight: 700 !important;
      margin-bottom: 20px;
      margin-top: 30px;
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
          margin-bottom: 40px;
        }

        .partner-item:nth-child(3n+3) {
          flex-basis: 33%;
          align-items: flex-end;

          img {
            float: right !important;
          }
        }

        .partner-item:nth-child(2) {
          img {
            width: 127px;
          }
        }

        img {
          height: 24px;
        }
      }
    }
  }
}
</style>
