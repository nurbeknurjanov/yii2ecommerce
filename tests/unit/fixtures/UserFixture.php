<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use user\models\User;
use yii\test\ActiveFixture;
use Yii;
use console\controllers\RbacInitController;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $forceUpdateRBAC = false;

    public function afterLoad()
    {
        parent::afterLoad();
        //Yii::$app->createControllerByID('rbac-init')->runAction('index');

        if($this->forceUpdateRBAC || !Yii::$app->authManager->getRoles())
        {
            $rbacController = new RbacInitController('rbac-init', Yii::$app);
            $rbacController->runAction('index');
        }
    }
    public function getData()
    {
        return parent::getData();
    }
}