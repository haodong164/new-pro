<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
		$db=db('region');
        $parent_id['parent_id'] = 1;
        $region=$db->where($parent_id)->select();
        $this->assign('region',$region);
        return $this->fetch();
    }
    public function pro(){
        $parent_id['parent_id'] = input('post.pro_id');
        $region = db('region')->where($parent_id)->select();
        $data = "<option value='null'>--请选择市区--</option>";
        foreach($region as $key=>$v){
            $data.= "<option value='{$v['id']}'>{$v['region_name']}</option>";
        }
        return json($data);
    }
    public function area(){
        $parent_id['parent_id'] = input('post.pro_id');
        $region = db('region')->where($parent_id)->select();
        $data = '<option>--请选择市区--</option>';
        foreach($region as $key=>$v){
            $data.= "<option value='{$v['id']}'>{$v['region_name']}</option>";
        }
        return json($data);
    }
	public function one(){
		$db=db('region');
		$list=$db->where('parent_id='. 1)->select();
		$this->assign('one',$list);
		return $this->fetch();
	}
	// public function two(){
		// $db=db('region');
		// $sid=input('post.pid');
		// $list=$db->where('parent_id='. $sid)->select();
		// $data='';
		// foreach($list as $key=>$v){
			// $data.="<option value='{$v['id']}'>{$v['region_name']}</option>";
		// }
		// return json($data);
	// }
	public function two(){
		$db=db('region');
		$pid=input('post.pid');
		// if($pid=''){
			// $list='';
		// }
		$list=$db->where('parent_id='.$pid)->select();
		return json($list);
	}
	public function three(){
		$db=db('region');
		$pid=input('post.pid');
		$list=$db->where('parent_id='.$pid)->select();
		return json($list);
	}
	public function ssq(){
		$db=db('region');
		$list=$db->where('parent_id='. 1)->select();
		$this->assign('region',$list);
		return $this->fetch();
	}
	public function shi(){
		$db=db('region');
		$sid=input('post.sid');
		$list=$db->where('parent_id='. $sid)->select();
		$data='<option>--选择城市--</option>';
		foreach($list as $key=>$v){
			$data.="<option value='{$v['id']}'>{$v['region_name']}</option>";
		}
		return json($data);
	}
	public function qu(){
		$db=db('region');
		$sid=input('post.sid');
		$list=$db->where('parent_id='. $sid)->select();
		$data='<option>--选择城市--</option>';
		foreach($list as $key=>$v){
			$data.="<option value='{$v['id']}'>{$v['region_name']}</option>";
		}
		return json($data);
	}
	// public function two(){
		// $pid=input('post.pid');
		// $db=db('region');
		// $list=$db->where('parent_id='. $pid)->select();
		// $data='<option>选择城市</option>';
		// foreach($list as $key=>$v){
			// $data.="<option value='{$v['id']}'>{$v['region_name']}</option>";
		// }
		// return json($data);
	// }
}
