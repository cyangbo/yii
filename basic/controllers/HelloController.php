<?php

/**
 * 请求组件:request
 */
namespace app\controllers;
use YII;
use yii\web\Controller;


class HelloController extends Controller
{
    
	/**
	 * http://yii.com/index.php?r=hello/index
	 * 入口文件index.php
	 * r=hello	表示控制器hello
	 * /index	表示下面这个方法actionIndex
	 * 
	 * http://yii.com/index.php?r=hello/index&id=3
	 * 传入参数id=3
	 * 
	 */
    public function actionIndex()
    {
    	/**
    	 * url传递参数:
    	 * 传入参数id=3,方法要获取参数,使用如下
    	 */
    	$request = \YII::$app->request;
    	
    	//$request = \YII::$app->request;   因为YII是全局变量,YII前面添加\,或者最开始使用use YII;
    	echo $request->get('id');
    	
    	//给id设置默认值
    	echo $request->get('id',233);
    	
    	//另外post请求:  $$request->post('id',233);
    	
    	if($request->isGet){
    		echo "判断到这是一个get请求";
    	}else{
    		echo "判断到这不是一个get请求";
    	}
    	
    	//获取用户id地址:
    	echo $request->userIP;
    	
    	
        echo "hello world";
        
        
    }
    
}
