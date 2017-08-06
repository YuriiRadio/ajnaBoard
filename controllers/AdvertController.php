<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use app\models\Advert;
use app\models\AdvertImage;
use yii\data\Pagination;

/**
 * Description of ArticleController
 *
 * @author Velizar
 */
class AdvertController extends AppController {

    public function actionIndex() {
        $query = Advert::find()
                ->with('advertCategory','region')
                ->where(['status' => Advert::STATUS_ACTIVE]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 9,
            'forcePageParam' => FALSE,
            'pageSizeParam' => FALSE
        ]);
        $adverts = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', ['adverts' => $adverts, 'pages' => $pages]);
    }

    public function actionView($id = null) {
        $advert = Advert::findOne($id);

        if (empty($advert)) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'The requested page does not exist.'));
        }
        $images = AdvertImage::find()
                ->where(['advert_id' => $id])
                ->orderBy(['is_main' => SORT_ASC])
                ->all();
        // Збільшуємо лічильник переглядів на 1
        $advert->view = $advert->view + 1;
        $advert->detachBehavior('TimestampBehavior');
        $advert->save();

        $this->setMeta('АПРІОРІ | ');
        return $this->render('view', ['advert' => $advert, 'images' => $images]);
    }

}
