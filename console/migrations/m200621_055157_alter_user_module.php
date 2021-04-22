<?php

use yii\db\Migration;
use user\models\User;


/**
 * Class m200621_055157_alter_user_module
 */
class m200621_055157_alter_user_module extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(User::tableName(), 'language');
        $this->dropColumn(User::tableName(), 'time_zone');
        $this->dropColumn(User::tableName(), 'referrer_id');
        $this->dropColumn(User::tableName(), 'from');
        $this->addColumn(User::tableName(), 'phone', $this->string()->after('email'));

        $this->createTable('user_profile', [
            'id'=>$this->primaryKey(),
            'address'=>$this->string()->notNull(),
            'country_id'=>$this->integer()->notNull(),
            'region_id'=>$this->integer()->notNull(),
            'city_id'=>$this->integer()->notNull(),
            'zip_code'=>$this->string()->notNull(),
        ]);
        $this->addForeignKey('user_profile_id', 'user_profile', 'id',
            User::tableName(), 'id', 'RESTRICT','RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200621_055157_alter_user_module cannot be reverted.\n";

        return false;

    }


}
