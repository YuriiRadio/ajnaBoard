<?php

/**
 * Description of SettingComponent
 *
 * @author Velizar
 * 07.11.2016

    Підключити компонент до проекту
    'components'=>array(

       // ...

       'config'=>array(
           'class'=>'DConfig',
           'cache'=>3600,
       ),
    ),

    Доступ до одного налаштування
    Yii::$app->setting->get('PARAM_NAME');

    Цей компонент має методи add() и delete() для додавання і видалення параметрів.
    Цими методами можно передавати як один параметр:

    Yii::$app->setting->add([
        'param'=>'BLOG.POSTS_PER_PAGE',
        'label'=>'Записей на странице',
        'value'=>'10',
        'type'=>'string',
        'default'=>'10',
    ]);

    Yii::$app->setting->delete('BLOG.POSTS_PER_PAGE');

    так і масив:

    Yii::$app->setting->add([
        [
            'param'=>'BLOG.POSTS_PER_PAGE',
            'label'=>'Записей на странице',
            'value'=>'10',
            'type'=>'string',
            'default'=>'10',
        ],
        [
            'param'=>'BLOG.POSTS_PER_HOME',
            'label'=>'Записей на главной странице',
            'value'=>'5',
            'type'=>'string',
            'default'=>'5',
        ],
    ]);

    Yii::$app->setting->delete([
        'BLOG.POSTS_PER_PAGE',
        'BLOG.POSTS_PER_HOME',
    ]);
 *
 */

namespace app\components;

use Yii;
use yii\base\Component;
# Підключаємо модель налаштувань
use app\models\Setting;
use yii\base\Exception;


class SettingComponent extends Component {

    public $cache = 0;
    public $dependency = null;
    protected $data = [];

    public function init() {
        parent::init();

        if ($this->cache) { # Якщо ввімкнуто кешування > 0, то повертаємо обєкт із кешу
            $items = Yii::$app->db->cache(function ($db) {
                $result = $db->createCommand('SELECT * FROM `settings`')->queryAll();
                return $result;
            }, $this->cache, $this->dependency);
        } else {
            $items = Yii::$app->db->createCommand('SELECT * FROM `settings`')->queryAll();
        }

        foreach ($items as $item) {
            if ($item['param']) {
                $this->data[$item['param']] = $item['value'] === '' ? $item['default'] : $item['value'];
            }
        }
    }

    public function get($key) {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            throw new Exception(Yii::t('app', 'Undefined parameter'). ' - ' . $key);
        }
    }

    public function set($key, $value) {
        $model = Setting::findOne(['param' => $key]);
        if (!$model) {
            throw new Exception(Yii::t('app', 'Undefined parameter'). ' - ' . $key);
        }

        $model->value = $value;

        if ($model->save()) {
            $this->data[$key] = $value;
        }
    }

    public function add($params) {
        if (isset($params[0]) && is_array($params[0])) {
            foreach ($params as $item) {
                $this->createParameter($item);
            }
        } elseif ($params) {
            $this->createParameter($params);
        }
    }

    public function delete($key) {
        if (is_array($key)) {
            foreach ($key as $item) {
                $this->removeParameter($item);
            }
        } elseif ($key) {
            $this->removeParameter($key);
        }
    }

    protected function createParameter($param) {
        if (!empty($param['param'])) {
            $model = Setting::findOne(['param' => $param['param']]);
            # Якщо параметра не існує виконуємо INSERT, створюємо новий обєкт моделі
            if ($model === null) {
                $model = new Setting();
            }
            # Якщо параметр існує виконуємо UPDATE
            $model->param = $param['param'];
            $model->label = isset($param['label']) ? $param['label'] : $param['param'];
            $model->value = isset($param['value']) ? $param['value'] : '';
            $model->default = isset($param['default']) ? $param['default'] : '';
            $model->type = isset($param['type']) ? $param['type'] : 'string';
            $model->save();
        }
    }

    protected function removeParameter($key) {
        if (!empty($key)) {
            $model = Setting::findOne(['param' => $key]);
            if ($model) {
                $model->delete();
            }
        }
    }

}