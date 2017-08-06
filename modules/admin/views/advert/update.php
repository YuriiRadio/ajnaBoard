<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Adverts */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Adverts',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="adverts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images
    ]) ?>

</div>