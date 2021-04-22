<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace shop\models;

use yii\helpers\Html;

use file\models\FileImage;

class FileImageShop extends FileImage
{
    public $thumbSmWidth = 120;
    public $thumbSmHeight = 120;
    public $thumbMdWidth = 300;
    public $thumbMdHeight = 300;
}