<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AdvertCategory */

$this->title = Yii::t('app', 'Create Advert Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advert Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
