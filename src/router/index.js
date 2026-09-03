import { createRouter, createWebHashHistory } from 'vue-router'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/',
      redirect: '/home'
    },
    {
      path: '/vip',
      name: 'vip',
      meta: {
        tabbarShow: true,
        navbarShow: false
      },
      component: () => import('@/views/VIP/index.vue')
    },
    {
      path: '/select-currency',
      name: 'selectCurrency',
      meta: {
        tabbarShow: false,
        navbarShow: false
      },
      component: () => import('@/views/Recharge/select.vue')
    },
    {
      path: '/recharge-detail',
      name: 'rechargeDetail',
      meta: {
        tabbarShow: false,
        navbarShow: false
      },
      component: () => import('@/views/Recharge/detail.vue')
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
        navbarShow: false
      },
      component: () => import('@/views/Login/index.vue')
    },
    {
      path: '/register',
      name: 'register',
      meta: {
        tabbarShow: false,
        navbarShow: false
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
    },
    {
      path: '/forgot-password',
      name: 'forgotPassword',
      meta: {
        tabbarShow: false,
        navbarShow: true
      },
      component: () => import('@/views/Login/forgot-password.vue')
    }
  ]
})

// 全局守卫：未登录时只能访问首页和登录/注册，登录后持久保持登录状态
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token') || sessionStorage.getItem('token')
  if (token && !sessionStorage.getItem('token')) {
    sessionStorage.setItem('token', token)
  }
  const publicRoutes = ['home', 'login', 'register', 'forgotPassword']
  if (!token) {
    if (publicRoutes.includes(to.name)) {
      next()
    } else {
      next({ name: 'login' })
    }
  } else {
    next()
  }
})

export default router
