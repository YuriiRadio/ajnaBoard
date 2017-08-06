<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
//use app\components\SiteMenuWidget;

$this->title = Yii::t('app', 'About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Про нас
        <br />
        <?php echo Yii::$app->requestedAction->id ?>
    </p>

    <code><?= __FILE__ ?></code>
</div>
