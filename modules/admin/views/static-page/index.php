<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\StaticPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Static pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Static Page'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'status',
            [
                'attribute' => 'status',
                'filter'=> [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')],
                'value' => function ($model) {
                    return $model->status ? '<span class="text-success">'.Yii::t('app', 'Active').'</span>' : '<span class="text-danger">'.Yii::t('app', 'Inactive').'</span>';
                },
                'format' => 'html',
            ],
            'alias',
            'title',
//            [
//                'attribute' => 'title',
//                'value' => function ($model) {
//                    //debug($model);die;
//                    return $model->i18n->title;
//                    //return $model->title;
//                 },
//            ],
            //'body:html',
            'menu_position',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
