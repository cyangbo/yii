<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/*
 * 这个视图包含两部分用以显示国家数据。
 * 第一部分遍历国家数据并以无序 HTML 列表渲染出来。
 * 第二部分使用 [[yii\widgets\LinkPager]] 去渲染从操作中传来的分页信息。
 * 小部件 LinkPager 显示一个分页按钮的列表。点击任何一个按钮都会跳转到对应的分页。
 */
?>
<h1>Countries</h1>
<ul>
<?php foreach ($countries as $country): ?>
    <li>
        <?= Html::encode("{$country->name} ({$country->code})") ?>:
        <?= $country->population ?>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>