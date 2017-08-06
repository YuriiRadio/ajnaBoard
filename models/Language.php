<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property string $timeZone
 * @property integer $created_at
 * @property integer $updated_at
 */
class Language extends ActiveRecord
{
    // Змінна, для зберігання поточного обєкту мови
    static $current = null;
    // Для картинки мови
    public $flagImage;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'name', 'timeZone', 'created_at', 'updated_at'], 'required'],
            [['default', 'created_at', 'updated_at'], 'integer'],
            [['url', 'local', 'name', 'timeZone', 'flag'], 'string', 'max' => 255],
            [['flagImage'], 'file', 'extensions' => 'png, jpg, gif, bmp', 'maxSize' => 1024*10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'local' => Yii::t('app', 'Local'),
            'name' => Yii::t('app', 'Name'),
            'default' => Yii::t('app', 'Default'),
            'timeZone' => Yii::t('app', 'Time Zone'),
            'flag' => Yii::t('app', 'Flag'),
            'flagImage' => Yii::t('app', 'Flag Image'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
        ];
    }

    //Получение текущего объекта языка
    public static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefault();
        }
        return self::$current;
    }

    // Встановлення поточного обєкта мови і локалі системи
    public static function setCurrent($url = null)
    {
        if (!preg_match("/^[a-z]{2}$/", $url)) {
            self::$current = self::getDefault();
        } else {
            $language = self::getByUrl($url);
            if ($language === null) {
                self::$current = self::getDefault();
            } else {
                self::$current = $language;
            }
        }
        Yii::$app->language = self::$current->local;
    }

    // Отримання обєкту мови по замовчуванню
    public static function getDefault()
    {
        $language = Yii::$app->cache->get('defaultLanguage');
        if ($language) { return $language; }

        $language = Language::find()->where('`default` = :default', [':default' => 1])->one();
        Yii::$app->cache->set('defaultLanguage', $language, Yii::$app->setting->get('TIME_CACHE_MENU'));
        return $language;
    }

    // Отримання обєкту мови по буквеному ідентифікатору
    public static function getByUrl($url = null)
    {
        if ($url === null) {
            return null;
        } else {
            $language = Yii::$app->cache->get('getByUrlLanguage'.$url);
            if ($language) { return $language; }

            $language = Language::find()->where('url = :url', [':url' => $url])->one();
            if ( $language === null ) {
                return null;
            }else{
                Yii::$app->cache->set('getByUrlLanguage'.$url, $language, Yii::$app->setting->get('TIME_CACHE_MENU'));
                return $language;
            }
        }
    }
}
