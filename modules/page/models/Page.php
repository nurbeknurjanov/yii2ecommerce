<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace page\models;

use file\models\File;
use file\models\FileImage;
use file\models\behaviours\FileImageBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property array $url
 * @property string $title_url
 * @property string $title
 * @property string $text
 * @property FileImage[] $images
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }


    public function behaviors()
    {
        return [
            [
                'class' => FileImageBehavior::class,
                'className'=>self::class,
                'loader'=>FileImagePage::class,
                'fileAttributes'=>['imagesAttribute'],
            ],
        ];
    }


    public $imagesAttribute=[];
    /**
     * @return \file\models\query\FileImageQuery
     */
    public function getImages()
    {
        return $this->hasMany(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryImages();
    }
    /**
     * @return \file\models\query\FileImageQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryMainImage();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_url', 'title'], 'required'],
            [['title_url'], 'unique'],
            ['title_url', 'match',
                'pattern' => '/^[a-z0-9_-]+$/',
                'message' => Yii::t('page', 'Url can only contain alphanumeric characters, underscores and dashes.')],
            [['text'], 'string'],
            [['text'], 'default', 'value'=>NULL],
            [['title_url', 'title'], 'default', 'value'=>''],
            [['title_url', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'title_url' => Yii::t('common', 'Url'),
            'title' => Yii::t('common', 'Title'),
            'text' => Yii::t('common', 'Text'),
            'imagesAttribute' => Yii::t('common', 'Images'),
        ];
    }

    /**
     * @inheritdoc
     * @return \page\models\query\PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \page\models\query\PageQuery(get_called_class());
    }

    public function fields()
    {
        return [
            'id',
            'title' => function ($model) {
                return $model->title;
            },
            'text',
        ];
    }
    public function extraFields()
    {
        return [
            'url' => function (self $model) {
                return Url::to($model->url);
            },
            'images' => function (self $model) {
                return $model->images;
            },
        ];
    }

    public function getUrl()
    {
        return ['/page/page/view', 'page_title_url'=>$this->title_url];
    }

}