<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
mihaildev\elfinder\Assets::noConflict($this);

?>

<div class="static-page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->checkbox([ '0', '1']) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
        foreach ($i18nMessages as $index => $i18nMessage) {
            echo $form->field($i18nMessage, "[$index]title")
                      ->textInput(['maxlength' => true, 'class' => 'form-inline'])
                      ->label(Yii::t('app', 'Title').': '.Html::img('@web/images/flagicons/'.$languages[$i18nMessage->language_id]['flag']).' '.$languages[$i18nMessage->language_id]['name']);
        }
    ?>

    <?php #echo $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?php
//        echo $form->field($model, 'body')->widget(CKEditor::className(), [
//            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
//                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
//                'inline' => false,
//            ])
//        ]);
    ?>

    <div>
        <!-- Навігація -->
        <ul class="nav nav-tabs">
            <?php $flagActive = true; foreach ($i18nMessages as $index => $i18nMessage): ?>
            <li<?php if ($flagActive) { echo ' class="active"'; } ?>><a href="#<?= $i18nMessage->language_id ?>" data-toggle="tab"><?= Html::img('@web/images/flagicons/'.$languages[$i18nMessage->language_id]['flag']).' '.$languages[$i18nMessage->language_id]['name']; ?></a></li>
            <?php $flagActive = false; endforeach; ?>
        </ul>
        <!-- Вміст вкладок -->
        <div class="tab-content">
            <?php $flagActive = true; foreach ($i18nMessages as $index => $i18nMessage): ?>
                <div class="tab-pane<?php if ($flagActive) { echo ' active'; } ?>" id="<?= $i18nMessage->language_id ?>">
                    <?php
                        echo $form->field($i18nMessage, "[$index]body")->widget(CKEditor::className(), [
                            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                'inline' => false,
                            ])
                        ]);
                    ?>
                </div>
            <?php $flagActive = false; endforeach; ?>
        </div>
    </div>

    <?= $form->field($model, 'menu_position')->dropDownList([ 'footer_menu' => 'Footer menu', 'header_menu' => 'Header menu', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
