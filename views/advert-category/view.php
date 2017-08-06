<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>
<?php if ($subCatHtml): ?>
<?= $subCatHtml; ?>
        <hr />
<?php endif; ?>

<?php if (!empty($adverts)): ?>
<h2><?= $advert_category->name ?></h2>
<?php $count = count($adverts); $i = 0; foreach ($adverts as $advert): ?>
<?php if (($i == 0) || ($i % 3 == 0)): ?><div class="row"><?php endif; ?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-lg-2 col-md-2 col-sm-3">
            <?php $image = $advert->getMainImage($advert->id); ?>
            <?php echo Html::img('/web/uploads/adverts/thumbs/'.$image->img_src_thumb, ['class' => 'img-thumbnail img-responsive', 'alt' => $image->img_alt]) ?>
        </div>

        <div class="col-lg-10 col-md-10 col-sm-9">
            <h4><a href="<?= Url::to(['advert/view', 'id' => $advert->id]); ?>"><?= $advert->title ?></a></h4>
            <div class="row">
                <div class="col-xs-11">
                    <p>
                    <?= \yii\helpers\StringHelper::truncateWords(strip_tags($advert->body), 12, $suffix = '...');?>
                    <a href="<?= Url::to(['advert/view', 'id' => $advert->id]); ?>">Далі &raquo;</a>
                    </p>
                    <div><strong>Ціна:</strong> грн</div>
                    <p></p>
                </div>
                <div class="col-xs-1">
                    <ul class="list-unstyled"></ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled list-inline small">
                        <li><span data-toggle="tooltip" title="<?= date("Y.m.d", $advert->created_at).' - '.date("Y.m.d", $advert->end_publication) ?>">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <?= ' '.date("Y.m.d", $advert->created_at) ?></span>
                        </li>
                        <li><span class="glyphicon glyphicon-eye-open"></span>
                            <?= $advert->view ?>
                        </li>
                        <li><span class="glyphicon glyphicon-comment"></span></li>
                        <li><span class="glyphicon glyphicon-map-marker"></span>
                            <?= $advert->region->name ?>
                        </li>
                        <li><span class="glyphicon glyphicon-list-alt"></span>
                            <a href="<?= Url::to(['advert-category/view', 'id' => $advert->advertCategory->id]) ?>"><?= $advert->advertCategory->name ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $i++; if ($i % 3 == 0 || $i == $count ): ?></div><?php endif; ?>
<?php endforeach; ?>
<?php echo LinkPager::widget(['pagination' => $pages]); ?>
<?php else: ?>
<h3>В базі даних записів не знайдено...</h3>
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