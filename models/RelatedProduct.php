<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%related_product}}".
 *
 * @property int $product_id
 * @property int $related_id
 *
 * @property Product $product
 * @property Product $related
 */
class RelatedProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%related_product}}';
    }

    public function transactions()
    {
        return[
            self::SCENARIO_DEFAULT=>self::OP_INSERT|self::OP_DELETE
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['related_id','required'],
            ['related_id','unique','targetAttribute'=>['product_id','related_id']],
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['related_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => ['related_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'related_id' => 'Related ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelated()
    {
        return $this->hasOne(Product::className(), ['id' => 'related_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->db->createCommand()->insert(self::tableName(),[
            'product_id'=> $this->related_id,
            'related_id'=>$this->product_id
        ])->execute();
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        self::deleteAll(['product_id'=> $this->related_id,'related_id'=> $this->product_id]);
        parent::afterDelete();
    }
}
