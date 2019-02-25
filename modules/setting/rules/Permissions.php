<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace setting\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $createSetting = $auth->createPermission('createSetting');
        $auth->add($createSetting);
        $updateSetting = $auth->createPermission('updateSetting');
        $auth->add($updateSetting);
        $deleteSetting = $auth->createPermission('deleteSetting');
        $auth->add($deleteSetting);
        $viewSetting = $auth->createPermission('viewSetting');
        $auth->add($viewSetting);
        $indexSetting = $auth->createPermission('indexSetting');
        $indexSetting->description = "The list of Settings to manage";
        $auth->add($indexSetting);

        $auth->addChild($administrator, $createSetting);
        $auth->addChild($administrator, $updateSetting);
        $auth->addChild($administrator, $deleteSetting);
        $auth->addChild($administrator, $viewSetting);
        $auth->addChild($administrator, $indexSetting);

    }

}