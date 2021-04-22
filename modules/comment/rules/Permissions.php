<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace comment\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $guestRole = $auth->getRole(User::ROLE_GUEST);
        $managerRole = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $rule = new Rule;
        $auth->add($rule);
        $createComment = $auth->createPermission('createComment');
        $createComment->ruleName=$rule->name;
        $auth->add($createComment);
        $updateComment = $auth->createPermission('updateComment');
        $updateComment->ruleName=$rule->name;
        $auth->add($updateComment);
        $deleteComment = $auth->createPermission('deleteComment');
        $deleteComment->ruleName=$rule->name;
        $auth->add($deleteComment);
        $viewComment = $auth->createPermission('viewComment');
        $auth->add($viewComment);
        $indexComment = $auth->createPermission('indexComment');
        $indexComment->description = "The list of categories to manage";
        $auth->add($indexComment);
        $listComment = $auth->createPermission('listComment');
        $listComment->description = "The list of categories to view";
        $auth->add($listComment);

        $auth->addChild($guestRole, $createComment);
        $auth->addChild($guestRole, $updateComment);
        $auth->addChild($guestRole, $deleteComment);
        $auth->addChild($guestRole, $viewComment);
        $auth->addChild($guestRole, $listComment);
        $auth->addChild($managerRole, $indexComment);

    }

}