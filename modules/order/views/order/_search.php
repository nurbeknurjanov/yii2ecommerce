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
use yii\helpers\Url;
use user\models\User;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
        
/* @var $this yii\web\View */
/* @var $model order\models\search\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search advancedSearch"  style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >

    <?php $form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?php //echo $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(\user\models\User::find()->all(), 'id', 'fullName'), ['prompt'=>Yii::t('common', 'Select'),]) ?>

    <?php //echo $form->field($model, 'name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone') ?>

    <?php echo $form->field($model, 'city') ?>

    <?php echo $form->field($model, 'address') ?>

    <?php echo $form->field($model, 'description') ?>

    <?php //echo $form->field($model, 'delivery_id')->dropDownList($model->deliveryValues, ['prompt'=>'Select',]) ?>

    <?php /*echo $form->field($model, 'created_at')->widget(DateTimePicker::className(), [
        'model' => $model,
        'attribute' => 'created_at',
        'options' => ['placeholder' => 'Select time'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
        ]
    ])*/ ?>

    <?php /*echo $form->field($model, 'updated_at')->widget(DateTimePicker::className(), [
        'model' => $model,
        'attribute' => 'updated_at',
        'options' => ['placeholder' => 'Select time'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
        ]
    ])*/ ?>

    <?php //echo $form->field($model, 'amount') ?>

    <?php //echo $form->field($model, 'payment_type')->dropDownList($model->payment_typeValues, ['prompt'=>Yii::t('common', 'Select'),]) ?>
    <?php //echo $form->field($model, 'status')->dropDownList($model->statusValues, ['prompt'=>Yii::t('common', 'Select'),]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>