<?php
namespace johnitvn\rbacplus\models;

use Yii;
use yii\data\ArrayDataProvider;
use yii\rbac\Item;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 
 */
abstract class AuthItemSearch extends AuthItem {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description',], 'safe'],
        ];
    }

    public static function find($name) {
        throw new \yii\base\Exception('Not support find() method in this object');
    }

    /**
     * Search authitem
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params) {
        $authManager = Yii::$app->authManager;
        if ($this->getType() == Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = $authManager->getPermissions();
        }
        
        if ($this->load($params) && $this->validate() && (trim($this->name) !== '' || trim($this->description) !== '' || trim($this->ruleName) !== '')) {
            $search = strtolower(trim($this->name));
            $desc = strtolower(trim($this->description));
            $ruleName = strtolower(trim($this->ruleName));
            $items = array_filter($items, function ($item) use ($search, $desc, $ruleName) {
                return (empty($search) || strpos(strtolower($item->name), $search) !== false)
                && ( empty($desc) || strpos(strtolower($item->description), $desc) !== false)
                && ( empty($ruleName) || strpos(strtolower($item->ruleName), $ruleName) !== false)
                    ;
            });
        }
        return new ArrayDataProvider([
            'allModels' => $items,
        ]);
    }

}
