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
use user\models\User;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\grid\GridView;
use order\models\OrderProduct;
use common\widgets\Alert;


/* @var $this yii\web\View */
/* @var $model order\models\Order */

$this->title = Yii::t('common', 'Create Order');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Alert::widget() ?>
    </p>

<?php
if($orderProducts){
    ?>

    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>

    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal', /*'enctype' => 'multipart/form-data'*/],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 control-label'],
        ],
    ]);
    ?>

    <?=$form->errorSummary($model);?>

    <?=$this->render('_products_form', ['form'=>$form, 'model'=>$model, 'orderProducts'=>$orderProducts,]);?>

    <div class="row" >
        <div class="col-lg-6" >
            <h3 style="margin: 20px 0;">Информация о покупателе</h3>

            <?php
            if(Yii::$app->user->isGuest){
                ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                <?php
            }
            ?>
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-lg-6" >
            <h3 style="margin: 20px 0;" ><?=$model->getAttributeLabel('delivery_id');?></h3>
            <?= $form->field($model, 'delivery_id',[
                'options' => ['class' => 'none-form-group'],
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label', 'style'=>'font-size:20px;'],
            ])->radioList($model->deliveryValues,  [
                'class' => 'form-control btn-group',
                'data-toggle' => 'buttons',
                'style'=>'padding:0; border:none; box-shadow:none; background:inherit; display:block;',
                //'itemOptions'=>['class'=>'btn btn-default',],
                'item'=>function($index, $label, $name, $checked, $value)  {
                    $labelOptions['style'] = 'padding:40px; margin-right:10px; border-radius:5px;';
                    $labelOptions['class'] = 'btn btn-default';
                    if($checked)
                        Html::addCssClass($labelOptions, 'active');
                    $return = Html::beginTag('label', $labelOptions);
                    $return .= Html::radio($name, $checked, ['value' => $value]);
                    $return .= ' '.$label;
                    $return .= '</label>';
                    return $return;
                },
            ])->label(false) ?>

            <div class="clear"></div>

            <h3 style="margin: 40px 0 20px;" ><?=$model->getAttributeLabel('payment_type');?></h3>
            <?= $form->field($model, 'payment_type',[
                'options' => ['class' => 'none-form-group'],
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label', 'style'=>'font-size:20px;'],
            ])->radioList($model->payment_typeValues,[
                'class' => 'form-control btn-group',
                'data-toggle' => 'buttons',
                'style'=>'padding:0; border:none; box-shadow:none; background:inherit; display:block;',
                //'itemOptions'=>['class'=>'btn btn-default',],
                'item'=>function($index, $label, $name, $checked, $value)  {
                    $labelOptions['style'] = 'padding:40px; margin-right:10px; border-radius:5px;';
                    $labelOptions['class'] = 'btn btn-default';
                    if($checked)
                        Html::addCssClass($labelOptions, 'active');
                    $return = Html::beginTag('label', $labelOptions);
                    $return .= Html::radio($name, $checked, ['value' => $value]);
                    $return .= ' '.$label;
                    $return .= '</label>';
                    return $return;
                },
            ])->label(false) ?>

            <div class="clear"></div>

            <div class="form-group" style="margin-top: 40px;">
                <div class="col-lg-12">
                    <?= Html::submitButton(Yii::t('common', 'Order'), ['class' =>  'btn btn-success btn-lg' ]) ?>
                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
}