<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Adverts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adverts-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php //echo $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'status')->checkbox(['0', '1']) ?>

    <?php echo $form->field($model, 'type_id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\AdvertType::find()->all(), 'id', 'name')) ?>
    <?php //echo $form->field($model, 'type_id')->dropDownList(\app\modules\admin\models\AdvertTypes::find()->select(['name', 'id'])->indexBy('id')->column());

    ?>

    <?php //echo $form->field($model, 'category_id')->textInput() ?>
    <div class="form-group field-advert-category_id has-success">
        <label class="control-label" for="advert-category_id"><?= Yii::t('app', 'Advert category'); ?></label>
        <select id="advert-category_id" class="form-control" name="Advert[category_id]">
<?php echo app\widgets\AdvertCategoryMenuWidget::widget(['tpl' => 'admin_advert_cat_select', 'model' => $model]); ?>
        </select>
        <div class="help-block"></div>
    </div>

    <?php //echo $form->field($model, 'region_id')->textInput() ?>
    <div class="form-group field-region_id has-success">
        <label class="control-label" for="region_id"><?= Yii::t('app', 'Region'); ?></label>
        <select id="region_id" class="form-control" name="Advert[region_id]">
<?php echo app\widgets\RegionMenuWidget::widget(['tpl' => 'admin_region_select', 'model' => $model]); ?>
        </select>
        <div class="help-block"></div>
    </div>

    <?php //echo $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?php
        echo $form->field($model, 'body')->widget(CKEditor::className(), [
            'editorOptions' => [
                'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
                'height' => 150,
                'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Image'
            ],
        ]);
    ?>

    <?php //echo $form->field($model, 'end_publication')->textInput() ?>

    <?php if (isset($images)): ?>
        <div class="form-group">
            <?php foreach ($images as $image): ?>
            <div class="thumbnail pull-left">
                <?= Html::img('@web/web/uploads/adverts/thumbs/'.$image->img_src_thumb, ['class' => 'img-thumbnail img-responsive', 'width' => "100", 'alt' => $image->img_alt ]) ?>
                <div class="text-center">
                    <?php if (!$image->is_main): ?>
                    <a href="<?= Url::to(['advert/set-main-image', 'img_id' => $image->id]) ?>" title="Головна"><span class="glyphicon glyphicon-check"></span></a>
                    <?php endif; ?>
                    <a href="<?= Url::to(['advert/del-image', 'img_id' => $image->id]) ?>" title="Видалити"><span class="glyphicon glyphicon-trash"></span></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <span class="clearfix"></span>
    <?php endif; ?>

    <?php //if (count($images) < 5 ) :?>
    <?php echo $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?php //endif; ?>


    <?php //echo $form->field($model, 'created_at')->textInput() ?>

    <?php //echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
