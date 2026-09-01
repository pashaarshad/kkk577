<!-- Member list / User commission income dynamics -->
<template>
  <div class="member-dynamics-container">
    <!-- Top Ribbon Header -->
    <div class="header-ribbon-wrapper">
      <div class="header-ribbon">
        <span>Member list</span>
      </div>
    </div>

    <!-- Golden Card Frame -->
    <div class="gold-card-body">
      <van-swipe 
        :autoplay="2000" 
        :show-indicators="false" 
        :touchable="false"
        vertical 
        class="member-swipe"
      >
        <van-swipe-item v-for="(group, gIdx) in dynamicGroups" :key="gIdx" class="swipe-group">
          <div v-for="(item, idx) in group" :key="idx" class="member-row">
            <div class="row-left">
              <span class="level-pill">{{ item.levelText }}</span>
              <span class="user-email">{{ item.email }}</span>
            </div>
            <div class="row-right">
              <span class="commission-val">+${{ item.amount }}</span>
            </div>
          </div>
        </van-swipe-item>
      </van-swipe>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  list: {
    type: Array,
    default: () => []
  }
})

// Generate dynamic member earnings list
const defaultEmails = [
  'facai1188@gmail.com',
  'qwe880@gmail.com',
  '535asd@gmail.com',
  'mario992@gmail.com',
  'david_k@gmail.com',
  'lucas88@gmail.com',
  'albert77@gmail.com',
  'sandra_v@gmail.com',
  'kevin2024@gmail.com',
  'emma_trade@gmail.com',
  'robert99@gmail.com',
  'sofia_gold@gmail.com'
]

const levelTypes = ['VIP 1', 'VIP 2', 'VIP 3', 'Task', 'VIP 1', 'VIP 2']

const dynamicList = computed(() => {
  if (props.list && props.list.length > 0) {
    return props.list.map((item, idx) => {
      const email = defaultEmails[idx % defaultEmails.length]
      const levelText = levelTypes[idx % levelTypes.length]
      const numVal = Number(item.num || 100)
      const amount = (numVal * (idx % 2 === 0 ? 15.6 : 3.4) + (idx * 27)).toFixed(2)
      return {
        email,
        levelText,
        amount: Number(amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
      }
    })
  }

  return defaultEmails.map((email, idx) => ({
    email,
    levelText: levelTypes[idx % levelTypes.length],
    amount: (Number([5656, 340, 2568, 1290, 4820, 890, 3150, 620, 7430, 1980, 4520, 2800][idx] || 500)).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
  }))
})

// Chunk into groups of 3 for smooth multi-row page scrolling
const dynamicGroups = computed(() => {
  const chunks = []
  const items = dynamicList.value
  for (let i = 0; i < items.length; i += 3) {
    chunks.push(items.slice(i, i + 3))
  }
  return chunks
})
</script>

<style lang="less" scoped>
.member-dynamics-container {
  width: 100%;
  margin: 25px 0 20px;
  position: relative;
  box-sizing: border-box;

  .header-ribbon-wrapper {
    display: flex;
    justify-content: center;
    position: relative;
    z-index: 3;
    margin-bottom: -16px;

    .header-ribbon {
      background: #543415;
      color: #ffffff;
      font-size: 16px;
      font-weight: 700;
      padding: 8px 38px 10px;
      border-radius: 0 0 10px 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.35);
      letter-spacing: 0.5px;
      position: relative;

      &::before, &::after {
        content: '';
        position: absolute;
        top: 0;
        border-style: solid;
      }

      &::before {
        left: -8px;
        border-width: 0 8px 8px 0;
        border-color: transparent #341e0a transparent transparent;
      }

      &::after {
        right: -8px;
        border-width: 0 0 8px 8px;
        border-color: transparent transparent transparent #341e0a;
      }
    }
  }

  .gold-card-body {
    background: linear-gradient(180deg, #d3ab79 0%, #ba8e55 100%);
    border-radius: 12px;
    padding: 26px 14px 14px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
    border: 2px solid #e5c396;
    overflow: hidden;
  }

  .member-swipe {
    height: 186px;
    overflow: hidden;
  }

  .swipe-group {
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    height: 100%;
  }

  .member-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 4px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.25);

    &:last-child {
      border-bottom: none;
    }

    .row-left {
      display: flex;
      align-items: center;
      gap: 12px;
      flex: 1;
      overflow: hidden;

      .level-pill {
        background: #ffffff;
        color: #2c2a29;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 9px;
        border-radius: 6px;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
      }

      .user-email {
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
      }
    }

    .row-right {
      flex-shrink: 0;
      margin-left: 10px;

      .commission-val {
        color: #ffffff;
        font-size: 15px;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
      }
    }
  }
}
</style>
