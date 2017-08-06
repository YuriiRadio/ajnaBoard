<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use yii\web\UrlManager;
use app\models\Language;

/**
 * Description of LangUrlManager
 *
 * @author Velizar
 */
class LanguageUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if (isset($params['lang_id'])){
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = Language::findOne($params['lang_id']);
            if ($lang === null) {
                $lang = Language::getDefault();
            }
            unset($params['lang_id']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Language::getCurrent();
        }

        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        //Добавляем к URL префикс - буквенный идентификатор языка
        if ($url == '/') {
            return '/'.$lang->url;
        } else {
            return '/'.$lang->url.$url;
        }
    }
}