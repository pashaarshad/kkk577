import { createRouter, createWebHashHistory } from 'vue-router'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/',
      redirect: '/home'
    },
    {
      path: '/home',
      name: 'home',
      meta: {
        tabbarShow: true,
        navbarShow: true
      },
      component: () => import('@/views/home/index.vue')
    },
    {
      path: '/login',
      name: 'login',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/Login/index.vue')
    },
    {
      path: '/register',
      name: 'register',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/Login/register.vue')
    },
    {
      path: '/mine',
      name: 'mine',
      meta: {
        tabbarShow: true,
        navbarShow: true
      },
      component: () => import('@/views/Mine/index.vue')
    },
    {
      path: '/order',
      name: 'order',
      meta: {
        tabbarShow: true,
        navbarShow: true
      },
      component: () => import('@/views/Order/index.vue')
    },
    {
      path: '/work',
      name: 'work',
      meta: {
        tabbarShow: true,
        navbarShow: true
      },
      component: () => import('@/views/Work/index.vue')
    },
    {
      path: '/grab',
      name: 'grab',
      meta: {
        tabbarShow: true,
        navbarShow: true
      },
      component: () => import('@/views/Grab/index.vue')
    },
    {
      path: '/pay',
      name: 'pay',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/Pay/index.vue')
    },
    {
      path: '/withdraw',
      name: 'withdraw',
      meta: {
        tabbarShow: false,
        navbarShow: false
      },
      component: () => import('@/views/Withdraw/index.vue')
    },
    {
      path: '/bankCard',
      name: 'bankCard',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/BankCard/index.vue')
    },
    {
      path: '/recharge',
      name: 'recharge',
      meta: {
        tabbarShow: false,
        navbarShow: false
      },
      component: () => import('@/views/Recharge/index.vue')
    },
    {
      path: '/information',
      name: 'information',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/Information/index.vue')
    },
    {
      path: '/rechargeRecord',
      name: 'rechargeRecord',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/RechargeRecord/index.vue')
    },
    {
      path: '/withdrawRecord',
      name: 'withdrawRecord',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/WithdrawRecord/index.vue')
    },
    {
      path: '/team',
      name: 'team',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/Team/index.vue')
    },
    {
      path: '/billList',
      name: 'billList',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/billList/index.vue')
    },
    {
      path: '/password',
      name: 'password',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/User/password.vue')
    },
    {
      path: '/message',
      name: 'message',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/User/message.vue')
    },
    {
      path: '/poster/detail/:id',
      name: 'posterDetail',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/Poster/Detail.vue')
    }
  ]
})

// 全局守卫：登录拦截 本地没有存token,请重新登录
router.beforeEach((to, from, next) => {
  // 判断有没有登录
  if (!sessionStorage.getItem('token')) {
    if (to.name === 'login' || to.name === 'home' || to.name === 'register' || to.name === 'posterDetail') {
      next()
    } else {
      router.push('/login')
    }
  } else {
    next()
  }
})

export default router
