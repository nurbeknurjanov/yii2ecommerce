<?php

namespace johnitvn\rbacplus\models;

use Yii;
use yii\rbac\Item;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 
 */
class RoleSearch extends AuthItemSearch {

    public function __construct($config = array()) {
        parent::__construct($item = null, $config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['name'] = Yii::t('rbac', 'Role name');
        $labels['permissions'] = Yii::t('rbac', 'Permissions');
        return $labels;
    }

    /**
     * @inheritdoc
     */
    protected function getType() {
        return Item::TYPE_ROLE;
    }

}
