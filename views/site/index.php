<?php

/* @var $this yii\web\View */

//$this->title = 'Заготовка на Yii2';
?>
<div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-9">
        <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
        </p>
        <div class="jumbotron">
            <h1>Привіт, світ!</h1>
            <p>Цей приклад демонструє потенціал шаблону offcanvas в Bootstrap. Спробуйте звузити вікно браузера, щоб побачити його в дії.</p>
        </div>
        <div class="row">

            <div class="col-xs-6 col-lg-4">
                <h2>Заголовок</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-default" href="#" role="button">Читати далі &raquo;</a></p>
            </div><!--/.col-xs-6.col-lg-4-->



        </div><!--/row-->
    </div><!--/.col-xs-12.col-sm-9-->

    <div id="sidebar" class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Назва панелі</h3>
            </div>
            <div class="panel-body">
                <ul>
<?php echo app\widgets\ArticleCategoriesMenuWidget::widget(); ?>
                </ul>
            </div>
        </div>

    </div><!--/.sidebar--><!--/.col-xs-6.col-sm-3-->

</div><!--/row-->
