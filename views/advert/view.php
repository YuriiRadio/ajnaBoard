<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->registerJsFile('@web/js/fotorama.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerCssFile('@web/css/fotorama.css')
?>
<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>

        <?php if (!empty($advert)): ?>
        <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-md-12">
                    <h2><?= Html::encode($advert->title) ?></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="thumbnail">
                    <?php if (isset($images)) { ?>
                        <div class="fotorama" data-nav="thumbs" data-allowfullscreen="true">
                            <?php if (count($images) == 0): ?>
                                <img src="<?php echo '/web/uploads/adverts/no-image.png' ?>" style="" alt="" />
                            <?php endif; ?>
                            <?php foreach ($images as $image) { ?>
                            <a href="<?php echo '/web/uploads/adverts/'.$image->img_src ?>">
                                <img src="<?php echo '/web/uploads/adverts/thumbs/'.$image->img_src_thumb ?>" style="" alt="" />
                            </a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    </div>
                </div>

                <div class="col-md-7">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td colspan="2">
                                <ul class="list-unstyled list-inline">
                                    <li>
                                        <span data-toggle="tooltip" title="<?= date("Y.m.d", $advert->created_at) . ' - ' . date("Y.m.d", $advert->end_publication) ?>">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            <?= ' ' . date("Y.m.d", $advert->created_at) ?>
                                        </span>
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
                            </td>
                        </tr>
                        <tr>
                            <td><strong><?= Yii::t('app', 'Advert type') ?></strong></td>
                            <td><?= $advert->type->name ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= Yii::t('app', 'Body') ?></strong></td>
                            <td><?= \yii\helpers\HtmlPurifier::process($advert->body) ?></td>
                        </tr>
                        <tr>
                            <td><strong><?= Yii::t('app', 'End publication') ?></strong></td>
                            <td><?= date("Y.m.d", $advert->end_publication) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <?php else: ?>
            <h3>В базі даних запис не знайдено...</h3>
        <?php endif; ?>
    </div><!--/.col-xs-12.col-sm-9-->

    <div id="sidebar" class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">

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