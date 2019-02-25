<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace article\models;

use extended\behaviours\ManyToManyBehaviour;
use file\models\File;
use file\models\FileImage;
use file\models\behaviours\FileImageBehavior;
use file\models\FileVideoNetwork;
use file\models\behaviours\FileVideoNetworkBehavior;
use tag\models\ObjectTag;
use tag\models\Tag;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\AfterSaveEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $title
 * @property integer $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property array $tags
 * @property string $tagsText
 * @property array $articleTags
 * @property FileVideoNetwork $video
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT => 'type',
                ],
                'value' => self::TYPE_ARTICLE,
            ],
            'images'=>[
                'class' => FileImageBehavior::class,
                'className'=>self::class,
                'loader'=>FileImageArticle::class,
                'fileAttributes'=>['imagesAttribute'],
            ],
            'videoNetwork'=>[
                'class' => FileVideoNetworkBehavior::class,
                'className'=>self::class,
                'fileAttributes'=>['videoAttribute'],
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_FIELDS_OF_MANY_TO_MANY => 'tagsAttribute',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    $model = $event->sender;
                    $model->tagsAttribute = ArrayHelper::map($model->tags, 'id', 'id');
                    $model->attachBehavior('tagsAttributeBehavior', [
                        'class' => ManyToManyBehaviour::class,
                        'manyAttribute'=>'tagsAttribute',
                        'manyAttributeOldValue'=>$model->tagsAttribute,
                        'saveFunction'=>'saveArticleTags',
                    ]);
                    return $model->tagsAttribute;
                },
            ],
        ];
    }
    const EVENT_INIT_FIELDS_OF_MANY_TO_MANY='EVENT_INIT_FIELDS_OF_MANY_TO_MANY';
    public $videoAttribute;
    public $imagesAttribute=[];

    /*public function saveFiles()
    {
        $model = $this;
        foreach (['imagesAttribute'] as $attribute)
            if($model->$attribute)
            {
                if(is_array($model->$attribute))
                    foreach($model->$attribute as $n=>$uploadedFile){
                        $type = FileImage::TYPE_IMAGE;
                        if($n==0 && !FileImage::find()->queryClassName(self::class)->queryModel($model)
                                ->queryMainImage()->exists())
                            $type = FileImage::TYPE_IMAGE_MAIN;
                        FileImage::create($model, $uploadedFile, ['type'=>$type, 'model_name'=>self::class,
                            'thumbSmWidth'=>120,'thumbSmHeight'=>90,
                            'thumbMdWidth'=>300,'thumbMdHeight'=>225,
                            'padding'=>false,]);
                    }
                else{
                    if($file = FileImage::find()->queryClassName(self::class)->queryModel($model)
                        ->queryImage()->one())
                        $file->delete();
                    FileImage::create($model, $model->$attribute, ['type'=>FileImage::TYPE_SINGLE_IMAGE,
                        'model_name'=>self::class,
                        'thumbSmWidth'=>120,'thumbSmHeight'=>90,
                        'thumbMdWidth'=>300,'thumbMdHeight'=>225,
                        'padding'=>false,]);
                }
            }
    }*/

    /**
     * @return \file\models\query\FileQuery
     */
    public function getImages()
    {
        return $this->hasMany(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryImages();
    }
    /**
     * @return \file\models\query\FileQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryMainImage();
    }

    const TYPE_ARTICLE = 1;
    const TYPE_NEWS = 2;
    public function init()
    {
        parent::init();


        $this->typeValues = [
            self::TYPE_ARTICLE=>Yii::t('article', 'Article'),
            self::TYPE_NEWS=>Yii::t('article', 'News'),
        ];


    }





    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['title', 'text', 'type'], 'required'],
            [['type'], 'default', 'value'=>NULL],
            [['title', 'text'], 'default', 'value'=>0],
            [['tagsAttribute'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['videoAttribute'], 'validateVideo'],
        ];
    }
    public $tagsAttribute=[];
    public function attributes()
    {
        $attributes = parent::attributes();
        $attributes[] = 'tagsAttribute';
        return $attributes;
    }

    public function saveArticleTags()
    {
        $elementsToDelete = array_diff((array) $this->getOldAttribute('tagsAttribute'), (array) $this->tagsAttribute);
        if($elementsToDelete){
            ObjectTag::deleteAll(['model_id'=>$this->id, 'model_name'=>self::class, 'tag_id'=>$elementsToDelete]);
            /*$toDeleteRecords = ObjectTag::find()
                ->andWhere(['model_id'=>$this->id, 'model_name'=>self::class])
                ->andWhere(['tag_id'=>$elementsToDelete])
                ->all();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($toDeleteRecords as $record)
                    $record->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }*/
        }

        if($this->tagsAttribute){
            if(is_array($this->tagsAttribute)){
                foreach ($this->tagsAttribute as $tag_id)
                    ObjectTag::createIfNotExists(self::class,$this->id, $tag_id);
            }
            else
                ObjectTag::createIfNotExists(self::class,$this->id, $this->tagsAttribute);
        }
    }
    public function getArticleTags()
    {
        return $this->hasMany(ObjectTag::class, ['model_id'=>'id'])->andOnCondition(['model_name'=>self::class]);
    }
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id'=>'tag_id'])->via('articleTags');
    }
    public function getTagsText()
    {
        $tags = [];
        foreach ($this->tags as $tag)
            $tags[] = Html::a("#".$tag->title.' '.$tag->getArticleTags()->count(),
                ['/article/article/list', 'ArticleSearch[tagsAttribute]'=>$tag->id],
                ['class'=>'btn btn-default',]);
        return implode(' ', $tags);
    }

    public function validateVideo()
    {
        $model = new FileVideoNetwork(['link'=>$this->videoAttribute]);
        if(!$model->validate(['link']))
            $this->addError("videoAttribute", Yii::t('file', 'The link of video is incorrect.'));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'type' => Yii::t('common', 'Type'),
            'title' => Yii::t('common', 'Title'),
            'text' => Yii::t('common', 'Text'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'tagsAttribute' => Yii::t('common', 'Tags'),
            'imagesAttribute' => Yii::t('common', 'Images'),
            'videoAttribute' => Yii::t('common', 'Video'),
        ];
    }

    /**
     * @inheritdoc
     * @return \article\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \article\models\query\ArticleQuery(get_called_class());
    }


	public $typeValues;
    public function getTypeText()
    {
        return isset($this->typeValues[$this->type]) ? $this->typeValues[$this->type]:null;
    }

    /**
     * @return \file\models\query\FileQuery
     */
    public function getVideo()
    {
        return $this->hasOne(FileVideoNetwork::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryNetwork();
    }
}