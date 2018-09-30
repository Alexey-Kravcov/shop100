<?php

namespace common\models\cell;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cell\CellItem;

/**
 * CellItemSearch represents the model behind the search form about `common\models\cell\CellItem`.
 */
class CellItemSearch extends CellItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'sort', 'cell_type_id', 'searchable', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'section_name', 'sections_name', 'element_name', 'elements_name'], 'safe'],
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
        // dump($params);
        $query = CellItem::find()->andFilterWhere(['cell_type_id' => $params['id']])->orderBy('sort');

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
            'active' => $this->active,
            'sort' => $this->sort,
            'cell_type_id' => $this->cell_type_id,
            'searchable' => $this->searchable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'section_name', $this->section_name])
            ->andFilterWhere(['like', 'sections_name', $this->sections_name])
            ->andFilterWhere(['like', 'element_name', $this->element_name])
            ->andFilterWhere(['like', 'elements_name', $this->elements_name]);

        return $dataProvider;
    }
}
