<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StaticPage;

/**
 * StaticPageSearch represents the model behind the search form about `app\models\StaticPage`.
 */
class StaticPageSearch extends StaticPage
{
    public $title;
    public $body;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'id'], 'integer'],
            [['alias', 'title', 'body', 'menu_position', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //$query = StaticPage::find();
        $query = StaticPage::find()->joinWith('i18n');
        //$query = StaticPage::find()->with('i18n');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'menu_position', $this->menu_position]);

        return $dataProvider;
    }
}
