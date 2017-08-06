<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\widgets;

use yii\base\Widget;

/**
 * Description of CarouselWidget
 *
 * @author Velizar
 */
class CarouselWidget extends Widget {

    public $tpl = 'bootstrap_carousel';

    public function init() {
        //parent::init();
//        if ($this->tpl === NULL) {
//            $this->tpl = 'bootstrap_carousel';
//        }
    }

    public function run() {
        return $this->carouselToTemplate();
    }

    protected function carouselToTemplate() {
        ob_start();
        include(__DIR__ . '/carousel_tpl/' . $this->tpl . '.php');
        return ob_get_clean();
    }

}
