<?php  
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Validate;
use think\helper\Hash;
use think\Session;
use app\index\model\Member as MemberModel;
use Qcloud\Sms\SmsSingleSender;
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

	//上传图片
	public function upload(){
		$file = request()->file('head');
		$info = $file->validate(['size'=>156780,'ext'=>'jpg,png,jpeg,gif'])->move(ROOT_PATH . 'public' . DS . 'head');
		if($info){
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $path = '/head/'.$info->getSaveName();
			return ['code'=>200,'path'=>$path];
        }else{
            // 上传失败获取错误信息
            return ['code'=>201,'msg'=>$file->getError()];
        }
		
	}

	//获取验证码
	public function getcode(){
		$phone = input('phone');
		$appid = 1400222679;
		$appkey = 'fe270826acbbd6dfa25c711786fa2008';
		
		//$msender = new SmsMultiSender($appid, $appkey);
	}
}