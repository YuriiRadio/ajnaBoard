<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\widgets;

use Yii;
use yii\base\Widget;
//use app\modules\admin\models\Regions;

/**
 * Description of MenuWidget
 *
 * @author Velizar
 */
class RegionMenuWidget extends Widget {

    public $tpl = 'site_region_menu';
    // admin_region_select - no cache
    // admin_region_select_parent - no cache
    // site_region_menu - site advert cetogories menu
    // user_region_select

    public $model;
    public $cache;

    public function init() {
        parent::init();

        $this->cache = Yii::$app->setting->get('TIME_CACHE_MENU');
    }

    public function run() {
        // get cache and return menu
        if ($this->tpl == 'site_region_menu' || $this->tpl == 'user_region_select') {
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
        if ($this->tpl == 'site_region_menu' || $this->tpl == 'user_region_select') {
            Yii::$app->cache->set($this->tpl, $menu, $this->cache);
        }

        return $menu;
    }

    protected function getSqlCommand() {
        return 'SELECT `id`, `alias`, `parent_id`, `name` FROM `regions`';
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
        include(__DIR__ . '/region_menu_tpl/' . $this->tpl . '.php');
        return ob_get_clean();
    }

}