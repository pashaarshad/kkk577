<!-- loading  -->
<template>
  <div class='loading'>
    <div class='loading-nav'>{{ $t('grab.TaskDetails') }}</div>
    <van-steps :active='active' active-color='#AD4F37FF' active-icon='circle' direction='vertical'
               finish-icon='checked'>
      <template v-for='(item, index) in list'>
        <van-step class='list'>
          <div>
            <div v-if='index !== active' class='title'>{{ item.title }}</div>
            <div v-else-if='index === active && !item.loading' class='loading-div'>
              <div class='loading-div1'></div>
              <div class='loading-div2'></div>
            </div>
            <div v-if='item.loading'>
              <div class='title' style='margin-bottom: 10px'>{{ item.title }}</div>
              <van-icon color='#e36564' name='warning' />
              <span style='color: #e36564;'>{{ info }}</span>
              <div>
                <van-button class='item-btn' plain type='warning' @click='goBack'>
                  {{ $t('grab.sure') }}
                </van-button>
              </div>
            </div>
          </div>
        </van-step>
      </template>
    </van-steps>
    <div v-show='show' class='bg-grey'>
      <div class='bg-grey-list'>
        <span>{{ $t('grab.Merchant') }}</span>
        <span class='bg-grey-list-text'>{{ goodsInfo?.goods_name }}</span>
      </div>
      <div class='bg-grey-list'>
        <span>{{ $t('grab.OrderPrice') }}</span>
        <span>{{ $t('main.money') }} {{ goodsInfo?.goods_price }}</span>
      </div>
      <div class='bg-grey-list'>
        <span>{{ $t('grab.Commission') }}</span>
        <span>{{ $t('main.money') }} {{ goodsInfo?.commission }}</span>
      </div>
      <van-button class='item-btn' plain type='warning' @click='goBack'>
        {{ $t('grab.sure') }}
      </van-button>
    </div>
  </div>
</template>

<script setup>

import { ref } from 'vue'
import { i18n } from '@/lang/index.js'
import Request from '@/services/index.js'
import { showSuccessToast } from 'vant'

const props = defineProps({
  data: Object
})

const goodsInfo = ref();

const show = ref(false)
const { t } = i18n.global
const emit = defineEmits(['goback'])

const active = ref(0)

const goBack = () => {
  emit('goback')
}

const list = ref([
  {
    title: t('grab.SendTask'),
    loading: false
  },
  {
    title: t('grab.MerchantAllocation'),
    loading: false
  },
  {
    title: t('grab.SendData'),
    loading: false
  },
  {
    title: t('grab.MissionCompleted'),
    loading: false
  }
])

const interval = setInterval(() => {
  active.value = active.value + 1
  if (active.value == 1) {
    setTimeout(() => {
      getSubmit_order()
    }, 2000)
  } else if (active.value == 2) {
    setTimeout(() => {
      getDo_order()
    }, 2000)
  }
  if (active.value >= 4) {
    show.value = true
    clearInterval(interval)
  }
}, 3000)


const info = ref('')

const oid = ref()
const getSubmit_order = () => {
  Request.get({ url: 'index/rot_order/submit_order' }).then(res => {
    oid.value = res.oid
	orderInfo(oid.value[0])
  }).catch(err => {
    info.value = err.info
    list.value[1].loading = true
    active.value = 1
    clearInterval(interval)
  })
}

const orderInfo = (id) => {
  Request.get({ url: 'index/order/order_info?id=' + id }).then(res => {
    goodsInfo.value = res.data
  }).catch(err => {
	  
  })
}

const getDo_order = () => {
  Request.post({ url: 'index/order/do_order', data: { oid: oid.value } }).then(res => {
    if (res.code == 2) {
      active.value = 1
      getSubmit_order()
    }

  }).catch(err => {
    info.value = err.info
    list.value[2].loading = true
    active.value = 2
    clearInterval(interval)
  })
}
const onSubmit = () => {
  Request.get({ url: 'index/rot_order/submit_order' }).then(res => {
    Request.post({ url: 'index/order/do_order', data: { oid: res.oid } }).then(res => {
      if (res.code == 2) {
        active.value = 2
        onSubmit()
      }
      showSuccessToast(res.info)
    }).catch(err => {
      info.value = err.info
      list.value[2].loading = true
      active.value = 2
      clearInterval(interval)
    })
  }).catch(err => {
    info.value = err.info
    list.value[1].loading = true
    active.value = 1
    clearInterval(interval)
  })
}

</script>

<style lang='less' scoped>
.loading {
  font-size: 13.2px;
  padding: 0 16px;
  height: 94vh;
  background: var(--bg-color);
  overflow-y: hidden;

  :deep(.van-step__line) {
    height: 80% !important;
    top: 25px;
  }

  .loading-nav {
    padding: 11px;
    background: var(--gray-color);
    color: var(--gray-light-color);
  }

  .loading-div {
    position: relative;
    overflow: hidden;
  }

  .loading-div1 {
    height: 4px;
    background: #e6cec6;
    margin-top: 40px;
  }

  .loading-div2 {
    position: absolute;
    top: 0;
    left: 0;
    width: 40%;
    height: 4px;
    background: #a65037;
    animation: slideRight 1s ease-in-out infinite running;
    margin-top: 40px;
  }

  .item-btn {
    font-size: 12px;
    width: 100%;
    height: 32px;
    border-radius: 15px;
    background-color: var(--second-color);
    border: 0.05px solid var(--main-color);
    color: var(--main-color);
    margin-top: 15px;
  }

  .bg-grey {
    background: var(--gray-color);
    width: 96%;
    border-radius: 10px !important;
    margin-top: 10px;
    padding: 22px 11px;

    .bg-grey-list {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
    }

    .bg-grey-list-text {
      width: 300px;
      text-align: right;
    }
  }
}

.title {
  font-size: 13.2px;
}

@keyframes slideRight {
  0% {
    transform: translateX(-300px);
  }
  100% {
    transform: translateX(350px);
  }
}
</style>
