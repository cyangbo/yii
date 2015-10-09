<?php

/**
 * 类的映射表
 */
namespace app\controllers;
use yii\web\Controller;
use app\models\Test;
use app\models\Customer;
use app\models\Order;


class ClassmapController extends Controller
{
    
	/**
	 * 类的映射表,可以加速加载,常用的可以使用,不常用的不要这样子用,占用内存
	 * http://yii.com/index.php?r=classmap/index
	 */
    public function actionIndex()
    {

    	//定义
    	\YII::$classMap['app\models\Order'] = 'D:\wamp\www\yii\basic\models\Order.php';
    	
    	//定义后就可以使用
    	$order = new Order;
    	
    	
    	
  
    }
    
    
    
}
