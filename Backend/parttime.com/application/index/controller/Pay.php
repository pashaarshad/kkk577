<?php

namespace app\index\controller;

use app\index\pay\Luxpag;
use app\index\pay\Qeapay;
use app\index\pay\Qeaepay;
use app\index\pay\Sepropay;
use app\index\pay\Sixgpay;
use app\index\pay\Speedypay;
use app\index\pay\Tokpay;
use app\index\pay\Yulupay;
use app\index\pay\Htpay;
use app\index\pay\Gtpay;
use app\index\pay\Slpay;
use app\index\pay\Grpay;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;

class Pay extends Base
{

    public function index()
    {

    }

    private function _op($payType)
    {
        $vip_id = input('get.vip_id/s', '');
        $vip_info = '';
        if ($vip_id) {
            $vip_info = Db::name('xy_level')->where('id', $vip_id)->find();
        }
        $num = input('get.num/s', '');
        $type = input('get.type/s', '');
        $uid = session('user_id');
        $uinfo = Db::name('xy_users')->field('pwd,salt,tel,username')->find($uid);
        $SN = getSn('SY');

        $pay_com = Db::name('xy_pay')->where('name2', $payType)->value('pay_commission');
        $pay_com = $pay_com ? floatval($pay_com) : 0;
        $dbData = [
            'id' => $SN,
            'uid' => session('user_id'),
            'tel' => $uinfo['tel'],
            'real_name' => $uinfo['username'],
            'pic' => '',
            'num' => $num,
            'addtime' => time(),
            'pay_name' => $payType,
            'pay_com' => $pay_com,
        ];
        if ($vip_info) {
            $num = $vip_info['num'];
            $dbData['num'] = $vip_info['num'];
            $dbData['is_vip'] = 1;
            $dbData['level'] = $vip_info['level'];
        }
        $dbRes = Db::name('xy_recharge')->insert($dbData);
        if (!$dbRes) {
            $this->showMessage(lang('czsbqshcs'));
        }
        return ['uid' => session('user_id'), 'sn' => $SN, 'amount' => $num];
    }

    public function luxpag()
    {
        $op_data = $this->_op('luxpag');
        $data = [];
        $data['timestamp'] = date('Y-m-d H:i:s');
        $data['out_trade_no'] = $op_data['sn'];
        $data['order_currency'] = 'BRL';
        $data['order_amount'] = floatval($op_data['amount']);
        $data['subject'] = 'user recharge';
        $data['content'] = 'user recharge UID:' . session('user_id');
        $data['trade_type'] = 'WEB';
        $data['notify_url'] = url('/index/callback/recharge_luxpag', '', true, true);
        $data['return_url'] = url('/index/my/index', '', true, true);
        $data['buyer_id'] = session('user_id');
        $data['version'] = "2.0";
        $resData = Luxpag::instance()->create_order($data);
        if (!empty($resData['code']) && $resData['code'] == '10000') {
            header('Location:' . $resData['web_url']);
        } else {
            $this->showMessage(lang('czsbqshcs'));
        }
        die;
    }

    public function sixgpay()
    {
        $op_data = $this->_op('sixgpay');
        $this->data = Sixgpay::instance()->create_order([
            'mch_order_no' => $op_data['sn'],
            'pay_type' => '4', //查阅后台商户支付通道
            'notify_url' => url('/index/callback/recharge_sixpag', '', true, true),
            'goods_name' => 'user recharge',
            'order_date' => date('Y-m-d H:i:s'),
            'trade_amount' => $op_data['amount'],
            'currency' => 'BRL', //货币代码商户后台查看
            'page_url' => url('/index/my/index', '', true, true),
            'payer_ip' => \think\facade\Request::ip(),
        ]);
        $this->payUrl = Sixgpay::instance()->get_pay_url();
        $this->fetch();
    }

    public function speedypay()
    {
        $op_data = $this->_op('speedypay');
        $resData = Speedypay::instance()->create_order([
            'orderId' => $op_data['sn'],
            'amount' => $op_data['amount'],
            'notifyUrl' => url('/index/callback/recharge_speedypay', '', true, true),
        ]);
        if (isset($resData['status']) && $resData['status'] == 0) {
            header('Location:' . $resData['data']['payUrl']);
        } else {
            $this->showMessage(lang('czsbqshcs'));
        }
    }

