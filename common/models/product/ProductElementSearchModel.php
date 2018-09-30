<?php

namespace common\models\product;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\product\ProductElement;

/**
 * ProductElementSearchModel represents the model behind the search form about `common\models\product\ProductElement`.
 */
class ProductElementSearchModel extends ProductElement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'section_id', 'user_id', 'preview_picture', 'detail_picture', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'active', 'preview_text', 'detail_text'], 'safe'],
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
        $query = ProductElement::find();

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
            'section_id' => $this->section_id,
            'user_id' => $this->user_id,
            'preview_picture' => $this->preview_picture,
            'detail_picture' => $this->detail_picture,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'preview_text', $this->preview_text])
            ->andFilterWhere(['like', 'detail_text', $this->detail_text]);

        return $dataProvider;
    }
}
