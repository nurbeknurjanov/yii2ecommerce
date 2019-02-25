<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace delivery;

use Yii;


class Module extends \yii\base\Module
{
    public $defaultRoute = 'delivery';
    public function init()
    {
        parent::init();
        Yii::configure(Yii::$app, require(__DIR__ . '/config/main.php'));
    }
}