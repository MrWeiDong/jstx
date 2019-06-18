<?php  
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Validate;
use think\helper\Hash;
use think\Session;
use app\index\model\Member as MemberModel;

class Login extends Controller{
	
	public function logion(){
		if(Request::instance()->isPost()){
			$name = input('name');
			$pass = input('pass');
			$user = MemberModel::where(['name'=>$name])->find();
			if(!$user){
				return ['code'=>202,'msg'=>'用户不存在'];
			}
			if (!Hash::check((string)$pass, $user['pass'])) {
				return ['code'=>202,'msg'=>'密码错误'];;

			}
			Session::set('name',$name);
			Session::set('uid',$user['id']);
			return ['code'=>200,'msg'=>'登录成功'];
		}
		return $this->fetch();
	}
	
	public function reg(){
		if(Request::instance()->isPost()){
			$data = input('post.');
			$rule = [
				'name' => 'require',
				'pass'=>'require',
				'repass' => 'require'
			];
			$msg = [
				'name.require' => '名称必须',
				'pass.require' => '请输入密码',
				'repass.require' => '请再次输入密码',
			];
			$validate = new Validate($rule,$msg);
			$result = $validate->check($data);
			if(!$result){
				return ['code'=>201,'msg'=>$validate->getError()];
			}
			$data['pass'] = Hash::make((string)$data['pass']);
			$data['create_time'] = time();
			$data['thumb'] = '/static/home/images/touxian.jpg';
			unset($data['repass']);
			$res = MemberModel::insertGetId($data);
			if($res){
				Session::set('name',$data['name']);
				Session::set('uid',$res);
				return ['code'=>200,'msg'=>'注册成功'];
			}
		}
		return $this->fetch();
	}

	public function outlog(){
		Session::delete('name');
		Session::delete('uid');
		$this->redirect('index/login/logion');
	}
}