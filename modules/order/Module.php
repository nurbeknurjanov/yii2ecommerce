<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order;


use Yii;


class Module extends \yii\base\Module
{
    public function init()
    {
        Yii::$app->mailer->viewPath = '@order/mail';
        parent::init();
    }
}