    public function user_ok()
    {
        $realname = $this->request->post('realname/s', '');
        $document_id = $this->request->post('document_id/s', '');
        $sn = $this->request->post('sn/s', '');
        $tNo = $this->request->post('tNo/s', '');
        $recharge = Db::name('xy_recharge')->where('id', $sn)->find();
        if (!$recharge) {
            return $this->error(lang('recharge_u_no_order'));
        }
        if ($recharge['status2'] == 1) {
            return $this->error(lang('qbycftj'));
        }
        $res = Db::name('xy_recharge')->where('id', $sn)->update([
            'status2' => 1,
            'user_realname' => $realname,
            'user_document_id' => $document_id,
            'pay_return' => $tNo,
        ]);
        if (!$res) {
            $this->error(lang('czsb'));
        }
        $this->success(lang('with_q_ok'));
    }

    public function user_ok_img()
    {
        $realname = $this->request->post('realname/s', '');
        $document_id = $this->request->post('document_id/s', '');
        $sn = $this->request->post('sn/s', '');
        $tNo = $this->request->post('tNo/s', '');
        $recharge = Db::name('xy_recharge')->where('id', $sn)->find();
        if (!$recharge) {
            return $this->error(lang('recharge_u_no_order'));
        }
        if ($recharge['status2'] == 1) {
            return $this->error(lang('qbycftj'));
        }

        if (is_image_base64($tNo)){
            $tNo = '/' . $this->upload_base64('xy', $tNo);  //调用图片上传的方法
        } else {
            return json(['code' => 1, 'info' => lang('tpgscw')]);
        }
        $res = Db::name('xy_recharge')->where('id', $sn)->update([
            'status2' => 1,
            'user_realname' => $realname,
            'user_document_id' => $document_id,
            'pay_return' => $tNo,
        ]);
        if (!$res) {
            $this->error(lang('czsb'));
        }
        $this->success(lang('with_q_ok'));
    }

    public function pix($sn = '')
    {
        if ($sn) {
            $recharge = Db::name('xy_recharge')->where('id', $sn)->find();
            $this->op_data['sn'] = $recharge['id'];
            $this->op_data['amount'] = $recharge['num'];
            if ($recharge['status2'] == 1) {
                header('Location:' . url('/index/index/index'));
                exit;
            }
        } else {
            $this->op_data = $this->_op('pix');
            header('Location:' . url('/index/pay/pix', ['sn' => $this->op_data['sn']]));
            exit;
        }
        $this->pay_info = Db::name('xy_pay')->where('name2', 'pix')->find();
        $this->fetch();
    }

    public function bit($sn = '')
    {
        if ($sn) {
            $recharge = Db::name('xy_recharge')->where('id', $sn)->find();
            if (!$recharge || $recharge['status'] > 1) {
                exit();
            }
            $this->op_data['sn'] = $recharge['id'];
            $this->op_data['amount'] = $recharge['num'];
            if ($recharge['status2'] == 1) {
                header('Location:' . url('/index/index/index'));
                exit;
            }
        } else {
            $this->op_data = $this->_op('bit');
            header('Location:' . url('/index/pay/bit', ['sn' => $this->op_data['sn']]));
            exit;
        }
        $this->desc_info = Db::name('xy_index_msg')->where('id', 15)->value('content');
        $this->pay_info = Db::name('xy_pay')->where('name2', 'bit')->find();


        $recharge = Db::name('xy_recharge')->where('id', $sn)->find();
        if ($recharge['num2'] == 0) {
            $this->op_data['amount2'] = number_format($this->op_data['amount'] * $this->pay_info['mch_id'], 2);
            //更新订单金额
            Db::name('xy_recharge')
                ->where('id', $this->op_data['sn'])
                ->update([
                    'num2' => $this->op_data['amount2'],
                ]);
        } else $this->op_data['amount2'] = $recharge['num2'];
        $this->fetch();
    }

    public function tokpay()
    {
        $op_data = $this->_op('tokpay');
        $resData = Tokpay::instance()->create_order([
            'paytype' => 'PIX',
            'orderno' => $op_data['sn'],
            'orderamount' => $op_data['amount'],
            'notifyurl' => url('/index/callback/recharge_tokpay', '', true, true),
            'returnurl' => url('/index/my/index', '', true, true),
        ]);
        $this->data = $resData;
        $this->payUrl = Tokpay::instance()->get_pay_url();
        $this->fetch();
    }

