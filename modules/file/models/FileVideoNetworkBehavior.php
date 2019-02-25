<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models;

use yii\base\Event;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class FileVideoNetworkBehavior extends FileBehavior
{
    public function initBehaviour()
    {
        if(!$this->className)
            $this->className = $this->owner->className();
    }


    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT=>[$this->owner, 'initBehaviour'],
            ActiveRecord::EVENT_AFTER_INSERT=>[$this->owner, 'saveFilesVideoNetwork'],
            ActiveRecord::EVENT_AFTER_UPDATE=>function(Event $event){
                $model = $event->sender;
                $model->saveFilesVideoNetwork();
            },
        ];
    }

    public function saveFilesVideoNetwork()
    {
        $model = $this->owner;
        foreach ($this->attributes as $attribute)
            if($model->$attribute)
            {
                if(is_array($model->$attribute))
                    foreach($model->$attribute as $n=>$value){
                        FileVideoNetwork::createVideoNetwork($model, $value, ['model_name'=>$this->className]);
                    }
                else{
                    if($file = File::find()->queryModel($this->className)->queryModelId($model->id)->queryType([FileVideoNetwork::TYPE_VIDEO_YOUTUBE, FileVideoNetwork::TYPE_VIDEO_VK])->one())
                        $file->delete();
                    FileVideoNetwork::createVideoNetwork($model, $model->$attribute, ['model_name'=>$this->className]);
                }
            }
    }

}