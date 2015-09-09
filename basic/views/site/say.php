<?php
use yii\helpers\Html;
?>
<?= Html::encode($message) ?>

这个是视图页面输出的内容:
D:\wamp\www\yii\basic\views\site\say.php

message 参数在输出之前被 yii\helpers\Html::encode() 方法处理过。这很有必要，当参数来自于最终用户时，参数中可能隐含的恶意 JavaScript 代码会导致跨站脚本（XSS）攻击。