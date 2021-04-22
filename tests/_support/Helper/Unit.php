<?php
namespace Helper;

use Yii;
use yii\web\Request;
use user\models\User;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
{

    public function mockUrlManagerImg()
    {
        Yii::$app->set('urlManagerImg', [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'hostInfo' => YII_ENV_TEST_PROD ? 'https://img.sakuracommerce.com':'http://img.yourdomain.com',
        ]);
    }
    public function mockUser()
    {
        Yii::$app->user->setIdentity(User::find()->one());
    }
    public function mockRequest()
    {
        $request = /*$this->make*/\Codeception\Stub::make(Request::class, [
            //'getUserIP' => Expected::never(),//nikogda ne budet vizivatsya
            //'getUserIP' => Expected::atLeastOnce('john')
            'getUserIP' => function() {
                return 'some ip';
            }
        ]);
        /*$this->mockApplication([
            'components' => [
                'request' => [
                    'class' => 'yii\web\Request',
                    'enableCsrfValidation' => true,
                    'cookieValidationKey' => 'key',
                ],
                'response' => [
                    'class' => 'yii\web\Response',
                ],
            ],
        ]);*/

        $request->cookieValidationKey='123123';
        $request->baseUrl = Yii::$app->request->baseUrl;
        $request->scriptUrl = Yii::$app->request->scriptUrl;
        $request->url='/';

        Yii::$app->set('request', $request);
    }
}
