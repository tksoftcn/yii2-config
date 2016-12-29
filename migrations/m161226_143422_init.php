<?php
//namespace tksoft\config\migrations;

use yii\db\Schema;
use tksoft\config\migrations\Migration;
//use Yii;

/**
 * migration script
 *
 * @author tongke
 *        
 */
class m161226_143422_init extends Migration
{

    public function up()
    {
        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(255)->notNull(),
            'key' => $this->string(32)->notNull(),
            'value' => $this->text(),
            'catid' => $this->integer(11)->defaultValue(0),
            'type' => $this->string(32)->notNull(),
            'isrequired' => $this->smallInteger(1)->defaultValue(0),
            'min' => $this->smallInteger(1)->defaultValue(0),
            'max' => $this->smallInteger(1)->defaultValue(0),
            'data' => $this->text(),
            'rule' => $this->string(32)->null(),
            'displayorder' => $this->integer(11)->defaultValue(0),
            'remark' => $this->string(255)->null(),
            'created_at' => $this->integer(10)->defaultValue(0),
            'updated_at' => $this->integer(10)->defaultValue(0),
            'created_by' => $this->integer(11)->defaultValue(0),
            'updated_by' => $this->integer(11)->defaultValue(0)
        ], $this->tableOptions);
        
        $this->createIndex('config_key', '{{%config}}', 'key', true);
        
        $this->createTable('{{%config_category}}', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(255)->notNull(),
            'status' => $this->smallInteger(1)->defaultValue(1),
            'remark' => $this->string(32)->null(),
            'displayorder' => $this->integer(11)->defaultValue(0),
            'created_at' => $this->integer(10)->defaultValue(0),
            'updated_at' => $this->integer(10)->defaultValue(0),
            'created_by' => $this->integer(11)->defaultValue(0),
            'updated_by' => $this->integer(11)->defaultValue(0)
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%config}}');
        $this->dropTable('{{%config_category}}');
    }
}
