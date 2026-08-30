<template>
	<div class="tab-group">
		<div class="tab-btn" v-for='item in navList' :class="{ 'active': item.id === selectedItemId }"  @click="onClickTab(item.id)">
			{{ item.title}}
		</div>
	</div>
	<div class="calendar-icon" @click="showCalendar = true">
	  <i class="icon-calendar"></i>
	</div>
	<van-calendar v-model="showCalendar" type="range" @confirm="onConfirm" />
	<div class="text-center" style="text-align: center;"></div>
	<div class="team">
		<div class="team-data bg-grey u-p-10 u-m-t-10">
		    <div class="d-flex-center border-bottom u-m-b-10 u-p-b-10">
				<i class="van-icon" style="font-size: 17px;">
					<img src="../../assets/img/ic_trend.png" class="van-icon__image">
				</i>
				<span class="u-font-16 u-m-l-10">All</span>
		    </div>
		    <div class="flex-between u-m-b-10 ">
		        <div class="flex-full">
		            <div data-v-11c150f3="">Team size</div>
		            <div class="text-red u-font-20">{{ data?.data.team_count }}</div>
		        </div>
		        <div class="flex-full">
		            <div data-v-11c150f3="">Commission</div>
		            <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">{{ $t('main.money') }}</span>{{ data?.data.team_yj}}</div>
		        </div>
		    </div>
		    <!-- <div class="flex-between">
		        <div class="flex-full">
		            <div data-v-11c150f3="">Accumulated recharge</div>
		            <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>0</div>
		        </div>
		        <div class="flex-full">
		            <div data-v-11c150f3="">Cumulative withdrawals</div>
		            <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>100</div>
		        </div>
		    </div> -->
		</div>
		<div class="u-m-tb-10">
		    <div class="team-data bg-grey u-p-10 u-m-t-10">
		        <div class="d-flex-center justify-between border-bottom u-m-b-10 u-p-b-10">
		            <div data-v-11c150f3=""><i class="van-icon" style="font-size: 17px;"><img src="../../assets/img/ic_trend.png" class="van-icon__image"></i><span class="u-font-16 u-m-l-10">Level 1</span>
		            </div><span class="van-tag van-tag--primary">{{ data?.tj_bili[0] }}%</span>
		        </div>
		        <div class="flex-between u-m-b-10 ">
		            <div class="flex-full">
		                <div data-v-11c150f3="">Team size</div>
		                <div class="text-red u-font-20">{{ data?.data.team1_count}}</div>
		            </div>
		            <div class="flex-full">
		                <div data-v-11c150f3="">Commission</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">{{ $t('main.money') }}</span>{{ data?.data.team1_yj}}</div>
		            </div>
		        </div>
		        <!-- <div class="flex-between">
		            <div class="flex-full">
		                <div data-v-11c150f3="">Accumulated recharge</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>0</div>
		            </div>
		            <div class="flex-full">
		                <div data-v-11c150f3="">Cumulative withdrawals</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>0</div>
		            </div>
		        </div> -->
		    </div>
		    <div class="team-data bg-grey u-p-10 u-m-t-10">
		        <div class="d-flex-center justify-between border-bottom u-m-b-10 u-p-b-10">
		            <div data-v-11c150f3=""><i class="van-icon" style="font-size: 17px;"><img src="../../assets/img/ic_trend.png" class="van-icon__image"></i><span class="u-font-16 u-m-l-10">Level 2</span>
		            </div><span class="van-tag van-tag--primary">{{ data?.tj_bili[1] }}%</span>
		        </div>
		        <div class="flex-between u-m-b-10 ">
		            <div class="flex-full">
		                <div data-v-11c150f3="">Team size</div>
		                <div class="text-red u-font-20">{{ data?.data.team2_count}}</div>
		            </div>
		            <div class="flex-full">
		                <div data-v-11c150f3="">Commission</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">{{ $t('main.money') }}</span>{{ data?.data.team2_yj}}</div>
		            </div>
		        </div>
		        <!-- <div class="flex-between">
		            <div class="flex-full">
		                <div data-v-11c150f3="">Accumulated recharge</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>0</div>
		            </div>
		            <div class="flex-full">
		                <div data-v-11c150f3="">Cumulative withdrawals</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>0</div>
		            </div>
		        </div> -->
		    </div>
		    <div class="team-data bg-grey u-p-10 u-m-t-10">
		        <div class="d-flex-center justify-between border-bottom u-m-b-10 u-p-b-10">
		            <div data-v-11c150f3=""><i class="van-icon" style="font-size: 17px;"><img src="../../assets/img/ic_trend.png" class="van-icon__image"></i><span class="u-font-16 u-m-l-10">Level 3</span>
		            </div><span class="van-tag van-tag--primary">{{ data?.tj_bili[2] }}%</span>
		        </div>
		        <div class="flex-between u-m-b-10 ">
		            <div class="flex-full">
		                <div data-v-11c150f3="">Team size</div>
		                <div class="text-red u-font-20">{{ data?.data.team3_count}}</div>
		            </div>
		            <div class="flex-full">
		                <div data-v-11c150f3="">Commission</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">{{ $t('main.money') }}</span>{{ data?.data.team3_yj}}</div>
		            </div>
		        </div>
		        <!-- <div class="flex-between">
		            <div class="flex-full">
		                <div data-v-11c150f3="">Accumulated recharge</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>0</div>
		            </div>
		            <div class="flex-full">
		                <div data-v-11c150f3="">Cumulative withdrawals</div>
		                <div class="text-red u-font-20"><span class="text-dark u-font-13 u-m-r-5">Q</span>0</div>
		            </div>
		        </div> -->
		    </div>
		    
		</div>
	</div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { i18n } from '@/lang/index.js'
