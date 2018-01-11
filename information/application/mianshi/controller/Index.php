<?php	
namespace app\mianshi\controller;
use think\Controller;
class Index extends  Controller{
	public function index(){
		return $this->fetch();
	}
	public function do_add(){
		$data=input('post.');
		// echo "<pre>";
		// print_r($data);
		// exit;
		if($data['username']==""){
			echo "<script>alert('姓名不可以为空');location.href='index/index';</script>";
		}
		$db=db('mianshi');
		$info=$db->insert($data);
		if($info){
			echo "<script>alert('你的资料上传成功"."<br/>"."');location.href='index/index';</script>";
		}else{

		}
	}
	public function ceshi(){
		// 用PHP打印出前一天的时间格式是2006-5-10 22:21:21
		$b = date("Y-m-d H:i:s", time());
		$a = date("Y-m-d H:i:s", strtotime("-1 day"));
		$c=array('a','b','c');
		echo $b."<br/>".$a."<br/>";
		print($c);
	}
	
}