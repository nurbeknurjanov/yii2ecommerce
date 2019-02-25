<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace product\rules;

use product\models\Product;
use Yii;
use yii\base\Exception;
use user\models\User;


class Rule extends \yii\rbac\Rule
{
    public $name = 'productRule';
    public function execute($userID, $item, $params)
    {
        /* @var Product $model */
        $model=null;
        if(isset($params['model']))
            $model = $params['model'];

        if(!($userModel = User::findOne($userID)))
            return false;

        $roleOrPermission=$item->name;

        switch(true){
            case $roleOrPermission == 'copyProduct':{
                if(!$model)
                    throw new Exception("model parameter is missing.");
                return $model->canBeParentOfGroup;
                break;
            }
            case $roleOrPermission == 'exportInstagram':{
                if(!$model)
                    throw new Exception("model parameter is missing.");
                return !$model->productNetworkInstagram && $model->images;
                break;
            }
            case $roleOrPermission == 'updateInstagram':{
                if(!$model)
                    throw new Exception("model parameter is missing.");
                return $model->productNetworkInstagram && $model->images;
                break;
            }
            case $roleOrPermission == 'updateDataInstagram':{
                if(!$model)
                    throw new Exception("model parameter is missing.");
                return $model->productNetworkInstagram;
                break;
            }
            case $roleOrPermission == 'removeInstagram':{
                if(!$model)
                    throw new Exception("model parameter is missing.");
                return $model->productNetworkInstagram;
                break;
            }
        }

        if(Yii::$app->user->can(User::ROLE_MANAGER))
            return true;

        switch(true){
            case $roleOrPermission == 'deleteProduct' || $roleOrPermission == 'updateProduct':{
                if(!$model)
                    throw new Exception("model parameter is missing.");
                return $model->user_id==$userModel->id;
                break;
            }
        }
        return false;
    }
}

