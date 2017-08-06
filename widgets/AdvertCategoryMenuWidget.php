<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\widgets;

use Yii;
use yii\base\Widget;
//use app\modules\admin\models\AdvertCategory;

/**
 * Description of MenuWidget
 *
 * @author Velizar
 */
class AdvertCategoryMenuWidget extends Widget {

    public $tpl = 'sidebar_advert_cat_menu';
    // site_advert_cat_menu - site advert cetogories menu
    // sidebar_advert_cat_menu - sitebar advert cetogories menu
    // user_advert_cat_select
    // admin_advert_cat_select - no cache
    // admin_advert_cat_select_parent - no cache

    public $model;
    public $cache;

    public function init() {
        parent::init();

        $this->cache = Yii::$app->setting->get('TIME_CACHE_MENU');
    }

    public function run() {
        // get cache and return menu
        if ($this->tpl == 'site_advert_cat_menu' || $this->tpl == 'sidebar_advert_cat_menu' || $this->tpl == 'user_advert_cat_select') {
            $menu = Yii::$app->cache->get($this->tpl);
            if ($menu) { return $menu; }
        }

        // if no cache - get data
        $query = $this->getSqlCommand();
        $data = Yii::$app->db->createCommand($query)->queryAll();
        $category = [];
        while ($temp = each($data)) { # Індексуємо по id
            $category[$temp['value']['id']] = $temp['value'];
        }
        $tree = $this->getTree($category);
        $menu = $this->getMenuHtml($tree);

        // set cache
        if ($this->tpl == 'site_advert_cat_menu' || $this->tpl == 'sidebar_advert_cat_menu' || $this->tpl == 'user_advert_cat_select') {
            Yii::$app->cache->set($this->tpl, $menu, $this->cache);
        }

        return $menu;
    }

    protected function getSqlCommand() {
        if ($this->tpl == 'sidebar_advert_cat_menu') {
            return 'SELECT `id`, `alias`, `parent_id`, `name` FROM `advert_categories` WHERE `parent_id` = 0';
        } else {
            return 'SELECT `id`, `alias`, `parent_id`, `name` FROM `advert_categories`';
        }
    }

    protected function getTree($data) {
        $tree = [];
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) { // if (parent_id == 0)
                $tree[$id] = &$node;
            }
            else {
                $data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '') {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category, $tab);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab) {
        ob_start();
        include(__DIR__ . '/advert_cat_menu_tpl/' . $this->tpl . '.php');
        return ob_get_clean();
    }

}