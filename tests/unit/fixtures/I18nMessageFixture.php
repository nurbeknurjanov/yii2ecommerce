<?php

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */
namespace tests\unit\fixtures;

use i18n\models\I18nMessage;
use yii\test\ActiveFixture;

class I18nMessageFixture extends ActiveFixture
{
    public $modelClass = I18nMessage::class;
}