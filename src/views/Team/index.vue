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
      <div class="level-card card-lvl-1">
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
      <div class="level-card card-lvl-2">
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
      <div class="level-card card-lvl-3">
        <div class="card-left">
          <span class="level-badge-lbl">LEVEL 3</span>
        </div>
        <div class="card-middle">
          <div class="meta-row">
            <div>Register/Valid: <span class="bold-txt">{{ data?.data?.team3_count || 0 }}/0</span></div>
            <div>Commission Percentage: <span class="bold-txt">{{ data?.tj_bili ? (data.tj_bili[2] * 100).toFixed(0) : 3 }}%</span></div>
          </div>
          <div class="meta-row">
            <div>Task rebate: <span class="bold-txt">1%</span></div>
            <div>Total income: <span class="bold-txt">$ {{ data?.data?.team3_yj || '0.00' }}</span></div>
          </div>
        </div>
        <button class="details-pill-btn" @click="showLevelDetails(3)">Details</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { showSuccessToast } from 'vant'
import { computed, ref } from 'vue'
import Request from '@/services/index.js'

const navList = [
  { id: 1, title: 'Today' },
  { id: 2, title: 'Yesterday' },
  { id: 3, title: 'This week' }
]

const selectedItemId = ref(1)
const data = ref({})
const userData = ref({})

Request.get({ url: 'index/user/team' }).then(res => {
  data.value = res
})

Request.get({ url: 'index/user/info' }).then(res => {
  userData.value = res.info || {}
})

const getReferralLink = computed(() => {
  const host = window.location.origin
  return `${host}/#/register?invite_code=${userData.value.invite_code || ''}`
})

const onClickTab = (id) => {
  selectedItemId.value = id
}

const copyCode = () => {
  if (userData.value.invite_code) {
    navigator.clipboard.writeText(userData.value.invite_code)
    showSuccessToast('Invitation code copied')
  }
}

const copyLink = () => {
  navigator.clipboard.writeText(getReferralLink.value)
  showSuccessToast('Referral link copied')
}

const showLevelDetails = (lvl) => {
  showSuccessToast(`Viewing Level ${lvl} member details`)
}
</script>

<style lang="less" scoped>
.team-view {
  background: #fff9f8;
  min-height: 100vh;
  padding: 16px 14px 90px;
  box-sizing: border-box;

  .invitation-box {
    background: #ffffff;
    border: 1.5px solid #E86C3F;
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 10px rgba(184, 58, 46, 0.08);

    .invite-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 14px;

      .lbl {
        font-size: 13px;
        color: #86909c;
        font-weight: 500;
      }

      .code-val {
        font-size: 16px;
        font-weight: 800;
        color: #B83A2E;
        letter-spacing: 1px;
      }
    }

    .invite-link-box {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-bottom: 14px;

      .lbl {
        font-size: 11px;
        color: #86909c;
      }

      .link-row {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff5f3;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px dashed #fdece8;

        .link-val {
          flex: 1;
          font-size: 11px;
          color: #1f1a1a;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }
      }
    }

    .copy-btn {
      background: linear-gradient(135deg, #B83A2E, #E86C3F);
      color: #ffffff;
      border: none;
      padding: 6px 16px;
      border-radius: 16px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(184, 58, 46, 0.2);
    }

    .social-icons {
      display: flex;
      justify-content: space-between;
      align-items: center;

      .social-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff0ed;
        color: #B83A2E;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        border: 1px solid #fdece8;
      }
    }
  }

  .period-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;

    .title-text {
      font-size: 15px;
      font-weight: 800;
      color: #1f1a1a;
    }

    .tab-group {
      display: flex;
      gap: 6px;
      background: #ffffff;
      padding: 3px;
      border-radius: 20px;
      border: 1px solid #fdece8;

      .tab-btn {
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 11px;
        color: #86909c;
        cursor: pointer;
        font-weight: 600;

        &.active {
          background: #B83A2E;
          color: #ffffff;
        }
      }
    }
  }

  .team-stats-panel {
    background: linear-gradient(135deg, #B83A2E, #E86C3F);
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 16px;
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(184, 58, 46, 0.2);

    .stats-row {
      display: flex;
      justify-content: space-around;
      align-items: center;

      &.three-cols {
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
      }

      .stat-cell {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;

        .lbl {
          font-size: 10.5px;
          opacity: 0.85;
          text-align: center;
        }

        .val {
          font-size: 16px;
          font-weight: 800;
        }
      }
    }
  }

  .level-cards-list {
    display: flex;
    flex-direction: column;
    gap: 12px;

    .level-card {
      background: #ffffff;
      border: 1.5px solid #E86C3F;
      border-radius: 12px;
      padding: 14px;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 2px 8px rgba(184, 58, 46, 0.06);

      .card-left {
        .level-badge-lbl {
          font-size: 11px;
          font-weight: 800;
          padding: 4px 10px;
          border-radius: 6px;
          color: #ffffff;
          background: linear-gradient(135deg, #B83A2E, #E86C3F);
        }
      }

      .card-middle {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;

        .meta-row {
          display: flex;
          justify-content: space-between;
          font-size: 10.5px;
          color: #86909c;

          .bold-txt {
            color: #1f1a1a;
            font-weight: 700;
          }
        }
      }

      .details-pill-btn {
        background: #fff0ed;
        color: #B83A2E;
        border: 1px solid #fdece8;
        padding: 5px 12px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
      }
    }
  }
}
</style>
