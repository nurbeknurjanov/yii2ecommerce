<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models;

use article\models\Article;
use category\models\Category;
use comment\models\Comment;
use extended\helpers\StringHelper;
use page\models\Page;
use product\models\Product;
use user\models\User;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\web\Request;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $model_name
 * @property string $title
 * @property string $file_name
 * @property string $modelNameValues
 * @property string $modelUrl
 * @property string $modelTitle
 * @property string $dir
 * @property string $shortModelName
 * @property string $shortModelNameLower
 * @property integer $type
 * @property string $icon
 * @property string $typeText
 * @property string $uploadFolder
 * @property array $allTypeValues
 * @property string $filePath
 *
 * @property ActiveRecord $model
 */
class File extends ActiveRecord implements \file\models\interfaces\File
{
    use FileTrait {
        //getIcon as getIconTrait;
    }

    public function getModelNameValues()
    {
        return [
            Product::class=>'Product',
            Category::class=>'Category',
            Comment::class=>'Comment',
            Article::class=>'Article',
            Page::class=>'Page',
            User::class=>'User',
        ];
    }

    const TYPE_DOC = 20;
    const TYPE_AUDIO = 30;
    public $typeValues = [
        self::TYPE_DOC=>'Doc file',
        self::TYPE_AUDIO=>'Audio file',
    ];
    public function getTypeText()
    {
        return isset($this->allTypeValues[$this->type]) ? $this->allTypeValues[$this->type]:$this->type;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }
    public static function find()
    {
        return new query\FileQuery(get_called_class());
    }



    public static function create($parentModel, UploadedFile $attribute, $options=[])
    {
        /* @var $model File */
        $model = new static();
        $model->model_name=get_class($parentModel);
        $model->model_id=$parentModel->primaryKey;
        $model->fileAttribute=$attribute;
        Yii::configure($model, $options);
        if($model->save())
            return $model;
        else
            throw new Exception(Html::errorSummary($model, ['header'=>false]));
    }

    public $uploadFolder='upload';
    public function init()
    {
        $this->on(static::EVENT_BEFORE_DELETE, [$this, 'deleteFile']);
        $this->on(static::EVENT_AFTER_INSERT, [$this, 'saveFile']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'saveFile']);

        if(isset(Yii::$app->params['uploadFolder']) && Yii::$app->params['uploadFolder'])
            $this->uploadFolder = Yii::$app->params['uploadFolder'];

        //$this->baseUrl = Yii::$app->urlManagerFrontend->hostInfo.'/'.$this->uploadFolder;
        $this->baseUrl = Yii::$app->urlManagerImg->hostInfo;

        $this->path=Yii::getAlias('@frontend').'/web/'.$this->uploadFolder;
        $this->path_tmp=Yii::getAlias('@frontend').'/web/tmp';
        parent::init();
    }
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function isUrlExist($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public function copy($url, $tmpName=null)
    {
        if(!$this->isUrlExist($url))
            throw new Exception("File failed to copy. Because not found. Address is ".$url);
        if(!$tmpName)
            $tmpName = "tmp.".pathinfo($url, PATHINFO_EXTENSION);
        if(strpos($tmpName, '/')!==false){
            $tmpName = explode('/', $tmpName);
            $tmpName = $tmpName[count($tmpName)-1];
        }
        $tmp_file = $this->path_tmp.'/'.$tmpName;
        if(copy($url, $tmp_file , stream_context_create( ["ssl" => ["verify_peer"=> false, "verify_peer_name" => false]] )))
            return $tmp_file;
        else
            throw new Exception("File failed to copy.");
    }

    public static $deleteTempFile=true;
    public function saveFile()
    {
        if($this->fileAttribute){
            if(!is_dir($this->dir)){
                mkdir($this->dir);
            }

            $this->file_name = md5(rand(100,999)).'.'.$this->fileAttribute->extension;
            $this->title = $this->fileAttribute->name;
            $this->updateAttributes(['file_name'=>$this->file_name, 'title'=>$this->title,]);

            if($_FILES===[]){
                $copy = copy($this->fileAttribute->tempName, $this->dir.'/'.$this->file_name);
                unlink($this->fileAttribute->tempName);
                return $copy;
            }
            return $this->fileAttribute->saveAs($this->dir.'/'.$this->file_name, static::$deleteTempFile);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'model_name'], 'required'],
            [['file_name'], 'safe'],
            [['file_name'], 'default', 'value'=>'',],
            //[['file_name'], 'required'],
            [['model_id'], 'integer'],
            [['title'], 'default', 'value'=>'',],
            [['title'], 'safe'],
            [['type'], 'default', 'value'=>0,],
            //[['type'], 'in', 'range'=>[self::TYPE_IMAGE,self::TYPE_DOC,self::TYPE_AUDIO, ]],
            [
                'fileAttribute', 'file',
                //'skipOnEmpty'=>false,
                'maxSize'=>1024*1024*50,//50 mb
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public $labels=[];
    public function setAttributeLabel($field, $value)
    {
        $this->labels[$field]=$value;
    }
    public function attributeLabels()
    {
        $labels = [
            'fileAttribute'=>Yii::t('common', 'File'),
            'created_at'=>Yii::t('common', 'Created date'),
        ];
        return array_merge($labels, $this->labels);
    }


    /**
     * @return \yii\db\ActiveRecord
     */
    public function getModel()
    {
        return $this->hasOne($this->model_name, ['id' => 'model_id']);
    }
    public function getShortModelName()
    {
        return (new \ReflectionClass($this->model_name))->getShortName();
    }
    public function getShortModelNameLower()
    {
        return strtolower($this->shortModelName);
    }
    public function getModelUrl()
    {
        $route_view = '/'.$this->shortModelNameLower.'/'.$this->shortModelNameLower. "/view";
        if($this->model_name==User::class)
            $route_view = '/'.$this->shortModelNameLower.'/manage/index/view';
        return [$route_view,   'id'=>$this->model_id];
    }
    public function getModelTitle()
    {
        $title = 'title';
        if($this->model_name==User::class)
            $title='name';
        return $this->model->$title;
    }

    public $fileAttribute;
    public $baseUrl;
    public $path;
    public $path_tmp;

    public function getDir()
    {
        return "$this->path/".$this->shortModelNameLower."/{$this->model_id}";
    }

    public function getFileUrl()
    {
        return $this->baseUrl."/".$this->shortModelNameLower."/".$this->model_id.'/'.$this->file_name;
    }

    public function getFilePath()
    {
        return $this->dir.'/'.$this->file_name;
    }
    public function deleteFile()
    {
        if(is_file($this->dir.'/'.$this->file_name))
            unlink($this->dir.'/'.$this->file_name);
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
        ];
    }

}
