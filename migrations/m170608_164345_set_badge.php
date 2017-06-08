<?php

use app\migrations\Migration;

class m170608_164345_set_badge extends Migration
{
    public $table = "{{%catalog_set}}";

    // NOTE!!! Use safeUp/safeDown to run migration code within a transaction

    public function up()
    {
        $this->addColumn($this->table, 'badge', $this->string()->notNull()->defaultValue('')->after('title'));
    }

    public function down()
    {
        $this->dropColumn($this->table, 'badge');
    }
}
