<?php

namespace app\admin\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\ThrowableError;
use think\Model;
use think\Db;

class Convey extends Model
{

    protected $table = 'xy_convey';

    public static function instance(): Convey
    {
        return new self();
    }

    /**
     * 创建订单
     * @param int $uid 用户编号
     * @param int $cid 商品组
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws Exception
     * @throws ModelNotFoundException
     * @throws \think\exception\PDOException
     */
    public function create_order($uid, $cid = 1)
    {
        // *teemo*
        $add_id = Db::name('xy_member_address')->where('uid', $uid)->value('id');//获取收款地址信息
        if (config('default_country') == 'RON' || config('default_country') == 'KAZ' || config('default_country') == 'THB' || config('default_country') == 'TUR' || config('default_country') == 'LKR' || config('default_country') == 'ZAR') {
            if (!$add_id){
                $name = 'name';
                $tel = '000000';
                $address = 'address';
                $area = 'area';
                $data = [
                    'uid' => $uid,
                    'name' => $name,
                    'tel' => $tel,
                    'area' => $area,
                    'address' => $address,
                    'addtime' => time()
                ];
                $tmp = db('xy_member_address')->where('uid', $uid)->find();
                if (!$tmp) $data['is_default'] = 1;
                $res = db('xy_member_address')->insert($data);
                // $add_id = $data;
                if (!$res) {
                    return ['code' => 1, 'info' => lang('wszshdz')];
                } else {
                    $add_id = Db::name('xy_member_address')->where('uid', $uid)->value('id');//获取收款地址信息
                }
            }
        } else {
          if (!$add_id) return ['code' => 1, 'info' => lang('wszshdz')];
        }
        $uinfo = Db::name('xy_users')->find($uid);
        if ($uinfo['deal_status'] != 2) return ['code' => 1, 'info' => lang('qdyzz')];
        $level = $uinfo['level'] ? intval($uinfo['level']) : 0;
        $orderSetting = $this->get_user_order_setting($uid, $level);
        if ($uinfo['balance'] < $orderSetting['min_money']) {
            return [
                'code' => 1,
                'info' => sprintf(lang('zhyebz'), ($orderSetting['min_money'] - $uinfo['balance']) . ""),
                'url' => url('index/ctrl/recharge')
            ];
        }

        $min = $uinfo['balance'] * config('deal_min_num') / 100;
        $max = $uinfo['balance'] * config('deal_max_num') / 100;
        list($orderNum) = $this->get_user_group_rule($uinfo['id'], $uinfo['group_id']);
        $inyectar = $this->get_inyectar($uid, $orderNum);
        //打针
        if ($inyectar) {
            $min = $max = $uinfo['balance'] * $inyectar['scale'];
        }

        $t_cust = Db::name('xy_convey_cust')->where('uid', $uid)->find();
        if ($t_cust) {
            // 存在则使用指定金额订单
            $min = $t_cust['num'];
            $max = $t_cust['num'];
            Db::table('xy_convey_cust')->where('uid', $uid)->delete();
        }

        $goods = $this->rand_order($min, $max, $cid);
        $goods_num = $goods['num'];
        if ($t_cust) {
            // 存在则使用指定金额订单
            $goods_num = $t_cust['num'];
        }

        $id = getSn('UB');
        Db::startTrans();
        $res = Db::name('xy_users')->where('id', $uid)->update(['deal_status' => 3, 'deal_time' => strtotime(date('Y-m-d')), 'deal_count' => Db::raw('deal_count+1')]);//将账户状态改为交易中
        //插入佣金记录
        $c_data = [
            'id' => $id,
            'uid' => $uid,
            'level_id' => $uinfo['level'],
            'num' => $goods_num,
            'addtime' => time(),
            'endtime' => time() + config('deal_timeout'),
            'add_id' => $add_id,
            'goods_id' => $goods['id'],
            'goods_count' => $goods['count'],
            'commission' => $goods_num * $orderSetting['bili'],  //交易佣金按照会员等级
            'user_balance' => $uinfo['balance'],
            'user_freeze_balance' => $uinfo['freeze_balance'],
        ];
        //查出用户推荐人 发放推荐人佣金
        if ($uinfo['parent_id'] > 0) {
            $pLevel = Db::name('xy_users')->where(['id' => $uinfo['parent_id']])->value('level');
            if ($pLevel) {
                $tj_bili = Db::name('xy_level')->where('level', $pLevel)->value('tj_bili');
                if ($tj_bili) {
                    $c_data['parent_commission'] = $c_data['commission'] * floatval($tj_bili);
                    $c_data['parent_uid'] = $uinfo['parent_id'];
                }
            }
        }
        $res1 = Db::name($this->table)
            ->insert($c_data);
        if ($inyectar) {
            Db::name('xy_inyectar')
                ->where('id', $inyectar['id'])
                ->update([
                    'in_time' => time(),
                    'in_amount' => $goods_num,
                    'in_oid' => $id
                ]);
        }
        if ($res && $res1) {
            Db::commit();
            return ['code' => 0, 'info' => lang('qd_ok'), 'oid' => $id, 'orderNum' => $orderNum];
        } else {
            Db::rollback();
            return ['code' => 1, 'info' => lang('qd_sb')];
        }
    }

