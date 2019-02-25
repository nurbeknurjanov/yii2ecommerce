<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models;


use yii\base\Event;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;

class FileVideoNetwork extends File implements \file\models\interfaces\FileVideoNetwork
{
    public static function find()
    {
        return new query\FileVideoNetworkQuery(get_called_class());
    }


    public function behaviors()
    {
        $behaviours = parent::behaviors();
        return array_merge($behaviours, [
            [
                'class' => AttributeBehavior::class,
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => 'file_name',
                    self::EVENT_BEFORE_VALIDATE => 'file_name',
                ],
                'value' => function (Event $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    $model->initVideo();
                    return $model->file_name;
                },
            ],
        ]);
    }
    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [
            ['link', 'required', 'on'=>'image',],
            ['link', 'validateVideo'],
        ]);
    }

    public $link;

    const TYPE_VIDEO_YOUTUBE=50;
    const TYPE_VIDEO_VK=51;

    public $typeValues = [
        self::TYPE_VIDEO_YOUTUBE=>'Youtube',
        self::TYPE_VIDEO_VK=>'Vk.com',
    ];

    public function getImg($options=[], $containerOptions=[])
    {
        $containerOptions = $containerOptions+
            ['class'=>'video-image', 'data'=>['id'=>$this->id, 'file_name'=>$this->file_name]];
        return Html::tag("div", Html::img($this->imageUrl, $options), $containerOptions);
    }
    public function getVideo($options=['width'=>'100%', 'height'=>'100%'])
    {
        return "<iframe src='//www.youtube.com/embed/".$this->file_name."'
                        width='".$options['width']."'
                        height='".$options['height']."'
                        frameborder='0'></iframe>
                ";
    }
    public function getImageUrl()
    {
        if($this->type==self::TYPE_VIDEO_YOUTUBE)
            return "http://img.youtube.com/vi/{$this->file_name}/0.jpg";
    }
    public function initVideo()
    {
        if(preg_match('/youtube.com/', $this->link)){
            $this->link=urldecode($this->link);
            $parsed = parse_url($this->link, PHP_URL_QUERY);
            parse_str($parsed, $get_array);
            if(isset($get_array['v']))
                $this->file_name = $get_array['v'];
            if($this->file_name)
                $this->type=self::TYPE_VIDEO_YOUTUBE;
        }
        if(preg_match('/youtu.be\//', $this->link)){
            $this->link=substr($this->link, strpos($this->link, ".be/")+4);
            $this->type=self::TYPE_VIDEO_YOUTUBE;
        }

        if(preg_match('/vk.com/', $this->link)){
            $this->link=urldecode($this->link);
            $parsed = parse_url($this->link, PHP_URL_QUERY);
            parse_str($parsed, $get_array);
            if(isset($get_array['z'])){
                $id = $get_array['z'];
                $id = trim($id,'video');
                $id = trim($id,'/pl_cat_updates');
                $this->file_name = $id;
            }
            if(strpos($this->link, 'vk.com/video')!==false && strpos($this->link, 'vk.com/video?')===false)
                $this->file_name=substr($this->link, strpos($this->link, "video")+5);

            if($this->file_name)
                $this->type=self::TYPE_VIDEO_VK;
        }
    }

    public function validateVideo()
    {
        $this->initVideo();
        if($this->link && !$this->file_name)
            $this->addError('link', Yii::t('common', 'Неправильная ссылка видеосервиса.'));
    }

    public static function createVideoNetwork($parentModel, $value, $options=[])
    {
        /* @var $model File */
        $model = new static();
        $model->model_name=get_class($parentModel);
        $model->model_id=$parentModel->id;
        $model->link=$value;
        Yii::configure($model, $options);

        if($model->validate()){
            return $model->save();
        }
        else
            throw new Exception(Html::errorSummary($model, ['header'=>false]));
    }
}