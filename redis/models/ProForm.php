<?php
namespace app\models;

use Yii;
use yii\base\Model;


class ProForm extends Model
{
	public $id;
	public $username;
	public $sex;
	public $idcate;
	public $dorm_id;
	public $iclass;
	
	public $nation;
	public $education;
	public $birthday;
	public $major;
	public $school;
	public $adress;
	public $post;
	public $phone;
	
	
	
	public function rules()
	{
		return [
			[['username','sex'],'required'],
			// ['username','email']
		];
	}
}
?>