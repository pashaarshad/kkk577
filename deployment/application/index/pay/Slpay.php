<?php

namespace app\index\pay;

use think\Db;

class Slpay extends PayBase
{
    const PAY_URL = 'https://www.myslsshh.com/Pay_Index.html';
    const PAYOUT_URL = 'https://www.myslsshh.com/Pay_Index.html';

    public static function instance()
    {
        return new self();
    }

    public function get_mch_id()
    {
        return config('pay.slpay.mch_id');
    }

    public function get_secret()
    {
        return config('pay.slpay.secret');

    }

    //发起代收订单
    public function createPay(array $op_data): array
    {
        // return ['respCode' => 'SUCCESS', 'payInfo' => 'http://www.baidu.com'];
        $oUser = Db::name('xy_users')->where('id', $op_data['uid'])->find();
        $userName = preg_replace("/\\d+/", '', $oUser['username']);
        if (!$userName) $userName = $this->randUsername();
        // return 'ok'
        $data = [
            'pay_memberid' => $this->get_mch_id(),
            'pay_orderid' => $op_data['sn'],
            'pay_applydate' => date('Y-m-d H:i:s') ,
            'pay_bankcode' => config('pay.slpay.pay_type'),
            'pay_notifyurl' => url('/index/callback/pay', [
                'gateway' => (new \ReflectionClass(__CLASS__))->getShortName(),
                'type' => input('get.type/d', 0)
            ], true, true),
            'pay_callbackurl' => url('/index/my/index', '', true, true),
            'pay_amount' => floatval($op_data['amount']),
        ];
        $data['pay_md5sign'] = $this->_make_sign($data);
        $data['pay_productname'] = 'foodpay';

        $res = $this->_post(self::PAY_URL, $data);
        $resData = json_decode($res, true);
        if (isset($resData['code']) && $resData['code'] == '200') {
            return ['respCode' => 'SUCCESS', 'payInfo' => $resData['payUrl']];
        }
        return ['respCode' => 'ERROR', 'payInfo' => '', 'res' => $res, 'resData' => $resData, 'postData' => $data];
    }

    /**
     * 验证代收回调
     * @param string $type
     * @return string 'OK'
     */
    public function parsePayCallback($type = ''): array
    {
        $put = file_get_contents('php://input');
        $data = json_decode($put, true);
        if (!isset($data['sign'])) {
            exit();
        }
        if ($data['returncode'] != '00') {
            exit();
        }
        $sign_old = $data['sign'];
        unset($data['sign']);
        if (isset($data['attach'])) unset($data['attach']);
        if (isset($data['actual_money'])) unset($data['actual_money']);
        $sign = $this->_make_sign2($data);
        if ($sign_old != $sign) {
            return ['status' => 'FAIL', 'msg' => '签名错误', 'data' => $data];
        }
        return 'OK';
    }

    public function payCallbackSuccess()
    {
        echo 'OK';
    }

    public function payCallbackFail()
    {
        echo 'fail';
    }

    public $_payout_msg = '';

    public function create_payout(array $oinfo, array $blank_info): bool
    {
        $data = [
            'store_id' => $this->get_mch_id(),
            'out_trade_no' => $oinfo['id'],
            'money' => $oinfo['num'],
            'pay_type' => config('pay.slpay.payout_type'),
            'full_name' => $blank_info['username'],
            'collect_account' => $blank_info['cardnum'],
            'collect_name' => $blank_info['bank_code'],
            'card_no' => $blank_info['document_id'],
            'store_remark' => 'account_name',
            'time' => date('Y-m-d H:i:s') ,
            'client_ip' => '127.0.0.1' ,
            'notify_url' => url('/index/callback/payout', [
                'gateway' => (new \ReflectionClass(__CLASS__))->getShortName(),
            ], true, true),
        ];
        $data['sign'] = $this->_make_payout_sign($data);
        $res = $this->_post(self::PAYOUT_URL, $data, 'json');
        $res = json_decode($res, true);
        if (isset($res['code']) && $res['code'] == '0') {
            return true;
        }
        $this->_payout_msg = !empty($res['msg']) ? $res['msg'] : '';
        return false;
    }

    //["status"=>"SUCCESS","oid"=>"订单号","amount"=>"支付金额"]
    public function parsePayoutCallback($type = ''): array
    {
        $put = file_get_contents('php://input');
        $data = json_decode($put, true);
        if (!isset($data['sign'])) {
            exit();
        }
        if ($data['code'] != '-1') {
            exit();
        }
        $sign_old = $data['sign'];
        unset($data['sign']);
        $sign = $this->_make_payout_sign2($data);
        if ($sign_old != $sign) {
            return ['status' => 'FAIL', 'msg' => '签名错误', 'data' => $data];
        }
        return 'OK';
    }

    public function parsePayoutCallbackFail()
    {
        echo "fail";
    }

    public function parsePayoutCallbackSuccess()
    {
        echo "SUCCESS";
    }


    /**
     * 创建签名
     * @param $data array  数据包
     * @return string
     */
    private function _make_sign(array $data): string
    {
        ksort($data);
        $str = '';
        foreach ($data as $key => $value) {
            if ($value) $str .= $key . '=' . $value . '&';
        }
        return strtoupper(md5($str . 'key=' . $this->get_secret()));
    }

    /**
     * 创建签名
     * @param $data array  数据包
     * @return string
     */
    private function _make_sign2(array $data): string
    {
        ksort($data);
        $str = '';
        foreach ($data as $key => $value) {
            if ($value) $str .= $key . '=' . $value . '&';
        }
        return strtolower(md5($str . 'key=' . $this->get_secret()));
    }

    private function _make_payout_sign(array $data): string
    {
        ksort($data);
        $str = '';
        foreach ($data as $key => $value) {
            $value = trim($value);
            if ($value) $str .= $key . '=' . $value . '&';
        }
        return strtoupper(md5($str . 'key=' . $this->get_secret()));
    }

    private function _make_payout_sign2(array $data): string
    {
        ksort($data);
        $str = '';
        foreach ($data as $key => $value) {
            $value = trim($value);
            if ($value) $str .= $key . '=' . $value . '&';
        }
        return strtolower(md5($str . 'key=' . $this->get_secret()));
    }
}