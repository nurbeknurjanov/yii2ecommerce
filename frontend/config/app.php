<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 8/12/19
 * Time: 2:23 PM
 */


Yii::$container->set(\frontend\assets\FrontendAppAsset::class, [
    'js' => [
        'dist/build.js?'.rand(1000,9999),
    ],
]);

return [
    'id'=>'app-frontend-app',
    'components' => [
    ],
];