<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Adverts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adverts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'status',
            [
                'attribute' => 'status',
                'value' => $model->status ? '<span class="text-success">Активно</span>' : '<span class="text-danger">Не Активно</span>',
                'format' => 'html',
            ],
            //'type_id',
            [
                'attribute' => 'type_id',
                'value' => $model->type->name ? $model->type->name : Yii::t('app', 'Independent category'),
            ],
            //'category_id',
            [
                'attribute' => 'category_id',
                'value' => $model->advertCategory->name ? $model->advertCategory->name : Yii::t('app', 'Independent category'),
            ],
            //'region_id',
            [
                'attribute' => 'region_id',
                'value' => $model->region->name ? $model->region->name : Yii::t('app', 'Independent category'),
            ],
            //'user_id',
            [
                'attribute' => 'user_id',
                'value' => '<a href="'. Url::to(['user/view', 'id' => $model->user->id]) .'">'. $model->user->username . '</a>',
                'format' => 'html',
            ],
            'title',
            'body:html',
            'created_at:date',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
