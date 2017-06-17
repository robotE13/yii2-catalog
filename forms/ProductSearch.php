<?php

namespace robote13\catalog\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use robote13\catalog\models\Product;

/**
 * ProductSearch represents the model behind the search form of `robote13\catalog\models\Product`.
 */
class ProductSearch extends Product
{
    public $kind;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'measurement_unit_id', 'status'], 'integer'],
            [['slug', 'title','kind', 'description','vendor_code'], 'string'],
            [['price'], 'number'],
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
        $query = Product::find();

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
        $dataProvider->getSort()->attributes['popularity']=[
            'asc'=>['popularity'=>SORT_ASC],
            'desc'=>['popularity'=>SORT_DESC],
            'default'=>SORT_DESC
        ];
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'measurement_unit_id' => $this->measurement_unit_id,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'vendor_code', $this->vendor_code])
            ->andFilterWhere(['like', 'description', $this->description]);

        $this->andFilterKind($query);

        return $dataProvider;
    }

    /**
     *
     * @param \robote13\catalog\models\ProductQuery $query
     */
    protected function andFilterKind(&$query)
    {
        if($this->kind)
        {
            $query->typeAlias($this->kind);
        }
    }

    public function formName()
    {
        return '';
    }
}
