<?php

/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace favorite\rules;

use favorite\models\Favorite;
use favorite\models\FavoriteLocal;
use Yii;
use yii\base\Exception;
use user\models\User;


class Rule extends \yii\rbac\Rule
{
    public $name = 'favoriteRule';
    public function execute($userID, $item, $params)
    {
        $roleOrPermission=$item->name;
        switch(true){
            case $roleOrPermission == 'createFavorite':{

                if(!isset($params['object']))//object is product
                    throw new Exception("object parameter is missing.");
                $productObject = $params['object'];

                return !in_array($productObject::className().'|'.$productObject->id, array_keys(FavoriteLocal::findAll()));
                /*if(array_key_exists('favoriteModel', $params))
                    return $params['favoriteModel']===null;*/
                break;
            }

            case $roleOrPermission == 'deleteFavorite':{

                if(!isset($params['object']))//object is product
                    throw new Exception("object parameter is missing.");
                $productObject = $params['object'];


                return in_array($productObject::className().'|'.$productObject->id, array_keys(FavoriteLocal::findAll()));

                /*$favoriteModel = Favorite::find()->modelQuery($object->id)->me()->one();
                    if($favoriteModel)
                        return $favoriteModel->author_id==Yii::$app->user->id;*/
                break;
            }
        }
        return false;
    }
}
