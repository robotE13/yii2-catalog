<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%catalog_warehouse}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 *
 * @property Leftover[] $leftovers
 * @property Product[] $products
 */
class Warehouse extends \yii\db\ActiveRecord
{

    use \robote13\yii2components\traits\DropdownItemsTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_warehouse}}';
    }

    public function init()
    {
        $this->attachInvalidate();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('robote13/catalog', 'ID'),
            'title' => Yii::t('robote13/catalog', 'Title'),
            'description' => Yii::t('robote13/catalog', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeftovers()
    {
        return $this->hasMany(Leftover::className(), ['warehouse_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('warehouseProducts');
    }
}
