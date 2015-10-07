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
    
    /**
     * 响应组件:response
     * http://yii.com/index.php?r=hello/response
     * 
     */
    public function actionResponse(){
    	
    	$response = new \YII::$app->response;
    	echo "ss";
    	//设置状态码
    	$response->statusCode = '404';
    	
    	$response->headers->add('pragma','no-cache');
    	$response->headers->set('pragma','max-age=5');

    	//跳转到baidu,无效?????
    	$response->headers->add('location','http://www.baidu.com');
    	
    	//跳转到sina
    	//$this->redirect('http://www.sina.com.cn');
    	
    }
    
}