    /**
     * 创建杀猪组订单
     * @param int $uid 用户编号
     * @param int $cid 商品组
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws Exception
     * @throws ModelNotFoundException
     * @throws \think\exception\PDOException
     */
    public function create_order_group($uid, $cid = 1)
    {
        // *teemo*
        $add_id = Db::name('xy_member_address')->where('uid', $uid)->value('id');//获取收款地址信息
        if (config('default_country') == 'RON' || config('default_country') == 'KAZ' || config('default_country') == 'THB' || config('default_country') == 'TUR' || config('default_country') == 'LKR' || config('default_country') == 'ZAR') {
            if (!$add_id) {
                $name = 'name';
                $tel = '000000';
                $address = 'address';
                $area = 'area';
                $data = [
                    'uid' => $uid,
                    'name' => $name,
                    'tel' => $tel,
                    'area' => $area,
                    'address' => $address,
                    'addtime' => time()
                ];
                $tmp = db('xy_member_address')->where('uid', $uid)->find();
                if (!$tmp) $data['is_default'] = 1;
                $res = db('xy_member_address')->insert($data);
                // $add_id = $data;
                if (!$res) {
                    return ['code' => 1, 'info' => lang('wszshdz')];
                } else {
                    $add_id = Db::name('xy_member_address')->where('uid', $uid)->value('id');//获取收款地址信息
                }
            }
        } else {
          if (!$add_id) return ['code' => 1, 'info' => lang('wszshdz')];
        }
        // if (!$add_id) return ['code' => 1, 'info' => lang('wszshdz')];
        $uinfo = Db::name('xy_users')->find($uid);
        if ($uinfo['deal_status'] != 2) return ['code' => 1, 'info' => lang('qdyzz')];
        $groupInfo = Db::name('xy_group')->where('id', $uinfo['group_id'])->find();
        //是否符合级别最低金额
        if ($uinfo['balance'] < $groupInfo['money']) {
            return [
                'code' => 1,
                'info' => sprintf(lang('zhyebz'), ($groupInfo['money'] - $uinfo['balance']) . ""),
                'url' => url('index/ctrl/recharge')
            ];
        }
        list($orderNum, $groupRule, $all_order_num, $orderNum_Size, $orderNum_Num) = $this->get_user_group_rule($uinfo['id'], $uinfo['group_id']);
        if (empty($groupRule)) {
            return ['code' => 1, 'info' => lang('qd_sb')];
        }
        $inyectar = $this->get_inyectar($uid, $orderNum);
        $time = time();
        $orderListData = [];
        //判断订单模式
        if ($groupRule['order_type'] == 1) {
            //叠加模式
            $oP = explode('|', $groupRule['order_price']);
            $ids = [];
            $cc = 1;
            $cc_count = count($oP);
            if($cc_count > 1 && $orderNum_Size == 1) {
                // 含有小单，并且是第一单的情况
                $orderNum_Size = $cc_count;
                $orderNum_Num = 1;
            } else {
                if($orderNum_Size >= $orderNum_Num + 1){
                    // 含有小单，并且不是第一单的情况
                    $orderNum_Num = $orderNum_Num + 1;
                }
            }
            foreach ($oP as $bl) {
                if ($cc == $orderNum_Num){
                    $bl = floatval($bl);
                    if ($bl < 0.01) {
                        return ['code' => 1, 'info' => lang('qd_sb')];
                    }
                    $min = $max = $uinfo['balance'] * $bl;
                    //打针
                    if ($inyectar) {
                        $min = $max = $uinfo['balance'] * $bl * $inyectar['scale'];
                    }
                    
                    $t_cust = Db::name('xy_convey_cust')->where('uid', $uid)->find();
                    if ($t_cust) {
                        // 存在则使用指定金额订单
                        $min = $t_cust['num'];
                        $max = $t_cust['num'];
                        Db::table('xy_convey_cust')->where('uid', $uid)->delete();
                    }
                    $goods = $this->rand_order($min, $max, $cid);
                    $goods_num = $goods['num'];
                    if ($t_cust) {
                        // 存在则使用指定金额订单
                        $goods_num = $t_cust['num'];
                    }

                    //计算佣金
                    $commission = $this->get_commission($goods_num, $groupRule);
                    $oid = getSn('UB');
                    $ids[] = $oid;
                    $orderListData[] = [
                        'id' => $oid,
                        'uid' => $uid,
                        'level_id' => $uinfo['level'],
                        'num' => $goods_num,
                        'addtime' => $time,
                        'endtime' => $time + config('deal_timeout'),
                        'add_id' => $add_id,
                        'goods_id' => $goods['id'],
                        'goods_count' => $goods['count'],
                        'commission' => $commission,
                        'group_id' => $uinfo['group_id'],
                        'group_rule_num' => $orderNum,
                        'user_balance' => $uinfo['balance'],
                        'user_freeze_balance' => $uinfo['freeze_balance'],
                        'group_rule_num_size' => $orderNum_Size,
                        'group_rule_num_num' => $orderNum_Num,
                    ];
                }
                $cc = $cc + 1;
            }
            // print_r($orderListData);die;
            if (empty($orderListData)) {
                return ['code' => 1, 'info' => lang('qd_sb')];
            }
        } else {
            $min = $uinfo['balance'] * config('deal_min_num') / 100;
            $max = $uinfo['balance'] * config('deal_max_num') / 100;
            //打针
            if ($inyectar) {
                $min = $max = $uinfo['balance'] * $inyectar['scale'];
            }
               
            $t_cust = Db::name('xy_convey_cust')->where('uid', $uid)->find();
            if ($t_cust) {
                // 存在则使用指定金额订单
                $min = $t_cust['num'];
                $max = $t_cust['num'];
                Db::table('xy_convey_cust')->where('uid', $uid)->delete();
            }

            $goods = $this->rand_order($min, $max, $cid);
            $goods_num = $goods['num'];
            if ($t_cust) {
                // 存在则使用指定金额订单
                $goods_num = $t_cust['num'];
            }

            //计算佣金
            $commission = $this->get_commission($goods_num, $groupRule);
            $ids = [getSn('UB')];
            $c_data = [
                'id' => $ids[0],
                'uid' => $uid,
                'level_id' => $uinfo['level'],
                'num' => $goods_num,
                'addtime' => $time,
                'endtime' => $time + config('deal_timeout'),
                'add_id' => $add_id,
                'goods_id' => $goods['id'],
                'goods_count' => $goods['count'],
                'commission' => $commission,  //交易佣金按照会员等级
                'group_id' => $uinfo['group_id'],
                'group_rule_num' => $orderNum,
                'user_balance' => $uinfo['balance'],
                'user_freeze_balance' => $uinfo['freeze_balance'],
            ];
        }
        $other_data = [];
        //查出用户推荐人 发放推荐人佣金
        if ($uinfo['parent_id'] > 0) {
            $pLevel = Db::name('xy_users')->where(['id' => $uinfo['parent_id']])->value('level');
            if ($pLevel) {
                $tj_bili = Db::name('xy_level')->where('level', $pLevel)->value('tj_bili');
                if ($tj_bili) {
                    if (isset($c_data)) $c_data['parent_commission'] = floatval($c_data['commission']) * floatval($tj_bili);
                    $other_data['parent_uid'] = $uinfo['parent_id'];
                }
            }
        }
        //事务处理
        Db::startTrans();
        //将账户状态改为交易中
        $res = Db::name('xy_users')->where('id', $uid)
            ->update(['deal_status' => 3,
                'deal_time' => strtotime(date('Y-m-d')),
                'deal_count' => Db::raw('deal_count+1')
            ]);
        //插入订单记录
        if ($groupRule['order_type'] == 1) {
            $oRes = [];
            foreach ($orderListData as $data) {
                $oRes[] = Db::name($this->table)->insert(array_merge($data, $other_data));
            }
            //全部成功才行
            $res1 = true;
            foreach ($oRes as $v) {
                if (!$v) {
                    $res1 = false;
                    break;
                }
            }
        } else {
            $res1 = Db::name($this->table)->insert(array_merge($c_data, $other_data));
        }
        if ($inyectar) {
            Db::name('xy_inyectar')
                ->where('id', $inyectar['id'])
                ->update([
                    'in_time' => time(),
                    'in_amount' => $goods['num'],
                    'in_oid' => $ids[0]
                ]);
        }
        if ($res && $res1) {
            Db::commit();
            return ['code' => 0, 'info' => lang('qd_ok'), 'oid' => $ids, 'orderNum' => $orderNum];
        } else {
            Db::rollback();
            return ['code' => 1, 'info' => lang('qd_sb')];
        }
    }

