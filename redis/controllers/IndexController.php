<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use app\models\Users;
use app\models\ProForm;

class IndexController extends Controller
{
	// public $layout=false;
	//加入缓存
    public function actionIndex(){
		// echo "132";
		// exit;
		header("Content-type: text/html; charset=utf-8");
		$userlist=Users::find()->all();
		$redis=Yii::$app->redis;
		foreach ($userlist as $k=>$v){
			$redis->hmset('user:'.$k,'id',$v['id'],'username',$v['username'],'sex',$v['sex'],'idcate',$v['idcate'],'dorm_id',$v['dorm_id']);
			// $redis->hmset('user:'.$k,'id',$v['id'],'username',$v['username'],'sex',$v['sex'],'idcate',$v['idcate'],'dorm_id',$v['dorm_id'],'iclass',$v['iclass'],'adress',$v['adress'],'nation',$v['nation'],'major',$v['major'],'birthday',$v['birthday'],'photo',$v['photo'],'famname',$v['famname'],'hujiadress',$v['hujiadress'],'stutel',$v['stutel'],'weixin',$v['weixin'],'qq',$v['qq'],'email',$v['email'],'famtel',$v['famtel'],'pro',$v['pro'],'city',$v['city'],'area',$v['area'],'rili',$v['rili'],'bed',$v['bed'],'openid',$v['openid'],'status',$v['status']);
			$redis->incr('userid');
			$redis->rpush('uid',$k);
		}
	}
	//列表
	public function actionList(){
		header("Content-type: text/html; charset=utf-8");
		$redis=Yii::$app->redis;
		$pagesize=20;
		$count=$redis->get('userid');
		$page=Yii::$app->request->get('page')?Yii::$app->request->get('page'):1;
		$ids=$redis->lrange('uid',$pagesize*($page-1),$pagesize*$page-1);
		end($ids);
		$sum=key($ids);
		foreach($ids as $tt)
        {
           $ulist[]=$redis->hgetall('user:'.$tt);
        }
		
		for($i=0;$i<=$sum;$i++){
			$ulist[$i]['uid']=$ids[$i];
		}
		// echo "<pre>";
		// print_r($ulist);
		// exit;
        return $this->render('index',['ulist'=>$ulist,'page'=>$page]);
	}
	//删除
	public function actionDellist(){
		$uid=Yii::$app->request->get('uid');
        $redis=Yii::$app->redis;
        $redis->del('user:'.$uid);
        $redis->lrem('uid',1,$uid);
        $redis->decr('userid');
	}
	//编辑(yii)
	public function actionUplist(){
		$model=new ProForm;
        $redis = Yii::$app ->redis;//实例化
        $id = Yii::$app ->request->get('uid');//获取传输方式用户的id
        $info = $redis -> hgetall('user:'.$id);
        $info['uid'] = $id;  //hash  user:id
        $model->sex = $info[5]=='男'?'男':'女';
        return $this ->render('uplist',['info' => $info,'model' => $model]);
	}
	//处理编辑
	public function actionDo_uplist(){
		header("Content-type: text/html; charset=utf-8");
		$data=Yii::$app->request->post();
		// echo "<pre>";
		// print_r($data);
		// exit;
		$redis=Yii::$app->redis;
		$info=$redis -> hmset('user:'.$data['ProForm']['uid'],'id',$data['ProForm']['id'],'username',$data['ProForm']['username'],'sex',$data['ProForm']['sex'],'idcate',$data['ProForm']['idcate'],'dorm_id',$data['ProForm']['dorm_id']);
		if($info){
			return $this->actionList();
		}else{
			echo "fail";
		}
		// echo "<pre>";
		// // echo $data;
		// print_r($data['ProForm']);
	}
	//添加
	public function actionAdd(){
		$model=new ProForm;
		return $this->render('add',['model'=>$model]);
	}
	//处理添加
	public function actionDo_add(){
		header("Content-type: text/html; charset=utf-8");
		echo "<pre>";
		// $data=Yii::$app->request->post();
		// echo "<pre>";
		// print_r($data);
		// exit;
		
		$model = new Users;
		$model->load(Yii::$app->request->post(),'');
		// echo "<pre>";
		// print_r($data);
		// exit;
		$model->save();
		
		
		
		
		exit;
		
		// $data=Yii::$app->request->post();
		
		// 获取 Users 表的所有行并以 username 排序
		// $countries = Users::find()->orderBy('username')->all();
		// 获取主键为 “US” 的行
		$country = Users::findOne('475');
		// 输出 “United States”
		$country->username;
		$country->username = '33445';
		$country->save();
		exit;
		
		print_r($countries);
		exit;
		// $info=Yii::$app->db->createCommand()->insert('wx_users', $data['ProForm'])->execute();
		Users::save()->$data['ProForm'];
		// $data->save();
		// $id=Yii::$app()->db->getLastInsertID();
		if($info){
			echo 'succ';
			
		}else{
			echo "fail";
		}
		exit;
		echo "<pre>";
		print_r($data);
	}
	
}