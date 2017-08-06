<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ArticleCategory */
/* @var $form yii\widgets\ActiveForm */
//debug($languages);

?>

<div class="article-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>
    <?php //echo $form->field($model, 'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map(app\modules\admin\models\ArticleCategory::find()->all(), 'id', 'name'));?>
    <div class="form-group field-articlecategory-parent_id has-success">
        <label class="control-label" for="articlecategory-parent_id"><?= Yii::t('app', 'Parent category'); ?></label>
        <select id="articlecategory-parent_id" class="form-control" name="ArticleCategory[parent_id]">
            <option value="0"><?= Yii::t('app', 'Independent category'); ?></option>
            <?php echo app\widgets\ArticleCategoryMenuWidget::widget(['tpl' => 'select', 'model' => $model]); ?>
        </select>
        <div class="help-block"></div>
    </div>

    <?php echo $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
        foreach ($i18nMessages as $index => $i18nMessage) {
            echo $form->field($i18nMessage, "[$index]name")
                    ->textInput(['maxlength' => true])
                    ->label(Yii::t('app', 'Name').': '.Html::img('@web/images/flagicons/'.$languages[$i18nMessage->language_id]['flag']).' '.$languages[$i18nMessage->language_id]['name']);
        }
    ?>

    <?php //echo $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?php
        foreach ($i18nMessages as $index => $i18nMessage) {
            echo $form->field($i18nMessage, "[$index]keywords")
                    ->textInput(['maxlength' => true])
                    ->label(Yii::t('app', 'Keywords').': '.Html::img('@web/images/flagicons/'.$languages[$i18nMessage->language_id]['flag']).' '.$languages[$i18nMessage->language_id]['name']);
        }
    ?>

    <?php //echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php
        foreach ($i18nMessages as $index => $i18nMessage) {
            echo $form->field($i18nMessage, "[$index]description")
                    ->textInput(['maxlength' => true, 'class' => 'form-inline'])
                    ->label(Yii::t('app', 'Description').': '.Html::img('@web/images/flagicons/'.$languages[$i18nMessage->language_id]['flag']).' '.$languages[$i18nMessage->language_id]['name']);
        }
    ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
