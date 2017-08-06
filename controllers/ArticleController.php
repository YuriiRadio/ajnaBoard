<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use app\models\Article;
use yii\data\Pagination;

/**
 * Description of ArticleController
 *
 * @author Velizar
 */
class ArticleController extends AppController {

    public function actionIndex() {

        //$articles = Article::find()->where(['status' => 1])->all();

        $query = Article::find()
                ->with('articleCategory')
                ->where(['status' => 1]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 9,
            'forcePageParam' => FALSE,
            'pageSizeParam' => FALSE
        ]);
        $articles = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['articles' => $articles, 'pages' => $pages]);
    }

    public function actionView($id = null) {
        $article = Article::findOne($id);
        if (empty($article)) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        // Збільшуємо лічильник переглядів на 1
        $article->view = $article->view + 1;
        $article->detachBehavior('TimestampBehavior');
        $article->save();

        $this->setMeta('АПРІОРІ | ' . $article->title, $article->keywords, $article->description);
        return $this->render('view', ['article' => $article]);
    }

}
