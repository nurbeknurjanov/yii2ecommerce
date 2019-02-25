<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models;

use yii\helpers\Html;

use file\models\FileImage;

class FileImageProduct extends FileImage
{
    public $thumbXs = true;
    public $thumbSm = true;
    public $thumbMd = true;
    public $thumbXsWidth=50;
    public $thumbXsHeight=50;
    public $thumbSmWidth=120;
    public $thumbSmHeight=120;
    public $thumbMdWidth=400;
    public $thumbMdHeight=400;

    public $imageWidth=1200;
    public $imageHeight=1200;
    public $padding=true;
    public $quality=90;
}