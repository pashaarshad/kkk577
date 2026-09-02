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
use think\Db;

/**
 * 应用入口
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    /**
     * 入口跳转链接
     */
    public function index()
    {
        $this->home();
    }

    public function home() {
        $data = new \stdClass();
        $data->banner = Db::name('xy_banner')->select();
        /*$reward_list = Db::name('xy_reward_log')->field('oid, num')->where('type', 2)->order('id desc')->limit(50)->select();
        foreach ($reward_list as &$item) {
            $item['oid'] = hideStr($item['oid']);
        }
        $data->reward_list = $reward_list;*/
        $deposit_list = Db::name('xy_deposit')->field('id, num, voucher')->where('status', 2)->order('addtime desc')->limit(50)->select();
        foreach ($deposit_list as &$item) {
            $item['id'] = hideStr($item['id']);
        }
        $data->deposit_list = $deposit_list;
        $uid = session('user_id');
        $data->user_info = Db::name('xy_users')->field('tel,invite_code,balance,level')->find($uid);
        $yes1 = strtotime(date("Y-m-d 00:00:00", strtotime("-1 day")));
        $yes2 = strtotime(date("Y-m-d 23:59:59", strtotime("-1 day")));
        $data->today_commission = Db::name('xy_convey')->where('uid', $uid)->where('status', 1)->where('addtime', 'between', [strtotime('Y-m-d 00:00:00'), time()])->sum('commission');
        $intro_msg = Db::name('xy_index_msg')->where('id', 16)->find();
        $data->intro_title = ($intro_msg && !empty($intro_msg['title'])) ? $intro_msg['title'] : 'Platform Introduction';
        $data->intro_desc = ($intro_msg && !empty($intro_msg['content'])) ? strip_tags($intro_msg['content']) : 'Welcome to the Platform. Complete daily interactive tasks, lock investments, and claim massive yield rewards instantly.';
        $data->intro_video = sysconf('intro_video_url') ?: 'https://www.w3schools.com/html/mov_bbb.mp4';
        $data->chats_link = sysconf('chats_link') ?: 'https://wa.me/553588236216?text=Hello';
        return json(['code'=> 0, 'data' => $data]);

        $uid = session('user_id');
        $this->info = Db::name('xy_users')->find($uid);
        $this->balance = $this->info['balance'];
        $this->banner = Db::name('xy_banner')->select();
        $this->notice = Db::name('xy_index_msg')->where('id', 1)->value('content');
        $this->notice = htmlspecialchars_decode($this->notice);
        $this->level_list = Db::table('xy_level')->where('level<8')->select();

        $this->index_icon = Db::name('xy_index_msg')->where('id', 'in',[2,3,4,12])->column('title','id');

        if (config('app_only')) {
            $dev = new \org\Mobile();
            $t = $dev->isMobile();
            if (!$t) {
                header('Location:/app');
            }
        }

        $sr_list = Db::query('SELECT uid,sum(`num`) as `today_income` FROM `xy_balance_log` WHERE addtime>' . strtotime('today') . ' and `type` in(3,6) and `status`=1 group by uid order by `today_income` desc limit 20');
        $list = [];
        foreach ($sr_list as $k => $v) {
            $list[$k] = $v;
            $list[$k]['tel'] = Db::name('xy_users')->where('id', $v['uid'])->value('username');
        }

        $this->list = $list;


        $this->lixi_count = Db::table('xy_lixibao')->where('uid', session('user_id'))->sum('yuji_num');
        $this->lixi_count_today = Db::table('xy_lixibao')->where('uid', session('user_id'))->where('addtime', 'between', [strtotime('Y-m-d 00:00:00'), time()])->sum('yuji_num');
        $this->today_income = $this->tod_user_yongjin + $this->lixi_count_today;


        return $this->fetch('home');
    }

    //获取首页图文
    public function get_msg()
    {
        $id = input('id/d', 1);
        $data = Db::name('xy_index_msg')->find($id);
        if ($data)
            return json(['code' => 0, 'info' => lang('czcg'), 'data' => $data]);
        else
            return json(['code' => 1, 'info' => lang('zwsj')]);
    }


    //获取首页图文
    public function getTongji()
    {
        $type = input('post.type/d', 1);
        $data = array();

        $data['user'] = Db::name('xy_users')->where('status', 1)->where('addtime', 'between', [strtotime(date('Y-m-d')) - 24 * 3600, time()])->count('id');
        $data['goods'] = Db::name('xy_goods_list')->count('id');;
        $data['price'] = Db::name('xy_convey')->where('status', 1)->where('endtime', 'between', [strtotime(date('Y-m-d')) - 24 * 3600, strtotime(date('Y-m-d'))])->sum('num');
        $user_order = Db::name('xy_convey')->where('status', 1)->where('addtime', 'between', [strtotime(date('Y-m-d')), time()])->field('uid')->Distinct(true)->select();
        $data['num'] = count($user_order);

        if ($data) {
            return json(['code' => 0, 'info' => lang('czcg'), 'data' => $data]);
        } else {
            return json(['code' => 1, 'info' => lang('zwsj')]);
        }
    }


    function getDanmu()
    {
        $barrages =    //弹幕内容
            array(
                array(
                    'info' => '用户173***4985开通会员成功',
                    'href' => '',

                ),
                array(
                    'info' => '用户136***1524开通会员成功',
                    'href' => '',
                    'color' => '#ff6600'

                ),
                array(
                    'info' => '用户139***7878开通会员成功',
                    'href' => '',
                    'bottom' => 450,
                ),
                array(
                    'info' => '用户159***7888开通会员成功',
                    'href' => '',
                    'close' => false,

                ), array(
                'info' => '用户151***7799开通会员成功',
                'href' => '',

            )
            );

        echo json_encode($barrages);
    }

}
