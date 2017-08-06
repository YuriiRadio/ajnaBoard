<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
//use yii\widgets\Menu;
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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
<?php
    NavBar::begin([
        'brandLabel' => 'АПРІОРІ - ADMIN CENTER',
        'brandUrl' => ['/admin'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

//    echo Menu::widget([
//        'options' => ['class' => 'navbar-nav navbar-left nav'],
//        'items' =>
//        [
//            ['label' => Yii::t('app', 'Home'), 'url' => '/site/index'],
//            [
//                'options' => ['class' => 'dropdown'],
//                'label' => 'Admin center',
//                'template' => '<a class="dropdown-toggle" href="#" data-toggle="dropdown">{label}<b class="caret"></b></a>' . "\n",
//                'url' => ['#'],
//                'submenuTemplate' => '<ul class="dropdown-menu">{items}</ul>' . "\n",
//                'items' =>
//                [
//                    ['label' => 'Статичні сторінки сайту', 'url' => '/admin/site-page'],
//                    //['label' => 'Inside2', 'url' => 'category/24'],
//                ]
//            ],
//            ['label' => Yii::t('app', 'Login'), 'url' => '/site/login'],
//        ],
//    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/']],
            '<li class="dropdown">'."\n"
            .'<a class="dropdown-toggle" href="#" data-toggle="dropdown">'."\n"
            .'<span class="glyphicon glyphicon-cog"></span>'."\n"
            .    Yii::t('app', 'Admin panel') . ' '
            .    '<b class="caret"></b>'."\n"
            .'</a>'."\n"
            .'<ul class="dropdown-menu">'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-list-alt"></span>'. ' ' . Yii::t('app', 'Static pages'), ['/admin/static-page'])."\n"
            .    '</li>'."\n"
            .    '<li class="divider"></li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-list-alt"></span>'. ' ' . Yii::t('app', 'Article categories'), ['/admin/article-category'])."\n"
            .    '</li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-list-alt"></span>'. ' ' . Yii::t('app', 'Articles'), ['/admin/article'])."\n"
            .    '</li>'."\n"
            .    '<li class="divider"></li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-list-alt"></span>'. ' ' . Yii::t('app', 'Advert categories'), ['/admin/advert-category'])."\n"
            .    '</li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-list-alt"></span>'. ' ' . Yii::t('app', 'Advert types'), ['/admin/advert-type'])."\n"
            .    '</li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-list-alt"></span>'. ' ' . Yii::t('app', 'Adverts'), ['/admin/advert'])."\n"
            .    '</li>'."\n"
            .    '<li class="divider"></li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-globe"></span>'. ' ' . Yii::t('app', 'Regions'), ['/admin/region'])."\n"
            .    '</li>'."\n"
            .    '<li class="divider"></li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-user"></span>'. ' ' . Yii::t('app', 'Users'), ['/admin/user'])."\n"
            .    '</li>'."\n"
            .    '<li class="divider"></li>'."\n"
            .    '<li>'."\n"
            .        Html::a('<span class="glyphicon glyphicon-cog"></span>'. ' ' . Yii::t('app', 'Settings'), ['/admin/setting'])."\n"
            .    '</li>'."\n"
            .'</ul>'."\n"
            .'</li>',
            Yii::$app->user->isGuest ? (
                ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
        ],
    ]);

//    echo Nav::widget([
//        'options' => ['class' => 'navbar-nav navbar-right'],
//        'items' => [
//            [
//                'label' => 'Мова',
//                'items' => [
//                    ['label' => 'Українська', 'url' => '#'],
//                    //'<li class="divider"></li>',
//                    //'<li class="dropdown-header">Dropdown Header</li>',
//                    ['label' => 'Русский', 'url' => '#'],
//                    ['label' => 'English', 'url' => '#'],
//                ]
//            ]
//        ]
//    ]);

    echo '<ul class="nav navbar-nav navbar-right">';
    echo app\widgets\LanguageWidget::widget();
    echo '</ul>';

    NavBar::end();
?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= AlertWidget::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right">Хостинг любязно надано - <a href="http://www.ho.ua/">ho.ua</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

