<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AdvertTypes */

$this->title = Yii::t('app', 'Create Advert Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advert Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
