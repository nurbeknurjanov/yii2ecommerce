<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


namespace shop\rules;

use extended\helpers\ArrayHelper;
use product\models\Product;
use Yii;
use yii\base\Exception;
use user\models\User;


class Rule extends \yii\rbac\Rule
{
    public $name = 'shopRule';
    public function execute($userID, $item, $params)
    {
        /* @var Product $model */
        $model=null;
        if(isset($params['model']))
            $model = $params['model'];

        if(!($userModel = User::findOne($userID)))
            return false;

        $roleOrPermission=$item->name;


        if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
            return true;

        switch(true){
            case $roleOrPermission == 'deleteShop' || $roleOrPermission == 'updateShop':{
                if(!$model)
                    throw new Exception("model parameter is missing.");
                return in_array($model->id, ArrayHelper::map($userModel->shops, 'id', 'id'));
                break;
            }
        }
        return false;
    }
}

