<?= "\t\t\t\t" ?><li<?php if ($category['parent_id'] == 0) { echo ' class="first_level"'; }?>>
<?= "\t\t\t\t\t" ?><a href="<?php echo yii\helpers\Url::to(['advert-categories/view', 'id' => $category['id']]) ?>"><?php if ($category['parent_id'] == 0) { echo '<b>'; }; echo $category['name']; if ($category['parent_id'] == 0) { echo '</b>'; }; ?>
<?php if( isset($category['childs']) ): ?>
<!--<span class="badge pull-right">+</span>--><?php endif; ?></a>
<?php if( isset($category['childs']) ): ?>
<?= "\t\t\t\t" ?><ul>
<?= $this->getMenuHtml($category['childs']) ?>
<?= "\t\t\t\t" ?></ul>
<?php endif; ?>
<?= "\t\t\t\t" ?></li><?= "\n" ?>