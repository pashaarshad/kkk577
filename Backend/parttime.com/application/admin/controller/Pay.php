<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | www.xydai.cn 新源代网
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// |

// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\service\NodeService;
use library\Controller;
use library\tools\Data;
use think\Db;

/**
 * 支付方式管理
 * Class Pay
 * @package app\admin\controller
 */
class Pay extends Base
{

    /**
     * 指定当前数据表
     * @var string
     */
    protected $table = 'xy_pay';

    /**
     * 支付方式
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '支付方式';

        $query = $this->_query($this->table)->alias('u');
        $where = [];
        if (input('tel/s', '')) $where[] = ['u.tel', 'like', '%' . input('tel/s', '') . '%'];
        if (input('username/s', '')) $where[] = ['u.username', 'like', '%' . input('username/s', '') . '%'];
        if (input('addtime/s', '')) {
            $arr = explode(' - ', input('addtime/s', ''));
            $where[] = ['u.addtime', 'between', [strtotime($arr[0]), strtotime($arr[1])]];
        }
        $query->field('*')
            ->where($where)
            ->order('u.sort desc,u.id asc')
            ->page(false);
    }


    /**
     * 编辑支付
     * @auth true
     * @menu true
     */
    public function edit()
    {
        $id = input('get.id', 0);

        if (request()->isPost()) {
            $id = input('post.id/d', 0);
            $token = input('__token__');
            $data = array(
                'name' => input('post.name/s', ''),
                'name2' => input('post.name2/s', input('post.name/s', '')),
                'ico' => input('post.ico/s', ''),
                'usercode' => input('post.usercode/s', ''),
                'username' => input('post.username/s', ''),
                'min' => input('post.min/f', 1),
                'max' => input('post.max/f', 100000),
                'ewm' => input('post.ewm/s', ''),
                'sort' => input('post.sort/d', 0),
                'status' => input('post.status/d', 1),
                'secret' => input('post.secret/s', ''),
                'mch_id' => input('post.mch_id/s', ''),
                'pay_commission' => input('post.pay_commission/f', 0),
            );
            $res = Db::table($this->table)->where('id', $id)->update($data);
            if ($res === false) {
                return $this->error('Save failed');
            }
            sysoplog('Edit Payment Method', json_encode($data, JSON_UNESCAPED_UNICODE));
            $this->success('Updated successfully');
        }
        if (!$id) $this->error('Invalid ID');
        $this->info = Db::table($this->table)->find($id);

        return $this->fetch();
    }

    /**
     * 添加支付方式
     * @auth true
     * @menu true
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = array(
                'name' => input('post.name/s', ''),
                'name2' => input('post.name2/s', input('post.name/s', '')),
                'ico' => input('post.ico/s', ''),
                'usercode' => input('post.usercode/s', ''),
                'username' => input('post.username/s', ''),
                'min' => input('post.min/f', 1),
                'max' => input('post.max/f', 100000),
                'ewm' => input('post.ewm/s', ''),
                'sort' => input('post.sort/d', 0),
                'status' => 1,
                'is_payout' => 1,
                'secret' => input('post.secret/s', ''),
                'mch_id' => input('post.mch_id/s', ''),
                'pay_commission' => input('post.pay_commission/f', 0),
                'type' => 1
            );
            $res = Db::table($this->table)->insert($data);
            if (!$res) {
                return $this->error('Add failed');
            }
            sysoplog('Add Payment Method', json_encode($data, JSON_UNESCAPED_UNICODE));
            $this->success('Added successfully');
        }
        $this->info = [
            'id' => 0,
            'name' => '',
            'name2' => '',
            'username' => '',
            'usercode' => '',
            'ico' => '',
            'sort' => 50,
            'min' => 1,
            'max' => 100000,
            'ewm' => '',
            'secret' => '',
            'mch_id' => '',
            'pay_commission' => 0,
            'status' => 1
        ];
        return $this->fetch('edit');
    }

    /**
     * 删除支付方式
     * @auth true
     */
    public function del()
    {
        $id = input('post.id/d', 0);
        if (!$id) $this->error('参数错误');
        Db::table($this->table)->where('id', $id)->delete();
        sysoplog('删除支付方式', "ID: {$id}");
        $this->success('删除成功');
    }


    /**
     * 禁用代收状态
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        //$this->applyCsrfToken();
        $this->_save($this->table, ['status' => '0']);
    }

    protected function _forbid_save_result($result, $data)
    {
        sysoplog('禁用代收状态', json_encode($_POST, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 启用代收状态
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        //$this->applyCsrfToken();
        $this->_save($this->table, ['status' => '1']);
    }

    protected function _resume_save_result($result, $data)
    {
        sysoplog('启用代收状态', json_encode($_POST, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 设置为代付
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function set_payout()
    {
        Db::name($this->table)->where('id', '>', 0)->update([
            'is_payout' => 0
        ]);
        //$this->applyCsrfToken();
        $this->_save($this->table, ['is_payout' => '1']);
    }

    protected function _set_payout_save_result($result, $data)
    {
        sysoplog('设置为代付', json_encode($_POST, JSON_UNESCAPED_UNICODE));
    }
}