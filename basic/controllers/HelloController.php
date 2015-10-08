<?php

/**
 * 请求组件:request
 */
namespace app\controllers;
use YII;
use yii\web\Controller;

use yii\web\Cookie;


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
    
    /**
     * session组件
     * http://yii.com/index.php?r=hello/session
     */
    public function actionSession(){
    	
    	$session = \YII::$app->session;
    	
    	//开启session
    	$session->open();
    	
    	//判断session是否开启
    	if($session->isActive){
    		echo "session is Active";
    	}else{
    		echo "session is not Active";
    	}
    	
    	//写法1(当成对象)
    	//设置session
    	$session->set('user','李白');
    	
    	//获取session
    	echo $session->get('user');
    	
    	//删除session
    	$session->remove('user');

    	
    	//写法2(当成数组)
    	$session['user'] = '杜甫'; 
    	echo $session['user'];
    	unset($session['user']);
    	
    	$session['user2'] = '小明';
    	
    }
    
    
    /**
     * Cookie组件
     * http://yii.com/index.php?r=hello/cookie
     * 
     * 当访问到这个方法后,cookie就会写入name为user,value值为:小李
     * 其中vaule显示的是加密后的密码串
     * 
     */
    public function actionCookie(){
    	
    	//设置cookie
    	$cookie = \YII::$app->response->cookies;
    	
    	$cookie_data = array('name'=>'user','value'=>'小李');
    	
    	$cookie->add(new Cookie($cookie_data));
    	
    	//删除cookie
    	//$cookie->remove('user');
    	
    	//获取cookie
    	$cookie2 = \YII::$app->request->cookies;
    	echo $cookie2->getValue('user');
    	
    	//如果user不存在,那么显示20
    	echo $cookie2->getValue('user',20);
    	
    	
    }
    
    /**
     * 显示视图文件:
     * http://yii.com/index.php?r=hello/view
     */
    public function actionView(){
    	
    	
    	//传递数据
    	$hello_str = "这是传递进视图的数据";
    	$hello_str2 = array(1,2,3);
    	
    	$data = array();
    	$data['view_hello'] = $hello_str;
    	$data['view_hello2'] = $hello_str2;
    	
    	
    	//视图的文件位置:
    	//\yii\basic\views\hello\helloview.php
    	return $this->renderPartial('helloview',$data);
    	//echo "shitu";
    	
    }
    
}
