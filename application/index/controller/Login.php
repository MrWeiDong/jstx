<?php  
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Validate;
use think\Session;
use app\index\model\Member as MemberModel;
use app\index\model\Regcode as RegcodeModel;

use qcode\SmsMultiSender;
use qcode\SmsSenderUtil;
use qcode\SmsSingleSender;


class Login extends Controller{
	
	public function logion(){
		if(Request::instance()->isPost()){
			$phone = input('name');
			$pass = input('pass');
			$user = MemberModel::where(['phone'=>$phone])->find();
			if(!$user){
				return ['code'=>202,'msg'=>'用户不存在'];
			}
			if (!password_verify($pass,$user['pass'])) {
				return ['code'=>202,'msg'=>'密码错误'];;

			}
			Session::set('name',$user['name']);
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
			
			$res = MemberModel::where(['phone'=>$data['phone']])->find();
			if($res){
				return ['code'=>203,'msg'=>'账号已存在'];
			}
			
			//判断验证码是否正确
			$code = $data['code'];
			$getcode = RegcodeModel::where(['phone'=>$data['phone'],'status'=>0])->value('code');
			if($code != $getcode){
				return ['code'=>202,'msg'=>'验证码错误！'];
			}
			
			$res = RegcodeModel::where(['phone'=>$data['phone'],'status'=>0])->setField('status',1);
			if(!$res){
				return ['code'=>202,'msg'=>'注册失败！'];
			}
			
			$data['thumb'] = str_replace('\\',"/",$data['thumb']);
			$data['pass'] = password_hash($data['pass'],PASSWORD_DEFAULT);
			$data['create_time'] = time();
			unset($data['repass']);
			unset($data['code']);
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
		
		$code = rand(111111,999999);
		$data['phone'] = $phone;
		$data['code'] = $code;
		$data['create_time'] = time();
		
		$res = MemberModel::where(['phone'=>$phone])->find();
		if($res){
			return ['code'=>202,'msg'=>'重复注册你麻痹啊!'];
		}
		$res = RegcodeModel::where(['phone'=>$phone,'status'=>0])->find();
		if($res){
			return ['code'=>202,'msg'=>'重复发你麻痹!'];
		}
		$res = RegcodeModel::insertGetId($data);
		if(!$res){
			return ['code'=>202,'msg'=>'发送失败,请稍后在试!'];
		}
		
		$appid = 1400222679;
		$appkey = 'fe270826acbbd6dfa25c711786fa2008';
		try {
			$ssender = new SmsSingleSender($appid, $appkey);
			$params = ["{$code}"];
			$result = $ssender->sendWithParam("86", $phone, 356433,$params, "", "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
			$rsp = json_decode($result);
			return ['code'=>200,'msg'=>'发送成功！'];
		} catch(\Exception $e) {
			return ['code'=>202,'msg'=>'发送失败,请稍后在试！'];
		}
	}
}