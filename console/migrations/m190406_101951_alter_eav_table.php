<?php

use yii\db\Migration;
use eav\models\DynamicField;

/**
 * Class m190406_101951_alter_eav_table
 */
class m190406_101951_alter_eav_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(DynamicField::tableName(), 'rule', $this->text()->null());
        $this->alterColumn(DynamicField::tableName(), 'default_value', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(DynamicField::tableName(), 'rule', $this->text()->notNull());
        $this->alterColumn(DynamicField::tableName(), 'default_value', $this->text()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190406_101951_alter_eav_table cannot be reverted.\n";

        return false;
    }
    */
}
