<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace order\rules;

use order\models\OrderLocal;
use Yii;
use yii\base\Exception;
use user\models\User;
use yii\helpers\ArrayHelper;


class Rule extends \yii\rbac\Rule
{
    public $name = 'orderRule';
    public function execute($userID, $item, $params)
    {
        if(Yii::$app->user->can(User::ROLE_MANAGER))
            return true;

        $userModel = User::findOne($userID);

        $roleOrPermission=$item->name;
        switch(true){
            case $roleOrPermission == 'viewOrder':{
                if(!isset($params['model']))
                    throw new Exception("model parameter is missing.");
                $order = $params['model'];
                if($userModel && $order->user_id==$userModel->id)
                    return true;
                return in_array($order->id, ArrayHelper::map(OrderLocal::findAll(), 'id', 'id'));
                break;
            }
        }
        return false;
    }
}
