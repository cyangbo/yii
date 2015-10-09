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
    	
    	
    
}
