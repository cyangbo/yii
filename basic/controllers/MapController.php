<?php

/**
 * 关联查询
 */
namespace app\controllers;
use yii\web\Controller;
use app\models\Test;
use app\models\Customer;
use app\models\Order;


class MapController extends Controller
{
    
	/**
	 * http://yii.com/index.php?r=map/index
	 */
    public function actionIndex()
    {
    	
    	//根据顾客查询订单的信息
    	$customer = Customer::find()->where(['name'=>'张三'])->one();
    	
    	//写法1
    	//$order = $customer->hasMany('app\models\Order',['customer_id'=>'id'])->asArray()->all();
    	//优化写法2
    	//$order = $customer->hasMany(Order::className(),['customer_id'=>'id'])->asArray()->all();
    	
    	//优化写法3(调用方法)
    	//$order = $customer->getOrders();
    	
    	//优化写法4(调用属性)
    	//YII中,调用了orders这个不存在的属性,就会自动调用_get(),在方法里面自动构造,调用get+属性名,即getOrders()这个方法
    	$order = $customer->orders;
    	
    	print_r($order);
    	echo "<br>";
    	
    	
    	//根据订单查询顾客信息
    	$getorder = Order::find()->where(['id'=>1])->one();
    	$getcustomer = $getorder->customer;
    	print_r($getcustomer);
    	
    	    
    }
    
    
    
}
