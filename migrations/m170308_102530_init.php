<?php

use robote13\yii2components\migrations\Migration;

class m170308_102530_init extends Migration
{
    public function up()
    {
        // Categories
        $this->createTable("{{%catalog_category}}",[
            'id'=> $this->primaryKey(),
            'slug_index'=> $this->char(32)->notNull(),
            'slug'=> $this->string()->notNull(),
            'title'=> $this->string()->notNull(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull()
        ], $this->tableOptions);
        $this->createIndex("category_slug_idx","{{%catalog_category}}",['slug_index'],true);

        // Warehouses
        $this->createTable("{{%catalog_warehouse}}",[
            'id'=> $this->primaryKey(),
            'title'=> $this->string()->notNull(),
            'description'=> $this->text()->notNull()->defaultValue('')
        ], $this->tableOptions);

        // Goods sets
        $this->createTable("{{%catalog_set}}", [
            'id'=> $this->primaryKey(),
            'slug_index'=> $this->char(32)->notNull(),
            'slug'=> $this->string()->notNull(),
            'title'=> $this->string()->notNull(),
            'description' => $this->text()->notNull()->defaultValue(''),
            'discount_amount' => $this->decimal(10,2)->notNull()
        ], $this->tableOptions);
        $this->createIndex("set_slug_idx","{{%catalog_set}}",['slug_index'],true);

        //Product types
        $this->createTable("{{%product_type}}", [
            'id'=> $this->primaryKey(),
            'title'=> $this->string()->notNull(),
            'table'=> $this->string()->notNull()
        ], $this->tableOptions);

        // Measurement units
        $this->createTable("{{%measurement_unit}}", [
            'id'=> $this->primaryKey(),
            'title'=> $this->string()->notNull()
        ], $this->tableOptions);

        // Shop products
        $this->createTable("{{%catalog_product}}", [
            'id'=> $this->primaryKey(),
            'type_id'=> $this->integer()->notNull(),//fk_product_type_idx
            'slug_index'=> $this->char(32)->notNull(),
            'slug'=> $this->string()->notNull(),
            'title'=> $this->string()->notNull(),
            'description' => $this->text()->notNull()->defaultValue(''),
            'measurement_unit_id' => $this->integer()->notNull(),//'fk_product_measurement_unit_idx'
            'origin_country' => $this->char(2)->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'status' => $this->integer()->notNull(),
        ], $this->tableOptions);
        $this->createIndex("product_slug_idx","{{%catalog_product}}",['slug_index'],true);
        $this->createIndex('fk_product_type_idx', "{{%catalog_product}}", 'type_id');
        $this->addForeignKey('fk_product_type', "{{%catalog_product}}", 'type_id', "{{%product_type}}", 'id', 'RESTRICT', 'CASCADE');
        $this->createIndex('fk_product_measurement_unit_idx', "{{%catalog_product}}", 'measurement_unit_id');
        $this->addForeignKey('fk_product_measurement_unit', "{{%catalog_product}}", 'measurement_unit_id', "{{%measurement_unit}}", 'id', 'RESTRICT', 'CASCADE');

        // Type characteristics
        $this->createTable("{{%type_characteristic}}", [
            'id' => $this->primaryKey(),
            'attribute' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
            'data_type' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull()
        ], $this->tableOptions);
        $this->createIndex('fk_characteristic_type_idx', "{{%type_characteristic}}", ['type_id','attribute'],true);
        $this->addForeignKey('fk_characteristic_type', "{{%type_characteristic}}", 'type_id', "{{%product_type}}", 'id', 'CASCADE', 'CASCADE');

        // Product <--> Warehouses
        $this->createTable("{{%warehouse_product}}", [
            'warehouse_id'=> $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'left_in_stok' => $this->integer()->null()
        ], $this->tableOptions);
        $this->addPrimaryKey('', "{{%warehouse_product}}",['warehouse_id','product_id']);
        $this->createIndex('fk_warehouse_product_idx', "{{%warehouse_product}}", 'warehouse_id');
        $this->createIndex('fk_product_warehouse_idx', "{{%warehouse_product}}", 'product_id');
        $this->addForeignKey('warehouse_product', "{{%warehouse_product}}", 'warehouse_id', "{{%catalog_warehouse}}", 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('product_warehouse', "{{%warehouse_product}}", 'product_id', "{{%catalog_product}}", 'id', 'CASCADE', 'CASCADE');

        // Product <--> Categories
        $this->createTable("{{%category_product}}", [
            'category_id'=> $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ], $this->tableOptions);
        $this->addPrimaryKey('', "{{%category_product}}",['category_id','product_id']);
        $this->createIndex('fk_category_product_idx', "{{%category_product}}", 'category_id');
        $this->createIndex('fk_product_category_idx', "{{%category_product}}", 'product_id');
        $this->addForeignKey('category_product', "{{%category_product}}", 'category_id', "{{%catalog_category}}", 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('product_category', "{{%category_product}}", 'product_id', "{{%catalog_product}}", 'id', 'CASCADE', 'CASCADE');

        // Product <--> Sets
        $this->createTable("{{%set_product}}", [
            'set_id'=> $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ], $this->tableOptions);
        $this->addPrimaryKey('', "{{%set_product}}",['set_id','product_id']);
        $this->createIndex('fk_set_product_idx', "{{%set_product}}", 'set_id');
        $this->createIndex('fk_product_set_idx', "{{%set_product}}", 'product_id');
        $this->addForeignKey('set_product', "{{%set_product}}", 'set_id', "{{%catalog_set}}", 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('product_set', "{{%set_product}}", 'product_id', "{{%catalog_product}}", 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable("{{%set_product}}");
        $this->dropTable("{{%category_product}}");
        $this->dropTable("{{%warehouse_product}}");
        $this->dropTable("{{%type_characteristic}}");
        $this->dropTable("{{%catalog_product}}");
        $this->dropTable("{{%measurement_unit}}");
        $this->dropTable("{{%product_type}}");
        $this->dropTable("{{%catalog_set}}");
        $this->dropTable("{{%catalog_warehouse}}");
        $this->dropTable("{{%catalog_category}}");
    }
}