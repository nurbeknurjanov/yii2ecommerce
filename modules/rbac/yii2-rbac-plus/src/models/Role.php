<?php

namespace johnitvn\rbacplus\models;

use user\models\User;
use Yii;
use yii\rbac\Item;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 
 */
class Role extends AuthItem {

    public $permissions = [];
    public $childRoles = [];

    public function init() {
        parent::init();
        if (!$this->isNewRecord) {
            $permissions = [];
            foreach (static::getPermistions($this->item->name) as $permission) {
                $permissions[] = $permission->name;
            }
            $this->permissions = $permissions;
        }
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['default'][] = 'permissions';
        $scenarios['default'][] = 'childRoles';
        return $scenarios;
    }

    protected function getType() {
        return Item::TYPE_ROLE;
    }

    public function afterSave($insert,$changedAttributes) {
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRole($this->item->name);
        if (!$insert) {
            $authManager->removeChildren($role);
        }
        if ($this->permissions != null && is_array($this->permissions)) {
            foreach ($this->permissions as $permissionName) {
                $permistion = $authManager->getPermission($permissionName);
                $authManager->addChild($role, $permistion);
            }
        }
        if ($this->childRoles != null && is_array($this->childRoles)) {
            foreach ($this->childRoles as $roleName) {
                $childRole = $authManager->getRole($roleName);
                $authManager->addChild($role, $childRole);
            }
        }
    }

    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('rbac', 'Role name');
        $labels['permissions'] = Yii::t('rbac', 'Permissions');
        return $labels;
    }

    public static function find($name) {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getRole($name);
        return new self($item);
    }

    public static function getPermistions($name) {
        $authManager = Yii::$app->authManager;
        return $authManager->getPermissionsByRole($name);
    }

}
