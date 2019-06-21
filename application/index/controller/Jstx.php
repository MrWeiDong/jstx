<?php 
namespace app\index\controller;
use think\Controller;
use app\index\controller\User;
use app\index\model\Member as MemberModel;
use app\index\model\Message as MessageModel;
use think\Db;

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
		$uid = $this->mid;
		
		//获取聊天历史记录
		$messageList =  Db::name('message')->where('(uid=:uid and tid=:tid) || (uid=:tid1 and  tid=:uid1)',['uid'=>$uid,'tid'=>$tid,'tid1'=>$tid,'uid1'=>$uid])->order(['create_time'=>'desc'])->paginate(10);

		$messageList = json_encode($messageList);
		$messageList = json_decode($messageList,true);
		$messageList = $messageList['data'];

		$id = array_column($messageList,'id');
		array_multisort($messageList,SORT_ASC,$id);
		$this->assign('messageList',$messageList);
		return $this->fetch();
	}
	
	public function pull(){
		$data = input('post.');
		$data['type'] = 1;
		$data['create_time'] = time();
		unset($data['date_time']);
		$res = MessageModel::insert($data);
	}

	//图片上传
	public function uploadimg(){
		$file = $_FILES['file'];
		$uid = input('uid');
		$tid = input('tid');
		$isdu = input('online');
		$suffix = strtolower(strrchr($file['name'],'.'));
		$type =['.jpg','.jpeg','.gif','.png'];
		if(!in_array($suffix,$type)){
			return ['code'=>202,'msg'=>'文件格式不符'];
		}

		if($file['size']/1024 > 5210){
			return ['code'=>202,'msg'=>'文件格式太大'];
		}

		$filename = uniqid("chat_img_",false);
		$uploadpath = ROOT_PATH.'public\\uploads\\';
		$file_up = $uploadpath.$filename.$suffix;
		$re = move_uploaded_file($file['tmp_name'],$file_up);

		if($re){
			$data['uid'] = $uid;
			$data['tid'] = $tid;
			$data['message'] = '/uploads/'.$filename.$suffix;
			$data['type'] = 2;
			$data['create_time'] = time();
			$data['isdu'] = $isdu;
			$res = MessageModel::insertGetId($data);
			if($res){
				return ['code'=>200,'ima_name'=>$data['message']];
			}else{
				return ['code'=>203,'msg'=>'发送失败'];
			}
		}
		
	}
}

