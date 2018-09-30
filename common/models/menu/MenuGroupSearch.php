<?php

namespace common\models\menu;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\menu\MenuGroup;

/**
 * MenuItemSearch represents the model behind the search form about `common\models\menu\MenuItem`.
 */
class MenuGroupSearch extends MenuGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['sort'], 'integer'],
            [['name', 'code', 'css_class', 'link'], 'string', 'max' => 32],
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
        $query = MenuGroup::find();

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
            'name' => $this->name,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'css_class', $this->css_class])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'sort', $this->sort]);

        return $dataProvider;
    }
}
