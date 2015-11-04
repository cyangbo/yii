<?php


namespace app\controllers;
use YII;
use yii\web\Controller;


use app\models\common\Express;

class TrackingController extends Controller
{
	
	public $layout = 'tracking_header';


	public function actionIndex()
	{
		/**
		 * url传递参数:
		 * 传入参数id=3,方法要获取参数,使用如下
		 */
		$request = \YII::$app->request;

		//获取用户id地址:
		//echo $request->userIP;
		 
		 
		//echo "hello world";
		
		$test = Express::ccc();
		
		//print_r($test);
		
		$data = array();
		
		
		
		return $this->render('index',$data);
		
		
		


	}
	
}