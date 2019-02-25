<?php
namespace Group;

use \Codeception\Event\TestEvent;
use user\models\User;
use Yii;
use \Codeception\Events;
/**
 * Group class is Codeception Extension which is allowed to handle to all internal events.
 * This class itself can be used to listen events for test execution of one particular group.
 * It may be especially useful to create fixtures data, prepare server, etc.
 *
 * INSTALLATION:
 *
 * To use this group extension, include it to "extensions" option of global Codeception config.
 */



class Moder extends \Codeception\Platform\Group
{
    public static $group = 'moder';

    public function _before(TestEvent $e)
    {

        $this->writeln('inserting additional admin users...');

        /*$user = new User();
        $user->save();*/
        $db = $this->getModule('Db');
        $db->haveInDatabase('user', [
            'username' => 'new',
            'email' => 'new@mail.ru',
            'name' => 'new',
            'institution_id' => 15,
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        /*$id = $e->getTest()->tester->haveRecord(User::className(), [
            'username' => 'new',
            'email' => 'new@mail.ru',
            'name' => 'new',
            'institution_id' => 15,
            'status' => User::STATUS_ACTIVE,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);*/
    }

    public function _after(TestEvent $e)
    {
        $this->writeln('cleaning up admin users...');
    }
}
