<?php

namespace app\index\controller;

use app\admin\model\Convey;
use library\Controller;
use think\App;
use think\facade\Request;
use think\Db;

/**
 * 验证登录控制器
 */
class Base extends Controller
{
    protected $rule = ['__token__' => 'token'];
    protected $msg = ['__token__' => '无效token！'];
    protected $_uid;

    function __construct(App $app)
    {
        parent::__construct($app);
        if (config('shop_status') == 0) exit();
        $uid = session('user_id');
        if (!$uid) {
            $uid = cookie('user_id');
        }
        //echo App::VERSION;exit;
        /*if (request()->subDomain() == 'cs' || request()->subDomain() == '') {
            header('Location:' . 'https://www.' . \request()->rootDomain());
            exit();
        }*/
        $controller = strtolower(\request()->controller());
        if ($controller == 'user') return;

        if (!$uid && request()->isPost()) {
            $this->error(lang('no_login'));
        }
        if (!$uid) $this->redirect('User/login');
        $this->_uid = $uid;
        /***实时监测账号状态***/
        $uinfo = Db::name('xy_users')->find($uid);
        // if($uinfo['status']!=1){
        //     \Session::delete('user_id');
        //     $this->redirect('User/login');
        // }
        $this->console = Db::name('xy_script')->where('id', 1)->value('script');

        /*$uChats = session('user_join_chats');
        if (!$uChats) {
            if (config('open_agent_chat') == 1) {
                $uChats = sysconf('chats_link');
            } else {
                $service = model('admin/Users')->get_user_service_id($uid);
                if (empty($service)) $uChats = sysconf('chats_link');
                else $uChats = $service['chats'];
            }
            session('user_join_chats', $uChats);
        }*/
        $uChats = url('support/index');
        $this->assign('user_service_chats', $uChats);
        
        $notice = Db::name('xy_notice')->where('tel', $uinfo['tel'])->where('is_read', 1)->find();
        if ($notice && !$notice['need_confirm']) {
            Db::name('xy_notice')->where('id', $notice['id'])->update(['is_read' => 2, 'read_time' => time()]);
        }
        $this->assign('show_user_notice', $notice ? 1 : 0);
        $this->assign('user_notice', $notice ? $notice['content'] : '');
    }

    public function showMessage($msg, $url = '-1')
    {
        if ($url == '-1') {
            echo "<script>alert('" . lang('free_user_lxb') . "');window.history.back();</script>";
        } else {
            echo "<script>alert('" . lang('free_user_lxb') . "');window.location.href='" . $url . "';</script>";
        }
        exit();
    }

    /**
     * 空操作 用于显示错误页面
     */
    public function _empty($name)
    {
        exit;
        return $this->fetch($name);
    }

