<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\AlertWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta name="author" content="yurii.radio@gmail.com">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar navbar-fixed-top navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">ajnaBoard</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li<?php if ($this->context->action->uniqueId == 'article-category/index') echo ' class="active"' ?>><a href="<?= Url::to(['/']) ?>"><?= Yii::t('app', 'Home') ?></a></li>
                    <?= app\widgets\StaticMenuWidget::widget(['tpl' => 'header_menu']); ?>
                    <li<?php if ($this->context->action->uniqueId == 'site/contact') echo ' class="active"' ?>><a href="<?= Url::to(['/site/contact']) ?>"><?= Yii::t('app', 'Contact') ?></a></li>
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li<?php if ($this->context->action->uniqueId == 'site/login') echo ' class="active"' ?>><a href="<?= Url::to(['/site/login']) ?>"><?= Yii::t('app', 'Login') ?></a></li>
                    <?php else: ?>
                        <?php if (Yii::$app->user->identity->isAdmin()): ?>
                            <li><a href="<?= Url::to(['/admin']) ?>"><span class="glyphicon glyphicon-cog"></span><?= ' '. Yii::t('app', 'Admin panel') ?></a></li>
                        <?php else: ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="glyphicon glyphicon-briefcase"></span><?= ' '.Yii::t('app', 'My office').' ' ?><span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?= Url::to(['/user']) ?>"><span class="glyphicon glyphicon-user"></span><?= ' ' . Yii::t('app', 'Account') ?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?= Url::to(['/user/advert']) ?>"><span class="glyphicon glyphicon-list-alt"></span><?= ' ' . Yii::t('app', 'Adverts') ?></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li>
                        <?= Html::beginForm(['/site/logout'], 'post') ?>
                        <?= Html::submitButton(Yii::t('app', 'Logout') . ' ('
                                . Yii::$app->user->identity->username
                                . ')', ['class' => 'btn btn-link logout'])
                        ?>
                        <?= Html::endForm() ?>
                        </li>
                    <?php endif; ?>
                </ul>

<!--                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                            Мова <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Українська</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Русский</a></li>
                            <li><a href="#">English</a></li>
                        </ul>
                    </li>
                </ul>-->
                <ul class="nav navbar-nav navbar-right">
                    <?= app\widgets\LanguageWidget::widget() ?>
                </ul>

                <form class="navbar-form navbar-right">
                    <input class="form-control" placeholder="Пошук..." type="text">
                </form>

            </div><!-- /.nav-collapse -->
        </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= AlertWidget::widget() ?>
        <?= $content ?>
    </div>

</div><!-- wrap -->

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ajnaBoard - <?= date('Y') ?></p>
        <p class="pull-right">Хостинг любязно надано - <a href=""></a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
