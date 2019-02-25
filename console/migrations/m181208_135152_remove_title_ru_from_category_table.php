<?php

use yii\db\Migration;
use category\models\Category;


/**
 * Class m181208_135152_remove_title_ru_from_category_table
 */
class m181208_135152_remove_title_ru_from_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(Category::tableName(), 'title_ru');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn(Category::tableName(), 'title_ru', $this->string()->after('title'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181208_135152_remove_title_ru_from_category_table cannot be reverted.\n";

        return false;
    }
    */
}
