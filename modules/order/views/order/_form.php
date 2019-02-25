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

/* @var $this yii\web\View */
/* @var $model order\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        //'options' => ['class' => 'form-horizontal', /*'enctype' => 'multipart/form-data'*/],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-4 control-label'],
            ],
        ]);
    ?>

    <?=$form->errorSummary($model);?>

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

    <?= $form->field($model, 'delivery_id')->dropDownList($model->deliveryValues, ['prompt'=>'Выбрать',]) ?>

    <?= $form->field($model, 'payment_type')->dropDownList($model->payment_typeValues, ['prompt'=>Yii::t('common', 'Select'),]) ?>

    <?php
    if(!$model->isNewRecord && Yii::$app->user->can('updateOrder')){
        ?>
        <?= $form->field($model, 'status')->radioList($model->statusValues); ?>
        <?php
    }
    ?>


    <div class="form-group">
        <div class="col-lg-offset-0 col-lg-0">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
