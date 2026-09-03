<!-- grab  -->
<template>
  <div v-if='show' class='grab'>
    <div class='tip'>
      <span>{{ $t('grab.Contracted') }}</span>
      <van-icon name='question' size='20' style='margin-left: 10px' />
    </div>
    <div class='task'>
      <img alt='' src='https://xiongmao002.com/api//file/cfg/202312/14/96566d7cf790464587998b55e4ef1aa8_.jpg'>
      <div class='task-div'>
        <span>{{ $t('grab.TaskProgress') }}</span>
        <van-progress :percentage='data.day_d_count / data.order_num * 100' :show-pivot='false' color='rgb(173, 79, 55)'
                      stroke-width='7'
                      style='margin-top: 15px' />
      </div>
    </div>
    <div class='tip tip2'>
      <span>{{ $t('grab.MerchantTasks') }}</span>
      <van-icon name='question' size='20' style='margin-left: 10px' />
    </div>
    <div v-if='data.convey' class='image'>
      <img :src='data.convey?.goods_pic' alt=''>
      <span>{{ data.convey?.goods_name }}</span>
      <div class='image-title'>
        <span>{{ $t('main.money') }}</span>
        <span>{{ data.convey?.goods_price }} * {{ data.convey?.goods_count }}</span>
      </div>
    </div>
    <div class='task-list'>
      <div>
        <span>{{ $t('grab.NumberTasks') }}</span>
        <span>{{ data?.day_d_count }}/{{ data?.order_num }}</span>
      </div>
      <div>
        <span>{{ $t('grab.EligibilityRequirements') }}</span>
        <span>{{ data?.level_name }}</span>
      </div>
      <div v-if='data.convey'>
        <span>{{ $t('grab.ThisCommission') }}</span>
        <span>{{ $t('main.money') }}{{ data.convey?.commission }}</span>
      </div>
      <div v-if='data.convey'>
        <span>{{ $t('grab.OrderPrice') }}</span>
        <span>{{ $t('main.money') }}{{ data?.convey?.num }}</span>
      </div>
    </div>
    <div class='btns'>
      <van-button
        class='btn' type='primary' @click='show = false'>
        {{ $t('grab.StartWorking') }}
      </van-button>
    </div>
    <div class='title'>{{ $t('grab.MerchantRecord') }} ({{ data?.convey_list?.length }})</div>
    <div class='list'>
      <div v-for='item in data.convey_list' class='list-item'>
        <div>
          <span>{{ $t('grab.OrderNumber') }}</span>
          <span>{{ item?.id }}</span>
        </div>
        <div>
          <span>{{ $t('grab.Merchant') }}</span>
          <span class='shop_name'>{{ item?.shop_name }}</span>
        </div>
        <div>
          <span>{{ $t('grab.TaskProgress') }}</span>
          <span class='task-progress'>{{ item?.group_rule_num_num }} / {{ item?.group_rule_num_size }}</span>
        </div>
        <div>
          <span>{{ $t('grab.OrderPrice') }}</span>
          <span>{{ $t('main.money') }}{{ item?.num }}</span>
        </div>
        <div>
          <span>{{ $t('grab.OrderNumber') }}</span>
          <span>{{ $t('main.money') }}{{ item?.commission }}</span>
        </div>
        <div>
          <span>{{ $t('grab.OperatingHours') }}</span>
          <span>{{ formatDate(item?.addtime) }}</span>
        </div>
        <div>
          <span>{{ $t('grab.State') }}</span>
          <van-button v-if='item.status == 1' class='item-btn' plain type='success'>{{ $t('grab.StartWorking') }}
          </van-button>
          <van-button v-if='item.status == 0' class='item-btn' plain type='warning' @click='submitOrder(item.id)'>
            {{ $t('grab.submitOrder') }}
          </van-button>

        </div>
      </div>
    </div>
    <div>
      <van-pagination v-model='currentPage' :page-count='1' :prev-text='null' class='pagination' mode='simple' />
    </div>
  </div>
  <Loading v-else @goback='goBack' />
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { formatDate } from '@/utils/format-date.js'
import { showSuccessToast } from 'vant'
import Loading from './cpns/loading.vue'

const router = useRouter()
const token = localStorage.getItem('token') || sessionStorage.getItem('token')

if (!token) {
  router.replace('/login')
}

const currentPage = ref(1)
const show = ref(true)

const goBack = () => {
  show.value = true
  getData()
}

const data = ref({})
const getData = () => {
  Request.get({ url: 'index/rot_order/index' }).then(res => {
    console.log(res.data)
    data.value = res.data
  })
}

const oid = ref()
const onSubmit = () => {
  Request.get({ url: 'index/rot_order/submit_order' }).then(res => {
    oid.value = res.oid
    Request.post({ url: 'index/order/do_order', data: { oid: res.oid } }).then(res => {
      showSuccessToast(res.info)
    })
  })
}

const getOid = async () => {
  await Request.get({ url: 'index/rot_order/submit_order' }).then(res => {
    oid.value = res.oid
  })
}

const submitOrder = async (id) => {
  Request.post({ url: 'index/order/do_order', data: { oid: id } }).then(async res => {
    if (res.code2 == 1) {
      onSubmit()
    }
    showSuccessToast(res.info)
    getData()
  })
}

getData()
</script>

<style lang='less' scoped>
.grab {
  background: var(--bg-color);
  height: 100%;
  padding: 22px 16.5px 80px 16.5px;
  font-size: 13.2px;

  .tip {
    display: flex;
    align-items: center;
    color: var(--gray-light-color);
  }

  .task {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 380px;
    height: 83px;
    background: var(--gray-color);
    border-radius: 50px;
    margin-top: 15px;
    padding: 11px 20px 11px 11px;
    box-sizing: border-box;

    .task-div {
      flex: 1;
      margin-left: 15px;
    }

    img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }
  }

  .tip2 {
    margin-top: 15px;
    color: var(--default-color);
  }

  .image {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    margin-top: 16px;

    img {
      width: 100px;
      height: 100px;
    }

    .image-title {
      font-size: 22px;
      font-weight: 700 !important;

      span:nth-child(2) {
        color: var(--main-color);
      }
    }
  }

  .task-list {
    display: flex;
    flex-wrap: wrap;
    background: var(--gray-color);
    padding: 15px 22px 0 22px;
    margin-top: 15px;

    div {
      width: 50%;
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;

      span:nth-child(2) {
        font-weight: 700 !important;
        font-size: 16.5px;
      }
    }
  }

  .btns {
    margin-top: 20px;

    .btn {
      width: 100%;
      color: var(--main-color);
      background-color: var(--second-color);
      border: 1px solid var(--main-color);

    }
  }

  .title {
    font-weight: 700 !important;
    font-size: 20px;
    margin-top: 20px;
  }

  .list {

    .shop_name {
      width: 70%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .list-item {
      padding: 11px 0;
      border-bottom: 1px dashed var(--second-color);

      div {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 0 6px;
      }
    }

    .task-progress {
      border: 1px solid var(--second-color);
      padding: 0 12px;
      border-radius: 8px;
    }

    .item-btn {
      height: 24px;
      font-size: 13px;
    }
  }

  .pagination {
    padding: 0 0 30px 0;
    margin-top: 20px;

    button:after {
      border: none;
    }
  }
}
</style>
