<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use file\models\File;
use yii\test\ActiveFixture;
use Yii;
use extended\helpers\Helper;

class FileFixture extends ActiveFixture
{
    public $modelClass = File::class;

    public $depends = [PageFixture::class,
        UserFixture::class,
        CommentFixture::class,
        ProductFixture::class
    ];

    public function beforeLoad()
    {
        parent::beforeLoad();
        Helper::emptydir(Yii::getAlias('@frontend/web/upload/article'));
        Helper::emptydir(Yii::getAlias('@frontend/web/upload/user'));
        Helper::emptydir(Yii::getAlias('@frontend/web/upload/page'));
        Helper::emptydir(Yii::getAlias('@frontend/web/upload/comment'));
        Helper::emptydir(Yii::getAlias('@frontend/web/upload/product'));
        Helper::emptydir(Yii::getAlias('@frontend/web/upload/category'));
        Helper::emptydir(Yii::getAlias('@frontend/web/upload/shop'));
    }
    public function afterLoad()
    {
        parent::afterLoad();
        Helper::copyr(__DIR__.'/files/article', Yii::getAlias('@frontend/web/upload/article'));
        Helper::copyr(__DIR__.'/files/user', Yii::getAlias('@frontend/web/upload/user'));
        Helper::copyr(__DIR__.'/files/page', Yii::getAlias('@frontend/web/upload/page'));
        Helper::copyr(__DIR__.'/files/comment', Yii::getAlias('@frontend/web/upload/comment'));
        Helper::copyr(__DIR__.'/files/product', Yii::getAlias('@frontend/web/upload/product'));
        Helper::copyr(__DIR__.'/files/category', Yii::getAlias('@frontend/web/upload/category'));
        Helper::copyr(__DIR__.'/files/shop', Yii::getAlias('@frontend/web/upload/shop'));
    }
}