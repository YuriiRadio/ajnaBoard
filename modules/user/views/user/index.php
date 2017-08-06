<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
        <h1><?= $model->username ?></h1>
        <p><?= Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'email:email',
                //'status',
//            [
//                'attribute' => 'status',
//                'value' => $user->status === 10 ? '<span class="text-success">Активно</span>' : '<span class="text-danger">Не Активно</span>',
//                'format' => 'html'
//            ],
                //'role',
                //'created_at:date',
                [
                'attribute' => 'created_at',
                'value' => date('d.m.Y', $model->created_at),
                ],
                //'updated_at:date',
                [
                'attribute' => 'updated_at',
                'value' => date('d.m.Y', $model->updated_at),
                ],
            ],
        ]) ?>
    </div>
</div>