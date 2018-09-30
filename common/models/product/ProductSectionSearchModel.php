<?php

namespace common\models\product;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\product\ProductSection;

/**
 * ProductSectionSearchModel represents the model behind the search form about `backend\models\product\ProductSection`.
 */
class ProductSectionSearchModel extends ProductSection
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'depth', 'parent', 'preview_image', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'active', 'preview_text'], 'safe'],
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
        $query = ProductSection::find();

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
            'depth' => $this->depth,
            'parent' => $this->parent,
            'preview_image' => $this->preview_image,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'preview_text', $this->preview_text]);

        return $dataProvider;
    }
}
