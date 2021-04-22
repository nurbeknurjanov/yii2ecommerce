<?php

namespace user\rules;

use extended\helpers\ArrayHelper;
use shop\models\UserShop;
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
        if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
            return true;

        $roleOrPermission=$item->name;
        switch(true){
            case $roleOrPermission == 'viewUser' || $roleOrPermission == 'deleteUser' || $roleOrPermission == 'updateUser':{
                if(!isset($params['model']))
                    throw new Exception("model parameter is missing.");
                if($params['model']->id==Yii::$app->user->id)
                    return true;

                if(Yii::$app->authManager->checkAccess($userID, User::ROLE_MANAGER)){
                    $shops_id = ArrayHelper::map(Yii::$app->user->identity->userShops, 'shop_id','shop_id');
                    return  UserShop::find(['shop_id'=>$shops_id, 'user_id'=>$params['model']->id]);
                }

                break;
            }
        }
        return false;
    }
}

