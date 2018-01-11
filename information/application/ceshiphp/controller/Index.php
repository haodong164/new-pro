<?php	
namespace app\ceshiphp\controller;
use think\Controller;

use think\Cache;

class Index extends  Controller{
	public function index(){
		phpinfo();
	}
	public function lianjie(){
		$memache=new \Memcache;
		$memache->connect('127.0.0.1','11211') or die('fail');
		$memache->set('key', 'liutiaopii');
		echo $memache->get('key');
	}
	public  function indexs(){
        Cache::set('username','刘调皮');
		echo Cache::get('username');
    }

}