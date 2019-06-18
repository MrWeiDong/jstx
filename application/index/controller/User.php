<?php 
namespace app\index\controller;
use think\Controller;
use think\Session;

class User extends Controller{
	
	protected $mid = 0; //当前账户id

	public function _initialize(){
		if(empty(Session::get('uid'))){
			$this->redirect('index/login/logion');
			die;
		}
		$this->mid = Session::get('uid');
	}
}