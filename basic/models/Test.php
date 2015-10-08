<?php 

namespace app\models;

use yii\db\ActiveRecord;

class Test extends ActiveRecord{
	
	public function rules(){
		
		//数据验证
		return[
			['id','integer'],	
			['title','string','length'=>[0,100]]
		];
		
	}
	
}
