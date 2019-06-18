<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Message as MessageModel;

class Index extends Controller
{
    public function index()
    {	
		$uid = input('uid');
		$tid = input('tid');
		$this->assign('uid',$uid);
		$this->assign('tid',$tid);
        return view();
    }
	
	public function ajax_message(){
		if(Request::instance()->isPost()){
			$data = input('post.');
			unset($data['type']);
			$data['create_time'] = time();
			$res = MessageModel::insertGetId($data);
		}
		
	}
}
