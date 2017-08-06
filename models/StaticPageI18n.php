<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "static_page_i18n".
 *
 * @property integer $id
 * @property integer $static_page_id
 * @property integer $language_id
 * @property string $alias
 * @property string $title
 * @property string $body
 */
class StaticPageI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_pages_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['static_page_id', 'language_id', 'title', 'body'], 'required'],
            [['language_id', 'title', 'body'], 'required'],
            [['static_page_id', 'language_id'], 'integer'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'static_page_id' => Yii::t('app', 'Static Page ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
        ];
    }
}