    //图片上传为base64为的图片
    public function upload_base64($type, $img)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)) {
            //$type_img = $result[2];  //得到图片的后缀
            $type_img = 'png';
            //上传 的文件目录

            $App = new \think\App();
            $new_files = $App->getRootPath() . 'upload' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . date('m-d') . DIRECTORY_SEPARATOR;

            if (!file_exists($new_files)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                //服务器给文件夹权限
                mkdir($new_files, 0777, true);
            }
            //$new_files = $new_files.date("YmdHis"). '-' . rand(0,99999999999) . ".{$type_img}";
            $new_files = check_pic($new_files, ".{$type_img}");
            if (file_put_contents($new_files, base64_decode(str_replace($result[1], '', $img)))) {
                //上传成功后  得到信息
                $filenames = str_replace('\\', '/', $new_files);
                $file_name = substr($filenames, strripos($filenames, "/upload"));
                return $file_name;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 检查交易状态
     */
    public function check_deal()
    {
        $uid = session('user_id');
        $uinfo = Db::name('xy_users')->where('id', $uid)->find();
        if ($uinfo['status'] == 2) return [
            'code' => 1,
            'info' => lang('gzhybjy')
        ];
        if ($uinfo['deal_status'] == 0) return [
            'code' => 1,
            'info' => lang('gzhybdj')
        ];
        $uinfo['level'] = $uinfo['level'] ? intval($uinfo['level']) : 0;
        /*if ($uinfo['deal_status'] == 3) return [
            'code' => 1,
            'info' => lang('gzhczwwcdd'),
            'url' => url('/index/order/index')
        ];*/
        //判断是否有未完成订单
        $order = Db::name('xy_convey')->field('id')
            ->where('uid', $uid)->where('status', 'in', [0, 5])->find();
        if ($order) {
            return [
                'code' => 1,
                'info' => lang('gzhczwwcdd'),
                'url' => url('/index/order/index')
            ];
        }
        if ($uinfo['balance'] < config('deal_min_balance')) return [
            'code' => 1,
            'info' => lang('yedy') . ' ' . config('deal_min_balance') . ',' . lang('wfjy'),
            'url' => url('index/ctrl/recharge')
        ];
        
        //是否昨天做过相同级别的任务 *teemo*
        // if (config('is_same_yesterday_order') == 0) {
            if (config('is_same_yesterday_order') == 0 && $uinfo['group_id'] == 0) {
                $d1 = strtotime(date('Y-m-d')) - 86400;
                $d2 = strtotime(date('Y-m-d'));
                // $d2 = strtotime(date('Y-m-d H:i:s'));
                $oTd = Db::name('xy_convey')
                    ->where('status', 1)
                    ->where('uid', $uinfo['id'])
                    ->where('level_id', $uinfo['level'])
                    //->where('addtime', 'between', [$d1, $d2])
                    ->where('addtime', '<', $d2)
                    ->value('id');
                if ($oTd) {
                    return [
                        'code' => 1,
                        'info' => lang('order_error_level_num'),
                        'url' => url('/index/support/index'),
                        'endRal' => true
                    ];
                }
            }
        if ($uinfo['group_id'] > 0) {
            //杀猪组
            
            $isRoll = Db::name('xy_group')
                ->where('id', $uinfo['group_id'])->value('is_roll');
            //如果不允许轮回 做单
            if ($isRoll == 0) {
                //order_num
                $max_order_num = Db::name('xy_group_rule')
                    ->where('group_id', $uinfo['group_id'])
                    ->order('order_num desc')
                    ->value('order_num');
                //如果规则组没有规则
                if (empty($max_order_num)) {
                    return ['code' => 1, 'info' => lang('hyddjycsbz'), 'endRal' => true];
                }
                // $u_order_num = Db::name('xy_convey')
                //     ->where('group_id', $uinfo['group_id'])
                //     ->where('uid', $uinfo['id'])
                //     ->order('addtime desc')
                //     ->limit(1)
                //     ->value('group_rule_num');
                // //如果是最后一单
                // if ($u_order_num >= $max_order_num) {
                //     return ['code' => 1, 'info' => lang('hyddjycsbz'), 'endRal' => true];
                // }
                $u_order = Db::name('xy_convey')
                ->where('group_id', $uinfo['group_id'])
                ->where('uid', $uinfo['id'])
                ->order('addtime desc')
                ->find();
                if(!empty($u_order)) {
                    $group_rule_num_size =  intval($u_order['group_rule_num_size']);
            // return ['code' => 1, 'info' => '333', 'endRal' => true];
                    $group_rule_num_num =  intval($u_order['group_rule_num_num']);
                    $u_order_num = intval($u_order['group_rule_num']);
                    //如果是最后一单
                    // echo $u_order_num . '-' . $max_order_num;die;
                    if ($u_order_num >= $max_order_num && $group_rule_num_size == $group_rule_num_num) {
                        return ['code' => 1, 'info' => lang('hyddjycsbz'), 'endRal' => true];
                    }
                }
            
            // return ['code' => 1, 'info' => $u_order_num.'='. $max_order_num.'='. $group_rule_num_size.'='. $group_rule_num_num, 'endRal' => true];
            }
        } else {
            //普通组
            $count = Db::name('xy_convey')
                ->where('addtime', 'between', [strtotime(date('Y-m-d')), time()])
                ->where('uid', $uinfo['id'])
                ->where('level_id', $uinfo['level'])
                ->where('status', 1)
                ->count('id');//统计当天完成交易的订单
            //获取可交易情况
            $orderSetting = Convey::instance()->get_user_order_setting($uid, $uinfo['level']);
            if ($count >= $orderSetting['order_num']) {
                return ['code' => 1, 'info' => lang('hyddjycsbz'), 'endRal' => true];
            }
        }
        // die('debug');
        
        return false;
    }


    protected function getBankList()
    {
        $fileurl = APP_PATH . "../config/bank.txt";
        $bank_data = file_get_contents($fileurl);
        $bank_data = explode("\n", $bank_data);
        $bank_list = [];
        foreach ($bank_data as $v) {
            $vS = explode('|', $v);
            if (count($vS) != 2) continue;
            $bank_list[trim($vS[0])] = trim($vS[1]);
        }
        return $bank_list;
    }

}
