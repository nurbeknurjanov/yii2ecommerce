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
use extended\helpers\Helper;
use yii\web\JsExpression;

/* @var $this \extended\view\View */
/* @var $searchModel product\models\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */

$request = Yii::$app->request;

if(isset($this->params['searchModel'])){
    $searchModel = $this->params['searchModel'];
}
else{
    $searchModel = new ProductSearchFrontend;
    $searchModel->load(Yii::$app->request->queryParams);
}
$action = ['/product/product/list'];
if($searchModel->category){
    $action['category_id'] = $searchModel->category->id;
    //$action['category_title_url'] = $searchModel->category->title_url;
}
?>


<div class="eavBlock"  >

    <?php $form = ActiveForm::begin([
        'action'=>$action,
        'id'=>'leftSearchForm',
        'enableAjaxValidation'=>false,
        //'options' => ['data' => ['pjax' => true]],//если будет внутри Pjax тогда имеет смысл
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
        <?php //=Yii::t('product', 'from');?>
        <?=Html::textInput("priceFrom", $request->get('priceFrom'),
            ['class'=>'form-control inputRange']);?>
        -
        <?php //Yii::t('product', 'to');?>
        <?=Html::textInput("priceTo",  $request->get('priceTo'),
            ['class'=>'form-control inputRange']);?>
    </div>
    <?php
    $priceContent = ob_get_clean();
    echo $form->field($searchModel, 'price', ['parts'=>['{input}'=>$priceContent]])
    ?>

    <?=$form->field($searchModel, 'category_id')->dropDownList(
        ArrayHelper::map(Category::find()->defaultFrom()->defaultOrder()
            ->enabled()->selectTitle()->all(), 'id', 'title'),
        [
            'prompt'=>'Select',
            'class'=>'selectpicker dropdown-sp eavSelectForSearch',
            'data-width'=>'100%',
            'data-live-search'=>'true',
            //'data-size'=>5,
            'encode'=>false,
            'data'=>[
                'id'=>$searchModel->id,
            ],
        ]); ?>

    <img src="<?=$this->assetManager->publish((new EavAsset)->sourcePath."/images/loading.gif")[1]?>" id="loading" />
    <div class="eavFields">
        <?php
        echo $this->render('@eav/views/dynamic-field/fields/_fields_for_search',[
            'valueModels'=>$searchModel->valueModels,
            'form'=>$form,
        ]);
        ?>
    </div>

    <?php // echo $form->field($searchModel, 'q') ?>
    <div class="form-group">
        <?php //echo Html::submitButton(Yii::t('product', 'Search'), ['class' => 'btn btn-primary submitButton']) ?>
        <?php //echo Html::button(Yii::t('product', 'Reset'), ['class' => 'btn btn-default resetButton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



