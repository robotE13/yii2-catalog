<?php

use yii\db\Migration;

class m171017_095922_add_enumerable_column extends Migration
{
    public $table = '{{%type_characteristic}}';

    // NOTE!!! Use safeUp/safeDown to run migration code within a transaction

    public function up()
    {
        $this->addColumn($this->table,'items', $this->text()->null()->defaultValue(null)->after('data_type'));
    }

    public function down()
    {
        $this->dropColumn($this->table, 'items');
    }
}