    /**
     * 获取用户可交易情况
     * @param $uid int 用户编号
     * @param $level_id int 级别编号
     * @return array [总订单量，佣金比例，最低金额，提现订单限制]
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function get_user_order_setting($uid, $level_id)
    {
        $setting = Db::name('xy_users_setting')
            ->where('uid', $uid)
            ->where('date', date('Y-m-d'))
            ->find();
        if ($setting) {
            return [
                'order_num' => $setting['order_num'],
                'bili' => $setting['bili'],
                'min_money' => $setting['min_money'],
                'min_deposit_order' => $setting['min_deposit_order'],
            ];
        }
        $level = Db::name('xy_level')->where('level', $level_id)->find();
        return [
            'order_num' => $level['order_num'],
            'bili' => $level['bili'],
            'min_money' => $level['num_min'],
            'min_deposit_order' => $level['tixian_nim_order'],
        ];
    }

    /**
     * 获取用户当前做单情况
     * @param $uid int 用户编号
     * @param $group_id int 叠加组
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function get_user_group_rule($uid, $group_id)
    {
        if (!$group_id) {
            //普通组
            $uinfo = Db::name('xy_users')->find($uid);
            $uinfo['level'] = $uinfo['level'] > 0 ? $uinfo['level'] : 0;
            $orderNum = Db::name('xy_convey')
                ->where([
                    ['uid', '=', $uid],
                    ['level_id', '=', $uinfo['level']],
                    ['addtime', 'between', strtotime(date('Y-m-d')) . ',' . time()],
                ])
                ->where('status', 'in', [0, 1, 3, 5])
                ->count('id');
            $all_order_num = Db::name('xy_level')->where('level', $uinfo['level'])->value('order_num');
            return [$orderNum, 0, $all_order_num];
        }
        $groupInfo = Db::name('xy_group')->where('id', $group_id)->find();
        //总单数
        $all_order_num = intval($groupInfo['order_num']);
        //判断当前第几单
        $orderNum = 1;
        // 记录当前子订单数量
        $orderNum_Size = 1;
        // 记录当前子订单第几单
        $orderNum_Num = 1;
        $orderNum_Full = 0;
        $lastOrder = Db::name('xy_convey')
            ->where('uid', $uid)
            ->where('group_is_active', 1)
            // ->where('group_id', $group_id)
            ->order('oid desc')
            ->find();
        // 判断从1开始计算的情况
        $reset = false;
        if ($lastOrder) {
            // 1. 重置叠加组
            if ($lastOrder['clear_group']) {
                $reset = true;
            }
            // 2. 重新分组后，原任务做完
            if ($lastOrder['group_id'] != $group_id) {
                $old_order_num = Db::name('xy_group')->where('id', $lastOrder['group_id'])->value('order_num');
                if ($old_order_num == $lastOrder['group_rule_num']) {
                    $reset = true;
                }
            }
            // 
        }
    
        if (!empty($lastOrder) && !$reset) {
            if ($lastOrder['group_rule_num'] <= $groupInfo['order_num']) {
                // *teemo*
                // echo 'aa';
                $orderNum_Full = $lastOrder['group_rule_num'];
                if ($lastOrder['group_rule_num_size'] == $lastOrder['group_rule_num_num']) {
                    // echo 'c';
                    $orderNum = $lastOrder['group_rule_num'] + 1;
                } else {
                    // echo 'd';
                    $orderNum = $lastOrder['group_rule_num'];
                    $orderNum_Size = $lastOrder['group_rule_num_size'];
                    $orderNum_Num = $lastOrder['group_rule_num_num'];
                }
            } else {
                // echo 'b';
                $orderNum_Full = $lastOrder['group_rule_num'];
            }
        }
        
        $groupRule = Db::name('xy_group_rule')
            ->where('group_id', $group_id)
            ->where('order_num', $orderNum)
            ->find();
        if (empty($groupRule)) {
            //如果没有 就从第一单开始
            $orderNum = 1;
            $groupRule = Db::name('xy_group_rule')
                ->where('group_id', $group_id)
                ->where('order_num', $orderNum)
                ->find();
        } else {
            //叠加 用户已经做了的单数
            /*if ($orderNum > 1) {
                $add_num = Db::name('xy_group_rule')
                    ->where('group_id', $group_id)
                    ->where('order_num', '<', $orderNum)
                    ->sum('add_orders');
                $all_order_num += intval($add_num);
            }*/
        }
        return [$orderNum, $groupRule, $all_order_num, $orderNum_Size, $orderNum_Num, $orderNum_Full];
    }

    /**
     * 获取打针比例
     * @param $uid int 用户编号
     * @param $order_num int 当前第几单
     * @return array|null|\PDOStatement|string|Model
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    private function get_inyectar($uid, $order_num)
    {
        if ($order_num > 1) $order_num = $order_num + 1;
        //优先执行 指定单
        $in = Db::name('xy_inyectar')
            ->where('uid', $uid)
            ->where('order_num', $order_num)
            ->where('date', date('Y-m-d'))
            ->where('in_time', 0)
            ->find();
        if (!$in) {
            //下一单
            $in = Db::name('xy_inyectar')
                ->where('uid', $uid)
                ->where('order_num', 0)
                ->where('date', date('Y-m-d'))
                ->where('in_time', 0)
                ->find();
        }
        return $in;
    }

    /**
     * 计算佣金
     * */
    private function get_commission($price, $groupRule)
    {
        if ($groupRule['commission_type'] == 1) {
            //固定佣金
            $commission = $groupRule['commission_value'];
        } else {
            //百分比佣金
            $commission = $price * ($groupRule['commission_value'] / 100);
        }
        return $commission;
    }

    /**
     * 随机生成订单商品
     */
    private function rand_order($min, $max, $cid)
    {
        $num = mt_rand($min, $max);//随机交易额
        $goods = Db::name('xy_goods_list')
            ->orderRaw('rand()')
            ->where('goods_price', 'between', [0, $num])
            ->where('cid', '=', $cid)
            ->find();
        if (!$goods) {
            echo json_encode(['code' => 1, 'info' => lang('qdsbkcbz') . '--' . $num]);
            die;
        }
        $price = $goods['goods_price'];
        $count = intval($num / $price);
        $num = $count * $price;
        
        if ($min == $max) {
            $price = round($max / $count, 2);
            $num = bcmul($price, $count);
        }
        return ['count' => $count, 'id' => $goods['id'], 'goods_price'=> $price, 'num' => $num, 'cid' => $goods['cid']];
    }

    /**
     * 处理订单
     *
     * @param string $oid 订单号
     * @param int $status 操作      1会员确认付款 2会员取消订单 3后台强制付款 4后台强制取消
     * @param int $uid 用户ID    传参则进行用户判断
     * @param int $uid 收货地址
     * @return array
     */
    public function do_order($oid, $status, $uid = '', $add_id = '')
    {
        $info = Db::name('xy_convey')->find($oid);
        if (!$info) return ['code' => 1, 'info' => lang('order_sn_none')];
        if ($uid && $info['uid'] != $uid) return ['code' => 1, 'info' => lang('cscw')];
        if (!in_array($info['status'], [0, 5])) return ['code' => 1, 'info' => lang('ddycl')];
        $tmp = [
            //'endtime' => time() + config('deal_feedze'),
            'status' => in_array($status, [2, 4]) ? 2 : 5,
            'is_pay' => in_array($status, [2, 4]) ? 0 : 1,
            'pay_time' => time()
        ];
        $add_id ? $tmp['add_id'] = $add_id : '';
        Db::startTrans();
        $res = Db::name('xy_convey')->where('id', $oid)->update($tmp);
        if (in_array($status, [1, 3])) {
            //TODO 判断余额是否足够
            $user = Db::name('xy_users')->where('id', $info['uid'])->find();
            if ($user['balance'] < $info['num']) {
                Db::rollback();
                return [
                    'code' => 1,
                    'info' => sprintf(lang('zhyebz'), ($info['num'] - $user['balance']) . ""),
                    'url' => url('index/ctrl/recharge')
                ];
            }
            //是否为多单模式
            $isGroup = false;
            $isMultipleOrder = false;
            if ($info['group_id'] > 0) {
                $isGroup = true;
                $o_g_ids = Db::name('xy_convey')
                    ->where('uid', $info['uid'])
                    ->where('group_is_active', 1)
                    ->where('group_id', $info['group_id'])
                    ->where('group_rule_num', $info['group_rule_num'])
                    ->column('id');
                if (count($o_g_ids) > 1) {
                    $isMultipleOrder = true;
                }
            }
            //付款
            if (!$info['is_pay']) {
                try {
                    $res1 = Db::name('xy_users')
                        ->where('id', $info['uid'])
                        ->dec('balance', $info['num'])
                        ->inc('freeze_balance', $info['num'] + $info['commission']) //冻结商品金额 + 佣金
                        ->update([
                            'deal_status' => 1,
                            'status' => 1
                        ]);
                    //商品支出
                    $res2 = Db::name('xy_balance_log')->insert([
                        'uid' => $info['uid'],
                        'sid' => $info['uid'],
                        'oid' => $oid,
                        'num' => $info['num'],
                        'type' => 2,
                        'status' => 2,
                        'addtime' => time()
                    ]);
                    //交易佣金
                    $res8 = Db::name('xy_balance_log')->insert([
                        'uid' => $info['uid'],
                        'sid' => $info['uid'],
                        'oid' => $oid,
                        'num' => $info['commission'],
                        'type' => 3,
                        'status' => 1,
                        'addtime' => time()
                    ]);
                    //商品收入
                    $res2 = Db::name('xy_balance_log')->insert([
                        'uid' => $info['uid'],
                        'sid' => $info['uid'],
                        'oid' => $oid,
                        'num' => $info['num'],
                        'type' => 2,
                        'status' => 1,
                        'addtime' => time()
                    ]);
                    if ($res && $res1 && $res2) {

                    } else {
                        Db::rollback();
                        return ['code' => 1, 'info' => lang('czsb')];
                    }
                } catch (Exception $th) {
                    Db::rollback();
                    return ['code' => 1, 'info' => lang('czsb')];
                }
            }
            //系统通知
            $isAllOk = true;
            if ($status == 3) {
                Db::name('xy_message')->insert(['uid' => $info['uid'], 'type' => 2, 'title' => lang('sys_msg'), 'content' => $oid . ',' . lang('dd_pay_system'), 'addtime' => time()]);
            }
            //提交事物
            Db::commit();
            if (!$isMultipleOrder) {
                $c_status = Db::name('xy_convey')->where('id', $oid)->value('c_status');
                //判断是否已返还佣金
                if ($c_status === 0) $this->deal_reward($info['uid'], $oid, $info['num'], $info['commission']);
            } else {
                //多单模式
                //判断全部做完
                $oList = Db::name('xy_convey')
                    ->field('id,uid,num,commission,status,c_status')
                    ->where('id', 'in', $o_g_ids)
                    ->select();
                    // *teemo*
                // foreach ($oList as $val) {
                //     if ($val['status'] != 5) {
                //         $isAllOk = false;
                // break;
                //     } 
                // }
                if ($isAllOk) {
                    foreach ($oList as $val) {
                        if ($val['c_status'] == 0) {
                            $this->deal_reward($val['uid'], $val['id'], $val['num'], $val['commission']);
                        }
                    }
                }
            }
            //杀猪组 做完一轮了更新状态
            /*if ($isGroup && $isAllOk) {
                list($orderNum, $groupRule, $all_order_num, $orderNum_Size, $orderNum_Num) = $this->get_user_group_rule($user['id'], $user['group_id']);
                if ($orderNum == 1 && $orderNum_Size == $orderNum_Num) {
                    Db::name('xy_convey')
                        ->where('uid', $user['id'])
                        ->where('group_id', $user['group_id'])
                        ->update([
                            'group_is_active' => 0
                        ]);
                }
            }*/

            // 判断是否存在小订单未做完，有小订单未做完，则返回状态码88，前端自动进行下一个小订单接单
            if ($info['group_rule_num_size'] != $info['group_rule_num_num']) {
                return ['code' => 0, 'code2' => 1, 'info' => lang('czcg')];
            }
            return ['code' => 0, 'code2' => 0, 'info' => lang('czcg')];
        } //
        elseif (in_array($status, [2, 4])) {
            $res1 = Db::name('xy_users')->where('id', $info['uid'])
                ->update([
                    'deal_status' => 1,
                ]);
            if ($status == 4) Db::name('xy_message')->insert(['uid' => $info['uid'], 'type' => 2, 'title' => lang('sys_msg'), 'content' => $oid . ',' . lang('dd_system_clean'), 'addtime' => time()]);
            //系统通知
            if ($res && $res1 !== false) {
                Db::commit();
                return ['code' => 0, 'info' => lang('czcg')];
            } else {
                Db::rollback();
                return ['code' => 1, 'info' => lang('czsb'), 'data' => $res1];
            }
        }
    }

    //计算代数佣金比例
    private function get_tj_bili($tj_bili, $lv)
    {
        $tj_bili = explode("/", $tj_bili);
        $tj_bili[0] = isset($tj_bili[0]) ? floatval($tj_bili[0]) : 0;
        $tj_bili[1] = isset($tj_bili[1]) ? floatval($tj_bili[1]) : 0;
        $tj_bili[2] = isset($tj_bili[2]) ? floatval($tj_bili[2]) : 0;
        return isset($tj_bili[$lv - 1]) ? $tj_bili[$lv - 1] : 0;
    }

    /**
     * 交易返佣
     *
     * @return void
     */
    public function deal_reward($uid, $oid, $num, $cnum)
    {
        Db::name('xy_users')->where('id', $uid)->setInc('balance', $num + $cnum);
        Db::name('xy_users')->where('id', $uid)->setDec('freeze_balance', $num + $cnum);
        //Db::name('xy_balance_log')->where('oid', $oid)->update(['status' => 1]);
        //将订单状态改为已返回佣金
        Db::name('xy_convey')
            ->where('id', $oid)
            ->update(['c_status' => 1, 'status' => 1]);
        Db::name('xy_reward_log')
            ->insert(['oid' => $oid, 'uid' => $uid, 'num' => $num, 'addtime' => time(), 'type' => 2, 'status' => 2]);
        //记录充值返佣订单
        /************* 发放交易奖励 *********/
        //之后下单人级别>0 才发放层级奖励
        $level = Db::name('xy_users')->where('id', $uid)->value('level');
        if ($level > 0) {
            $userList = model('admin/Users')->parent_user($uid, 3);
        } else $userList = [];

        //发放佣金
        if ($userList) {
            foreach ($userList as $v) {
                if ($v['level'] == 0) continue;
                $tj_bili = Db::name('xy_level')->where('level', $v['level'])->value('tj_bili');
                $price = $this->get_tj_bili($tj_bili, intval($v['lv'])) * $cnum;
                if ($v['status'] === 1) {
                    Db::name('xy_reward_log')
                        ->insert([
                            'uid' => $v['id'],
                            'sid' => $v['pid'],
                            'oid' => $oid,
                            'num' => $price,
                            'lv' => $v['lv'],
                            'type' => 2,
                            'status' => 2,
                            'addtime' => time(),
                        ]);
                    $res = Db::name('xy_users')
                        ->where('id', $v['id'])
                        ->where('status', 1)
                        ->setInc('balance', $price);
                    //下级佣金
                    $res2 = Db::name('xy_balance_log')->insert([
                        'uid' => $v['id'],
                        'sid' => $uid,
                        'oid' => $oid,
                        'num' => $price,
                        'type' => 6,
                        'status' => 1,
                        'addtime' => time()
                    ]);
                }
            }
        }
        /************* 发放交易奖励 *********/
    }
}