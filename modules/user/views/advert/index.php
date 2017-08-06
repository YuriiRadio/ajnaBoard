<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\AdvertsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Adverts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adverts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <a href="<?= Url::to(['create']) ?>" class="btn btn-success">
            <span class="glyphicon glyphicon-plus"></span><?= ' '.Yii::t('app', 'Create Advert') ?>
        </a>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'status',
            [
                'attribute' => 'status',
                'filter'=> ["1" => "Активно", "0" => "Не активно"],
                'value' => function ($model) {
                    return $model->status ? '<span class="text-success">Активно</span>' : '<span class="text-danger">Не Активно</span>';
                },
                'format' => 'html',
            ],
            //'type_id',
            [
                'attribute' => 'type_id',
                'filter' => yii\helpers\ArrayHelper::map(\app\models\AdvertType::find()->all(), 'id', 'name'),
                'value' => function ($model) {
                    return $model->type->name ? $model->type->name : Yii::t('app', 'Independent category');
                },
            ],
            //'category_id',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->advertCategory->name ? $model->advertCategory->name : Yii::t('app', 'Independent category');
                },
            ],
            //'region_id',
            [
                'attribute' => 'region_id',
                'value' => function ($model) {
                    return $model->region->name ? $model->region->name : Yii::t('app', 'Independent category');
                },
                //'format' => 'html',
            ],
            //'user_id',
//            [
//                'attribute' => 'user_id',
//                'value' => function ($model) {
//                    return '<a href="'. Url::to(['user/view', 'id' => $model->user->id]) .'">'. $model->user->username . '</a>';
//                },
//                'format' => 'html',
//            ],
            'title',
            // 'body:ntext',
            //'end_publication',
            [
                'attribute' => 'end_publication',
                'value' => function ($model) {
                    return date('d.m.Y', $model->end_publication);
                },
            ],
            // 'created_at:datetime',
            // 'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
