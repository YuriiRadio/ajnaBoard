<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>

<?php if (!empty($articles)): ?>
        <h2><?= Yii::t('app', 'Articles'); ?></h2>
<?php $count = count($articles); $i = 0; foreach ($articles as $article): ?>
<?php if (($i == 0) || ($i % 3 == 0)): ?><div class="row"><?php endif; ?>
            <div class="col-xs-6 col-lg-4">
                <h3><a href="<?= Url::to(['article/view', 'id' => $article->id]); ?>"><?= $article->title ?></a></h3>
                <ul class="list-unstyled list-inline small">
                    <li>
                        <span class="glyphicon glyphicon-calendar"></span>
                        <?= ' ' . date("Y.m.d", $article->created_at) ?>
                    </li>
                    <li><span class="glyphicon glyphicon-list-alt"></span>
                        <a href="<?= Url::to(['article-category/view', 'id' => $article->articleCategory->id]) ?>"><?= $article->articleCategory->name ?></a>
                    </li>
                </ul>
                <p><?= \yii\helpers\StringHelper::truncateWords(strip_tags($article->body), 12, $suffix = '...');?>
                <a href="<?= Url::to(['article/view', 'id' => $article->id]); ?>">Далі &raquo;</a>
                </p>
            </div><!--/.col-xs-6.col-lg-4-->
<?php $i++; if ($i % 3 == 0 || $i == $count ): ?></div><?php endif; ?>
<?php endforeach; ?>
<?php echo LinkPager::widget(['pagination' => $pages]); ?>
<?php else: ?>
<h3>В базі даних немає записів...</h3>
<?php endif; ?>
    </div><!--/.col-xs-12.col-sm-9-->

    <div id="sidebar" class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Категорії статтей</h3>
            </div>
            <div class="panel-body">
                <ul id="article-category">
<?php echo app\widgets\ArticleCategoryMenuWidget::widget(); ?>
                </ul>
            </div>
        </div>

        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Наші оголошення</h3>
            </div>
            <div class="panel-body">
                <ul id="advert-category">
                    <li><b><a href="<?= Url::to(['/advert-category']) ?>">Всі категорії</a></b></li>
<?php echo app\widgets\AdvertCategoryMenuWidget::widget(); ?>
                </ul>
            </div>
        </div>

    </div><!--/.sidebar--><!--/.col-xs-6.col-sm-3-->

</div><!--/row-->




