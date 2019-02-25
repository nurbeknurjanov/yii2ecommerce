<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace comment\models;

use yii\helpers\Html;

use file\models\FileImage;

class FileImageComment extends FileImage
{
    public $thumbSmWidth = 120;
    public $thumbSmHeight = 90;
    public $thumbMdWidth = 300;
    public $thumbMdHeight = 225;
    public $padding = false;
}