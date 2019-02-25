<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

/* @var \eav\models\DynamicField[] $fieldModels */
/* @var \eav\models\DynamicValue[] $valueModels */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use extended\helpers\Helper;
use yii\jui\SliderInput;
use yii\web\JsExpression;

$request = Yii::$app->request;

$i=0;
foreach ($valueModels as $field_id=>$valueModel)
{
    $fieldModel=$valueModel->fieldObject;
    $opened = ($valueModel->isNotEmpty || $i==0) ? 'opened':null;

    $field = $form->field($valueModel,"[$fieldModel->id]value", [
        'options'=>['class'=>'form-group '.$opened],
        'inputOptions'=>['class'=>'form-control checkBoxBlock'],
    ]);
    $fieldModel->trigger($fieldModel::EVENT_INIT_DATA);

    if($fieldModel->json_values){
        $field->checkboxList(Helper::jsonToArray($fieldModel->json_values),['class'=>'form-control checkBoxBlock']);
        $field->parts['{input}'] = Html::checkboxList($fieldModel->key,
            is_string($request->get($fieldModel->key)) ?
                explode('-',$request->get($fieldModel->key)):$request->get($fieldModel->key),
            Helper::jsonToArray($fieldModel->json_values),['class' => 'form-control checkBoxBlock']);
    }
    elseif($fieldModel->slider || $fieldModel->input_fields){
        ob_start();
        ?>
        <div class="checkBoxBlock">
            <?php
            if($fieldModel->slider){
                ?>
                <div style="margin: 5px 8px 0;" >
                    <?=SliderInput::widget([
                        'id' => 'slider'.$fieldModel->key,
                        'name' => 'slider'.$fieldModel->key,
                        'options'=>['disabled'=>'disabled',],
                        'clientOptions' => [
                            'min' => (float) $fieldModel->min,
                            'max' => (float) $fieldModel->max,
                            'range' => true,
                            'values' => [(float) $request->get($fieldModel->key."From")?:$fieldModel->min ,
                                (float) $request->get($fieldModel->key."To")?:$fieldModel->max],
                            'slide'=> new JsExpression ('function( event, ui ){
                                    $( "[name=\''.$fieldModel->key.'From\']" ).val(ui.values[ 0 ]);
                                    $( "[name=\''.$fieldModel->key.'To\']" ).val(ui.values[ 1 ]);
                            }'),
                            'change'=> new JsExpression ('function( event, ui ){
                            $(this).parents("form").submit();
                    }'),
                        ],
                    ]);?>
                </div>
                <?php
            }
            ?>
            <div style="margin: 10px 0;" style="<?=$fieldModel->input_fields? '':'display:none'?>" >
                <?=Yii::t('product', 'from');?> <?=Html::textInput($fieldModel->key."From", $request->get($fieldModel->key."From"),
                    ['class'=>'form-control inputRange']);?>
                <?=Yii::t('product', 'to');?> <?=Html::textInput($fieldModel->key."To",  $request->get($fieldModel->key."To"),
                    ['class'=>'form-control inputRange']);?>
            </div>
        </div>
        <?php
        $content = ob_get_clean();
        $field->parts['{input}'] = $content;
    }
    echo $field;
    $i++;
}