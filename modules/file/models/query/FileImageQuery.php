<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models\query;
use file\models\File;
use file\models\FileImage;
use yii\db\Expression;

class FileImageQuery  extends FileQuery
{
    public function queryImage()
    {
        $this->andOnCondition(['file.type'=>FileImage::TYPE_SINGLE_IMAGE,]);
        return $this;
    }
    public function queryMainImage()
    {
        $this->andOnCondition(['file.type'=>FileImage::TYPE_IMAGE_MAIN,]);
        return $this;
    }
    public function queryImages()
    {
        $this->andOnCondition(['file.type'=>[FileImage::TYPE_IMAGE_MAIN, FileImage::TYPE_IMAGE],])
            ->orderBy(new Expression("FIELD(file.type,".FileImage::TYPE_IMAGE_MAIN.",".FileImage::TYPE_IMAGE.")"));
        return $this;
    }
} 