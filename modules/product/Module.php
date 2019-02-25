<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product;

use Yii;
use yii\web\View;


class Module extends \yii\base\Module
{
    public $defaultRoute = 'product';
    public function init()
    {
        parent::init();

        /*$this->modules = [
            'manage' => [
                'class' => 'category\modules\manage\Module',
            ],
        ];*/
    }
}