    public function sepropay()
    {
        $op_data = $this->_op('sepropay');
        $oUser = Db::name('xy_users')->where('id', $op_data['uid'])->find();
        $resData = Sepropay::instance()->create_order([
            'goods_name' => lang('log_cz'),
            'mch_order_no' => $op_data['sn'],
            'trade_amount' => $op_data['amount'],
            'payer_phone' => str_replace('+', "", config('lang_tel_pix')) . '' . $oUser['tel'],
            'order_date' => date('Y-m-d H:i:s'),
            'notify_url' => url('/index/callback/recharge_sepropay', '', true, true),
            'page_url' => url('/index/my/index', '', true, true),
        ]);
        if ($resData['respCode'] != 'SUCCESS') {
            return $this->error(lang('czsbqshcs'), $resData);
        }
        header('Location:' . $resData['payInfo']);
        exit;
    }

    public function yulupay()
    {
        $op_data = $this->_op('yulupay');
        $resData = Yulupay::instance()->createPay([
            'name' => 'd',
            'email' => 'a@a.com',
            'phone' => 1,
            "mer_order_no" => $op_data['sn'],
            "amount" => $op_data['amount'],
            'pageUrl' => url('/index/my/index', '', true, true),
        ]);
        if ($resData['code'] != '1000') {
            return $this->error(lang('czsbqshcs'));
        }
        header('Location:' . $resData['url']);
        exit;
    }

    public function qeapay()
    {
        $op_data = $this->_op('qeapay');
        $resData = Qeapay::instance()->createPay([
            'goods_name' => lang('log_cz'),
            'mch_order_no' => $op_data['sn'],
            'trade_amount' => $op_data['amount'],
            'order_date' => date('Y-m-d H:i:s'),
            'notify_url' => url('/index/callback/recharge_qeapay', ['type' => input('type/d', 0)], true, true),
            'page_url' => url('/index/my/index', '', true, true),
        ]);
        if ($resData['respCode'] != 'SUCCESS') {
            return $this->error(lang('czsbqshcs'), $resData);
        }
        header('Location:' . $resData['payInfo']);
        exit;
    }

    public function qeaepay()
    {
        $op_data = $this->_op('qeaepay');
        $resData = Qeaepay::instance()->createPay([
            'goods_name' => lang('log_cz'),
            'mch_order_no' => $op_data['sn'],
            'trade_amount' => $op_data['amount'],
            'order_date' => date('Y-m-d H:i:s'),
            'notify_url' => url('/index/callback/recharge_qeaepay', ['type' => input('type/d', 0)], true, true),
            'page_url' => url('/index/my/index', '', true, true),
        ]);
        if ($resData['respCode'] != 'SUCCESS') {
            return $this->error(lang('czsbqshcs'), $resData);
        }
        header('Location:' . $resData['payInfo']);
        exit;
    }

    public function htpay()
    {
        $op_data = $this->_op('htpay');
        $resData = Htpay::instance()->createPay($op_data);
        if ($resData['respCode'] != 'SUCCESS') {
            return $this->error(lang('czsbqshcs'), $resData);
        }
        header('Location:' . $resData['payInfo']);
        exit;
    }

    public function gtpay()
    {
        $op_data = $this->_op('gtpay');
        $resData = Gtpay::instance()->createPay($op_data);
        if ($resData['respCode'] != 'SUCCESS') {
            return $this->error(lang('czsbqshcs'), $resData);
        }
        header('Location:' . $resData['payInfo']);
        exit;
    }

    public function slpay()
    {
        $op_data = $this->_op('slpay');
        try {
            $resData = Slpay::instance()->createPay($op_data);
            if (!empty($resData['respCode']) && $resData['respCode'] == 'SUCCESS' && !empty($resData['payInfo'])) {
                if (request()->isAjax() || request()->isJson()) {
                    return json(['code' => 0, 'info' => 'Success', 'data' => ['payInfo' => $resData['payInfo'], 'sn' => $op_data['sn']]]);
                }
                header('Location:' . $resData['payInfo']);
                exit;
            }
        } catch (\Exception $e) {}

        $detailUrl = request()->domain() . '/#/recharge-detail?sn=' . $op_data['sn'] . '&amount=' . $op_data['amount'];
        if (request()->isAjax() || request()->isJson()) {
            return json(['code' => 0, 'info' => 'Success', 'data' => ['payInfo' => $detailUrl, 'sn' => $op_data['sn']]]);
        }
        header('Location:' . $detailUrl);
        exit;
    }

