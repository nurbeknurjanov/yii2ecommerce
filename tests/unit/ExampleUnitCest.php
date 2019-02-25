<?php

use user\models\User;
use product\models\Product;

class ExampleUnitCest
{

    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }


    // tests
    public function wannaSeeProduct(UnitTester $I)
    {
        Yii::$app->urlManager->showScriptName=false;
        $url = Yii::$app->urlManager->createAbsoluteUrl(['/']);
        $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/']);
        Yii::info($url);
        //$I->assertContains('Thank', $emails[0]);
        //$I->grabAttributeFrom('Thank', $emails[0]);

        //$I->seeRecord(Product::class, ['id' => 1]);
        //$I->seeRecord(User::className(), ['username' => 'admin']);

        /*Yii::$app->mailer->compose()
            ->setTo(['nurbek.nurjanov@mail.ru'=>'Nurbek Nurjanov'])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'))
            ->setHtmlBody(Yii::t('common', 'Thank you for contacting us. We will respond to you as soon as possible.'))
            ->send();*/
    }
}
