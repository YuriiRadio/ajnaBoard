<?php if (!empty($model)) { foreach ($model as $menu) { ?>
<li<?php if (Yii::$app->request->get('alias') == $menu['alias']) {echo ' class="active"';} ?>><a href="<?= yii\helpers\Url::to(['site/static', 'alias' => $menu['alias']]) ?>"><?= $menu['title'] ?></a></li>
<?php }} ?>