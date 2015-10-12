<?php

/**
 * http缓存
 */
namespace app\controllers;
use yii\web\Controller;
use app\models\Test;
use app\models\Customer;
use app\models\Order;

class HttpcacheController extends Controller
{
    
	/**
	 * http://yii.com/index.php?r=httpcache/index
	 * 在视图文件中的内容为this is a page!
	 * 第一次访问上面url,会缓存到,
	 * 修改视图文件内容
	 * 在访问一次,会显示原来的内容,修改的不被显示
	 * 
	 * 浏览器会缓存
	 * 
	 * 
	 */
    public function actionIndex()
    {
    	
		return $this->renderPartial('idnex');
        
    }
    
    public function behaviors(){
    	return [
    			[
    					'class'=>'yii\filters\HttpCache',
    					'lastModified'=>function(){
    						return 13322233345;
    					}
    					
    			]	
    	];
    }
    
    
    
    
    
}
