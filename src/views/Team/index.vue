<template>
  <div class="team-view">
    <!-- Top Invitation Box -->
    <div class="invitation-box">
      <div class="invite-item">
        <div class="code-info">
          <span class="lbl">Invitation code:</span>
          <span class="code-val">{{ userData.invite_code || '------' }}</span>
        </div>
        <button class="copy-btn" @click="copyCode">Copy</button>
      </div>
      
      <div class="invite-link-box">
        <span class="lbl">Share your referral link and start earning</span>
        <div class="link-row">
          <input 
            type="text" 
            readonly 
            :value="getReferralLink" 
            class="link-input" 
            @click="copyLink"
          />
          <button class="copy-btn" @click="copyLink">Copy</button>
        </div>
      </div>
      
      <!-- Social icons row -->
      <div class="social-icons">
        <div class="social-icon icon-x" title="Share on X (Twitter)" @click="shareOn('x')">𝕏</div>
        <div class="social-icon icon-fb" title="Share on Facebook" @click="shareOn('fb')">f</div>
        <div class="social-icon icon-tg" title="Share on Telegram" @click="shareOn('tg')">✈</div>
        <div class="social-icon icon-in" title="Share on LinkedIn" @click="shareOn('in')">in</div>
        <div class="social-icon icon-wa" title="Share on WhatsApp" @click="shareOn('wa')">💬</div>
        <div class="social-icon icon-tt" title="Share on TikTok" @click="shareOn('tt')">🎵</div>
        <div class="social-icon icon-share" title="Copy Link" @click="copyLink">🔗</div>
      </div>
    </div>

    <!-- Period Selection -->
    <div class="period-header">
      <span class="title-text">Selection period</span>
      <div class="tab-group">
        <div 
          v-for="item in navList" 
          :key="item.id" 
          class="tab-btn" 
          :class="{ 'active': item.id === selectedItemId }" 
          @click="onClickTab(item.id)"
        >
          {{ item.title }}
        </div>
      </div>
    </div>

    <!-- Statistics Panel -->
    <div class="team-stats-panel">
      <div class="stats-row top-row">
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

    <!-- VIP Level Cards Redesigned for Spacious & Elegant Layout -->
    <div class="level-cards-list">
      <!-- Level 1 -->
      <div class="level-card card-lvl-1">
        <div class="card-header">
          <div class="header-left">
            <span class="level-badge badge-1">LEVEL 1</span>
            <span class="commission-tag">1st Tier Members</span>
          </div>
          <button class="details-pill-btn" @click="showLevelDetails(1)">
            Details <van-icon name="arrow" size="12" />
          </button>
        </div>
        <div class="card-body-grid">
          <div class="grid-cell">
            <span class="cell-label">Register / Valid</span>
            <span class="cell-val">{{ data?.data?.team1_count || 0 }} / 0</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Commission Rate</span>
            <span class="cell-val highlight-val">{{ data?.tj_bili ? (data.tj_bili[0] * 100).toFixed(0) : 15 }}%</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Task Rebate</span>
            <span class="cell-val">5%</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Total Income</span>
            <span class="cell-val income-val">$ {{ data?.data?.team1_yj || '0.00' }}</span>
          </div>
        </div>
      </div>

      <!-- Level 2 -->
      <div class="level-card card-lvl-2">
        <div class="card-header">
          <div class="header-left">
            <span class="level-badge badge-2">LEVEL 2</span>
            <span class="commission-tag">2nd Tier Members</span>
          </div>
          <button class="details-pill-btn" @click="showLevelDetails(2)">
            Details <van-icon name="arrow" size="12" />
          </button>
        </div>
        <div class="card-body-grid">
          <div class="grid-cell">
            <span class="cell-label">Register / Valid</span>
            <span class="cell-val">{{ data?.data?.team2_count || 0 }} / 0</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Commission Rate</span>
            <span class="cell-val highlight-val">{{ data?.tj_bili ? (data.tj_bili[1] * 100).toFixed(0) : 5 }}%</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Task Rebate</span>
            <span class="cell-val">3%</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Total Income</span>
            <span class="cell-val income-val">$ {{ data?.data?.team2_yj || '0.00' }}</span>
          </div>
        </div>
      </div>

      <!-- Level 3 -->
      <div class="level-card card-lvl-3">
        <div class="card-header">
          <div class="header-left">
            <span class="level-badge badge-3">LEVEL 3</span>
            <span class="commission-tag">3rd Tier Members</span>
          </div>
          <button class="details-pill-btn" @click="showLevelDetails(3)">
            Details <van-icon name="arrow" size="12" />
          </button>
        </div>
        <div class="card-body-grid">
          <div class="grid-cell">
            <span class="cell-label">Register / Valid</span>
            <span class="cell-val">{{ data?.data?.team3_count || 0 }} / 0</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Commission Rate</span>
            <span class="cell-val highlight-val">{{ data?.tj_bili ? (data.tj_bili[2] * 100).toFixed(0) : 3 }}%</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Task Rebate</span>
            <span class="cell-val">1%</span>
          </div>
          <div class="grid-cell">
            <span class="cell-label">Total Income</span>
            <span class="cell-val income-val">$ {{ data?.data?.team3_yj || '0.00' }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { showSuccessToast, showToast } from 'vant'
import { computed, ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'

const router = useRouter()

const navList = [
  { id: 1, title: 'Today' },
  { id: 2, title: 'Yesterday' },
  { id: 3, title: 'This week' }
]

const selectedItemId = ref(1)
const data = ref({})
const userData = ref({})

const loadData = async () => {
  const token = sessionStorage.getItem('token')
  if (!token) {
    router.replace('/login')
    return
  }

  try {
    const uRes = await Request.get({ url: 'index/user/info' })
    if (uRes && uRes.info) {
      userData.value = uRes.info
    } else {
      router.replace('/login')
      return
    }
  } catch (e) {
    router.replace('/login')
    return
  }

  try {
    const res = await Request.get({ url: 'index/user/team' })
    if (res) data.value = res
  } catch (e) {
    console.error('Failed to load team data:', e)
  }
}

onMounted(() => {
  if (!sessionStorage.getItem('token')) {
    router.replace('/login')
    return
  }
  loadData()
})

const getReferralLink = computed(() => {
  const origin = window.location.origin
  const code = userData.value.invite_code || ''
  return `${origin}/#/register?invite_code=${code}`
})

const onClickTab = (id) => {
  selectedItemId.value = id
}

// Universal copy function that works on HTTPS, plain HTTP, IP addresses, localhost, and mobile
const copyToClipboard = (text, successMsg = 'Copied to clipboard!') => {
  if (!text) {
    showToast('No content to copy')
    return
  }

  // 1. Try modern clipboard API if supported and in secure context
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(text)
      .then(() => {
        showSuccessToast(successMsg)
      })
      .catch(() => {
        fallbackCopy(text, successMsg)
      })
    return
  }

  // 2. Fallback for non-HTTPS / HTTP / Mobile browsers
  fallbackCopy(text, successMsg)
}

const fallbackCopy = (text, successMsg) => {
  try {
    const textArea = document.createElement('textarea')
    textArea.value = text
    // Prevent zooming and scrolling
    textArea.style.position = 'fixed'
    textArea.style.top = '0'
    textArea.style.left = '0'
    textArea.style.width = '2em'
    textArea.style.height = '2em'
    textArea.style.padding = '0'
    textArea.style.border = 'none'
    textArea.style.outline = 'none'
    textArea.style.boxShadow = 'none'
    textArea.style.background = 'transparent'
    textArea.setAttribute('readonly', '')
    document.body.appendChild(textArea)
    
    // Select text across iOS and desktop
    textArea.focus()
    textArea.select()
    textArea.setSelectionRange(0, 99999)
    
    const successful = document.execCommand('copy')
    document.body.removeChild(textArea)
    
    if (successful) {
      showSuccessToast(successMsg)
    } else {
      window.prompt('Copy this text manually:', text)
    }
  } catch (err) {
    window.prompt('Copy this text manually:', text)
  }
}

const copyCode = () => {
  const code = userData.value.invite_code
  if (code) {
    copyToClipboard(code, 'Invitation code copied!')
  } else {
    showToast('Loading invitation code...')
  }
}

const copyLink = () => {
  copyToClipboard(getReferralLink.value, 'Referral link copied!')
}

const shareOn = (platform) => {
  const link = getReferralLink.value
  const text = `Join my team and start earning daily commissions! Sign up now: ${link}`
  copyToClipboard(link, 'Referral link copied! Opening share...')

  let shareUrl = ''
  switch (platform) {
    case 'tg':
      shareUrl = `https://t.me/share/url?url=${encodeURIComponent(link)}&text=${encodeURIComponent(text)}`
      break
    case 'wa':
      shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`
      break
    case 'x':
      shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}`
      break
    case 'fb':
      shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}`
      break
    case 'in':
      shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(link)}`
      break
    case 'tt':
    default:
      // Link already copied
      return
  }

  if (shareUrl) {
    window.open(shareUrl, '_blank')
  }
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
    border-radius: 16px;
    padding: 18px 16px;
    margin-bottom: 18px;
    box-shadow: 0 4px 14px rgba(184, 58, 46, 0.08);

    .invite-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;

      .code-info {
        display: flex;
        align-items: center;
        gap: 8px;

        .lbl {
          font-size: 13px;
          color: #64748b;
          font-weight: 500;
        }

        .code-val {
          font-size: 17px;
          font-weight: 800;
          color: #B83A2E;
          letter-spacing: 1px;
        }
      }
    }

    .invite-link-box {
      margin-bottom: 16px;

      .lbl {
        font-size: 12px;
        color: #64748b;
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
      }

      .link-row {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #faf4f3;
        border: 1px solid #ebd3d0;
        border-radius: 10px;
        padding: 4px 6px 4px 12px;

        .link-input {
          flex: 1;
          background: transparent;
          border: none;
          outline: none;
          font-size: 12.5px;
          color: #334155;
          font-weight: 500;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          cursor: pointer;
        }
      }
    }

    .copy-btn {
      background: linear-gradient(135deg, #B83A2E, #E86C3F);
      color: #ffffff;
      border: none;
      border-radius: 20px;
      padding: 6px 18px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(184, 58, 46, 0.25);
      transition: opacity 0.15s;

      &:active {
        opacity: 0.85;
      }
    }

    .social-icons {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 4px;

      .social-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #fff0ed;
        color: #B83A2E;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: bold;
        border: 1px solid #fdece8;
        cursor: pointer;
        transition: transform 0.15s, background 0.15s;

        &:active {
          transform: scale(0.92);
          background: #fde2dc;
        }
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
    border-radius: 16px;
    padding: 18px 16px;
    margin-bottom: 18px;
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(184, 58, 46, 0.22);

    .stats-row {
      display: flex;
      justify-content: space-around;
      align-items: center;

      &.top-row {
        padding-bottom: 14px;
      }

      &.three-cols {
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
      }

      .stat-cell {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;

        .lbl {
          font-size: 11px;
          opacity: 0.9;
          text-align: center;
          font-weight: 500;
        }

        .val {
          font-size: 18px;
          font-weight: 800;
          letter-spacing: 0.5px;
        }
      }
    }
  }

  /* Spacious, modern, premium Level Cards layout */
  .level-cards-list {
    display: flex;
    flex-direction: column;
    gap: 16px;

    .level-card {
      background: #ffffff;
      border: 1.5px solid #f2deda;
      border-radius: 16px;
      padding: 16px 16px 18px;
      box-shadow: 0 4px 16px rgba(184, 58, 46, 0.07);
      transition: transform 0.2s, box-shadow 0.2s;

      &:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(184, 58, 46, 0.12);
      }

      &.card-lvl-1 {
        border-color: #f1b3a8;
      }
      &.card-lvl-2 {
        border-color: #fed7aa;
      }
      &.card-lvl-3 {
        border-color: #e2e8f0;
      }

      .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #fce9e6;

        .header-left {
          display: flex;
          align-items: center;
          gap: 10px;

          .level-badge {
            font-size: 12px;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 8px;
            color: #ffffff;
            letter-spacing: 0.5px;

            &.badge-1 {
              background: linear-gradient(135deg, #B83A2E, #E86C3F);
              box-shadow: 0 2px 8px rgba(184, 58, 46, 0.25);
            }
            &.badge-2 {
              background: linear-gradient(135deg, #ea580c, #f59e0b);
              box-shadow: 0 2px 8px rgba(234, 88, 12, 0.25);
            }
            &.badge-3 {
              background: linear-gradient(135deg, #475569, #64748b);
              box-shadow: 0 2px 8px rgba(71, 85, 105, 0.25);
            }
          }

          .commission-tag {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
          }
        }

        .details-pill-btn {
          display: flex;
          align-items: center;
          gap: 3px;
          background: #fff0ed;
          color: #B83A2E;
          border: 1px solid #fdece8;
          padding: 5px 12px;
          border-radius: 14px;
          font-size: 11.5px;
          font-weight: 700;
          cursor: pointer;
          transition: background 0.15s;

          &:hover, &:active {
            background: #fde2dc;
          }
        }
      }

      .card-body-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;

        .grid-cell {
          background: #fff8f7;
          border: 1px solid #fae8e5;
          border-radius: 10px;
          padding: 10px 12px;
          display: flex;
          flex-direction: column;
          gap: 4px;

          .cell-label {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
          }

          .cell-val {
            font-size: 14px;
            font-weight: 800;
            color: #1e293b;

            &.highlight-val {
              color: #ea580c;
              font-size: 15px;
            }

            &.income-val {
              color: #B83A2E;
              font-size: 15px;
            }
          }
        }
      }
    }
  }
}
</style>
