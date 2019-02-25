<?php
namespace user\models;

use backend\models\BlockUserIP;
use backend\models\LoginHistory;
use Yii;
use yii\base\Model;
use yii\helpers\Html;

/**
 * Invite form
 */
class InviteForm extends Model
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'emailExistValidate'],
        ];
    }

    public function emailExistValidate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(User::find()->where(['email'=>$this->$attribute])->exists())
                $this->addError($attribute, 'This user has already registered.');
        }
    }
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('common', 'Email'),
        ];
    }
}
