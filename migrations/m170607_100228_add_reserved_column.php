<?php

use yii\db\Migration;

class m170607_100228_add_reserved_column extends Migration
{
    public $table = "{{%leftover}}";

    public function up()
    {
        $this->alterColumn($this->table, 'left_in_stock', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn($this->table, 'reserved', $this->integer()->notNull()->defaultValue(0)->after('left_in_stock'));
    }

    public function down()
    {
        $this->dropColumn($this->table,'reserved');
        $this->alterColumn($this->table, 'left_in_stock', $this->integer()->null());
    }
}
