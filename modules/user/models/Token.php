<?php

namespace user\models;

use order\models\Order;
use user\models\create\TokenCreate;
use user\models\create\UserCreate;
use user\models\query\TokenQuery;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "user_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $action
 * @property integer $run
 * @property string $token
 * @property string $ip_address
 * @property string $expire_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $data
 * @property User $user
 * @property boolean $reusable
 * @property boolean $isRunnable
 */

class Token extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'expire_date',
                ],
                'value' => function($event){
                    $model = $event->sender;
                    /* @var self $model */
                    return date('Y-m-d H:i:s', time()+3600*24*7);
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'reusable',
                ],
                'value' => function($event){
                    $model = $event->sender;
                    /* @var self $model */
                    return 0;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'data',
                ],
                'value' => function($event){
                    $model = $event->sender;
                    /* @var self $model */
                    if($model->data && is_array($model->data))
                        return json_encode($model->data);
                    return $model->data;
                },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'ip_address',
                ],
                'value' => function ($event) {
                        return Yii::$app->request->userIP;
                    },
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'token',
                ],
                'value' => function ($event) {
                        return Yii::$app->security->generateRandomString();
                },
            ],

        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action'], 'required'],
            [['user_id'], 'integer'],
            [['run', 'reusable'], 'boolean'],
            [['data'], 'safe'],
            [['run', 'reusable'], 'default', 'value' => 0],
            [['expire_date', 'created_at', 'updated_at'], 'safe'],
            [['token', 'ip_address'], 'default', 'value'=>''],
            [['expire_date', 'created_at', 'updated_at'], 'default', 'value'=>'0000-00-00 00:00:00'],
            [['token', 'ip_address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }



    const ACTION_ACTIVATE_ACCOUNT = 10;//sign up, resend in guest, in order if already exists
    const ACTION_COMPLETE_ACCOUNT = 11;//created by admin, must complete his info and set password
    const ACTION_RESET_PASSWORD = 20;
    const ACTION_CHANGE_EMAIL = 30;
    const ACTION_SHARE_LINK_TO_REGISTER = 40; //for sharing manually, or sending in invite
    //const ACTION_INVITE = 60;
    const ACTION_INVITE_FROM_ORDER = 61;//from order
    const ACTION_LOGIN = 50;//from api login



    public function getIsRunnable()
    {
        return ($this->run==0 || $this->reusable==1) &&
            ($this->expire_date==null || $this->expire_date>=date('Y-m-d H:i:s'));
    }

    protected function checkRunnable()
    {
        if(!$this->isRunnable){
            if($this->run==1 && $this->reusable==0){
                if($this->action==self::ACTION_ACTIVATE_ACCOUNT)
                    throw new Exception('You have already activated your account');
                throw new Exception('The token can not be run twice.');
            }
            if($this->expire_date && $this->expire_date<date('Y-m-d H:i:s'))
                throw new Exception('The token is expired.');
        }
    }
    public function run()
    {
        $this->checkRunnable();

        $user = $this->user;
        switch($this->action)
        {
            case self::ACTION_ACTIVATE_ACCOUNT: {
                $user->activateStatus();
                break;
            }
            case self::ACTION_CHANGE_EMAIL:{
                //Yii::info("{$user->id}-{$user->fullName} changed email from '$user->email' to '$this->data'", 'userChanges');
                if($this->data)//email validation here
                    $user->updateAttributes(['email'=>$this->data]);
                break;
            }

            case self::ACTION_INVITE_FROM_ORDER:{
                $data = json_decode($this->data, JSON_FORCE_OBJECT);
                if(isset($data['email']) && $data['email']){
                    $user = UserCreate::createUserInactiveForce($data);
                    $user->activateStatus();
                    $user->tightOrders();
                    $this->user_id = $user->id;
                    if(!$this->save())
                        throw new Exception(Html::errorSummary($this));
                }else
                    throw new Exception("Email is missing.");
                break;
            }
        }
        $this->run = 1;
        $this->save(false);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public static function find()
    {
        return new TokenQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User'),
            'token' => Yii::t('common', 'Token'),
            'ip_address' => Yii::t('common', 'Ip Address'),
            'expire_date' => Yii::t('common', 'Expire Date'),
            'created_at' => Yii::t('common', 'Created Date'),
            'updated_at' => Yii::t('common', 'Updated Date'),
        ];
    }


    /**
     * @inheritdoc
     * @return Token|null self instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return static::findByCondition($condition)->one();
    }

    public function updateExpiredDate()
    {
        $this->updateAttributes(['expire_date'=>date('Y-m-d H:i:s',
            time() + 3600*24*7)]);
    }

}