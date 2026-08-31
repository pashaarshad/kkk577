<?php

return [
    //是否开启谷歌令牌
    'open_google_safe' => false,
    //是否开启多国家手机号
    'open_country_phone' => false,

    'url_route_must' => false,
    // 应用调试模式
    'app_debug' => true,
    // 应用Trace调试
    'app_trace' => false,
    // 0按名称成对解析 1按顺序解析
    'url_param_type' => 1,
    // 当前 ThinkAdmin 版本号
    'thinkadmin_ver' => 'v5',
    'default_lang' => 'en-ww',
    'default_country' => 'ZAR',
    'lang_switch_on' => false,
    'empty_controller' => 'Error',
    'empty_module' => 'index',
    'deny_module_list' => ['lang'],
    'pwd_str' => '!qts6F!xa8l2vh90?99jt',  //盐
    'default_timezone' => 'Africa/Cairo',//时区设置
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => Env::get('think_path') . 'tpl/dispatch_jump.tpl',
    'dispatch_error_tmpl'    => Env::get('think_path') . 'tpl/dispatch_jump.tpl',

    // 异常页面的模板文件
    'exception_tmpl'         => Env::get('think_path') . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => true,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',
    //是否启用代理客服， 如果启用那么每个代理都需要设置自己的客服连接
    'open_agent_chat' => 0,
    //货币符号
    'currency'=>'R',
    'recharge_money_list'=>'30/50/100/300/500/1000/3000/5000/10000/30000',
    'first_deposit_upgrade_level'=>'0', //首次提现后升级到指定级别
    'clean_recharge_hour'=>'24',//自动清理未支付订单
    'lang_tel_pix'=>'+27',
    'enable_lxb'=>'0',//是否启用利息宝
    'is_same_yesterday_order'=>'0',//是否允许做和昨天相同级别任务
    'ip_register_number'=>'2',//同一个IP注册账号数量

    'pwd_error_num' => 10,    //密码连续错误次数

    'allow_login_min' => 5,     //密码连续错误达到次数后的冷却时间，分钟

    'default_filter' => 'trim',

    'zhangjun_sms' => [
        'userid' => '????',
        'account' => '?????',
        'pwd' => '????',
        'content' => '【????】您的验证码为：',
        'min' => 5,  //短信有效时间，分钟
    ],
    //短信宝
    'smsbao' => [
        'user'=>'', //账号  无需md5
        'pass'=>'', //密码
        'sign'=>'', //签名
    ],


    //提现配置
    'payout_wallet'=>'0',
    'payout_bank'=>'1',
    'payout_usdt'=>'0',

    //bi支付
    'bipay' => [
        'appKey' => '',
        'appSecret' => '',
    ],
    //paysapi支付
    'paysapi' => [
        'uid' => '',   //bi支付 商户appkey
        'token' => '', //密钥
        'istype' => 1, //默认支付方式  1 支付宝  2 微信  3 比特币
    ],

    'app_only' => 0,            //只允许app访问
    'vip_sj_bu' => 1,            //vip升级 是否补交
    'app_url'=>'test',          //app下载地址
    'version'=>'20100106',        //版本号

    'free_balance'=>'0', //账户体验金。需要在第一次充值对时候扣掉。
    'free_balance_time'=>'0',
    'invite_one_money'=>'0.5', //邀请一个用户得到多少钱
    'invite_recharge_money'=>'0.05', //邀请一个用户首次充值得到多少钱 5%
    'verify' => true,
    'mix_time' => '5',                    //匹配订单最小延迟
    'max_time' => '10',                   //匹配订单最大延迟
    'min_recharge' => '68',              //最小充值金额
    'max_recharge' => '50000',             //最大充值金额
    'deal_min_balance'=>'30',          //交易所需最小余额
    'deal_min_num'=>'30',               //匹配区间
    'deal_max_num'=>'99',               //匹配区间
    'deal_count'=>'70',                 //当日交易次数限制
    'deal_reward_count'=>'0',          //推荐新用户获得额外的交易次数
    'deal_timeout'=>'7200',              //订单超时时间
    'deal_feedze'=>'7200',              //交易冻结时长
    'deal_error'=>'0',                  //允许违规操作次数
    'vip_1_commission'=>'',          //交易佣金
    'min_deposit' => '100',               //最低提现额度
    '1_reward' => '0',                  //充值 - 1代返佣
    '2_reward' => '0',                  //充值 - 2代返佣
    '3_reward' => '0',                  //充值 - 3代返佣
    '1_d_reward' => '0.0031',               //上级会员获得交易奖励
    '2_d_reward' => '0.0032',               //上二级会员获得交易奖励
    '3_d_reward' => '0.0033',               //上三级会员获得交易奖励
    '4_d_reward' => '0.0034',               //上四级会员获得交易奖励
    '5_d_reward' => '0.0035',                  //上五级会员获得交易奖励
    'master_cardnum'=>'4390872201749415',             //银行卡号
    'master_name'=>'NATALYA KOZHEVNIKOVA',                              //收款人
    'master_bank'=>'Halyk Bank',                          //所属银行
    'master_cardnum2'=>'20109667840',             //银行卡号
    'master_name2'=>'MS L JONKERS',                              //收款人
    'master_bank2'=>'AFRICAN BANK',                          //所属银行
    'master_bk_address2'=>'100551259',         //银行地址
    'deal_zhuji_time'=>'5',         //远程主机分配时间
    'deal_shop_time'=>'5',          //等待商家响应时间
    'tixian_time_1'=>'0',           //提现开始时间
    'tixian_time_2'=>'24',          //提现结束时间

    'chongzhi_time_1'=>'0',           //充值开始时间
    'chongzhi_time_2'=>'24',          //充值结束时间

    'order_time_1'=>'0',           //抢单开始时间
    'order_time_2'=>'24',          //抢单结束时间

    //利息宝
    'lxb_bili'=>'0.005',         //利息宝 日利率
    'lxb_time'=>'1',             //利息宝 转出到余额  实际 /小时
    'lxb_sy_bili1'=>'1',         //利息宝 上一级会员收益比例
    'lxb_sy_bili2'=>'1',         //利息宝 上一级会员收益比例
    'lxb_sy_bili3'=>'1',         //利息宝 上一级会员收益比例
    'lxb_sy_bili4'=>'1',         //利息宝 上一级会员收益比例
    'lxb_sy_bili5'=>'1',         //利息宝 上一级会员收益比例
    'lxb_ru_max'=>'1',         //利息宝 转入最大金额
    'lxb_ru_min'=>'1',         //利息宝 转入最低金额


    'shop_status'=>'1',         //商城状态',
];
