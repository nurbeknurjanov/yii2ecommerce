<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace country\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $managerRole = $auth->getRole(User::ROLE_MANAGER);


        $createCountry = $auth->createPermission('createCountry');
        $auth->add($createCountry);
        $updateCountry = $auth->createPermission('updateCountry');
        $auth->add($updateCountry);
        $deleteCountry = $auth->createPermission('deleteCountry');
        $auth->add($deleteCountry);
        $viewCountry = $auth->createPermission('viewCountry');
        $auth->add($viewCountry);
        $indexCountry = $auth->createPermission('indexCountry');
        $indexCountry->description = "The list of countries to manage";
        $auth->add($indexCountry);

        $auth->addChild($managerRole, $createCountry);
        $auth->addChild($managerRole, $updateCountry);
        $auth->addChild($managerRole, $deleteCountry);
        $auth->addChild($managerRole, $viewCountry);
        $auth->addChild($managerRole, $indexCountry);


        $createRegion = $auth->createPermission('createRegion');
        $auth->add($createRegion);
        $updateRegion = $auth->createPermission('updateRegion');
        $auth->add($updateRegion);
        $deleteRegion = $auth->createPermission('deleteRegion');
        $auth->add($deleteRegion);
        $viewRegion = $auth->createPermission('viewRegion');
        $auth->add($viewRegion);
        $indexRegion = $auth->createPermission('indexRegion');
        $indexRegion->description = "The list of regions to manage";
        $auth->add($indexRegion);

        $auth->addChild($managerRole, $createRegion);
        $auth->addChild($managerRole, $updateRegion);
        $auth->addChild($managerRole, $deleteRegion);
        $auth->addChild($managerRole, $viewRegion);
        $auth->addChild($managerRole, $indexRegion);


        $createCity = $auth->createPermission('createCity');
        $auth->add($createCity);
        $updateCity = $auth->createPermission('updateCity');
        $auth->add($updateCity);
        $deleteCity = $auth->createPermission('deleteCity');
        $auth->add($deleteCity);
        $viewCity = $auth->createPermission('viewCity');
        $auth->add($viewCity);
        $indexCity = $auth->createPermission('indexCity');
        $indexCity->description = "The list of city to manage";
        $auth->add($indexCity);

        $auth->addChild($managerRole, $createCity);
        $auth->addChild($managerRole, $updateCity);
        $auth->addChild($managerRole, $deleteCity);
        $auth->addChild($managerRole, $viewCity);
        $auth->addChild($managerRole, $indexCity);

    }

}