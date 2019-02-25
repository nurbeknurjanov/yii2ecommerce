<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models\behaviours;

use file\models\FileVideoNetwork;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class FileVideoNetworkBehavior extends FileBehavior
{
    public $type=FileVideoNetwork::TYPE_VIDEO_YOUTUBE;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT=>[$this->owner, 'saveFilesVideoNetwork'],
            ActiveRecord::EVENT_AFTER_UPDATE=>[$this->owner, 'saveFilesVideoNetwork'],
        ];
    }

    public function saveFilesVideoNetwork()
    {
        $model = $this->owner;
        foreach ($this->fileAttributes as $attribute)
            if($model->$attribute){
                if(is_array($model->$attribute))
                    foreach($model->$attribute as $n=>$value){
                        FileVideoNetwork::createVideoNetwork($model, $value, ['model_name'=>$this->className]);
                    }
                else{
                    if($file = FileVideoNetwork::find()
                        ->queryNetwork()
                        ->queryClassName($this->className)
                        ->queryModel($model)
                        ->one())
                        $file->delete();
                    FileVideoNetwork::createVideoNetwork($model, $model->$attribute, ['model_name'=>$this->className]);
                }
            }
    }

}