<?php

use yii\db\Schema;
use yii\db\Migration;

class m151001_122637_add_parent_id_to_topic extends Migration
{
    public function up()
    {
        $this->addColumn('{{%topic}}', 'tpc_parent_id', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
        $this->refreshCache();
    }

    public function down()
    {
        $this->dropColumn('{{%topic}}', 'tpc_parent_id');
        $this->refreshCache();
    }

    public function refreshCache()
    {
        Yii::$app->db->schema->refresh();
        Yii::$app->db->schema->getTableSchemas();
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
