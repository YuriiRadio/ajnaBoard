<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\models\Region;
use app\models\AdvertCategory;
use app\models\AdvertImage;

/**
 * This is the model class for table "adverts".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type_id
 * @property integer $category_id
 * @property integer $user_id
 * @property integer $region_id
 * @property string $title
 * @property string $body
 * @property integer $end_publication
 * @property integer $created_at
 * @property integer $updated_at
 */
class Advert extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $imageFiles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adverts';
    }

    public function getAdvertCategory() {
        return $this->hasOne(AdvertCategory::ClassName(), ['id' => 'category_id']);
    }

    public function getRegion() {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getType() {
        return $this->hasOne('app\models\AdvertType', ['id' => 'type_id']);
    }

    public function getUser() {
        return $this->hasOne('app\models\User', ['id' => 'user_id']);
    }

    public function getImages() {
        return $this->hasMany('app\models\AdvertImage', ['advert_id' => 'id']);
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
            [['status', 'type_id', 'category_id', 'region_id'], 'required'],
            [['status', 'type_id', 'category_id', 'region_id', 'user_id', 'view'], 'integer'],
            [['body'], 'string'],
            [['title', 'body'], 'trim'],
            [['title'], 'string', 'max' => 255],
            [['created_at', 'updated_at', 'end_publication', 'view'], 'safe'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, bmp', 'maxSize' => 1024*1024*2, 'maxFiles' => 5]
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
            'type_id' => Yii::t('app', 'Advert type'),
            'category_id' => Yii::t('app', 'Advert category'),
            'region_id' => Yii::t('app', 'Region'),
            'user_id' => Yii::t('app', 'User'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'end_publication' => Yii::t('app', 'End publication'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'imageFiles' => Yii::t('app', 'Image files'),
        ];
    }

    public function getMainImage($advert_id = null) {
        $model = AdvertImage::findOne(['advert_id' => $advert_id, 'is_main' => 1]);
        if (count($model) == 0) {
            $model = new AdvertImage();
            $model->img_src = 'no-image.png';
            $model->img_src_thumb = 'no-image.png';
            $model->img_alt = 'no image';
        }
        return $model;
    }

}