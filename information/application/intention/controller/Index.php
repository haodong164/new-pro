<?php	
namespace app\intention\controller;
use think\Controller;
class Index extends  Controller{
	public function index(){
		return $this->fetch();
	}
	public function do_add(){
		$data=input('post.');
		$db=db('intention');
		$username=$data['username'];
		$datas=$db->where("username='".$username."'")->find();
		if($datas){
			$data=[
				'status'=>3,
				'msg'=>'姓名重复'
			];
		}else{
			$info=$db->insert($data);
			if($info){
				$data=[
					'status'=>1,
					'msg'=>'succ'
				];
			}else{
				$data=[
					'status'=>2,
					'msg'=>'fail'
				];
			}
		}
		
		return $data;
	}
	public function kong(){
		return $this->fetch();
	}
	public function tongji(){
		$db=db('intention');
		//总人数
		$num=$db->count();
		$count=db()->query("select inten,count(inten) as a from intention group by inten");
		$this->assign('count',$count);
		$this->assign('num',$num);
		
		//php人数
		$phpnum=$db->where("iclass='PHP'")->count();
		$php=db()->query("select inten,count(inten) as a from intention where iclass='PHP' group by inten");
		$php1=db('intention')->where("iclass='PHP'")->order('inten desc')->select();
		//echo "<pre>";print_r($php1);exit;
		$this->assign('php1',$php1);
		$this->assign('php',$php);
		$this->assign('phpnum',$phpnum);
		
		
		//设计人数
		$webnum=$db->where("iclass='设计'")->count();
		$web=db()->query("select inten,count(inten) as a from intention where iclass='设计' group by inten");
		$web1=db('intention')->where("iclass='设计'")->order('inten desc')->select();
		 
		$this->assign('web1',$web1);
		$this->assign('web',$web);
		$this->assign('webnum',$webnum);
		
		//JAVA人数
		$javanum=$db->where("iclass='JAVA'")->count();
		$java=db()->query("select inten,count(inten) as a from intention where iclass='JAVA' group by inten");
		$java1=db('intention')->where("iclass='JAVA'")->order('inten desc')->select();
		 
		$this->assign('java1',$java1);
		$this->assign('java',$java);
		$this->assign('javanum',$javanum);
		return $this->fetch();
	}
	public function chaxun(){
		return $this->fetch();
	}
	public function do_chaxun(){
		$data=input('post.username');
		$info=db('intention')->where("username='".$data."'")->find();
		$this->assign('info',$info);
		return $this->fetch();
	}
}