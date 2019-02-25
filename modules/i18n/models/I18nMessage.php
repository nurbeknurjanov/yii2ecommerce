<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace i18n\models;

use Yii;
use yii\base\Event;
use yii\db\ActiveQuery;
use yii\db\AfterSaveEvent;

/**
 * This is the model class for table "{{%i18n_message}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 * @property string $languageText
 *
 * @property I18nSourceMessage $source
 */
class I18nMessage extends \yii\db\ActiveRecord
{

    public function init()
    {
        parent::init();

        $this->on(static::EVENT_AFTER_INSERT, [$this, 'deleteCache']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'deleteCache']);
        $this->on(static::EVENT_AFTER_DELETE, [$this, 'deleteCache']);
    }
    public function deleteCache()
    {
        Yii::$app->cache->flush();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%i18n_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => I18nSourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'language' => Yii::t('common', 'Language'),
            'translation' => Yii::t('common', 'Translation'),
            'sourceMessage' => Yii::t('common', 'Source message'),
        ];
    }




    /**
     * @inheritdoc
     * @return \i18n\models\query\I18nMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \i18n\models\query\I18nMessageQuery(get_called_class());
    }

    public function getLanguageText()
    {
        return (new I18nSourceMessage())->languageValues[$this->language];
    }

    /**
     * @return ActiveQuery
     * */
    public function getSource()
    {
        return $this->hasOne(I18nSourceMessage::className(), ['id' => 'id']);
    }

    public $sourceMessage;
}
