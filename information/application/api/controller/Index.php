<?php	
namespace app\api\controller;
use think\Controller;
class Index extends  Controller{
	public function index(){
		$db=db('wx_choserule');
		$data=$db->find();
		$this->assign('info',$data);
		return $this->fetch();
	}
	public function do_up(){
		$teacher=input('post.teacher');
        $student=input('post.stu');
        $data['teacher']=isset($teacher)?$teacher:0;
        $data['student']=isset($student)?$student:0;
		if($data['teacher']==0 && $data['student']==0){
			$this->error('设置失败,重新设置',url('index'),'',1);
		}
        $info=db('wx_choserule')->where('id=1')->update($data);
        if($info!==false)
        {
            $this->success('设置成功',url('index'),'',1);
        }

	}
	 public function choserule(){
        $info=db('wx_choserule')->find();
        return json($info);
    }
	public function select(){
		$code=input('code');
		$id=input('id');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx114d4f0839f65ee3&secret=6ba951fa16f0a6ae134907b580b96f4f&js_code=".$code."&grant_type=authorization_code";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$res = curl_exec($ch);
		// $openid=$res['openid'];
		curl_close($ch);
		$user_obj = json_decode($res,true);
		$data['openid']=$user_obj['openid'];
		$openid=$data['openid'];
		$db=db('wx_teacher');
		$db1=db('wx_users');
		$info=$db->where("openid="."'".$openid."'")->find();
		if(!empty($info)){
			$data=[
				'msg'=>1,
			];
		}else{
			$infos=$db1->where("openid="."'".$openid."'")->find();
			if(!empty($infos)){
				$data=[
					'msg'=>2,
				];
			}else{
				$data=[
					'msg'=>0,
				];
			}
		}
		return json($data);
	}

}