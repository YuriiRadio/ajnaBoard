<?= "\t\t\t\t" ?><li>
<?= "\t\t\t\t\t" ?><a href="<?php echo yii\helpers\Url::to(['article-category/view', 'id' => $category['id']]) ?>"><?php if ($category['parent_id'] == 0) { echo '<b>'; }; echo $category['name']; if ($category['parent_id'] == 0) { echo '</b>'; }; ?>
<?php if( isset($category['childs']) ): ?>
<!--<span class="badge pull-right">+</span>--><?php endif; ?></a>
<?php if( isset($category['childs']) ): ?>
<?= "\t\t\t\t" ?><ul>
<?= $this->getMenuHtml($category['childs']) ?>
<?= "\t\t\t\t" ?></ul>
<?php endif; ?>
<?= "\t\t\t\t" ?></li><?= "\n" ?>