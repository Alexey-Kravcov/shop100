<?php

namespace common\models\product;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\product\ProductProperty;

/**
 * ProductPropertySearchModel represents the model behind the search form about `common\models\product\ProductProperty`.
 */
class ProductPropertySearchModel extends ProductProperty
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort'], 'integer'],
            [['name', 'code', 'active', 'default_value', 'property_type', 'implement', 'multiple', 'filtrable', 'required', 'description'], 'safe'],
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
        $query = ProductProperty::find();

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
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'default_value', $this->default_value])
            ->andFilterWhere(['like', 'property_type', $this->property_type])
            ->andFilterWhere(['like', 'implement', $this->implement])
            ->andFilterWhere(['like', 'multiple', $this->multiple])
            ->andFilterWhere(['like', 'filtrable', $this->filtrable])
            ->andFilterWhere(['like', 'required', $this->required])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
