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
    	
		return $this->renderPartial('index');
        
    }
    
    /**
     * http缓存实例
     *http://yii.com/index.php?r=httpcache/httpcache
     */
    public function actionHttpcache(){
    	
    	$content = file_get_contents('hw.txt');
    	return $this->renderPartial('httpcache',['new'=>$content]);
    }
    
    public function behaviors(){
    	
    	return [
    		[
    				'class'=>'yii\filters\HttpCache',
    				'lastModified'=>function(){
    					return filemtime('hw.txt');		//根据文件的修改时间判断
    				},
    				'etagSeed'=>function (){
    					$fp = fopen('hw.txt','r');		//根据文件的第一行内容,是否改变判断
    					$title = fgets($fp);
    					fclose($fp);
    					return $title;
    				}
    				
    		]	
    	];
    	
    	
    	/* return [
    			[
    					'class'=>'yii\filters\HttpCache',
    					'lastModified'=>function(){	//通过lastModified判断比对:判断数据修改时间是否一样
    						return 1432817565;		//这个是时间戳,会塞到http的头部,服务器发送给浏览器
    												//浏览器会存储成lastModifid
    												//之后再访问会和服务器的时间戳比对,如果一样,那么直接用缓存,不调用视图文件
    												//服务器会把304的状态发送给浏览器
    					},
    					
    					//判断lastModified,如果是一样的话,直接使用缓存,不再判断etagSeed
    					
    					'etagSeed'=>function(){		//通过etagSeed判断比对
    						return 'etagseed2';		//判断etagSeed的值(内容,是否一样)
    					}
    			]	
    	]; */
    }
    
    
    
    
    
}
