<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Support extends Base
{
    /**
     * 首页
     */
    public function index()
    {
        $this->info = db('xy_cs')->where('status', 1)->select();
        if (config('open_agent_chat') == 1) {
            $service = model('admin/Users')->get_user_service_id($this->_uid);
            if ($service) {
                foreach ($this->info as $k => $v) {
                    $this->info[$k]['url'] = $service['chats'];
                }
            }
        }
        $this->assign('list', $this->info);
        $this->msg = db('xy_index_msg')->where('status', 1)->select();
        return $this->fetch();
    }


    public function index2()
    {
        $this->url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '';
        return $this->fetch();
    }

    /**
     * 首页
     */
    public function detail()
    {
        $id = input('get.id/d', 1);
        $this->info = db('xy_index_msg')->where('id', $id)->find();


        return $this->fetch();
    }


    /**
     * 换一个客服
     */
    public function other_cs()
    {
        $data = db('xy_cs')->where('status', 1)->where('id', '<>', $id)->find();
        if ($data) return json(['code' => 0, 'info' => lang('czcg'), 'data' => $data]);
        return json(['code' => 1, 'info' => lang('zwsj')]);
    }
}