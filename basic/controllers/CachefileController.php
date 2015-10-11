<?php

/**
 * 缓存
 */
namespace app\controllers;
use yii\web\Controller;
use app\models\Test;
use app\models\Customer;
use app\models\Order;


class CachefileController extends Controller
{
    
	/**
	 * http://yii.com/index.php?r=cachefile/index
	 */
    public function actionIndex(){
    	
    	//获取缓存组件
    	$cache = \YII::$app->cache;
    	
    	//往缓存中写入数据
    	$cache->add('key1','hello cache');
    	$cache->add('key2','hello cache2');
    	
    	// http://yii.com/index.php?r=cachefile/index
    	//访问后,成功写入缓存
    	
    	//读取缓存
    	$data = $cache->get('key1');
    	//print_r($data);		//hello cache
    	
    	//修改缓存
    	$cache->set('key1','hello cache_alter');
    	$data2 = $cache->get('key1');
    	
    	//print_r($data2);	//hello cache_alter
    	
    	//删除缓存
    	//$cache->delete('key1');
    	
    	//清空缓存
    	//$cache->flush();
    	
    	
    }
    
    /**
     * 设置缓存的有效期
     * http://yii.com/index.php?r=cachefile/time
     */
    public function actionTime(){
    	
    	$cache = \YII::$app->cache;
    	
    	//有效期设置(有效期15秒),过了15秒会消失
    	$cache->add('key1','hello cache time',15);
    	$cache->add('key2','hello cache time',15);
    	
    	$cache->set('key2','hello cache time',5);	//设置5秒
    	
    	echo $cache->get('key1');
    	
    }
    
    /**
     * 依赖关系缓存:文件依赖
     * http://yii.com/index.php?r=cachefile/dependency
     */
    public function actionDependency(){
    	
    	//获取缓存组件
    	$cache = \YII::$app->cache;
    	
    	//文件依赖
    	$dependency = new \yii\caching\FileDependency(['fileName'=>'hw.txt']);	//$dependency对应的地址:D:\wamp\www\yii\basic\web\hw.txt
    	$cache->add('file_key22','hello cache',3000,$dependency);	//设置了缓存时间为3000s,依赖文件$dependency定义的hw.txt
    	

    	var_dump($cache->get('file_key22'));	//会打印出hello cache,//如果超过3000s或者hw.txt修改,缓存就会失效,打印出boolse
    	//print_r($dependency);

    }
    	
    	
    
}
