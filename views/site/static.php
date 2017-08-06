<?php

use yii\helpers\Html;

//$this->title = $model->i18n->title;
//$this->title = $model['title'];
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //echo Yii::$app->requestedAction->id ?>
        <?php //echo $model['body']; ?>
        <?php echo $model->body; ?>
        <?php //echo $model->i18n->body; ?>
    </p>

</div>

