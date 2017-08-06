<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use app\models\Article;
use app\models\ArticleCategoryI18n;
use app\models\Language;

/**
 * This is the model class for table "articles_categories".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property virtual string $name
 * @property virtual string $keywords
 * @property virtual string $description
 * @property string $created_at
 * @property string $updated_at
 */
class ArticleCategory extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_categories';
    }

    public function getI18n() {
        return $this->hasOne(ArticleCategoryI18n::className(), ['aticle_category_id' => 'id'])
            ->where('language_id = :language_id', [':language_id' => Language::getCurrent()->id]);
    }

    public function getName() {
        return $this->i18n->name;
    }

    public function getKeywords() {
        return $this->i18n->keywords;
    }

    public function getDescription() {
        return $this->i18n->description;
    }

    public function getArticles() {
        return $this->hasMany(Article::ClassName(), ['category_id' => 'id']);
    }

    public function getParentCategory() {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    public static function getParentsList() {
        // Вибираємо ті категорії в яких є дочірні
        $parents = ArticleCategory::find()
            ->select(['article_categories.id', 'article_categories_i18n.name'])
            ->join('JOIN', 'article_categories_i18n', 'article_categories_i18n.aticle_category_id = article_categories.id')
            ->join('JOIN', 'article_categories a', 'a.parent_id = article_categories.id')
            ->where('article_categories_i18n.language_id = :language_id', [':language_id' => Language::getCurrent()->id])
            ->distinct(true)
            ->all();

        return \yii\helpers\ArrayHelper::map($parents, 'id', 'name');
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
//            [
//                'class' => SluggableBehavior::className(),
//                'attribute' => 'name',
//                'slugAttribute' => 'alias',
//                'immutable' => true,
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['name'], 'required'],
            [['alias'], 'required'],
            [['parent_id'], 'integer'],
            //[['name'], 'trim'],
            [['created', 'modified'], 'safe'],
            //[['alias', 'name', 'keywords', 'description'], 'string', 'max' => 255],
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
            'alias' => Yii::t('app', 'Alias'),
            'parent_id' => Yii::t('app', 'Parent category'),
            'name' => Yii::t('app', 'Name'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
        ];
    }
}
