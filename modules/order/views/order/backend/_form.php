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
use country\models\Country;
use country\models\Region;
use country\models\City;

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
        <?= $form->field($model, 'name')->textInput(['readonly'=>true]) ?>
        <?= $form->field($model, 'email')->textInput(['readonly'=>true]) ?>
        <?= $form->field($model, 'phone')->textInput(['readonly'=>true]) ?>
        <?php
    }
    ?>


    <?=$form->field($model, 'country_id',['parts'=>['{input}'=>
        (new Country)->getWidgetSelectPicker($model, 'country_id', null, ['class'=>'selectpicker country_id', 'disabled'=>true])]]) ?>
    <?=$form->field($model, 'region_id',['parts'=>['{input}'=>
        (new Region)->getWidgetSelectPicker($model, 'region_id', Region::find()->countryQuery($model->country_id),
            ['class'=>'selectpicker region_id', 'disabled'=>true])]]) ?>
    <?=$form->field($model, 'city_id',['parts'=>['{input}'=>
        (new City)->getWidgetSelectPicker($model, 'city_id', City::find()->regionQuery($model->region_id),
            ['class'=>'selectpicker city_id', 'disabled'=>true])]]) ?>


    <?= $form->field($model, 'address')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'readonly'=>true]) ?>

    <?= $form->field($model, 'delivery_id')->dropDownList($model->deliveryValues, ['prompt'=>'Выбрать', 'disabled'=>true]) ?>

    <?= $form->field($model, 'payment_type')->dropDownList($model->paymentTypeValues, ['prompt'=>Yii::t('common', 'Select'), 'disabled'=>true]) ?>

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
