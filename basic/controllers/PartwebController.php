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

    
}
