<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
mihaildev\elfinder\Assets::noConflict($this);

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->checkbox([ '0', '1', ]) ?>

    <?php  //$form->field($model, 'category_id')->textInput(['maxlength' => true]) ?>
    <div class="form-group field-article-category_id has-success">
        <label class="control-label" for="article-category_id"><?= Yii::t('app', 'Parent category'); ?></label>
        <select id="article-category_id" class="form-control" name="Article[category_id]">
<?php echo app\widgets\ArticleCategoryMenuWidget::widget(['tpl' => 'select_article', 'model' => $model]); ?>
        </select>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php #echo $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?php
        echo $form->field($model, 'body')->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false,
            ])
        ]);
    ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
