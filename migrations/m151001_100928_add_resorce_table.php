<?php

use yii\db\Schema;
use yii\db\Migration;

class m151001_100928_add_resorce_table extends Migration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';

        $this->createTable('{{%resource}}', [
            'res_id' => Schema::TYPE_PK,
            'res_name' => Schema::TYPE_STRING . ' Not Null Comment \'Название\'',
            'res_active' => Schema::TYPE_SMALLINT . ' Not Null Default 1 Comment \'Активен\'',
            'res_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);

        $this->createIndex('idx_res_name', '{{%resource}}', 'res_name');

        $this->refreshCache();
    }

    public function down()
    {
        $this->dropTable('{{%resource}}');
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
