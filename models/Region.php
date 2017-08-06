<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Advert;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "regions".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $alias
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Region extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'regions';
    }

    public function getAdverts() {
        return $this->hasMany(Advert::ClassName(), ['category_id' => 'id']);
    }

    public function getParentRegion() {
        return $this->hasOne(Region::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
            [['parent_id', 'name'], 'required'],
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
            [['alias', 'name'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['alias', 'name'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent category'),
            'alias' => Yii::t('app', 'Alias'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
        ];
    }
}
