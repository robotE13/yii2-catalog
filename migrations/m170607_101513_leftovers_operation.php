<?php

use app\migrations\Migration;

class m170607_101513_leftovers_operation extends Migration
{
    public $table = "{{%leftover_operation}}";

    // NOTE!!! Use safeUp/safeDown to run migration code within a transaction

    public function up()
    {
        $this->createTable($this->table,[
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'warehouse_id' => $this->integer()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'initiator' => $this->string()->notNull(),
            'time_stamp' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()')
        ], $this->tableOptions);

        $this->createIndex("loperation_product_idx", $this->table,'product_id');
        $this->createIndex("loperation_warehouse_idx", $this->table,'warehouse_id');
        $this->createIndex("leftover_operation_idx", $this->table,['product_id','warehouse_id']);

        $this->addForeignKey('fk_loperation_product', $this->table, 'product_id', "{{%catalog_product}}", 'id', "CASCADE","CASCADE");
        $this->addForeignKey('fk_loperation_warehouse', $this->table, 'warehouse_id', "{{%catalog_warehouse}}", 'id', "CASCADE","CASCADE");
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
