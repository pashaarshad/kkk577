<!-- loading preloader -->
<template>
  <transition name="fade">
    <div v-if="showPreloader || mainStore.isLoading" class="preloader-overlay" @click="dismissLoading">
      <div class="preloader-content">
        <div class="logo-spinner-box">
          <img src="../../assets/img/main/fbdb7d08a0b0413fb4d95f214770967b_.jpg" class="preloader-logo" alt="Logo">
          <div class="spinner-ring"></div>
        </div>
        <div class="preloader-text">Loading...</div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useMainStore } from '@/store/modules/main.js'

const mainStore = useMainStore()
const showPreloader = ref(true)

onMounted(() => {
  // Show initial preloader for 1.5s on arrival
  setTimeout(() => {
    showPreloader.value = false
  }, 1500)
})

const dismissLoading = () => {
  showPreloader.value = false
  mainStore.isLoading = false
}
</script>

<style lang="less" scoped>
.preloader-overlay {
  position: fixed;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #1a1a1a;
  z-index: 99999;

  .preloader-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
  }

  .logo-spinner-box {
    position: relative;
    width: 76px;
    height: 76px;
    display: flex;
    align-items: center;
    justify-content: center;

    .preloader-logo {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .spinner-ring {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 3px solid rgba(245, 174, 72, 0.15);
      border-top-color: #f5ae48;
      animation: spin 0.9s linear infinite;
    }
  }

  .preloader-text {
    color: #e2e8f0;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
  }
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
