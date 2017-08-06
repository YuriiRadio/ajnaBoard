<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\helpers\Url;

$this->title = Yii::t('app', 'Login');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Please fill out the following fields to login:'); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <div class="text-muted">
                    <?php echo Yii::t('app', 'If you forgot your password you can').' '; echo Html::a(Yii::t('app', 'reset it'), ['site/request-password-reset']); ?>.
                </div>

                <div class="text-muted">
                    <?php echo Yii::t('app', 'If you have not account you can create new').' '; echo Html::a(Yii::t('app', 'account'), ['site/signup']) ?>.
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
