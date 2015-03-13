<?php

namespace app\models;

use yii\base\Model;

//模型类 EntryForm 代表从用户那请求的数据
class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],        //name 和 email 值都是必须的
            ['email', 'email'],                     //email 的值必须满足email规则验证
        ];
    }
}