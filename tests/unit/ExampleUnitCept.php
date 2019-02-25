<?php
use user\models\User;
//$scenario->group(array('moder'));
$I = new UnitTester($scenario);
$I->wantTo('perform actions and see result');
$I->assertTrue(true);
//$I->seeRecord(User::className(), ['username' => 'admin']);
