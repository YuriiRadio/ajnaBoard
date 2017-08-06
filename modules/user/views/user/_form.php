<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
        <div class="user-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<?php //echo $form->field($model, 'password_hash')->passwordInput() ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?php //echo $form->field($model, 'status')->textInput() ?>

<?php //echo $form->field($model, 'role')->textInput() ?>

<?php //echo $form->field($model, 'created_at')->textInput() ?>

<?php //echo $form->field($model, 'updated_at')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
            </div>

<?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
