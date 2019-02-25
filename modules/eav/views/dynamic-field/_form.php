<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use category\models\Category;
use eav\models\DynamicField AS DF;
use yii\helpers\Json;
use yii\web\View;
use extended\helpers\Helper;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model eav\models\DynamicField */
/* @var $form yii\widgets\ActiveForm */
?>

<br/>
<div class="dynamic-field-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\" >{input}{hint}{error}</div>\n",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
    ]); ?>


    <?=$form->errorSummary($model);?>

   <div class="row">
       <div class="col-lg-6">
           <?= $form->field($model, 'category_id')->dropDownList( ArrayHelper::map(
                   Category::find()
                       ->defaultFrom()->defaultOrder()
                       ->selectTitle()->enabled()->all(), 'id', 'title'), ['prompt'=>'Select', 'encode'=>false,]); ?>


           <?=$form->field($model, "label")->begin(); ?>
           <?=Html::activeLabel($model, "label", ['class'=>'col-lg-3 control-label',]) ?>
           <div class="col-lg-4">
               <?=Html::activeTextInput($model, 'label',['class'=>'form-control'])?>
               <?= Html::error($model, "label", ['class'=>'help-block']) ?>
           </div>
           <div class="col-lg-4">
               <?=$form->field($model, 'unit',[
                   'template' => "{label}\n<div class=\"col-lg-6\" >{input}{error}</div>",
                   'labelOptions' => ['class' => 'col-lg-6 control-label']
               ] )?>
           </div>
           <?=$form->field($model, "label")->end(); ?>

           <?= $form->field($model, 'type')->dropDownList($model->typeValues, ['prompt'=>Yii::t('common', 'Select')]) ?>

           <?php
           $model->trigger($model::EVENT_INIT_DATA);
           ?>
           <?=$form->field($model, "slider", [
               'options'=>[
                   'class'=>'form-group',
                   'style'=>in_array($model->type, [DF::TYPE_INPUT,DF::TYPE_AREA]) ? '':'display:none;'
               ]
           ])->begin(); ?>
               <?=Html::activeLabel($model, "slider", ['class'=>'col-lg-3 control-label',]) ?>
               <div class="col-lg-1">
                   <?=Html::activeCheckbox($model, 'slider', ['label'=>false])?>
                   <?= Html::error($model, "slider", ['class'=>'help-block']) ?>
               </div>
               <div class="col-lg-7">
                   <div class="row">
                       <div class="row">
                           <?=$form->field($model, 'min',[
                               'options'=>['class'=>'col-lg-6'],
                               'template' => "{label}\n<div class=\"col-lg-9\" >{input}{error}</div>",
                               'labelOptions' => ['class' => 'col-lg-3 control-label']
                           ] )?>
                           <?=$form->field($model, 'max',[
                               'options'=>['class'=>'col-lg-6'],
                               'template' => "{label}\n<div class=\"col-lg-9\" >{input}{error}</div>",
                               'labelOptions' => ['class' => 'col-lg-3 control-label']
                           ] )?>
                       </div>
                   </div>
               </div>
           <?=$form->field($model, "slider")->end(); ?>

           <?=$form->field($model, 'input_fields', [
               'options'=>[
                   'class'=>'form-group',
                   'style'=>in_array($model->type, [DF::TYPE_INPUT,DF::TYPE_AREA]) ? '':'display:none;'
               ]
           ])->checkbox([], false)?>

           <?php
           if(!Yii::$app->request->isPost){
               if(is_array($model->json_values))
                   $model->json_values = Helper::arrayToJson($model->json_values);
           }
           $hint = "<div class='pull-left'>".nl2br(Helper::arrayToJson(
                   ['asus'=>'Asus','apple'=>'Apple','samsung'=>'Samsung']))."
                        </div>
                        <div class='pull-left' style='margin: 0 20px;'>or for boolean</div>
                        <div class='pull-left'>
                            ".nl2br(Helper::arrayToJson( ['0'=>'No','1'=>'Yes']))."
                        </div>
                        <div class='clear'></div>
                        ";
           echo $form->field($model, 'json_values',
               [
                   'options'=>[
                       'class'=>'form-group',
                       'style'=>in_array($model->type, [DF::TYPE_DROP_DOWN_LIST,DF::TYPE_DROP_DOWN_LIST_MULTIPLE,DF::TYPE_RADIO_LIST,DF::TYPE_CHECKBOX_LIST ]) ? '':'display:none;'
                   ]
               ])->textarea(['rows' => 10])->hint($hint) ?>
           <?php echo $form->field($model, 'default_value')->textInput(['maxlength' => 100]) ?>

       </div>
       <div class="col-lg-6"  >
           <?=$form->field($model, "key")->begin(); ?>
               <?=Html::activeLabel($model, "key", ['class'=>'col-lg-3 control-label',]) ?>
               <div class="col-lg-4">
                   <?=Html::activeTextInput($model, 'key',['class'=>'form-control'])?>
                   <?= Html::error($model, "key", ['class'=>'help-block']) ?>
               </div>
               <div class="col-lg-4">
                   <?= $form->field($model, 'section',[
                       'template' => "{label}\n<div class=\"col-lg-8\" >{input}{error}</div>",
                       'labelOptions' => ['class' => 'col-lg-4 control-label']
                   ])->dropDownList($model->sectionValues, ['prompt'=>Yii::t('common', 'Select')]) ?>
               </div>
           <?=$form->field($model, "key")->end(); ?>

           <?php
           $model->rule=$model->ruleArray;
           echo $form->field($model, 'rule')->checkboxList( $model->ruleValues,
               [
                   'class' => 'btn-group',
                   'data-toggle' => 'buttons',
                   'item'=>function ($index, $label, $name, $checked, $value) {
                       return '<label class="btn btn-default' . ($checked ? ' active' : '') . '">' .
                           Html::checkbox($name, $checked, ['value' => $value, 'class' => 'project-status-btn']) . $label . '</label>';
                   },
               ]
           );
           ?>

           <?=$form->field($model, "position")->begin(); ?>
               <?=Html::activeLabel($model, "position", ['class'=>'col-lg-3 control-label',]) ?>
               <div class="col-lg-2">
                   <?=Html::activeTextInput($model, 'position',['class'=>'form-control'])?>
                   <?= Html::error($model, "position", ['class'=>'help-block']) ?>
               </div>
               <div class="col-lg-6">
                   <?php echo $form->field($model, 'with_label', [
                       'options'=>['class'=>'col-lg-6'],
                       'template' => "{label}{input}{error}",
                   ])->checkbox() ?>
                   <?php echo $form->field($model, 'clickable', [
                       'options'=>['class'=>'col-lg-6'],
                       'template' => "{label}{input}{error}",
                   ])->checkbox() ?>
               </div>
           <?=$form->field($model, "position")->end(); ?>

           <?=$form->field($model, "enabled")->checkbox([], false); ?>
       </div>

   </div>


    <div class="clear"></div>

    <div class="form-group">
        <div class="col-lg-offset-6"  >
            <div class="col-lg-offset-9">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php JSRegister::begin() ?>
