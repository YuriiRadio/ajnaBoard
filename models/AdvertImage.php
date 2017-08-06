<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advert_images".
 *
 * @property integer $id
 * @property integer $advert_id
 * @property integer $is_main
 * @property string $img_src
 * @property string $img_src_thumb
 * @property string $img_alt
 */
class AdvertImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert_images';
    }

    public function getAdvert() {
        return $this->hasOne('app\models\Advert', ['id' => 'advert_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advert_id', 'is_main', 'img_src', 'img_src_thumb'], 'required'],
            [['advert_id', 'is_main'], 'integer'],
            [['img_src', 'img_src_thumb'], 'string', 'max' => 50],
            [['img_alt'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'advert_id' => Yii::t('app', 'Advert ID'),
            'is_main' => Yii::t('app', 'Is Main'),
            'img_src' => Yii::t('app', 'Img Src'),
            'img_src_thumb' => Yii::t('app', 'Img Src Thumb'),
            'img_alt' => Yii::t('app', 'Img Alt'),
        ];
    }
}
