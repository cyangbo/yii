
<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<h1>显示视图文件</h1>

<h2>这是控制器传过来的数据:</h2>
<?=$view_hello; ?><br>
<?=$view_hello2[1]; ?>
<?=Html::encode($view_hello3); ?><br>
<?=HTMLPurifier::process($view_hello3); ?>