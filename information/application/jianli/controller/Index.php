<?php	
namespace app\jianli\controller;
use think\Controller;
class Index extends  Controller{
	public function index(){
		return $this->fetch();
	}
}