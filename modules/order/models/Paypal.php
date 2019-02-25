<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 11/6/18
 * Time: 12:00 AM
 */

namespace order\models;

use Yii;
use \PayPal\Rest\ApiContext;
use \PayPal\Auth\OAuthTokenCredential;


class Paypal
{
    public static function getApiConnection($live)
    {
        if($live){
            $apiContext = new ApiContext(
                new OAuthTokenCredential(Yii::$app->params['paypal']['live']['client_id'],Yii::$app->params['paypal']['live']['secret'])
            );
            $apiContext->setConfig(
                array(
                    'log.LogEnabled' => true,
                    'log.FileName' => Yii::getAlias('@frontend/runtime').'/PayPal.log',
                    'log.LogLevel' => 'FINE',
                    'mode' => 'live',
                )
            );
        }else{
            $apiContext = new ApiContext(
                new OAuthTokenCredential(Yii::$app->params['paypal']['sandbox']['client_id'],Yii::$app->params['paypal']['sandbox']['secret'])
            );
            $apiContext->setConfig(
                array(
                    'log.LogEnabled' => true,
                    'log.FileName' => Yii::getAlias('@frontend/runtime').'/PayPal.log',
                    'log.LogLevel' => 'FINE',
                    'mode' => 'sandbox',
                )
            );
        }
        return $apiContext;
    }
}
