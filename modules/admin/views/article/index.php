<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'filter'=>array("1"=>"Активно","0"=>"Не активно"),
                'value' => function ($model) {
                    return $model->status ? '<span class="text-success">Активно</span>' : '<span class="text-danger">Не Активно</span>';
                },
                'format' => 'html',
            ],
            //'category_id',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->articleCategory->name;
                },
            ],
            'title',
            //'body:ntext',
            // 'keywords',
            // 'description',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
