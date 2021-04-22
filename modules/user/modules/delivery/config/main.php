<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */


return [
    'components'=>[
        'cronMailer' => [
            'class' => 'delivery\CronMailer',
            'viewPath' => '@user/mail'
        ],
    ],
    'params'=>array_merge(Yii::$app->params , [
    ]),
];

