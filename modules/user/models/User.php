<?php

namespace user\models;

use extended\behaviours\ManyToManyBehaviour;
use extended\helpers\Html;
use file\models\File;
use file\models\FileImage;
use file\models\behaviours\FileImageBehavior;
use i18n\models\I18nSourceMessage;
use order\models\query\OrderQuery;
use product\models\Product;
use product\models\query\ProductQuery;
use shop\models\query\ShopQuery;
use shop\models\Shop;
use shop\models\UserShop;
use user\models\create\TokenCreate;
use user\models\query\UserProfileQuery;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use order\models\Order;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $fullName
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password write-only password
 * @property integer $status
 * @property string $statusText
 * @property array $roles
 * @property string $rolesText
 * @property array $rolesValues
 * @property array $possibleRolesValues
 * @property integer $created_at
 * @property integer $updated_at
 * @property \file\models\FileImage $image
 * @property array $images
 * @property string $description
 * @property integer $subscribe
 * @property string $subscribeText
 * @property array $subscribeValues
 * @property bool $isActive
 * @property bool $isNotActive
 * @property array $statusOptions
 * @property UserShop[] $userShops
 * @property Shop[] $shops
 * @property string $link
 * @property [] $url
 * @property UserProfile $userProfile
 * @property UserProfile $userProfileObject
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     * @return \user\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \user\models\query\UserQuery(get_called_class());
    }

    public $password_new;
    public $password_new_repeat;

    public $password_set;
    public $password_set_repeat;

    public $password;//current password

    public $email_new;


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_BLOCKED = 20;
    const STATUS_DELETED = 21;

    public $statusOptions;



    public function getStatusText()
    {
        return isset($this->statusOptions[$this->status]) ? $this->statusOptions[$this->status]:null;
    }

    public function getFullName()
    {
        if($this->name)
            return $this->name;
        if($this->username)
            return $this->username;
        if($this->email)
            return explode('@', $this->email)[0];
    }

    /*    public function setRoleValue($value)
        {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //$this->role = $value;
                //$this->save();
                $this->saveRoles($value);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }*/
    public $rolesAttribute=[];

    const ROLE_GUEST = 1;
    const ROLE_USER = 10;
    const ROLE_MANAGER = 20;
    const ROLE_ADMINISTRATOR = 30;


    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }
    public function getRoles()
    {
        return ArrayHelper::map(Yii::$app->authManager->getAssignments($this->id), 'roleName', 'roleName');
    }
    public function getPossibleRolesValues()
    {
        $roleValues = [];
        foreach ($this->rolesValues as $name=>$description)
            if(Yii::$app->user->can($name))
                $roleValues[$name] = $description;
        unset($roleValues[User::ROLE_GUEST]);
        return $roleValues;
    }
    public function getRolesValues()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', function($value){
            return Yii::t('user', $value->description);
        });
    }
    public function getRolesText()
    {
        $roles = $this->roles;
        $rolesValues = $this->rolesValues;
        /*$roles = array_map( function($value) use ($rolesValues){
            if(isset($rolesValues[$value]))
                return $rolesValues[$value];
        }, $roles);*/
        array_walk($roles, function(&$value, $key) use ($rolesValues)
        {
            if(isset($rolesValues[$key]))
                $value = $rolesValues[$key];
        });
        return implode(', ', $roles);
    }
    public function attributes()
    {
        $attributes = parent::attributes();
        $attributes[] = 'rolesAttribute';
        $attributes[] = 'shopsAttribute';
        return $attributes;
    }
    public function saveRoles()
    {
        Yii::$app->authManager->revokeAll($this->id);
        if($this->rolesAttribute){
            if(is_array($this->rolesAttribute))
                foreach ($this->rolesAttribute as $role)
                    Yii::$app->authManager->assign(Yii::$app->authManager->getRole($role) , $this->id);
            else
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole($this->rolesAttribute) , $this->id);
        }
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, function(AfterSaveEvent $event){
            $event->sender->saveRoles();
        });
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->rolesAttribute  || $model->rolesAttribute===''){//Если дали какое то значение
                $model->setOldAttribute('rolesAttribute', $model->roles);
                $model->setAttribute('rolesAttribute', $model->rolesAttribute);
                //if(isset($event->changedAttributes['rolesAttribute']))
                if(isset($model->getDirtyAttributes()['rolesAttribute']))
                    $model->saveRoles();
            }
        });

        $this->on(self::EVENT_BEFORE_DELETE, function(Event $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->getProducts()->exists())
                throw new Exception("Sorry. You must first detach "
                    .Inflector::titleize(Inflector::pluralize(StringHelper::basename(Product::class)), true)." from the "
                    .Inflector::titleize(StringHelper::basename(self::class), true).' '.$model->fullName, 400);
        });

        $this->statusOptions = [
            self::STATUS_ACTIVE=>Yii::t('common', 'Active'),
            self::STATUS_INACTIVE=>Yii::t('common', 'Inactive'),
            self::STATUS_DELETED=>Yii::t('common', 'Deleted'),
            self::STATUS_BLOCKED=>Yii::t('user', 'Blocked'),
        ];

        $this->on(self::EVENT_AFTER_DELETE, function(Event $event){
            /* @var $model self */
            $model = $event->sender;
            $userShops = $model->userShops;
            foreach ($userShops as $userShop)
                $userShop->delete();
        });

        $this->on(self::EVENT_BEFORE_DELETE, function(Event $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->userProfile)
                $model->userProfile->delete();
        });
    }

    public $shopsAttribute=[];


    public function activateStatus()
    {
        $this->updateAttributes(['status'=>self::STATUS_ACTIVE]);
    }
    public function tightOrders()
    {
        Order::updateAll(['user_id'=>$this->id],['email'=>$this->email]);
    }




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    const EVENT_INIT_FIELDS_OF_MANY_TO_MANY='EVENT_INIT_FIELDS_OF_MANY_TO_MANY';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            [
                'class' => FileImageBehavior::class,
                'className'=>self::class,
                'fileAttributes'=>['imageAttribute', 'imagesAttribute'],
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT_FIELDS_OF_MANY_TO_MANY => 'shopsAttribute',
                ],
                'value' => function ($event) {
                    /* @var self $model */
                    $model = $event->sender;
                    $model->shopsAttribute = ArrayHelper::map($model->shops, 'id', 'id');
                    $model->attachBehavior('shopsAttributeBehavior', [
                        'class' => ManyToManyBehaviour::class,
                        'manyAttribute'=>'shopsAttribute',
                        'manyAttributeOldValue'=>$model->shopsAttribute,
                        'saveFunction'=>'saveUserShops',
                    ]);
                    return $model->shopsAttribute;
                },
            ],
        ];
    }
    public $imageAttribute;
    public $imagesAttribute=[];
    /**
     * @return \file\models\query\FileQuery
     */
    public function getImage()
    {
        return $this->hasOne(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryImage();
    }
    /**
     * @return \file\models\query\FileQuery
     */
    public function getImages()
    {
        return $this->hasMany(FileImage::class, ['model_id' => 'id'])
            ->queryClassName(self::class)->queryImages();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['imageAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
                'maxSize'=>1024*1024*4,//4 mb
            ],
            ['imagesAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
                'maxFiles'=>10,
                'maxSize'=>1024*1024*4,//4 mb
            ],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => array_keys($this->statusOptions)],
            ['status', 'required'],
            ['status', 'filter', 'filter' => 'intval'],

            ['name', 'default', 'value' => ''],
            ['name', 'required'],

            //[['username'], 'required'],
            [['username'], 'default', 'value'=>null],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],

            [['email'], 'required'],
            [['email', 'username'], 'unique'],
            [['email'], 'email'],
            [['phone'], 'safe'],

            [['password', 'password_new', 'password_new_repeat'], 'required', 'on'=>'changePassword'],
            ['password', 'validateCurrentPassword', 'on'=>'changePassword'],
            [['password_new', 'password_set'], 'string', 'min' => 6],
            ['password_new_repeat', 'compare', 'compareAttribute'=>'password_new', 'on'=>'changePassword'],

            [['password_set', 'password_set_repeat'], 'required', 'on'=>'setPassword'],
            ['password_set_repeat', 'compare', 'compareAttribute'=>'password_set', 'on'=>'setPassword'],

            [['email_new', 'password'], 'required', 'on'=>'changeEmail'],
            ['password', 'validateCurrentPassword', 'on'=>'changeEmail'],
            ['email_new', 'email'],//'on'=>'changeEmail' можно и так
            ['email_new', 'unique', 'targetClass' => '\user\models\User', 'targetAttribute'=>'email'],
            ['email_new', 'uniqueValidate',],

            [['password_new', 'password_new_repeat'], 'required', 'on'=>'resetByAdministrator'],
            ['password_new_repeat', 'compare', 'compareAttribute'=>'password_new','on'=>'resetByAdministrator'],

            /*['rolesAttribute', 'each', 'rule' =>   ['in', 'range' => array_keys($this->rolesValues)], 'when'=>function(self $model){
                return is_array($model->rolesAttribute);
            }],
            ['rolesAttribute', 'in', 'range' => array_keys($this->rolesValues), 'when'=>function(self $model){
                return !is_array($model->rolesAttribute);
            }],*/
            
            ['rolesAttribute', 'safe'],
            ['description', 'safe'],
            [['subscribe'], 'default', 'value'=>0],

            ['!email', 'safe', 'on'=>self::SCENARIO_EDIT_PROFILE],
            [['shopsAttribute'], 'safe'],
        ];
    }
    const SCENARIO_EDIT_PROFILE='editProfile';
    public function uniqueValidate($attribute, $params)
    {
        if(self::find()->where(['email'=>$this->$attribute,])->exists())
            $this->addError($attribute,  Yii::t('yii', '{attribute} "{value}" has already been taken.', ['attribute'=>$this->getAttributeLabel($attribute), 'value'=>$this->email_new,]));
    }
    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->validatePassword($this->password)){
            $this->addError($attribute, Yii::t('common', '{attribute} is incorrect.', ['attribute'=>$this->getAttributeLabel($attribute),]));
            $this->$attribute = null;
        }
    }

    public function saveUserShops()
    {
        $elementsToDelete = array_diff((array) $this->getOldAttribute('shopsAttribute'), (array) $this->shopsAttribute);
        if($elementsToDelete){
            UserShop::deleteAll(['user_id'=>$this->id,'shop_id'=>$elementsToDelete]);
        }

        if($this->shopsAttribute){
            if(is_array($this->shopsAttribute)){
                foreach ($this->shopsAttribute as $shop_id)
                    UserShop::createIfNotExists($this->id, $shop_id);
            }
            else
                UserShop::createIfNotExists($this->id, $this->shopsAttribute);
        }
    }
    public function getUserShops()
    {
        return $this->hasMany(UserShop::class, ['user_id'=>'id']);
    }

    /**
     * @return ShopQuery
     */
    public function getShops()
    {
        return $this->hasMany(Shop::class, ['id'=>'shop_id'])->via('userShops');
    }



    public $_fields=[];
    public function fields()
    {
        return array_merge([
            'id',
            'username',
            'name',
            'email',
            'phone',
            'status',
            'description',
            'roles',
            'image'=>function($model){
                    return $model->image;
                },
            'hasPassword'=>function($model){
                return (bool) $model->password_hash;
            },
            'userProfile'
        ], $this->_fields);
    }
    public function extraFields()
    {
        return [
            'images'=>function($model){
                    return $model->images;
                },
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'password'=>Yii::t('user', 'Current password'),
            'password_new'=>Yii::t('user', 'New password'),
            'password_new_repeat'=>Yii::t('user', 'Repeat new password'),
            'password_set'=>Yii::t('user', 'Password'),
            'password_set_repeat'=>Yii::t('user', 'Repeat password'),
            'email_new'=>Yii::t('user', 'New email'),
            'imageAttribute'=>Yii::t('common', 'Image'),
            'imagesAttribute'=>Yii::t('common', 'Images'),
            'name'=>Yii::t('user', 'Name'),
            'username'=>Yii::t('user', 'User name'),
            'email'=>Yii::t('common', 'Email'),
            'rolesAttribute'=>Yii::t('common', 'Roles'),
            'status'=>Yii::t('common', 'Status'),
            'description'=>Yii::t('common', 'Description'),
            'subscribe'=>Yii::t('user', 'Subscribe'),
            'created_at'=>Yii::t('common', 'Create date'),
            'updated_at'=>Yii::t('common', 'Update date'),
            'shopsAttribute' => Yii::t('common', 'Shops'),
        ];
    }




    /**
     * @inheritdoc
     * @return User
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $loginToken = Token::find()->where(['token'=>$token])->one();
        if($loginToken)
            return static::findOne(['id' => $loginToken->user_id]);
        else
            throw new Exception("Token is incorrect", 401);
    }

    /**
     * Finds user by username
     *
     * @param string $username|$email
     * @return User|null
     */
    public static function findByUsernameOrEmail($username)
    {
        return static::find()->where( ['OR', ['username' => $username], ['email' => $username]])->one();
    }
    public static function findActiveUserByUsernameOrEmail($username)
    {
        return static::find()->where(
            [
                'AND',
                ['OR', ['username' => $username], ['email' => $username]],
                ['status' => self::STATUS_ACTIVE]
            ]
        )->one();
    }



    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if(!$this->password_hash)
            return false;
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }




    const SUBSCRIBE_YES=1;
    const SUBSCRIBE_NEUTRAL=0;
    const SUBSCRIBE_NO=-1;
    public function getSubscribeValues()
    {
        return [
            self::SUBSCRIBE_YES=>Yii::t('user', 'Subscribed'),
            self::SUBSCRIBE_NEUTRAL=>Yii::t('user', 'Not set'),
            self::SUBSCRIBE_NO=>Yii::t('user', 'Unsubscribed'),
        ];
    }

    public function getSubscribeText()
    {
        if(isset($this->subscribeValues[$this->subscribe]))
            return $this->subscribeValues[$this->subscribe];
    }

    public function sendActivateToken()
    {
        $token = TokenCreate::createIfNotExists(Token::ACTION_ACTIVATE_ACCOUNT, $this, 'auto_login');
        return Yii::$app->mailer->compose('@user/mail/activateAccount-html', ['user' => $this, 'token'=>$token,])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo([$this->email=>$this->fullName])
            ->setSubject(Yii::t('user', 'You requested to activate your account.'))
            ->send();
    }

    public function getThumbImg(string $thumbType, $options=[], $width=null, $height=null)
    {
        if(!isset($options['alt']))
            $options['alt']=$this->fullName;

        if(!$height)
            $height = $width;
        if(!$width){
            $widthAttribute = 'thumb'.ucfirst($thumbType).'Width';
            $width = (new FileImage)->$widthAttribute;
        }
        if(!$height){
            $heightAttribute = 'thumb'.ucfirst($thumbType).'Height';
            $height = (new FileImage)->$heightAttribute;
        }
        if($width && $height){
            $cssSize = "width:{$width}px;height:{$height}px;";
            if(isset($options['style']))
                $options['style'].=$cssSize;
            else
                $options['style']=$cssSize;
        }

        if($this->image)
            return $this->image->getThumbImg($thumbType, $options);
        return Html::noImg($width, $height, $options);
    }

    /**
     * @return OrderQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    /**
     * @return ProductQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['user_id' => 'id']);
    }

    public function getIsActive()
    {
        return in_array($this->status, [self::STATUS_ACTIVE]);
    }
    public function getIsNotActive()
    {
        return !$this->isActive;
    }


    public function getUrl()
    {
        return ['/user/manage/user/view', 'id'=>$this->id];
    }
    public function getLink()
    {
        return Html::a($this->fullName, $this->url);
    }



    /**
     * @return UserProfileQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'id']);
    }

    private $_userProfile;
    public function getUserProfileObject()
    {
        if($this->_userProfile)
            return $this->_userProfile;
        if($this->userProfile)
            return $this->_userProfile = $this->userProfile;
        return $this->_userProfile = new UserProfile(['id'=>$this->id]);
    }

}