    public function grpay()
    {
        $op_data = $this->_op('grpay');
        try {
            $resData = Grpay::instance()->createPay($op_data);
            if (!empty($resData['respCode']) && $resData['respCode'] == 'SUCCESS' && !empty($resData['payInfo'])) {
                if (request()->isAjax() || request()->isJson()) {
                    return json(['code' => 0, 'info' => 'Success', 'data' => ['payInfo' => $resData['payInfo'], 'sn' => $op_data['sn']]]);
                }
                header('Location:' . $resData['payInfo']);
                exit;
            }
        } catch (\Exception $e) {}

        $detailUrl = request()->domain() . '/#/recharge-detail?sn=' . $op_data['sn'] . '&amount=' . $op_data['amount'];
        if (request()->isAjax() || request()->isJson()) {
            return json(['code' => 0, 'info' => 'Success', 'data' => ['payInfo' => $detailUrl, 'sn' => $op_data['sn']]]);
        }
        header('Location:' . $detailUrl);
        exit;
    }

    /**
     * 空操作 用于显示错误页面
     */
    public function _empty($name)
    {
        $op_data = $this->_op($name);
        try {
            $className = "\\app\\index\\pay\\" . $name;
            $pay = new $className();
            $resData = $pay->createPay($op_data);
            if (!empty($resData['respCode']) && $resData['respCode'] == 'SUCCESS' && !empty($resData['payInfo'])) {
                if (request()->isAjax() || request()->isJson()) {
                    return json(['code' => 0, 'info' => 'Success', 'data' => ['payInfo' => $resData['payInfo'], 'sn' => $op_data['sn']]]);
                }
                header('Location:' . $resData['payInfo']);
                exit;
            }
        } catch (\Exception $e) {}

        $detailUrl = request()->domain() . '/#/recharge-detail?sn=' . $op_data['sn'] . '&amount=' . $op_data['amount'];
        if (request()->isAjax() || request()->isJson()) {
            return json(['code' => 0, 'info' => 'Success', 'data' => ['payInfo' => $detailUrl, 'sn' => $op_data['sn']]]);
        }
        header('Location:' . $detailUrl);
        exit;
    }

    private function showCode($code, $payData)
    {
        $this->code = $code;
        $this->payData = $payData;
        $this->fetch();
    }

