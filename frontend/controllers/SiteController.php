<?php
namespace frontend\controllers;

use common\models\Spisok;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionSpisok(){

        $spisok = Spisok::find()->where(['userid' => $_SESSION['__id']])->all();
        return $this->render('spisok', ['spisok' => $spisok]);
    }

    public function actionUpdate($id)
    {
        $spisok = Spisok::findOne($id);
        if ($spisok->load(Yii::$app->request->post()) && $spisok->save())
        {
            Yii::$app->session->addFlash('success', 'Задача успешно изменена!');
            return $this->redirect(['/site/spisok']);
        }
        else{
            return $this->render('update', ['spisok' => $spisok]);
        }
    }

    public function actionCreate(){
        $spisok = new Spisok();
        $spisok->userid = $_SESSION['__id'];

        $formData = Yii::$app->request->post();

        if ($spisok->load($formData))
        {
            if ($spisok->save())
            {
                Yii::$app->session->addFlash('success', 'Задача успешно добавлена!');
                return $this->redirect(['/site/spisok/']);
            }
            else
            {
                Yii::$app->getSession()->setFlash('message', "Failed");
            }
        }
        return $this->render('create', ['spisok' => $spisok]);
    }

    public function actionDelete($id){
        $spisok = Spisok::findOne($id);
        if ($spisok!= null){
            $spisok = Spisok::findOne($id)->delete();
            if ($spisok)
            {
                Yii::$app->session->addFlash('success', 'Список успешно удален!');
            }
        }
        else
            echo "!";
        return $this->render('index', ['spisok' => $spisok]);
    }

}
