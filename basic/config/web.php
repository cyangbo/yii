<?php

$params = require(__DIR__ . '/params.php');
//在不中断程序的情况下,输出信息到文件
//file_put_contents("d:/mylog.txt",dirname(__DIR__)."cc".__FILE__.date('Y-m-d H:i:s')."tt\r\n",FILE_APPEND);
//dirname(__DIR__)  D:\wamp\www\yii\basic	    
//__FILE__   D:\wamp\www\yii\basic\config\web.php
$config = [
    'id' => 'basic',		//id用来区分其他应用的唯一标识ID。主要给程序使用。 为了方便协作，最好使用数字作为应用主体ID，但不强制要求为数字。
    'basePath' => dirname(__DIR__),	//basePath 指定该应用的根目录。根目录包含应用系统所有受保护的源代码。	D:\wamp\www\yii\basic	    
    'bootstrap' => ['log'],
	
	//components
	//这是最重要的属性，它允许你注册多个在其他地方使用的应用组件
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '233333333333333',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
		
	//该属性允许你用一个数组定义多个 别名。数组的key为别名名称，值为对应的路径。
	//使用这个属性来定义别名，代替 Yii::setAlias() 方法来设置。
	'aliases' => [
			'@name1' => 'path/to/path1',
			'@name2' => 'path/to/path2',
	],
];

//开发环境下会在启动阶段运行 debug 和 gii 模块。
//注: 启动太多的组件会降低系统性能，因为每次请求都需要重新运行启动组件，因此谨慎配置启动组件。
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