    /**
     * Get payment methods list (QR Code, Address/UPI ID, Icon, Name)
     */
    public function get_pay_list()
    {
        // Auto-migration for VPS: If reference channels are missing in xy_pay, auto-seed them immediately
        $hasTrc20 = Db::name('xy_pay')->where('name', 'TRC20-USDT')->count();
        if (!$hasTrc20) {
            // Disable legacy / test channels like Qeapay
            Db::name('xy_pay')->where('name', 'like', '%Qeapay%')->update(['status' => 0]);
            $channels = [
                ['name' => 'TRC20-USDT', 'name2' => 'TRC20', 'ico' => '/static/image/trc20-usdt.jpg', 'usercode' => 'TXYZo89h129kJs99aLqP10x992KmNsQW1a', 'min' => 1, 'max' => 100000, 'sort' => 100, 'status' => 1, 'is_payout' => 1],
                ['name' => 'TRX', 'name2' => 'TRX', 'ico' => '/static/image/trx.webp', 'usercode' => 'TXYZo89h129kJs99aLqP10x992KmNsQW1a', 'min' => 1, 'max' => 100000, 'sort' => 95, 'status' => 1, 'is_payout' => 1],
                ['name' => 'BEP20-USDT', 'name2' => 'BEP20', 'ico' => '/static/image/bep20-usdt.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 90, 'status' => 1, 'is_payout' => 1],
                ['name' => 'BNB', 'name2' => 'BNB', 'ico' => '/static/image/bnb.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 85, 'status' => 1, 'is_payout' => 1],
                ['name' => 'BEP20-USDC', 'name2' => 'BEP20', 'ico' => '/static/image/bep20-usdc.png', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 80, 'status' => 1, 'is_payout' => 1],
                ['name' => 'POLYGON-USDT', 'name2' => 'POLYGON', 'ico' => '/static/image/polygon-usdt.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 75, 'status' => 1, 'is_payout' => 1],
                ['name' => 'ETH-USDT', 'name2' => 'ERC20', 'ico' => '/static/image/eth-usdt.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 70, 'status' => 1, 'is_payout' => 1],
                ['name' => 'POLYGON-USDC', 'name2' => 'POLYGON', 'ico' => '/static/image/polygon-usdc.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 65, 'status' => 1, 'is_payout' => 1],
                ['name' => 'ETH-USDC', 'name2' => 'ERC20', 'ico' => '/static/image/eth-usdc.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 60, 'status' => 1, 'is_payout' => 1],
                ['name' => 'ETH', 'name2' => 'ETH', 'ico' => '/static/image/eth.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 55, 'status' => 1, 'is_payout' => 1],
                ['name' => 'POLYGON', 'name2' => 'POLYGON', 'ico' => '/static/image/polygon.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 50, 'status' => 1, 'is_payout' => 1],
                ['name' => 'ETH-PYUSD', 'name2' => 'ERC20', 'ico' => '/static/image/eth-pyusd.webp', 'usercode' => '0x4f85459F610376Ee6Ad77216785582c55817d5bc', 'min' => 1, 'max' => 100000, 'sort' => 45, 'status' => 1, 'is_payout' => 1],
                ['name' => 'PHP', 'name2' => 'PHP', 'ico' => '/static/image/flb.webp', 'usercode' => '09123456789', 'min' => 1, 'max' => 100000, 'sort' => 40, 'status' => 1, 'is_payout' => 1]
            ];
            foreach ($channels as $c) {
                Db::name('xy_pay')->insert($c);
            }
        }

        $list = Db::name('xy_pay')->where('status', 1)->where('name', 'not like', '%Qeapay%')->order('sort desc, id asc')->select();
        foreach ($list as &$item) {
            if (!empty($item['ewm']) && strpos($item['ewm'], 'http') !== 0) {
                $item['ewm'] = request()->domain() . $item['ewm'];
            }
            if (!empty($item['ico']) && strpos($item['ico'], 'http') !== 0) {
                $item['ico'] = request()->domain() . $item['ico'];
            }
        }
        return json(['code' => 0, 'data' => $list]);
    }

    /**
     * Get VIP levels list
     */
    public function get_level_list()
    {
        $list = Db::name('xy_level')->order('level asc, id asc')->select();
        foreach ($list as &$item) {
            $item['daily_profit'] = number_format($item['num'] * $item['bili'], 2);
        }
        return json(['code' => 0, 'data' => $list]);
    }

    /**
     * Submit recharge order
     */
    public function submit_recharge()
    {
        $uid = $this->_uid ?: session('user_id') ?: cookie('user_id') ?: input('post.uid/d', 0);
        if (!$uid) {
            $hdrUid = request()->header('user-id') ?: request()->header('uid');
            if ($hdrUid) $uid = intval($hdrUid);
        }
        if (!$uid) {
            $token = request()->header('token') ?: input('post.token/s');
            if ($token) {
                $uid = Db::name('xy_users')->where('token', $token)->value('id');
            }
        }
        if (!$uid) return json(['code' => 1, 'msg' => 'Please log in first']);
        $pay_id = input('post.pay_id/d', 0);
        $amount = input('post.amount/f', 0);
        $voucher = input('post.voucher/s', '');
        
        if ($amount <= 0) return json(['code' => 1, 'msg' => 'Invalid amount']);
        
        $payInfo = Db::name('xy_pay')->where('id', $pay_id)->find();
        $uinfo = Db::name('xy_users')->where('id', $uid)->find();
        
        $SN = getSn('SY');
        $data = [
            'id' => $SN,
            'uid' => $uid,
            'tel' => $uinfo['tel'] ?? '',
            'real_name' => $uinfo['username'] ?? '',
            'pic' => $voucher ?: '/upload/sample_voucher.png',
            'num' => $amount,
            'addtime' => time(),
            'pay_name' => !empty($payInfo['name']) ? $payInfo['name'] : 'TRC20-USDT',
            'status' => 1
        ];
        Db::name('xy_recharge')->insert($data);
        return json(['code' => 0, 'msg' => 'Recharge order submitted successfully!', 'data' => ['sn' => $SN]]);
    }
}