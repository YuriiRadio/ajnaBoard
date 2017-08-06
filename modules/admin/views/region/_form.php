<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Regions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'parent_id')->textInput() ?>

    <div class="form-group field-region-parent_id has-success">
        <label class="control-label" for="region-parent_id"><?= Yii::t('app', 'Parent category'); ?></label>
        <select id="region-parent_id" class="form-control" name="Region[parent_id]">
            <option value="0"><?= Yii::t('app', 'Independent category'); ?></option>
<?php echo app\widgets\RegionMenuWidget::widget(['tpl' => 'admin_region_select_parent', 'model' => $model]); ?>
        </select>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'created_at')->textInput() ?>

    <?php //echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
