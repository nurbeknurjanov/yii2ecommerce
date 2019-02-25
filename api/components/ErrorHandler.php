<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace api\components;


use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\Request;
use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler
{

    /**
     * @inheridoc
     */
    protected function renderException($exception)
    {
        if (Yii::$app->has('response'))
            $response = Yii::$app->getResponse();
        else
            $response = new Response();

        $response->data = $this->convertExceptionToArray($exception);

        if(isset($exception->statusCode)){
            $response->setStatusCode($exception->statusCode, $exception->getMessage());
        }else{
            $response->setStatusCode(/*$exception->getCode()*/400, $exception->getMessage());
        }
        $response->format = Response::FORMAT_JSON;
        $response->send();
    }

    protected function convertExceptionToArray($exception)
    {
        return  [];
    }
}