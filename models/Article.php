<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\ArticleCategory;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $category_id
 * @property string $title
 * @property string $body
 * @property string $keywords
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    public function getArticleCategory() {
        return $this->hasOne(ArticleCategory::ClassName(), ['id' => 'category_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'category_id'], 'required'],
            [['body'], 'string'],
            [['status', 'category_id', 'view'], 'integer'],
            [['created_at', 'updated_at', 'view'], 'safe'],
            [['title', 'keywords', 'description'], 'string', 'max' => 255],
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
            'category_id' => Yii::t('app', 'Category ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
        ];
    }
}
