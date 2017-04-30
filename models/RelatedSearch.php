<?php

namespace robote13\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use robote13\catalog\models\RelatedProduct;

/**
 * RelatedSearch represents the model behind the search form about `robote13\catalog\models\RelatedProduct`.
 */
class RelatedSearch extends RelatedProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'related_id'], 'integer'],
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
        $query = RelatedProduct::find();

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
            'product_id' => $this->product_id,
            'related_id' => $this->related_id,
        ]);

        return $dataProvider;
    }
}
