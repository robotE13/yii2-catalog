<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%leftover_operation}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $warehouse_id
 * @property int $type
 * @property int $quantity
 * @property string $initiator
 * @property string $time_stamp
 *
 * @property Product $product
 * @property Warehouse $warehouse
 */
class LeftoverOperation extends \yii\db\ActiveRecord
{
    const TYPE_INCOME = 1;
    const TYPE_EXPENSE = 2;
    const TYPE_RESERVATION = 3;
    const TYPE_CANCEL_RESERVATION = 4;
    const TYPE_WRITE_OFF = 5;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%leftover_operation}}';
    }

    public function behaviors()
    {
        return [
            'textField'=>[
                'class'=> \robote13\yii2components\behaviors\TextStatusBehavior::className(),
                'attributes'=>[
                    'type' => self::getTypes()
                ]
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity', 'initiator'], 'required'],
            [['type','quantity'], 'integer'],
            ['type','in','range'=> array_keys(self::getTypes())],
            [['initiator'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }

    public function init()
    {
        parent::init();
        if($this->isNewRecord)
        {
            $this->initiator = \Yii::$app->user->isGuest ? 'buyer' : Yii::$app->user->identity->username;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('robote13/catalog', 'ID'),
            'product_id' => Yii::t('robote13/catalog', 'Product ID'),
            'warehouse_id' => Yii::t('robote13/catalog', 'Warehouse ID'),
            'type' => Yii::t('robote13/catalog', 'Type'),
            'quantity' => Yii::t('robote13/catalog', 'Quantity'),
            'initiator' => Yii::t('robote13/catalog', 'Initiator'),
            'time_stamp' => Yii::t('robote13/catalog', 'Time Stamp'),
        ];
    }

    public static function getTypes()
    {
        return [
            self::TYPE_INCOME => Yii::t('robote13/catalog', 'Operation_income'),
            self::TYPE_EXPENSE => Yii::t('robote13/catalog', 'Operation_expense'),
            self::TYPE_RESERVATION => Yii::t('robote13/catalog', 'Operation_reservation'),
            self::TYPE_CANCEL_RESERVATION => Yii::t('robote13/catalog', 'Operation_cancel'),
            self::TYPE_WRITE_OFF => Yii::t('robote13/catalog', 'Operation_write_off')
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
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->ensureLeftover();
        $condition = ['warehouse_id'=> $this->warehouse_id,'product_id'=> $this->product_id];
        switch ($this->type)
        {
            case static::TYPE_INCOME:
                Leftover::updateAllCounters(['left_in_stock'=> $this->quantity],$condition);
                break;

            default:
                break;
        }
    }

    private function ensureLeftover()
    {
        $model = Yii::createObject([
            'class' => Leftover::className(),
            'warehouse_id'=> $this->warehouse_id,
            'product_id'=> $this->product_id
        ]);
        $validator = \yii\validators\Validator::createValidator('exist', $model,['warehouse_id','product_id']);
        if(!$validator->validateAttributes($model))
        {
            $model->save(false);
        }
    }

}
