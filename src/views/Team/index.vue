<template>
  <div class="team-view">
    <!-- Top Invitation Box -->
    <div class="invitation-box">
      <div class="invite-item">
        <span class="lbl">Invitation code:</span>
        <span class="code-val">{{ userData.invite_code || '------' }}</span>
        <button class="copy-btn" @click="copyCode">Copy</button>
      </div>
      
      <div class="invite-link-box">
        <span class="lbl">Share your referral link and start earning</span>
        <div class="link-row">
          <span class="link-val">{{ getReferralLink }}</span>
          <button class="copy-btn" @click="copyLink">Copy</button>
        </div>
      </div>
      
      <!-- Social icons row -->
      <div class="social-icons">
        <span class="social-icon icon-x">𝕏</span>
        <span class="social-icon icon-fb">f</span>
        <span class="social-icon icon-tg">✈</span>
        <span class="social-icon icon-in">in</span>
        <span class="social-icon icon-wa">💬</span>
        <span class="social-icon icon-tt">🎵</span>
        <span class="social-icon icon-share">🔗</span>
      </div>
    </div>

    <!-- Period Selection -->
    <div class="period-header">
      <span class="title-text">Selection period</span>
      <div class="tab-group">
        <div v-for="item in navList" :key="item.id" class="tab-btn" :class="{ 'active': item.id === selectedItemId }" @click="onClickTab(item.id)">
          {{ item.title }}
        </div>
      </div>
    </div>

    <!-- Statistics Panel -->
    <div class="team-stats-panel">
      <div class="stats-row">
        <div class="stat-cell">
          <span class="lbl">Team size</span>
          <span class="val">{{ data?.data?.team_count || 0 }}</span>
        </div>
        <div class="stat-cell">
          <span class="lbl">Team recharge</span>
          <span class="val">$ {{ data?.data?.team_yj || '0.00' }}</span>
        </div>
      </div>
      <div class="stats-row three-cols">
        <div class="stat-cell">
          <span class="lbl">New team</span>
          <span class="val">0</span>
        </div>
        <div class="stat-cell">
          <span class="lbl">First time recharge</span>
          <span class="val">0</span>
        </div>
        <div class="stat-cell">
          <span class="lbl">First withdrawal</span>
          <span class="val">0</span>
        </div>
      </div>
    </div>

    <!-- VIP Level Cards -->
    <div class="level-cards-list">
      <!-- Level 1 -->
      <div class="level-card card-gradient-green">
        <div class="card-left">
          <span class="level-badge-lbl">LEVEL 1</span>
        </div>
        <div class="card-middle">
          <div class="meta-row">
            <div>Register/Valid: <span class="bold-txt">{{ data?.data?.team1_count || 0 }}/0</span></div>
            <div>Commission Percentage: <span class="bold-txt">{{ data?.tj_bili ? (data.tj_bili[0] * 100).toFixed(0) : 15 }}%</span></div>
          </div>
          <div class="meta-row">
            <div>Task rebate: <span class="bold-txt">5%</span></div>
            <div>Total income: <span class="bold-txt">$ {{ data?.data?.team1_yj || '0.00' }}</span></div>
          </div>
        </div>
        <button class="details-pill-btn" @click="showLevelDetails(1)">Details</button>
      </div>

      <!-- Level 2 -->
      <div class="level-card card-gradient-pink">
        <div class="card-left">
          <span class="level-badge-lbl">LEVEL 2</span>
        </div>
        <div class="card-middle">
          <div class="meta-row">
            <div>Register/Valid: <span class="bold-txt">{{ data?.data?.team2_count || 0 }}/0</span></div>
            <div>Commission Percentage: <span class="bold-txt">{{ data?.tj_bili ? (data.tj_bili[1] * 100).toFixed(0) : 5 }}%</span></div>
          </div>
          <div class="meta-row">
            <div>Task rebate: <span class="bold-txt">3%</span></div>
            <div>Total income: <span class="bold-txt">$ {{ data?.data?.team2_yj || '0.00' }}</span></div>
          </div>
        </div>
        <button class="details-pill-btn" @click="showLevelDetails(2)">Details</button>
      </div>

      <!-- Level 3 -->
      <div class="level-card card-gradient-blue">
        <div class="card-left">
          <span class="level-badge-lbl">LEVEL 3</span>
        </div>
        <div class="card-middle">
          <div class="meta-row">
            <div>Register/Valid: <span class="bold-txt">{{ data?.data?.team3_count || 0 }}/0</span></div>
            <div>Commission Percentage: <span class="bold-txt">{{ data?.tj_bili ? (data.tj_bili[2] * 100).toFixed(0) : 2 }}%</span></div>
          </div>
          <div class="meta-row">
            <div>Task rebate: <span class="bold-txt">2%</span></div>
            <div>Total income: <span class="bold-txt">$ {{ data?.data?.team3_yj || '0.00' }}</span></div>
          </div>
        </div>
        <button class="details-pill-btn" @click="showLevelDetails(3)">Details</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { i18n } from '@/lang/index.js'
import Request from '@/services/index.js'
import { showSuccessToast } from 'vant'

const router = useRouter()
const { t } = i18n.global
const selectedItemId = ref(0)
const data = ref([])
const userData = ref({})

const navList = [
  { title: 'All', id: 0 },
  { title: 'Today', id: 1 },
  { title: 'Yesterday', id: 2 },
  { title: 'Week', id: 3 }
]

const onClickTab = (id) => {
  selectedItemId.value = id
  getData(selectedItemId.value)
}

