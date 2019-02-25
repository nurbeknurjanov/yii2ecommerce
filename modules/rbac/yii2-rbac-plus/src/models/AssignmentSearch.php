<?php

namespace johnitvn\rbacplus\models;

use Yii;
use yii\data\ActiveDataProvider;
use johnitvn\rbacplus\Module;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 
 * 
 */
class AssignmentSearch extends \yii\base\Model {

    /**
     * @var Module $rbacModule
     */
    protected $rbacModule;

    /**
     *
     * @var mixed $id
     */
    public $id;

    /**
     *
     * @var string $login
     */
    public $login;

    public $username;
    public $name;
    public $email;
    public $role;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->rbacModule = Yii::$app->getModule('rbac');
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'login', 'username','email', 'role', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('rbac', 'ID'),
            'login' => $this->rbacModule->userModelLoginFieldLabel,
        ];
    }

    /**
     * Create data provider for Assignment model.    
     */
    public function search() {
        $query = call_user_func($this->rbacModule->userModelClassName . "::find");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $params = Yii::$app->request->getQueryParams();


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }



        $query->andFilterWhere(['{{%user}}.id' => $this->id]);
        $query->andFilterWhere(['{{%user}}.role' => $this->role]);
        $query->andFilterWhere(['LIKE', '{{%user}}.username', $this->username]);
        $query->andFilterWhere(['LIKE', '{{%user}}.email', $this->email]);
        $query->andFilterWhere(['LIKE', '{{%user}}.name', $this->name]);
        //$query->andFilterWhere(['like', $this->rbacModule->userModelLoginField, $this->login]);
        return $dataProvider;
    }

}
