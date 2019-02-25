<?php

use yii\db\Migration;


/**
 * Class m181220_063726_add_full_text
 */
class m181220_063726_add_full_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE category ADD FULLTEXT INDEX title_index (title)");

        $this->execute("ALTER TABLE i18n_message ADD FULLTEXT INDEX translation_index (`translation`)");

        $this->execute("ALTER TABLE product ADD FULLTEXT INDEX product_title_index (title, description)");

        $this->execute("ALTER TABLE dynamic_value ADD FULLTEXT INDEX value_index (`value`)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("ALTER TABLE category DROP INDEX title_index");
        $this->execute("ALTER TABLE i18n_message DROP INDEX translation_index");

        $this->execute("ALTER TABLE product DROP INDEX product_title_index");
        $this->execute("ALTER TABLE dynamic_value DROP INDEX value_index");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181220_063726_add_full_text cannot be reverted.\n";

        return false;
    }
    */
}
