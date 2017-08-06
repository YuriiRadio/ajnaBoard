<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\base\Model;
use app\models\StaticPage;
use app\models\StaticPageSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Language;
use app\models\StaticPageI18n;

/**
 * StaticPageController implements the CRUD actions for StaticPage model.
 */
class StaticPageController extends AppAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StaticPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaticPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StaticPage model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StaticPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new StaticPage();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
    public function actionCreate()
    {
        $model = new StaticPage();
        $i18nMessages = [new StaticPageI18n()];
        $languages = Language::find()->asArray()->indexBy('id')->all();

        $i18nMessages[0]->language_id = $languages[1]['id'];
        for ($i = 1; $i < count($languages); $i++) {
            $i18nMessages[] = new StaticPageI18n();
            $i18nMessages[$i]->language_id = $languages[$i+1]['id'];
        }

        if (($model->load(Yii::$app->request->post()) && $model->validate()) && (Model::loadMultiple($i18nMessages, Yii::$app->request->post()) && Model::validateMultiple($i18nMessages))) {
            // Зберігаємо основну модель
            $model->save(false);
            // Зберігаємо інтернаціоналізаційні повідомлення моделі
            foreach ($i18nMessages as $i18nMessage) {
                $i18nMessage->static_page_id = $model->id;
                $i18nMessage->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'i18nMessages' => $i18nMessages,
                'languages' => $languages
            ]);
        }
    }

    /**
     * Updates an existing StaticPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $i18nMessages = StaticPageI18n::find()
                ->where(['static_page_id' => $model->id])->indexBy('id')->all();
        $languages = Language::find()->asArray()->indexBy('id')->all();

        if (($model->load(Yii::$app->request->post()) && $model->validate()) && (Model::loadMultiple($i18nMessages, Yii::$app->request->post()) && Model::validateMultiple($i18nMessages))) {
            // Зберігаємо основну модель
            $model->save(false);
            // Зберігаємо інтернаціоналізаційні повідомлення моделі
            foreach ($i18nMessages as $i18nMessage) {
                $i18nMessage->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'i18nMessages' => $i18nMessages,
                'languages' => $languages
            ]);
        }
    }

    /**
     * Deletes an existing StaticPage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            StaticPageI18n::deleteAll(['static_page_id' => $id]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the StaticPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StaticPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaticPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
