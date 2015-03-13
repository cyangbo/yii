<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

//载入表单需要的模型
use app\models\EntryForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    //say 操作被定义为 actionSay 方法.Yii 使用 action 前缀区分普通方法和操作。action 前缀后面的名称被映射为操作的 ID。
    //浏览器访问:
    //http://yii.com/index.php?r=site/say
    //yii.com/index.php?r=site/say&message=cc+world
    //新页面和其它页面使用同样的头部和尾部是因为 [[yii\web\Controller::render()|render()]] 方法会自动把 say 视图执行的结果嵌入称为布局的文件中
    //本例中是 views/layouts/main.php。
    //参数 r 需要更多解释。它代表路由，是整个应用级的，指向特定操作的独立 ID。路由格式是 控制器 ID/操作 ID
    public function actionSay($message = 'Hello'){
        return $this->render('say',['message' => $message]);
    }
    
    //表单处理方法
    //浏览器访问:
    //http://yii.com/index.php?r=site/entry
    /*
     * 原理:
     * 其实数据首先由客户端 JavaScript 脚本验证，然后才会提交给服务器通过 PHP 验证。
     * [[yii\widgets\ActiveForm]] 足够智能到把你在 EntryForm 模型中声明的验证规则转化成客户端 JavaScript 脚本去执行验证。
     * 如果用户浏览器禁用了 JavaScript， 服务器端仍然会像 actionEntry() 方法里这样验证一遍数据。
     * 这保证了任何情况下用户提交的数据都是有效的。
     */
    public function actionEntry()
    {
        $model = new EntryForm;     //创建一个EntryForm对象
    
        //尝试从 $_POST 搜集用户提交的数据，由 Yii 的 [[yii\web\Request::post()]] 方法负责搜集
        //如果模型被成功填充数据（也就是说用户已经提交了 HTML 表单），操作将调用 [[yii\base\Model::validate()|validate()]] 去确保用户提交的是有效数据
        //补充：表达式 Yii::$app 代表应用实例，它是一个全局可访问的单例。同时它也是一个服务定位器，能提供 request，response，db 等等特定功能的组件。
        //在上面的代码里就是使用 request 组件来访问应用实例收到的 $_POST 数据。
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // 验证 $model 收到的数据
    
            // 做些有意义的事 ...
    
            //用户提交表单后，操作将会渲染一个名为 entry-confirm 的视图去确认用户输入的数据
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // 无论是初始化显示还是数据验证错误
            return $this->render('entry', ['model' => $model]);
        }
    }
}
