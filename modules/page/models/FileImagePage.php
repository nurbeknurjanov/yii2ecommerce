<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace page\models;

use Yii;
use yii\helpers\Html;

use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;
use file\models\FileImage;

class FileImagePage extends FileImage
{
    public $thumbSmWidth = 120;
    public $thumbSmHeight = 90;
    public $thumbMdWidth = 300;
    public $thumbMdHeight = 225;
    public $padding=false;
}