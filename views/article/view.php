<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $article->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['/article']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h2><?= Html::encode($this->title) ?></h2>
    <ul class="list-unstyled list-inline small">
        <li>
            <span class="glyphicon glyphicon-calendar"></span>
            <?= ' ' . date("Y.m.d", $article->created_at) ?>
        </li>
        <li><span class="glyphicon glyphicon-eye-open"></span>
            <?= $article->view ?>
        </li>
        <li><span class="glyphicon glyphicon-list-alt"></span>
            <a href="<?= Url::to(['article-category/view', 'id' => $article->articleCategory->id]) ?>"><?= $article->articleCategory->name ?></a>
        </li>
    </ul>
    <?php echo $article->body; ?>
</div>
