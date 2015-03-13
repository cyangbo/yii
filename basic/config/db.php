<?php
/*
 * 配置的数据库连接可以在应用中通过 Yii::$app->db 表达式访问
 * config/db.php 将被包含在应用配置文件 config/web.php 中，后者指定了整个应用如何初始化
 */
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
];
