<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace eav\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use eav\models\DynamicField;

/**
 * DynamicFieldSearch represents the model behind the search form about `app\models\DynamicField`.
 */
class DynamicFieldSearch extends DynamicField
{
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'integer'],
            [[ 'enabled'], 'boolean'],
            [[ 'rule'], 'safe'],
            [['label', 'json_values', 'key', 'default_value'], 'safe'],
            [['category_id'], 'safe'],
            [['section'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DynamicField::find();
        $query->defaultFrom();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->with('category');

        if($this->category_id)
            $query->categoryQuery($this->category_id, true, true);


        if(!$dataProvider->sort->attributeOrders)
            $query->defaultOrder();

        $query->andFilterWhere([
            'dynamic_field.id' => $this->id,
            'dynamic_field.type' => $this->type,
            'dynamic_field.enabled' => $this->enabled,
            'dynamic_field.section' => $this->section,
        ]);

        $query
            ->andFilterWhere(['like', 'dynamic_field.label', $this->label])
            ->andFilterWhere(['like', 'dynamic_field.key', $this->key])
            ->andFilterWhere(['like', 'dynamic_field.default_value', $this->default_value])
            ->andFilterWhere(['like', 'dynamic_field.json_values', $this->json_values]);
        if($this->rule)
            $query->andWhere("FIND_IN_SET('{$this->rule}', dynamic_field.rule)");


        return $dataProvider;
    }
}
