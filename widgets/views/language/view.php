<?php
//use yii\helpers\Url;
use yii\helpers\Html;
?>
<li class="dropdown">
    <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
        <?= Html::img('@web/images/flagicons/'.$current->flag).' '.$current->name.' '; ?><span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
    <?php foreach ($languages as $language): ?>
        <li>
            <?= Html::a(Html::img('@web/images/flagicons/'.$language->flag).' '.$language->name, '/'.$language->url.Yii::$app->getRequest()->getLangUrl()) ?>
        </li>
    <?php endforeach; ?>
    </ul>
</li>

