<?php

use robote13\yii2components\migrations\Migration;

class m170430_165536_related_products extends Migration
{
    public $table = "{{%related_product}}";

    public $productTable = "{{%catalog_product}}";

    public function up()
    {
        $this->createTable($this->table,[
            'product_id'=> $this->integer()->notNull(),
            'related_id'=> $this->integer()->notNull()
        ], $this->tableOptions);

        $this->addPrimaryKey('', $this->table,['product_id','related_id']);
        $this->createIndex('product_vertex_idx', $this->table,'product_id');
        $this->createIndex('related_product_vertex_idx', $this->table,'related_id');
        $this->addForeignKey('product_vertex', $this->table, 'product_id', $this->productTable, 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('related_product_vertex', $this->table, 'related_id', $this->productTable, 'id', "CASCADE", "CASCADE");
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
