<?php
use yii\helpers\Url;

$I = new ApiTester($scenario);
$I->wantTo('test an API');
//$I->amHttpAuthenticated('service_user', '123456');
//$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
//$I->sendPOST('/index2', ['name' => 'davert', 'email' => 'davert@codeception.com']);
$I->sendGET(Url::to('/test-api'));
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();
$I->seeResponseContains('{"qwe":"asd"}');
$I->seeResponseContainsJson([
    'qwe' => 'asd'
]);