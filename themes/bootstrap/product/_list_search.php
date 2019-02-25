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


/* @var $this yii\web\View */
/* @var $model product\models\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
$productAsset = \product\assets\AppAsset::register($this);
?>


<div class="product-search" >

    <?php
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
        $action['title_url'] = $searchModel->category->title_url;
    }
    ?>
    <?php $form = ActiveForm::begin([
        'action'=>$action,
        'id'=>'searchFormListProduct',
        'enableAjaxValidation'=>false,
        //'options' => ['data' => ['pjax' => true]],//если будет внутри Pjax тогда имеет смысл
        'method' => 'get',
        'fieldConfig'=>[
            'template' => "{label}\n{input}"
        ],
    ]); ?>



    <?php //echo $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->defaultQuery()->selectTitle()->all(), 'id', 'title'), ['prompt'=>'Select', 'encode'=>false,]) ?>

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
                'values' => [isset($_GET['priceFrom']) ? $_GET['priceFrom']:1 , isset($_GET['priceTo']) ? $_GET['priceTo']:1000],
                'slide'=> new \yii\web\JsExpression ('function( event, ui ){
                            $( "[name=\'priceFrom\']" ).val(ui.values[ 0 ]);
                            $( "[name=\'priceTo\']" ).val(ui.values[ 1 ]);
                    }'),
            ],
        ]);?>
    </div>
    <div style="margin: 10px 0;">
        от <?=Html::textInput("priceFrom", isset($_GET['priceFrom']) ? $_GET['priceFrom']:null, ['class'=>'form-control','style'=>'display:inline; width:70px;',]);?>

        до <?=Html::textInput("priceTo",  isset($_GET['priceTo']) ? $_GET['priceTo']:null, ['class'=>'form-control','style'=>'display:inline; width:70px;',]);?>
    </div>
    <?php
    $priceContent = ob_get_contents();

    ob_end_clean();
    ?>
    <?=$form->field($model, 'price', ['parts'=>['{input}'=>$priceContent]]) ?>


    <?=$form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->defaultQuery()->selectTitle()->all(), 'id', 'title'),
        [
            'prompt'=>'Select',
            'class'=>'selectpicker dropdown-sp category-search-select',
            'data-width'=>'100%',
            'data-live-search'=>'true',
            //'data-size'=>5,
            'encode'=>false,
            'data'=>[
                'id'=>$model->id,
            ],
        ]); ?>


    <div class="additionalFields">
        <img src="<?=$productAsset->baseUrl;?>/images/loading.gif" id="loading" />
        <?php
        $valueModels = $this->params['valueModels'];
        $fieldModels = $this->params['fieldModels'];
        $i=0;
        foreach ($valueModels as $field_id=>$valueModel)
        {
            $fieldModel=$fieldModels[$field_id];
            $active = isset($_GET['DynamicValue'][$fieldModel->id]) || $i==0 ? 'active':null;
            /*$field = Html::activeCheckboxList($valueModel,  "[$fieldModel->id]value", $fieldModel->fromJson() ,  [
                'class' => 'form-control',
                //'class' => 'form-control btn-group',
                //'data-toggle' => 'buttons',
                //'unselect' => null, // remove hidden field
                'style'=>'padding:0; border:none; box-shadow:none; background:inherit; '.($active?null:'display:none;'),
                //'itemOptions'=>['class'=>'btn btn-default',],
                'item'=>function($index, $label, $name, $checked, $value) {
                    //$labelOptions['class'] = 'btn btn-default';
                    if($checked)
                        Html::addCssClass($labelOptions, 'active');
                    $return = Html::beginTag('label');
                    $return .= Html::checkbox($name, $checked, ['value' => $value]).' '.$label;
                    $return .= Html::endTag('label');;
                    return $return;
                },
            ]);*/
            $field = Html::activeCheckboxList($valueModel,  "[$fieldModel->id]value", $fieldModel->fromJson() ,  [
                'class' => 'form-control',
                //'class' => 'form-control btn-group',
                //'data-toggle' => 'buttons',
                //'unselect' => null, // remove hidden field
                'style'=>'padding:0; border:none; box-shadow:none; background:inherit; '.($active?null:'display:none;'),
                //'itemOptions'=>['class'=>'btn btn-default',],
                'item'=>function($index, $label, $name, $checked, $value) {
                    //$labelOptions['class'] = 'btn btn-default';
                    if($checked)
                        Html::addCssClass($labelOptions, 'active');
                    $return = Html::beginTag('label');
                    $return .= Html::checkbox($name, $checked, ['value' => $value]).' '.$label;
                    $return .= Html::endTag('label');;
                    return $return;
                },
            ]);
            echo $form->field($valueModel, "[$fieldModel->id]value",['parts'=>['{input}'=>$field ],
                'options'=>[
                    'class'=>'form-group '.$active
                ],
            ]);
            /*
            echo $form->field($valueModel, "[$i]value")->begin();
            echo Html::activeLabel($valueModel, 'value', ['class'=>'control-label',]) ;
            echo $fieldModel->getField($valueModel, "[$i]value");
            echo Html::error($valueModel, "[$i]value", ['class'=>'help-block']);
            echo $form->field($valueModel, "[$i]value")->end();
            */
            $i++;
        }
        ?>
    </div>


    <?php // echo $form->field($model, 'q') ?>

    <!--<div class="form-group">-->
    <?php //echo Html::button(Yii::t('product', 'Search'), ['class' => 'btn btn-primary submitButton']) ?>
    <?php //echo Html::button(Yii::t('product', 'Reset'), ['class' => 'btn btn-default resetButton']) ?>
    <!--</div>-->

    <?php ActiveForm::end(); ?>

</div>



