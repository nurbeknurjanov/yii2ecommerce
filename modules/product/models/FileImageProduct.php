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
    public $thumbXsWidth=40;
    public $thumbXsHeight=54;
    public $thumbSmWidth=184;
    public $thumbSmHeight=250;
    public $thumbMdWidth=398;
    public $thumbMdHeight=540;

    public $imageWidth=1200;
    public $imageHeight=1200;
    public $padding=true;
    public $quality=90;
}