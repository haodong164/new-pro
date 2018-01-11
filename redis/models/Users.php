<?php

/**
 * Created by PhpStorm.
 * User: 13058
 * Date: 2017/11/30
 * Time: 8:39
 */

namespace app\models;
use yii\db\ActiveRecord;

class Users extends ActiveRecord
{
	public static function users(){
		return '{{%users}}';
	}
}