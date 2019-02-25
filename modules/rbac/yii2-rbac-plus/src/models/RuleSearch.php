<?php

namespace johnitvn\rbacplus\models;

use Yii;
use yii\data\ArrayDataProvider;

/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2016 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 
 */
class RuleSearch extends Rule {

    /**
     *
     * @var string 
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'className'], 'safe']
        ];
    }

    /**
     * Search authitem
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params) {
        $this->load($params);
        $authManager = Yii::$app->authManager;
        $models = [];

        foreach ($authManager->getRules() as $name => $item)
        {
            if ($this->name == null || empty($this->name))
                $models[$name] = new Rule($item);
            else if (strpos($name, $this->name) !== FALSE)
                $models[$name] = new Rule($item);
        }


        if($this->className)
            foreach ($models as $n=>$model)
            {
                if (stripos($model->className, $this->className) === FALSE)
                    unset($models[$n]);
            }
        return new ArrayDataProvider([
            'allModels' => $models,
        ]);
    }

}