const getData = (type) => {
  let start = ''
  if (type === 1) {
    start = new Date().getTime() / 1000
  } else if (type === 2) {
    start = new Date().getTime() / 1000 - (60 * 60 * 24)
  } else if (type === 3) {
    start = new Date().getTime() / 1000 - (60 * 60 * 24 * 7)
  }
  
  Request.get({ url: '/index/ctrl/junior?ajax=1&start=' + start }).then(res => {
    data.value = res.data
  }).catch(() => {})
}

// Fetch user data for copy link and copy code details
Request.get({ url: 'index/user/info' }).then(res => {
  userData.value = res.info || {}
})

getData(selectedItemId.value)

const getReferralLink = computed(() => {
  return window.location.origin + '/#/register?invite_code=' + (userData.value.invite_code || '')
})

const copyToClipboard = (text) => {
  if (navigator.clipboard && navigator.clipboard.writeText) {
    return navigator.clipboard.writeText(text)
  }
  const textArea = document.createElement('textarea')
  textArea.value = text
  textArea.style.position = 'fixed'
  textArea.style.opacity = '0'
  document.body.appendChild(textArea)
  textArea.focus()
  textArea.select()
  try { document.execCommand('copy') } catch(e) {}
  document.body.removeChild(textArea)
  return Promise.resolve()
}

const copyCode = () => {
  const code = userData.value.invite_code || ''
  copyToClipboard(code)
  showSuccessToast('Copy invite code successfully: ' + code)
}

const copyLink = () => {
  const link = getReferralLink.value
  copyToClipboard(link)
  showSuccessToast('Copy referral link successfully')
}

const showLevelDetails = (level) => {
  showSuccessToast('Viewing Level ' + level + ' Details')
}
</script>

<style lang="less" scoped>
.team-view {
  background: var(--bg-second-color);
  min-height: 100vh;
  padding: 16px 16px 90px 16px;
  box-sizing: border-box;

  .invitation-box {
    background-color: var(--bg-color);
    border: 1px solid var(--second-color);
    border-radius: 12px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    margin-bottom: 20px;

    .invite-item {
      display: flex;
      align-items: center;
      gap: 10px;

      .lbl {
        font-size: 13px;
        color: var(--text-second);
      }

      .code-val {
        font-size: 18px;
        font-weight: 750;
        color: var(--default-color);
      }
    }

    .invite-link-box {
      display: flex;
      flex-direction: column;
      gap: 6px;

      .lbl {
        font-size: 11px;
        color: var(--text-second);
      }

      .link-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--bg-second-color);
        border: 1px solid var(--second-color);
        padding: 8px 12px;
        border-radius: 8px;

        .link-val {
          font-size: 12px;
          color: var(--text-second);
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          max-width: 75%;
        }
      }
    }

    .copy-btn {
      background-color: var(--main-color);
      color: #000000;
      border: none;
      padding: 4px 14px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 700;
      cursor: pointer;
    }

    .social-icons {
      display: flex;
      justify-content: space-around;
      align-items: center;
      margin-top: 6px;

      .social-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--second-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--default-color);
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        border: 1px solid var(--second-color);

        &:hover {
          background-color: var(--main-color);
          color: #000;
        }
      }
    }
  }

  .period-header {
    margin-bottom: 20px;

    .title-text {
      font-size: 14px;
      font-weight: 700;
      color: var(--default-color);
      display: block;
      margin-bottom: 10px;
    }

    .tab-group {
      display: flex;
      background-color: var(--bg-color);
      border: 1px solid var(--second-color);
      border-radius: 8px;
      padding: 4px;

      .tab-btn {
        flex: 1;
        text-align: center;
        padding: 8px 0;
        font-size: 12px;
        color: var(--text-second);
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;

        &.active {
          background-color: var(--second-color);
          color: var(--main-color);
          font-weight: 700;
        }
      }
    }
  }

  .team-stats-panel {
    background-color: var(--bg-color);
    border: 1px solid var(--second-color);
    border-radius: 12px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    margin-bottom: 20px;

    .stats-row {
      display: flex;
      justify-content: space-between;

      &.three-cols {
        border-top: 1px solid var(--second-color);
        padding-top: 16px;
        
        .stat-cell {
          width: 30%;
          text-align: center;
          align-items: center;
        }
      }

      .stat-cell {
        display: flex;
        flex-direction: column;
        gap: 4px;

        .lbl {
          font-size: 11px;
          color: var(--text-second);
        }

        .val {
          font-size: 16px;
          font-weight: 750;
          color: var(--default-color);
        }
      }
    }
  }

  .level-cards-list {
    display: flex;
    flex-direction: column;
    gap: 14px;

    .level-card {
      border-radius: 12px;
      padding: 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);

      .card-left {
        width: 25%;
        font-size: 14px;
        font-weight: 800;
        border-right: 1px dashed rgba(30, 41, 59, 0.2);
        padding-right: 10px;
        display: flex;
        align-items: center;
        height: 100%;
      }

      .card-middle {
        flex: 1;
        padding-left: 14px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 10px;

        .meta-row {
          display: flex;
          justify-content: space-between;

          .bold-txt {
            font-weight: 700;
          }
        }
      }

      .details-pill-btn {
        background: transparent;
        color: inherit;
        border: 1px solid currentColor;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        margin-left: 10px;

        &:hover {
          background-color: rgba(0,0,0,0.05);
        }
      }

      &.card-gradient-green {
        background: linear-gradient(90deg, #d4fc79 0%, #96e6a1 100%);
        color: #1e293b;
        .details-pill-btn {
          border-color: #1e293b;
        }
      }

      &.card-gradient-pink {
        background: linear-gradient(90deg, #ff9a9e 0%, #fecfef 100%);
        color: #1e293b;
        .details-pill-btn {
          border-color: #1e293b;
        }
      }

      &.card-gradient-blue {
        background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        color: #1e293b;
        .details-pill-btn {
          border-color: #1e293b;
        }
      }
    }
  }
}
</style>
