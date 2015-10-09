<?php 

namespace app\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord{
	
	
	//获取订单信息
	public function getOrders(){
		
		$order = $this->hasMany(Order::className(),['customer_id'=>'id'])->asArray()->all();
		 return $order;
		
	}
	
	
}
