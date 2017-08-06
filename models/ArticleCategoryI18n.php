<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_categories_i18n".
 *
 * @property integer $id
 * @property integer $language_id
 * @property integer $aticle_category_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 */
class ArticleCategoryI18n extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_categories_i18n';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['aticle_category_id', 'name'], 'required'],
            [['name'], 'required'],
            [['language_id', 'aticle_category_id'], 'integer'],
            [['name', 'keywords', 'description'], 'trim'],
            [['name', 'keywords', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'aticle_category_id' => Yii::t('app', 'Aticle Category ID'),
            'name' => Yii::t('app', 'Name'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
