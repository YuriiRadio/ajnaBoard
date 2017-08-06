<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use app\models\Article;
use app\models\ArticleCategory;
use yii\data\Pagination;

/**
 * Description of ArticleCategoryController
 *
 * @author Velizar
 */
class ArticleCategoryController extends AppController {

    public function actionIndex() {
        $articles = Article::find()
                ->with('articleCategory')
                ->where(['status' => Article::STATUS_ACTIVE])
                ->limit(9)
                ->all();
        return $this->render('index', ['articles' => $articles]);
    }

    public function actionView($id = null, $alias = null) {

        $article_category = ArticleCategory::findOne($id);
        //$article_category = ArticleCategory::find($id)->with('i18n')->one();

        if (empty($article_category)) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $article_categories = ArticleCategory::find()
                //->select(['id', 'alias', 'parent_id', 'keywords', 'description'])
                ->select(['id', 'alias', 'parent_id'])
                ->indexBy('id')
                ->asArray()
                ->all();

        //debug($this->getSubCatArray($id, $article_categories)); die;

        $query = Article::find()
                ->with('articleCategory')
                ->where(['IN', 'category_id', $this->getSubCatArray($id, $article_categories)]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 9,
            'forcePageParam' => FALSE,
            'pageSizeParam' => FALSE
        ]);
        $articles = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMeta('АПРІОРІ | ' . $article_category->name, $article_category->keywords, $article_category->description);
        return $this->render('view', ['articles' => $articles, 'article_category' => $article_category, 'pages' => $pages]);
    }

    protected function getSubCatArray($id, $data = []) {

        $keys = array();    // Тут буде масив ключів
        $keys[] = $id;      // Додаємо перший ключ в масив де будемо шукати

        // Це шедевр :) 10.11.2016 21:00 - Velizar
        while ($category = each($data)) {
            if (in_array($category['value']['parent_id'], $keys)) {
                $keys[] = $this->getSubCatArray($category['value']['id'], $data)[0];
            }
        }
        return $keys;
    }

}
