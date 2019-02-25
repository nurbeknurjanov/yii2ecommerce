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
use file\models\FileVideoNetwork;
use yii\db\Expression;

class FileVideoNetworkQuery  extends FileQuery
{
    public function queryNetwork()
    {
        $this->andOnCondition(['file.type'=>[FileVideoNetwork::TYPE_VIDEO_VK, FileVideoNetwork::TYPE_VIDEO_YOUTUBE]]);
        return $this;
    }
} 