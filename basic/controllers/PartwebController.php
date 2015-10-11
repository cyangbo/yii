<?php

/**
 * 片段缓存
 */
namespace app\controllers;
use yii\web\Controller;
use app\models\Test;
use app\models\Customer;
use app\models\Order;


class PartwebController extends Controller
{
    
	/**
	 * http://yii.com/index.php?r=partweb/index
	 * 
	 */
    public function actionIndex()
    {
		return $this->renderPartial('index');
        
    }
    
    
    /**
     * 整个页面缓存
     * behaviors()方法的使用
     * 例如,访问:
     * http://yii.com/index.php?r=partweb/index
     * 会先执行这个控制器的behaviors()这个方法,再执行index这个方法
     * 
     * (non-PHPdoc)
     * @see \yii\base\Component::behaviors()
     */
    public function behaviors(){
    	
    	echo '1';
    	
    	return[
    		[
    				'class'=>'yii\filters\PageCache',		//这样就会缓存整个index里面的页面内容
    				'duration'=>1000,		//缓存时间1000秒
    				'only'=>['idnex'],		//只缓存actionIndex方法操作的缓存,下面actionTest()方法不缓存
    				'dependency'=>[			//文件依赖缓存
    						'class'=>'yii\caching\FileDependency',
    						'fileName'=>'hw2.txt'		//web目录下的hw2.txt
    				]
    		]
    			
    	];
    	
    }
    
    public function actionTest(){
    	
    	echo '测试整个页面缓存';
    	
    }

    
}
