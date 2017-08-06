<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\controllers\AppController;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\StaticPage;
use app\models\StaticPageI18n;
use app\models\Language;

class SiteController extends AppController
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
     * @return string
     */
    public function actionIndex()
    {
        $this->setMeta('Апріорі');
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
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
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays static pages.
     *
     * @return string
     * @author Yurii Radio <yurii.radio@gmail.com>
     */
    public function actionStatic($alias = null) {
        //$page_alias = Yii::$app->request->get('page_alias');
        if ($alias === null) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        $alias = clearGetData($alias);

        // Get cache
        $model = Yii::$app->cache->get('staticPage-'.$alias.Language::getCurrent()->local);
        if ($model) { return $this->render('static', ['model' => $model]); }
        // Get record from Database
//        $model = StaticPage::find()
//            ->innerJoinWith('i18nCurrent')
//            ->select([
//                StaticPage::tableName().'.id',
//                StaticPage::tableName().'.alias',
//                StaticPageI18n::tableName().'.title',
//                StaticPageI18n::tableName().'.body',
//                //StaticPage::tableName().'.created_at',
//                //StaticPage::tableName().'.updated_at'
//             ])
//            ->where('alias = :page_alias AND status = :status')
//            ->addParams([':page_alias' => $alias])
//            ->addParams([':status' => StaticPage::STATUS_ACTIVE])
//            //->addParams([':language_id' => Language::getCurrent()->id])
//            ->limit(1)
//            //->asArray()
//            ->one();

        $model = StaticPage::find()
            ->innerJoin(StaticPageI18n::tableName(), '`'.StaticPageI18n::tableName().'`.`static_page_id` = `'.StaticPage::tableName().'`.`id`')
            ->select([
                StaticPage::tableName().'.id',
                StaticPage::tableName().'.alias',
                StaticPageI18n::tableName().'.title',
                StaticPageI18n::tableName().'.body',
                //StaticPage::tableName().'.created_at',
                //StaticPage::tableName().'.updated_at'
             ])
            ->where('((`alias` = :page_alias) AND (`status` = :status) AND (`language_id` = :language_id))')
            ->addParams([':page_alias' => $alias])
            ->addParams([':status' => StaticPage::STATUS_ACTIVE])
            ->addParams([':language_id' => Language::getCurrent()->id])
            ->limit(1)
            //->asArray()
            ->one();
        // Set cache
        Yii::$app->cache->set('staticPage-'.$alias.Language::getCurrent()->local, $model, Yii::$app->setting->get('TIME_CACHE_MENU'));

//        $model = Yii::$app->db->createCommand(
//            'SELECT * FROM `'.StaticPage::tableName().'`, `'.StaticPageI18n::tableName().'`'
//          . ' WHERE (`'.StaticPage::tableName().'`.`id` = `'.StaticPageI18n::tableName().'`.`static_page_id`)'
//          . ' AND (`'.StaticPage::tableName().'`.`status` = :status)'
//          . ' AND (`'.StaticPage::tableName().'`.`alias` = :alias)'
//          . ' AND (`'.StaticPageI18n::tableName().'`.`language_id` = :language_id)',
//          [
//              ':status' => StaticPage::STATUS_ACTIVE,
//              ':alias' => $alias,
//              ':language_id' => Language::getCurrent()->id
//          ]
//        )->queryOne();

        if (!$model) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        return $this->render('static', ['model' => $model]);
    }

}