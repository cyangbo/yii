<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Country;

/*
 * 浏览器访问:
 * http://yii.com/index.php?r=country/index
 * 在这个场景里，[[yii\data\Pagination|Pagination]] 提供了为数据结果集分页的所有功能：
 * 首先 [[yii\data\Pagination|Pagination]] 把 SELECT 的子查询 LIMIT 5 OFFSET 0 数据表示成第一页。因此开头的五条数据会被取出并显示。
 * 然后小部件 [[yii\widgets\LinkPager|LinkPager]] 使用 [[yii\data\Pagination::createUrl()|Pagination::createUrl()]] 方法生成的 URL 去渲染翻页按钮。URL 中包含必要的参数 page 才能查询不同的页面编号。
 * 如果你点击按钮 “2”，将会发起一个路由为 country/index 的新请求。[[yii\data\Pagination|Pagination]] 接收到 URL 中的 page 参数把当前的页码设为 2。新的数据库请求将会以 LIMIT 5 OFFSET 5 查询并显示。
 */
class CountryController extends Controller
{
    public function actionIndex()
    {
        //调用活动记录 Country::find() 方法，去生成查询语句并从 country 表中取回所有数据
        $query = Country::find();

        /*
         * 为了限定每个请求所返回的国家数量，查询在 [[yii\data\Pagination]] 对象的帮助下进行分页。 
         * Pagination 对象的使命主要有两点：
         * 为 SQL 查询语句设置 offset 和 limit 从句，确保每个请求只需返回一页数据（本例中每页是 5 行）
         * 在视图中显示一个由页码列表组成的分页器
         */
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
    }
}