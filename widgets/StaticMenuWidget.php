<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\StaticPage;
use app\models\StaticPageI18n;
use app\models\Language;

/**
 * Description of MainMenuWidget
 *
 * @author Velizar
 */
class StaticMenuWidget extends Widget {

    public $tpl;

    public function init() {
        parent::init();

        if ($this->tpl === null) {
            $this->tpl = 'footer_menu';
        }
    }

    public function run() {
        // Get cache
        $model = Yii::$app->cache->get($this->tpl.Language::getCurrent()->local);
        if ($model) {
            return $this->render('static_menu/'.$this->tpl, ['model' => $model]);
        }
        // Get records from Database
//        $this->model = StaticPage::find()
//             ->select(['id', 'alias', 'title'])
//             ->where(['menu_position' => $this->tpl, 'status' => 1])
//             ->asArray()
//             ->all();

        $model = StaticPage::find()
            ->innerJoin(StaticPageI18n::tableName(), '`'.StaticPageI18n::tableName().'`.`static_page_id` = `'.StaticPage::tableName().'`.`id`')
            ->select([
                StaticPage::tableName().'.id',
                StaticPage::tableName().'.alias',
                StaticPageI18n::tableName().'.title',
                //StaticPageI18n::tableName().'.body',
                //StaticPage::tableName().'.created_at',
                //StaticPage::tableName().'.updated_at'
             ])
            ->where('((`menu_position` = :menu_position) AND (`status` = :status) AND (`language_id` = :language_id))')
            ->addParams([':menu_position' => $this->tpl])
            ->addParams([':status' => StaticPage::STATUS_ACTIVE])
            ->addParams([':language_id' => Language::getCurrent()->id])
            ->asArray()
            ->all();
        // Set cache
        Yii::$app->cache->set($this->tpl.Language::getCurrent()->local, $model, Yii::$app->setting->get('TIME_CACHE_MENU'));
        return $this->render('static_menu/'.$this->tpl, ['model' => $model]);
    }
}