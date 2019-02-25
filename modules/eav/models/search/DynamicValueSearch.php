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
use eav\models\DynamicValue;

/**
 * DynamicValueSearch represents the model behind the search form about `app\models\DynamicValue`.
 */
class DynamicValueSearch extends DynamicValue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'field_id', 'object_id'], 'integer'],
            [['value'], 'safe'],
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
        $query = DynamicValue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'v.id' => $this->id,
            'v.field_id' => $this->field_id,
        ]);

        $query->andFilterWhere(['like', 'v.value', $this->value]);

        return $dataProvider;
    }
}
