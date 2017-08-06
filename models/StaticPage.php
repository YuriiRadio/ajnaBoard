<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\models\Language;
use app\models\StaticPageI18n;

/**
 * This is the model class for table "site_pages".
 *
 * @property integer $id
 * @property integer $status
 * @property string $alias
 * @property string $title
 * @property string $body
 * @property string $menu_position
 * @property string $created_at
 * @property string $updated_at
 */
class StaticPage extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_pages';
    }

    // Інтернаціоналізація - поточна мова
    public function getI18n()
    {
        return $this->hasOne(StaticPageI18n::className(), ['static_page_id' => 'id'])
            ->where('language_id = :language_id', [':language_id' => Language::getCurrent()->id]);
    }

    public function getTitle()
    {
        return $this->i18n->title;
    }

    public function getBody()
    {
        return $this->i18n->body;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'menu_position'], 'required'],
            [['status'], 'integer'],
            //[['body', 'menu_position'], 'string'],
            [['menu_position'], 'string'],
            //[['alias', 'title', 'body'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            //[['alias', 'title'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'alias' => Yii::t('app', 'Alias'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'menu_position' => 'Menu Position',
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
        ];
    }
}
