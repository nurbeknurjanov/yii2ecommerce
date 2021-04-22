<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models;


use Yii;
use yii\helpers\Html;

use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;



/**
 * FileImage model
 *
 * @property string $imageImg
 * @property string $imageUrl
*/
class FileImage extends File implements \file\models\interfaces\FileImage
{
    /**
     * @inheritdoc
     * @return \file\models\query\FileImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new query\FileImageQuery(get_called_class());
    }
    const TYPE_SINGLE_IMAGE = 10;

    const TYPE_IMAGE_MAIN = 11;
    const TYPE_IMAGE = 12;

    public $typeValues = [
        self::TYPE_SINGLE_IMAGE=>'Single image file',
        self::TYPE_IMAGE_MAIN=>'Main image file',
        self::TYPE_IMAGE=>'Image file',
    ];

    public function getThumbImg(string $thumbType, $options=[])
    {
        return Html::img($this->getThumbUrl($thumbType), $options);
    }

    public function getImageImg($options=[])
    {
        return Html::img($this->imageUrl, $options);
    }



    public function getThumbUrl(string $thumbType)
    {
        return $this->baseUrl."/".$this->shortModelNameLower.
            "/".$this->model_id.'/thumb/'.$thumbType."-".$this->file_name;
    }
    public function getImageUrl()
    {
        return parent::getFileUrl();
    }
    public $thumbXs = true;
    public $thumbSm = true;
    public $thumbMd = true;

    public $thumbXsWidth=50;
    public $thumbXsHeight=50;
    public $thumbXsQuality=60;

    public $thumbSmWidth=120;
    public $thumbSmHeight=120;
    public $thumbSmQuality=60;

    public $thumbMdWidth=400;
    public $thumbMdHeight=400;
    public $thumbMdQuality=75;

    public $imageWidth=1366;
    public $imageHeight=768;
    public $padding=true;
    public $quality=90;

    public function resizeFile()
    {
        $image = Image::getImagine();

        $image = $image->open($this->dir.'/'.$this->file_name);

        //растягивает по высоте несмотря ни на что
        //$image->resize($size->heighten(1000))->save("assets/resized.png", ['quality' => $this->quality] );

        //растягивает по ширине несмотря ни на что
        //$image->resize($size->widen(100))->save("assets/resized.png", ['quality' => $this->quality] );

        //режет лишнее
        //$image->crop(new Point(0, 0),new Box(100, 100))->save("assets/cropped.png", ['quality' => $this->quality] );

        //Устанавливает масимумы пределы сохраняя пропорции, если предел не првышается все остается так как и было
        //$image->thumbnail(new Box(1500, 1500))->save("assets/thumbnail1.png", ['quality' => $this->quality] );

        //Устанавливает масимумы пределы сохраняя пропорции, если предел не првышается все остается так как и было
        //big image
        $image->thumbnail(new Box($this->imageWidth, $this->imageHeight),
            ImageInterface::THUMBNAIL_INSET)->save($this->dir.'/'.$this->file_name );

        //thumbnails
        if($this->thumbXs || $this->thumbSm || $this->thumbMd){
            if(!is_dir($this->dir.'/thumb'))
                mkdir($this->dir.'/thumb');
        }
        //Устанавливает масимумы пределы сохраняя пропорции, если предел не првышается все остается так как и было
        if($this->thumbXs){
            $size = new Box($this->thumbXsWidth, $this->thumbXsHeight);
            $fileName = $this->dir.'/thumb/xs-'.$this->file_name;
            if($this->padding){
                $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($fileName  );
                \extended\imagine\Imagine::pad($fileName, $size);
            }else
                $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($fileName );
        }
        //Устанавливает масимумы пределы сохраняя пропорции, если предел не првышается все остается так как и было
        if($this->thumbSm){
            $size = new Box($this->thumbSmWidth, $this->thumbSmHeight);
            $fileName = $this->dir.'/thumb/sm-'.$this->file_name;
            if($this->padding){
                $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($fileName );
                \extended\imagine\Imagine::pad($fileName, $size);
            }else
                $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($fileName );
        }
        //Устанавливает масимумы пределы сохраняя пропорции, если предел не првышается все остается так как и было
        if($this->thumbMd){
            $size = new Box($this->thumbMdWidth, $this->thumbMdHeight);
            $fileName = $this->dir.'/thumb/md-'.$this->file_name;
            if($this->padding){
                $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($fileName );
                \extended\imagine\Imagine::pad($fileName, $size);
            }else
                $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($fileName );
        }
    }
    public function saveFile()
    {
        if($this->fileAttribute)
        {
            parent::saveFile();
            static::resizeFile();
            //$this->resizeFile();
        }
    }

    public function deleteFile()
    {
        if(is_file($this->dir.'/'.$this->file_name))
            unlink($this->dir.'/'.$this->file_name);
        foreach (['xs', 'sm', 'md'] as $size) {
            if(is_file($this->dir.'/thumb/'.$size.'-'.$this->file_name))
                unlink($this->dir.'/thumb/'.$size.'-'.$this->file_name);
        }
    }
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['fileAttribute'] = Yii::t('common', 'Image file');
        return array_merge($labels, $this->labels);
    }
    public function rules()
    {
        return array_merge(parent::rules() , [
            [
                'fileAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
            ],
            /*[
                'fileAttribute',  'image',
                'minWidth' => 338,
                'minHeight' => 212,
                'maxFiles'=>10,
            ],*/
        ]);
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'created_at',
            'url'=>function(){
                return $this->fileUrl;
            },
            'imageUrl'=>function(){
                return $this->imageUrl;
            },
            'thumbUrlXs'=>function(){
                return $this->getThumbUrl('xs');
            },
            'thumbUrlSm'=>function(){
                return $this->getThumbUrl('sm');
            },
            'thumbUrlMd'=>function(){
                return $this->getThumbUrl('md');
            },
        ];
    }
} 