<?php
namespace app\controllers;
use yii;
use yii\web\controller;

class HuanController extends Controller
{
	
	public function actionRedis()
	{
		$redis=yii::$app->redis;
		$query= new \yii\db\Query();
		$info=$query
		->select(['id','username','sex','adress','nation','major','birthday','famname','openid','photo'])
		->from('wx_users')
		->all();
		//清空表数
		$redis->del('usercount');
		$redis->del('userlist');
		$redis->del('user');
		foreach($info as $k=>$v)
		{
			//创建一个哈希存储对象
			$redis->hmset('user:'.$v['id'],
				'id',$v['id'],
				'username',$v['username'],
				'sex',$v['sex'],
				'adress',$v['adress'],
				'nation',$v['nation'],
				'major',$v['major'],
				'birthday',$v['birthday'],
				'famname',$v['famname'],
				'openid',$v['openid'],
				'photo',$v['photo']
			);
			//记录数据值
			$redis->incr('usercount');
			$redis->Expire('userlist',3600);
			//创建一个列表与哈希对象关联
			$redis->rpush('userlist',$v['id']);
		}
		return $this->render('ulist');
	}
	public function actionEcho()
	{
		echo "this is echo";
	}
	public function actionUlist()
	{
		$redis=yii::$app->redis;
		$page=Yii::$app->request->get('page')?Yii::$app->request->get('page'):1;
		$pagesize=20;
		$countpage=$redis->get('usercount');
		$ulist=$redis->lrange('userlist',($page-1)*$pagesize,$pagesize*$page-1);
		if($ulist){
				foreach ($ulist as $k => $v) {
				$zhi[] = $redis->hgetall('user:'.$v);
				foreach ($zhi as $key => $value) {
					$data[$k]=[
						$value['0']=>$value['1'],
						$value['2']=>$value['3'],
						$value['4']=>$value['5'],
						$value['6']=>$value['7'],
						$value['8']=>$value['9'],
						$value['10']=>$value['11'],
						$value['12']=>$value['13'],
						$value['14']=>$value['15'],
						$value['16']=>$value['17'],
						$value['18']=>$value['19'],
					];
				}
			}
		}else{
		 return $this->actionRedis();
		}
		return $this->render('ulist',['ulist'=>$data,'page'=>$page]);
	}

	public function actionDuser($id)
	{

		$page=yii::$app->request->get('page');
		$redis=yii::$app->redis;
		$hdel=$redis->del('user:'.$id);
		$lrem=$redis->lrem('userlist',1,$id);
		if($hdel==true||$lrem==true)
		{
			$redis->decr('usercount');
			return $this->render('ulist');
		}
	}
	public function actionUuser()
	{
		$id=yii::$app->request->get('id')?yii::$app->request->get('id'):'null';
		$redis=yii::$app->redis;
		if($id=='null')
		{
			$data=[
				'id'=>'ceshi',
				'username'=>'',
				'sex'=>'',
				'adress'=>'',
				'nation'=>'',
				'major'=>'',
				'birthday'=>'',
				'famname'=>'',
				'openid'=>'',
				'photo'=>'',
			];
		}else{
			$info[]=$redis->hgetall('user:'.$id);
			foreach ($info as $key => $value) {
				$data=[
					$value['0']=>$value['1'],
					$value['2']=>$value['3'],
					$value['4']=>$value['5'],
					$value['6']=>$value['7'],
					$value['8']=>$value['9'],
					$value['10']=>$value['11'],
					$value['12']=>$value['13'],
					$value['14']=>$value['15'],
					$value['16']=>$value['17'],
					$value['18']=>$value['19'],
				];
			}
		}
		
		return $this->render('uuser',['info'=>$data]);
	}
	public function actionDouuser()
	{
		$v=yii::$app->request->post();
		// print_r($v['username']);exit;
		$redis=yii::$app->redis;
		if( is_numeric($v['id']))
		{
			$info=$redis->hmset('user:'.$v['id'],
				'id',$v['id'],
				'username',$v['username'],
				'sex',$v['sex'],
				'adress',$v['adress'],
				'nation',$v['nation'],
				'major',$v['major'],
				'birthday',$v['birthday'],
				'famname',$v['famname'],
				'openid',$v['openid'],
				'photo',$v['photo']
			);
		}else
		{
			$value=$redis->lindex('userlist',-1);
			$redis->rpush('userlist',$value+1);
			$value=$value+1;
			//创建一个哈希存储对象
			$redis->hmset('user:'.$value,
				'id',$value,
				'username',$v['username'],
				'sex',$v['sex'],
				'adress',$v['adress'],
				'nation',$v['nation'],
				'major',$v['major'],
				'birthday',$v['birthday'],
				'famname',$v['famname'],
				'openid',$v['openid'],
				'photo',$v['photo']
			);
			//记录数据值
			$redis->incr('usercount');
			//创建一个列表与哈希对象关联
		}
		
		
		return $this->render('ulist');
	}



	public function actionMemcache()
	{

		$key='get请求参数：';
		// $value='this is memcache';
		//调用memcache
		$m=yii::$app->MemCache;
		//存储k/v值八秒set
		$mem=$m->setValue($key,'get存储k/v值',6);
		$mem=$m->add($key,'add存储如果存在值将不更新');
		// $mem=$m->replace($key,'replace替换');
		//读取get
		$mem=$m->get($key);

		print_r($mem);

	}
}
