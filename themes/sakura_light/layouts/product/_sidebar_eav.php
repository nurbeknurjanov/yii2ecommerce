<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use user\models\User;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
use category\models\Category;
use yii\helpers\Url;
use yii\jui\SliderInput;
use product\models\search\ProductSearchFrontend;
use product\assets\ProductAsset;
use eav\assets\EavAsset;
use yii\web\JsExpression;
use extended\helpers\Helper;
use eav\models\DynamicValue;
use eav\models\DynamicField;

/* @var $this \extended\view\View */
/* @var $model product\models\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */

$request = Yii::$app->request;



if(isset($this->params['searchModel']))
    $searchModel = $this->params['searchModel'];
else{
    $searchModel = new ProductSearchFrontend;
    $searchModel->load(Yii::$app->request->queryParams);
}

$searchFormAction = ['/product/product/list'];
if($searchModel->category){
    if($searchModel->formName())
        $searchFormAction["{$searchModel->formName()}[category_id]"] = $searchModel->category->id;
    else
        $searchFormAction["category_id"] = $searchModel->category->id;
    $searchFormAction['title_url'] = $searchModel->category->title_url;
}
?>

<div class="eavBlock" >

    <?php
    $categories=null;
    if($request->get('q') && Helper::cleanForMatchAgainst($request->get('q'))){
        $categories = Category::find()->defaultFrom()->whereByQTranslate(Helper::cleanForMatchAgainst($request->get('q')))->all();
        if($categories){
            ?>
            <div class="categoriesBlock">
                <label>Categories</label>
                <ul>
                    <?php
                    foreach ($categories as $category) {
                        ?>
                        <li><?=Html::a($category->title, $category->url)?></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>

            <?php
        }

    }
    ?>
    <?php
    $form = ActiveForm::begin([
        'action'=>$searchFormAction,
        'id'=>'leftSearchForm',
        'enableAjaxValidation'=>false,
        //'options' => ['data' => ['pjax' => true]],//если будет внутри Pjax тогда имеет смысл
        'options' => ['data' => ['pjax' => true]],//если будет внутри Pjax тогда имеет смысл
        'method' => 'get',
        'fieldConfig'=>[
            'template' => "{label}\n{input}"
        ],
    ]); ?>


    <?php
    ob_start();
    ?>
    <div style="margin: 5px 8px 0;">
        <?=SliderInput::widget([
            'id' => 'slider',
            'name' => 'slider',
            'options'=>['disabled'=>'disabled',],
            'clientOptions' => [
                'min' => 1,
                'max' => 1000,
                'range' => true,
                'values' => [$request->get('priceFrom')?:1 , $request->get('priceTo')?:1000],
                'slide'=> new JsExpression ('function( event, ui ){
                            $( "[name=\'priceFrom\']" ).val(ui.values[ 0 ]);
                            $( "[name=\'priceTo\']" ).val(ui.values[ 1 ]);
                    }'),
                'change'=> new JsExpression ('function( event, ui ){
                            $(this).parents("form").submit();
                    }'),
            ],
        ]);?>
    </div>
    <div style="margin: 10px 0;">
        <?=Html::textInput("priceFrom", $request->get('priceFrom'),
            ['class'=>'form-control inputRange']);?>
        -
        <?=Html::textInput("priceTo",  $request->get('priceTo'),
            ['class'=>'form-control inputRange']);?>
    </div>
    <?php
    $priceContent = ob_get_clean();
    echo $form->field($model, 'price', ['parts'=>['{input}'=>$priceContent]])
    ?>

    <div class="eavFields">
        <?php
        if($searchModel->valueModels)
            echo $this->render('@eav/views/dynamic-field/fields/_fields_for_search',[
                'valueModels'=>$searchModel->valueModels,
                'form'=>$form,
            ]);
        if($categories){
            $valueModels=[];
            $dynamicFields = DynamicField::find()
                ->defaultFrom()
                ->defaultOrder()
                ->enabled()
                ->categoryQuery(ArrayHelper::map($categories, 'id','id'), true, true, true)
                ->orKeyQuery()
                ->indexBy('id')->all();
            foreach ($dynamicFields as $fieldModel)
                $valueModels[$fieldModel->id]=$fieldModel->valueObject;
            echo $this->render('@eav/views/dynamic-field/fields/_fields_for_search',[
                'valueModels'=>$valueModels,
                'form'=>$form,
            ]);
        }
        ?>
    </div>

    <div class="form-group">
        <?php //echo Html::submitButton(Yii::t('product', 'Search'), ['class' => 'btn btn-primary submitButton']) ?>
        <?php //echo Html::button(Yii::t('product', 'Reset'), ['class' => 'btn btn-default resetButton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