import Request from '@/services/index.js'
import { showSuccessToast } from 'vant'
import { formatDate } from '@/utils/format-date.js'

const router = useRouter()
const { t } = i18n.global
const showCalendar = ref(false);
let selectedItemId = ref(0);

const loadShow = ref(false)

const data = ref([]);

const navList = [
  {
    title: t('team.all'),
    id: 0
  },
  {
    title: t('team.today'),
    id: 1
  },
  {
    title: t('team.yesterday'),
    id: 2
  },
  {
    title: t('team.week'),
    id: 3
  }
]
const onClickTab = (id) => {
	console.log(id)
	selectedItemId.value = id
	getData(selectedItemId.value)
}
const getData = (type) => {
	let start = ''; 
	if (type === 1) {
		start = new Date().getTime() / 1000
	} else if (type === 2) {
		start = new Date().getTime() / 1000 - (60 * 60 * 24)
	} else if (type === 3) {
		start = new Date().getTime() / 1000 - (60 * 60 * 24 * 7)
	}
	  if (start) {
		  formatDate(start, 'YYYY-MM-DD')
	  }
  
  Request.get({ url: '/index/ctrl/junior?ajax=1&start=' + start }).then(res => {
	data.value = res.data
  }).catch(err => {
	  
  })
}
getData(selectedItemId.value)
</script>

<style lang='less' scoped>
	.tab-group{
		width: 92%;
		display: flex;
		margin:10px 4%;
	}
    .tab-btn {
		text-align: center;
		width: 25%;
		height: .6rem;
		line-height: .6rem;
		border: 0.05px solid var(--main-color);
		color: var(--main-color);
		font-size: var(--van-button-normal-font-size);
   }
   .active {
	 background-color: var(--second-color);
   }
   .calendar-icon {
	   with:10px;
	   height:10px;
	   .icon-calendar {
	   	   background: url("../../assets/img/mine/calendar.png") 100%/contain;
	   }
   }
   .team {
		width: 92%;
		height: 100vh;
		background: #ffffff;
		padding: 0 4% 10px;
		overflow: hidden;
		font-size: 11px;
   }
   .team-data {
		
   }
   .u-font-13 {
       font-size: 13px;
   }
   .text-dark {
       color: #343a40!important;
   }
   .u-m-r-5 {
       margin-right: 5px;
   }
   
   .u-p-10, .u-padding-10 {
   	padding: 10px;
   }
   
   .bg-grey {
   	background: var(--gray-color);
   }
   .u-m-t-10 {
       margin-top: 0.26667rem!important;
   }
   .u-m-b-10 {
       margin-bottom: 0.26667rem!important;
   }
   .border-bottom {
       border-bottom: 0.5px solid #cacaca;
   }
   .van-tag--primary {
       background-color: #1989fa;
   }
   
   .van-tag {
       position: relative;
       display: -webkit-inline-box;
       display: -webkit-inline-flex;
       display: inline-flex;
       -webkit-box-align: center;
       -webkit-align-items: center;
       align-items: center;
       padding: 0 4px;
       color: #fff;
       font-size: 12px;
       line-height: 16px;
       border-radius: 2px;
   }
   
   .d-flex-center {
       -webkit-box-align: center;
       -ms-flex-align: center;
       align-items: center;
   }
   .d-flex-center, .d-flex-row {
       display: -webkit-box;
       display: -ms-flexbox;
       display: flex;
   }
   .van-icon {
       position: relative;
       display: inline-block;
       font: normal normal normal 14px/1 vant-icon;
       font-size: inherit;
       text-rendering: auto;
       -webkit-font-smoothing: antialiased;
   }
   .van-icon__image {
       display: block;
       width: 1em;
       height: 1em;
       object-fit: contain;
   }
   .u-font-16 {
       font-size: 16px;
   }
   .flex-between, .flex-center {
       display: -webkit-box;
       display: -ms-flexbox;
       display: flex;
       -webkit-box-align: center;
       -ms-flex-align: center;
       align-items: center;
   }
   .flex-full {
       -webkit-box-flex: 1;
       -ms-flex: 1;
       flex: 1;
   }
   .u-font-20 {
       font-size: 20px;
   }
   
   .text-red {
       color: var(--red-color);
   }
   .justify-between {
       -webkit-box-pack: justify;
       -ms-flex-pack: justify;
       justify-content: space-between;
   }
</style>
