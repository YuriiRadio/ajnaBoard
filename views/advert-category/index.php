<?php
use yii\helpers\Url;
?>
<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>
<?= app\widgets\CarouselWidget::widget(); ?>
        <ul>
<?= \app\widgets\AdvertCategoryMenuWidget::widget(['tpl' => 'site_advert_cat_menu']) ?>
        </ul>
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
