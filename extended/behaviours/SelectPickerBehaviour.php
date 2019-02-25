<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 3/2/18
 * Time: 11:35 AM
 */

namespace extended\behaviours;


use comment\models\Comment;
use extended\helpers\Helper;
use extended\helpers\Html;
use kartik\datetime\DateTimePicker;
use yii\base\Behavior;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use Yii;
use yii\db\ActiveQuery;
use extended\vendor\BootstrapSelectAsset;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use product\models\Product;
use yii\helpers\Url;

class SelectPickerBehaviour extends Behavior
{
    public $title;
    public $ajaxUrl;
    public function init()
    {
        parent::init();

        if(Yii::$app->id!='app-console')
            BootstrapSelectAsset::register(Yii::$app->view);
        if(!$this->title)
            $this->title='title';
    }



    /**
     * @param integer|array $value the id of selected records
     * @param string $q - string for like search
     * */
    public function getOrderedQuery($value=null, $q=null)
    {
        /** @var $model Comment */
        /** @var $query ActiveQuery */
        $owner = $this->owner;

        $query = $owner::find()->limit(5);

        if(is_array($value))
            $value = array_filter($value);

        if($value){
            $query->orFilterWhere(['id'=> $value]);//nurbek

            if(is_array($value)){
                $value = array_reverse($value);
                $value = implode(',',$value);
            }
            $query->addOrderBy(new Expression("FIELD(id, {$value}) DESC"));
        }


        if(defined($owner::className().'::BIG_VALUES') && $owner::BIG_VALUES){
            $query->orFilterWhere(['id'=> $owner::BIG_VALUES]);//nurbek

            $bigValues = array_reverse($owner::BIG_VALUES);
            $bigValues = implode(',', $bigValues);
            $query->addOrderBy(new Expression("FIELD(id, $bigValues) DESC"));
        }

        if($q){
            $query->addOrderBy(new Expression("IF({$this->title} LIKE '%{$q}%', 0,1)"));
            $query->orWhere("{$this->title} LIKE '%{$q}%'");//nurbek
        }


        $query->addOrderBy($this->title);//default title asc
        return $query;
    }

    public function getWidgetSelectPicker($model, $attribute, $addQuery=null,$options=[])
    {
        if(!$this->ajaxUrl){
            $ownerId = Helper::getId($this->owner);
            $this->ajaxUrl = Url::to(["/$ownerId/$ownerId/select-picker"]);
        }

        /** @var $model Comment */
        /** @var $owner Product */
        /** @var $query ActiveQuery */

        $options = array_merge([
            'prompt'=>Yii::t('common', 'Select'),
            //'multiple'=>true,
            'class'=>'selectpicker',
            //'prompt'=>'',
            'data-live-search'=>'true',
            'data-width' => '100%',
            'data-title' => Yii::t('common', 'Select'),
            'data-header' => Yii::t('common', 'Select'),
            //'data-style' => 'btn-danger',
            'data-url' => $this->ajaxUrl,
        ], $options);

        $query = $this->getOrderedQuery($model->$attribute);
        if($addQuery && $addQuery->where)
            $query->andFilterWhere($addQuery->where);


        $data = ArrayHelper::map($query->all(), 'id', $this->title);

        return Html::activeDropDownList($model, $attribute, $data, $options);
    }
}