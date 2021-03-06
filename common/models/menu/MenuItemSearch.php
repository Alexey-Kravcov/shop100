<?php

namespace common\models\menu;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\menu\MenuItem;

/**
 * MenuItemSearch represents the model behind the search form about `common\models\menu\MenuItem`.
 */
class MenuItemSearch extends MenuItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'sort'], 'integer'],
            [['name', 'code', 'css_class', 'attributes'], 'safe'],
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
        $query = MenuItem::find();

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
            'parent' => $this->parent,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'css_class', $this->css_class])
            ->andFilterWhere(['like', 'attributes', $this->attributes]);

        return $dataProvider;
    }
}
