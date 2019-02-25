<?php

namespace user\rules;

use Yii;
use yii\base\Exception;
use yii\rbac\Rule;
use user\models\User;


class UserRule extends Rule
{
    public $name = 'userRule';
    public function execute($userID, $item, $params)
    {
        if(!($userModel = User::findOne($userID)))
            return false;
        if(Yii::$app->user->can(User::ROLE_MANAGER))
            return true;

        $roleOrPermission=$item->name;
        switch(true){
            case $roleOrPermission == 'viewUser' || $roleOrPermission == 'deleteUser' || $roleOrPermission == 'updateUser':{
                if(!isset($params['model']))
                    throw new Exception("model parameter is missing.");
                return $params['model']->id==Yii::$app->user->id;
                break;
            }
        }
        return false;
    }
}

