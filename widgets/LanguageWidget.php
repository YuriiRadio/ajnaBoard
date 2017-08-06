<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\widgets;

use app\models\Language;
use yii\base\Widget;

/**
 * Description of LanguageWidget
 *
 * @author Velizar
 */
class LanguageWidget extends Widget {

    public function init() {}

    public function run() {
        return $this->render('language/view', [
            'current' => Language::getCurrent(),
            'languages' => Language::find()->where('id != :current_id', [':current_id' => Language::getCurrent()->id])->all(),
        ]);
    }

}
