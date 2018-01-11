<?php	
namespace app\api\controller;
use think\Controller;
class Lihaodong extends  Controller{
	public function info(){
		//echo "123";exit;
		
        $code=input('code');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx114d4f0839f65ee3&secret=6ba951fa16f0a6ae134907b580b96f4f&js_code=".$code."&grant_type=authorization_code";
		$data=file_get_contents($url);
        $jsondecode = json_decode($data); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $openid['openid'] = $array['openid'];//输出openid
        $db=db('xuyuan');
        $info=$db->insert($openid);
        return json($info);
	}

	public function getopenid()
	{
		$code=input('code');
		$id=input('id');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wx114d4f0839f65ee3&secret=6ba951fa16f0a6ae134907b580b96f4f&js_code=".$code."&grant_type=authorization_code";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$res = curl_exec($ch);
		curl_close($ch);
		$user_obj = json_decode($res,true);
		$data['openid']=$user_obj['openid'];
		if($id==1){
			$info=db('wx_teacher')->insert($data);
		}else{
			$info=db('wx_users')->insert($data);
		}
		if($info){
			return $res;
		}else{
			return "";
		}
		

	}
	

}
?>