<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use app\models\Users;
use app\models\ProForm;

class RedisController extends Controller
{
	// public $layout=false;
	//加入缓存
    public function actionIndex(){
		header("Content-type: text/html; charset=utf-8");
		$userlist=Users::find()->all();//读取users表中的所有数据
		// echo "<pre>";
		// print_r($userlist);	
		// exit;
		$redis=Yii::$app->redis;//引用所有的函数
		foreach($userlist as $key=>$v)
		{
			$redis->hmset(
			'user:'.$v['id'],
			'id',$v['id'],
			'username',$v['username'],
			'sex',$v['sex'],
			'idcate',$v['idcate'],
			'dorm_id',$v['dorm_id'],
			'iclass',$v['iclass'],
			// 'adress',$v['adress'],
			'nation',$v['nation'],
			'major',$v['major'],
			'birthday',$v['birthday']
			// 'photo',$v['photo'],
			// 'famname',$v['famname'],
			// 'hujiadress',$v['hujiadress'],
			// 'stutel',$v['stutel'],
			// 'weixin',$v['weixin'],
			// 'qq',$v['qq'],
			// 'email',$v['email'],
			// 'famtel',$v['famtel'],
			// 'pro',$v['pro'],
			// 'city',$v['city'],
			// 'area',$v['area'],
			// 'rili',$v['rili'],
			// 'bed',$v['bed'],
			// 'openid',$v['openid'],
			// 'status',$v['status']
			);
			
			$redis->rpush('uid',$v['id']);//rpush在列表中添加一个或多个值
			$redis->incr('userid');
		}
		return $this->actionList();
		
		
	}
	//列表
	public function actionList(){
		header("Content-type: text/html; charset=utf-8");
		$redis=Yii::$app->redis;
		$pagesize=40;
		$count=$redis->get('userid');
		$pages=ceil($count/$pagesize);
		$page=Yii::$app->request->get('page')?Yii::$app->request->get('page'):1;
		if($page>$pages || $page<1){
			echo "访问的页面不存在";
			exit;
		}
		$ids=$redis->lrange('uid',$pagesize*($page-1),$pagesize*$page-1);
		end($ids);
		$sum=key($ids);
		foreach($ids as $tt)
        {
           $ulist[]=$redis->hgetall('user:'.$tt);
        }
		
		// for($i=0;$i<=$sum;$i++){
			// $ulist[$i]['uid']=$ids[$i];
		// }
		// echo "<pre>";
		// print_r($ulist);
		// exit;
        return $this->render('index',['ulist'=>$ulist,'page'=>$page,'pages'=>$pages]);
	}
	//删除
	public function actionDellist(){
		$id=Yii::$app->request->get('id');
        $redis=Yii::$app->redis;
        $redis->del('user:'.$id);
        $redis->lrem('uid',1,$id);
        $redis->decr('userid');
		return $this->actionList();
	}
	//编辑(yii)
	public function actionUplist(){
		$model=new ProForm;
        $redis = Yii::$app ->redis;//实例化
        $id = Yii::$app ->request->get('id');//获取传输方式用户的id
        $info = $redis -> hgetall('user:'.$id);
        // $info['uid'] = $id;  //hash  user:id
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
		$info=$redis -> hmset(
			'user:'.$data['ProForm']['id'],
			'id',$data['ProForm']['id'],
			'username',$data['ProForm']['username'],
			'sex',$data['ProForm']['sex'],
			'idcate',$data['ProForm']['idcate'],
			'dorm_id',$data['ProForm']['dorm_id'],
			'iclass',$data['ProForm']['iclass'],
			'nation',$data['ProForm']['nation'],
			'major',$data['ProForm']['major'],
			'birthday',$data['ProForm']['birthday']
		);
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
		$data=Yii::$app->request->post();
		// echo "<pre>";
		// print_r($data);
		// exit;
		$redis=Yii::$app->redis;
		$id=$redis->lindex('uid',-1)+1;
		$redis->rpush('uid',$id);
		$redis->hmset(
			'user:'.($id),
			'id',$id,
			'username',$data['ProForm']['username'],
			'sex',$data['ProForm']['sex'],
			'idcate',$data['ProForm']['idcate'],
			'dorm_id',$data['ProForm']['dorm_id'],
			'iclass',$data['ProForm']['iclass'],
			'nation',$data['ProForm']['nation'],
			'major',$data['ProForm']['major'],
			'birthday',$data['ProForm']['birthday']
		);
		$redis->incr('userid');
		return $this->actionList();
		// echo $data;
	}
	
}