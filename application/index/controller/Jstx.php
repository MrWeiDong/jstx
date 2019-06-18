<?php 
namespace app\index\controller;
use think\Controller;
use app\index\controller\User;
use app\index\model\Member as MemberModel;

class Jstx extends User {
	public function _initialize(){
		parent::_initialize();
		$userinfo = MemberModel::where(['id'=>$this->mid])->find();
		$this->assign('userinfo',$userinfo);
		$userlist = MemberModel::where(['id'=>['NEQ',$this->mid]])->select();
		$this->assign('userlist',$userlist);
	}

	public function index(){
		$this->assign('uid',$this->mid);
		$tid = input('tid');
		$this->assign('tid',$tid);
		$touser = MemberModel::where(['id'=>$tid])->find();
		$this->assign('touser',$touser);
		return $this->fetch();
	}
	
}

