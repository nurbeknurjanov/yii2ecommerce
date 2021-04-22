<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@tests', dirname(dirname(__DIR__)) . '/tests');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@landing', dirname(dirname(__DIR__)) . '/landing');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@extended', dirname(dirname(__DIR__)) . '/extended');
Yii::setAlias('@themes', dirname(dirname(__DIR__)) . '/themes');

//standard sakura modules
//Yii::setAlias('@sakura', dirname(dirname(__DIR__)) . '/modules/sakura');
Yii::setAlias('@sakura', dirname(dirname(__DIR__)) . '/modules');

Yii::setAlias('@mii', '@sakura/mii');
Yii::setAlias('@i18n', '@sakura/i18n');
Yii::setAlias('@user', '@sakura/user');
Yii::setAlias('@file', '@sakura/file');
Yii::setAlias('@rbac', '@sakura/rbac');
Yii::setAlias('@product', '@sakura/product');
Yii::setAlias('@eav', '@sakura/eav');
Yii::setAlias('@category', '@sakura/category');
Yii::setAlias('@favorite', '@sakura/favorite');
Yii::setAlias('@order', '@sakura/order');
Yii::setAlias('@page', '@sakura/page');
Yii::setAlias('@article', '@sakura/article');
Yii::setAlias('@tag', '@sakura/tag');
Yii::setAlias('@comment', '@sakura/comment');
Yii::setAlias('@country', '@sakura/country');
Yii::setAlias('@like', '@sakura/like');
Yii::setAlias('@shop', '@sakura/shop');