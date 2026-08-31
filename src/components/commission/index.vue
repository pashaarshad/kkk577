<!-- Commission / Activities -->
<template>
  <div class='commission'>
    <div class="header-row">
      <div class="title-with-icon">
        <span class="icon-pulse">🔥</span>
        <h2 class='section-title'>Latest Activities</h2>
      </div>
    </div>

    <div class="activity-list">
      <!-- Colorful Activity Card 1 -->
      <div class='activity-card gradient-1'>
        <div class="card-icon">
          <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="white" fill="none" stroke-width="2" stroke-linejoin="round"/></svg>
        </div>
        <div class="card-content">
          <div class="user-id">User 183****921</div>
          <div class="task-desc">Completed Elite Bot Task</div>
        </div>
        <div class="card-action">
          <div class='profit'>+$45.00 USDT</div>
          <button class='view-btn' @click='router.push("/work")'>Join Now</button>
        </div>
      </div>

      <!-- Colorful Activity Card 2 -->
      <div class='activity-card gradient-2'>
        <div class="card-icon">
          <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="white" fill="none" stroke-width="2"/><path d="M7 11V7a5 5 0 0110 0v4" stroke="white" fill="none" stroke-width="2"/></svg>
        </div>
        <div class="card-content">
          <div class="user-id">User 192****384</div>
          <div class="task-desc">VIP Upgrade Reward</div>
        </div>
        <div class="card-action">
          <div class='profit'>+$120.00 USDT</div>
          <button class='view-btn' @click='router.push("/recharge")'>Upgrade</button>
        </div>
      </div>

      <!-- Colorful Activity Card 3 -->
      <div class='activity-card gradient-3'>
        <div class="card-icon">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="5" stroke="white" fill="none" stroke-width="2"/><path d="M3 21v-2a7 7 0 0114 0v2" stroke="white" fill="none" stroke-width="2"/></svg>
        </div>
        <div class="card-content">
          <div class="user-id">User 155****099</div>
          <div class="task-desc">Team Referral Bonus</div>
        </div>
        <div class="card-action">
          <div class='profit'>+$9.00 USDT</div>
          <button class='view-btn' @click='router.push("/team")'>Invite</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const props = defineProps({
  list: {
    type: Array,
    default: () => []
  }
})

const router = useRouter()
</script>

<style lang='less' scoped>
.commission {
  margin: 20px 0;

  .header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;

    .title-with-icon {
      display: flex;
      align-items: center;
      gap: 8px;

      .icon-pulse {
        font-size: 18px;
        animation: pulse 1.5s infinite;
      }

      .section-title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #ffffff;
      }
    }
  }

  .activity-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .activity-card {
    display: flex;
    align-items: center;
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;

    &::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 100px;
      height: 100px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
    }

    .card-icon {
      width: 42px;
      height: 42px;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 14px;
      flex-shrink: 0;
      backdrop-filter: blur(4px);

      svg {
        width: 22px;
        height: 22px;
      }
    }

    .card-content {
      flex: 1;

      .user-id {
        font-size: 14px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 4px;
      }

      .task-desc {
        font-size: 12px;
        color: rgba(255,255,255,0.8);
      }
    }

    .card-action {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 8px;

      .profit {
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
      }

      .view-btn {
        border: none;
        padding: 6px 14px;
        border-radius: 20px;
        color: #333;
        background: #ffffff;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: transform 0.1s;

        &:active {
          transform: scale(0.95);
        }
      }
    }
  }

  /* Vibrant Gradients */
  .gradient-1 {
    background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
  }
  .gradient-2 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  }
  .gradient-3 {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
  }

  @keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
  }
}
</style>
