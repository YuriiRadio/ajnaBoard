<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Advert;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "advert_categories".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $parent_id
 * @property string $name
 * @property string $keywords
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class AdvertCategory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'advert_categories';
    }

    public function getAdverts() {
        return $this->hasMany(Advert::ClassName(), ['category_id' => 'id']);
    }

    public function getParentCategory() {
        return $this->hasOne(AdvertCategory::className(), ['id' => 'parent_id']);
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'trim'],
            [['created_at', 'updated_at'], 'safe'],
            [['alias', 'name', 'keywords', 'description'], 'string', 'max' => 255],
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
            'alias' => Yii::t('app', 'Alias'),
            'parent_id' => Yii::t('app', 'Parent category'),
            'name' => Yii::t('app', 'Name'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'updated'),
        ];
    }
}
