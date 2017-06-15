<?php

use app\migrations\Migration;

class m170615_090145_add_status_to_products_set extends Migration
{
    public $table = "{{%catalog_set}}";

    // NOTE!!! Use safeUp/safeDown to run migration code within a transaction

    public function up()
    {
        $this->addColumn($this->table, 'status', $this->smallInteger()->notNull()->defaultValue(1)->after('badge'));
    }

    public function down()
    {
        $this->dropColumn($this->table, 'status');
    }
}
