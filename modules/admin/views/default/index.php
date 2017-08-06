<div class="admin-default-index">
    <h1>Admin panel</h1>
    <p>
        <b>$this->context->action->uniqueId:</b> <code><?= $this->context->action->uniqueId ?></code><br />
        <b>$this->context->action->id:</b><code><?= $this->context->action->id ?></code><br />
        <b>get_class($this->context):</b><code><?= get_class($this->context) ?></code><br />
        <b>$this->context->module->id:</b><code><?= $this->context->module->id ?></code><br />
        <b>Yii::$app->user->identity->role:</b><code><?= Yii::$app->user->identity->role ?></code><br />
        <b>Yii::$app->setting->get('TIME_CACHE_MENU'):</b><code><?php echo Yii::$app->setting->get('TIME_CACHE_MENU') ?></code>

        <?php
//            Yii::$app->settings->add([
//        'param'=>'TIME_CACHE_MENU',
//        'label'=>'Записей на странице',
//        'value'=>'60',
//        'type'=>'string',
//        'default'=>'3600',
//    ]);
        ?>
    </p>
</div>
