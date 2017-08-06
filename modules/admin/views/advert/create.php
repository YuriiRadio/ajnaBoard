<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Adverts */

$this->title = Yii::t('app', 'Create Adverts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adverts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
