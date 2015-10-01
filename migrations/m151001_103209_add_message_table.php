<?php

use yii\db\Schema;
use yii\db\Migration;

class m151001_103209_add_message_table extends Migration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';

        $this->createTable('{{%topic}}', [
            'tpc_id' => Schema::TYPE_PK,
            'tpc_resource' => Schema::TYPE_INTEGER . ' Not Null Comment \'Ресурс\'',
            'tpc_level' => Schema::TYPE_INTEGER . ' Not Null Default 0 Comment \'Уровень\'',
            'tpc_lft' => Schema::TYPE_INTEGER . ' Not Null',
            'tpc_rgt' => Schema::TYPE_INTEGER . ' Not Null',
            'tpc_title' => Schema::TYPE_STRING . ' Not Null Comment \'Название\'',
            'tpc_text' => Schema::TYPE_TEXT . ' Not Null Comment \'Текст\'',
            'tpc_active' => Schema::TYPE_SMALLINT . ' Not Null Default 1 Comment \'Активен\'',
            'tpc_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
            'tpc_updated' => Schema::TYPE_DATETIME . ' Not Null Comment \'Изменен\'',
        ], $tableOptionsMyISAM);

        $this->createIndex('idx_tpc_resource', '{{%topic}}', 'tpc_resource');
        $this->createIndex('idx_tpc_lft', '{{%topic}}', 'tpc_lft');
        $this->createIndex('idx_tpc_rgt', '{{%topic}}', 'tpc_rgt');

        $this->refreshCache();
    }

    public function down()
    {
        $this->dropTable('{{%topic}}');
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
