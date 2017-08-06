<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use app\models\Advert;
use app\models\AdvertCategory;
use yii\data\Pagination;


/**
 * Description of ArticleCategoryController
 *
 * @author Velizar
 */
class AdvertCategoryController extends AppController {

    public function actionIndex() {

        //$articles = Adverts::find()->where(['status' => 1])->limit(6)->all();

        return $this->render('index');
    }

    public function actionView($id = null, $alias = null) {

        $advert_category = AdvertCategory::findOne($id);

        if (empty($advert_category)) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }

        $advert_categories = AdvertCategory::find()
                ->select(['id', 'alias', 'parent_id', 'name'])
                ->indexBy('id')
                ->asArray()
                ->all();

        $subCatArray = $this->getSubCatArray($id, $advert_categories);

        # Будуємо дерево дочірніх категорій
        $subCatHtml = null;
//        if (count($subCatArray) > 1) { # Якщо є дочірні категорії
//            $subCategories = AdvertCategories::find()
//                    ->asArray()
//                    ->where(['IN', 'id', $subCatArray])
//                    ->all();
//            //debug($subCategories);
//            $subCatHtml = $this->getSubCatHtml($id, $subCategories);
//        }

        # Шукаємо всі оголошення з самої категорії $id і всіх дочірніх категорій
        $query = Advert::find()
                        ->with('advertCategory', 'region', 'images')
                        ->where(['IN', 'category_id', $subCatArray]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 9,
            'forcePageParam' => FALSE,
            'pageSizeParam' => FALSE
        ]);
        $adverts= $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMeta('АПРІОРІ | ' . $advert_category->name, $advert_category->keywords, $advert_category->description);

        return $this->render('view', ['adverts' => $adverts, 'advert_category' => $advert_category, 'subCatHtml' => $subCatHtml, 'pages' => $pages]);
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

    /**
     * Повертає Html код дочірніх категорій, у вигляді дерева.
     *
     * @param $subCategories array зі всіма даними категорії
     *
     * @return string
     * @author Yurii Radio <yurii.radio@gmail.com>
     */
    protected function getSubCatHtml($id, $data = []) {
        $result = "";
        $result .= "<ul>\n";
        while ($category = each($data)) {
            if ($category[1]['parent_id'] <> $id) { # Батьківська категорія
                $result .= "<li>\n";
                $result .= '<a href="'. \yii\helpers\Url::to(['advert-category/view', 'id' => $category[1]['id']]) .'">'.$category[1]['name']."</a>\n";
                $result .= "</li>\n";
            } else {
                //array_shift($data);
                $result .= $this->getSubCatHtml($category[1]['id'], $data);
                // Тут потрібна умова виходу з циклу
            }
        }
        $result .= '</ul>\n';
        return $result;
    }

}
