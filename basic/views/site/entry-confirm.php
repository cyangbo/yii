<?php
use yii\helpers\Html;
?>
<p>请输入用户名和邮箱:</p>

<ul>
    <li><label>Name</label>: <?= Html::encode($model->name) ?></li>
    <li><label>Email</label>: <?= Html::encode($model->email) ?></li>
</ul>