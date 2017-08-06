<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update') . ' ' . $model->username;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account'), 'url' => ['/user/user/index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update') . ' ' . $model->username;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
