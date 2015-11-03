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
    	
    	//关联查询结果缓存
    	//select * from order where customer_id = ...
    	//unset($customer->orders);
    	//当第二次中orders查询的时候,不会查询,而是从缓存中查找,所以可以先释放,再查询
    	//$order2 = $customer->orders;	
    	
    	print_r($order);
    	echo "<br>";
    	
    	
    	//根据订单查询顾客信息
    	$getorder = Order::find()->where(['id'=>1])->one();
    	$getcustomer = $getorder->customer;
    	print_r($getcustomer);
    	
    	//关联查询的多次查询
    	//写法1
    	$customer2 = Customer::find()->all();		//查询出所有:select * from customer
    	
    	//优化写法2(选取所有顾客,并给顾客赋值orders
    	//$customer2 = Customer::find()->with('orders')->all();			这个写法报错了
    	//select * from customer
    	//select * from order where customer_id in (..);
    	
    	//这样就不会再下面执行://select * from order where customer_id = 
    	//因此,本来要执行n条,变成写法2中,只需要执行2条
    	
    	foreach ($customer2 as $cus){
    		
    		//每个顾客都访问订单数据(每次都会查询)
    		//
    		$ord = $cus->orders;	//select * from order where customer_id = 
    		print_r($ord);
    		
    	}
    	
    	
    	
    	
    	    
    }
    
    
    
}
