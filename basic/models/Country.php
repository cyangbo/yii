<?php

namespace app\models;

use yii\db\ActiveRecord;

/*
 * 这个 Country 类继承自 [[yii\db\ActiveRecord]]。
 * 不用在里面写任何代码。Yii 就能根据类名去猜测对应的数据表名。
 * 如果类名和数据表名不能直接对应，可以覆写 [[yii\db\ActiveRecord::tableName()|tableName()]] 方法去显式指定相关表名。
 */
class Country extends ActiveRecord
{
}