<script>
    $('#dynamicfield-type').change(function(){
        if(in_array($(this).val(), [3,4,5,6]))
        {
            $('#<?=$form->id?>').yiiActiveForm('add', ".Json::encode(ArrayHelper::index($form->attributes, 'id')['dynamicfield-json_values'])." );
            $('.field-dynamicfield-json_values').show();

            $('#<?=$form->id?>').yiiActiveForm('remove', 'dynamicfield-slider' );
            $('#<?=$form->id?>').yiiActiveForm('remove', 'dynamicfield-input_fields' );
            $('#<?=$form->id?>').yiiActiveForm('remove', 'dynamicfield-min' );
            $('#<?=$form->id?>').yiiActiveForm('remove', 'dynamicfield-max' );
            $('.field-dynamicfield-slider').hide();
            $('.field-dynamicfield-input_fields').hide();
        }
        if(in_array($(this).val(), [1,2]))
        {
            $('#<?=$form->id?>').yiiActiveForm('remove', 'dynamicfield-json_values' );
            $('.field-dynamicfield-json_values').hide();

            $('#<?=$form->id?>').yiiActiveForm('add', ".Json::encode(ArrayHelper::index($form->attributes, 'id')['dynamicfield-slider'])." );
            $('#<?=$form->id?>').yiiActiveForm('add', ".Json::encode(ArrayHelper::index($form->attributes, 'id')['dynamicfield-input_fields'])." );
            $('#<?=$form->id?>').yiiActiveForm('add', ".Json::encode(ArrayHelper::index($form->attributes, 'id')['dynamicfield-min'])." );
            $('#<?=$form->id?>').yiiActiveForm('add', ".Json::encode(ArrayHelper::index($form->attributes, 'id')['dynamicfield-max'])." );
            $('.field-dynamicfield-slider').show();
            $('.field-dynamicfield-input_fields').show();
        }
    }).change();
</script>
<?php JSRegister::end() ?>
<?php
$this->registerJs("", View::POS_READY);

/*
foreach ($this->js as $jsArray)
    foreach ($jsArray as $js)
        echo $js."\n";
*/
?>
