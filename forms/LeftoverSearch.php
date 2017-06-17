<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use robote13\catalog\models\Leftover;

/**
 * Description of LeftoverSearch
 *
 * @author Tartharia
 */
class LeftoverSearch extends Model
{
    public $title;

    public $warehouse_id;

    public $vendor_code;

    public function rules()
    {
        return[
            [['warehouse_id'],'integer'],
            [['title','vendor_code'],'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('robote13/catalog', 'Title'),
            'vendor_code' => Yii::t('robote13/catalog', 'Vendor Code')
        ];
    }

    public function search($params)
    {
        $query = Leftover::find();

        // add conditions that should always apply here
        $query->joinWith(['product'=>function($query){return $query->alias('product');}]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->getSort()->attributes['vendor_code']=[
            'asc'=>['product.vendor_code'=>SORT_ASC],
            'desc'=>['product.vendor_code'=>SORT_DESC],
        ];
        $dataProvider->getSort()->attributes['title']=[
            'asc'=>['product.title'=>SORT_ASC],
            'desc'=>['product.title'=>SORT_DESC],
            'default'=>SORT_DESC
        ];

        $query->andFilterWhere([
            'warehouse_id'=> $this->warehouse_id
        ]);

        $query->andFilterWhere(['like', 'product.vendor_code', $this->vendor_code])
                ->andFilterWhere(['like', 'product.title', $this->title]);

        return $dataProvider;
    }

    public function formName()
    {
        return '';
    }
}
