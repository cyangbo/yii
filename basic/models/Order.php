<?php 

namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord{
	
	//根据订单查询顾客的信息
	public function getCustomer(){
		
		//一个订单属于一个顾客,1:1,所以用hasOne
		return $this->hasOne(Customer::className(),['id'=>'customer_id'])->asArray();
		
	}
	
}
