<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 11/5/16
 * Time: 11:46 AM
 */

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use page\models\CallBackForm;
use yii\helpers\Html;

\page\assets\AppAsset::register($this);
?>
<?php
Modal::begin([
    'id'=>'callBackModal',
    'header' => '<h4 style="display:inline;">'.Yii::t('page', 'Call back').'</h4>',
    'clientOptions' => ['show' => false]
]);
?>
    <?=Yii::t('page', 'Please leave your name and phone number, and we will recall you as soon as possible.');?>
    <?php
    $model = new CallBackForm();
    $form = ActiveForm::begin([
        'action'=>['/page/call-back'],
        'id' => 'call-back-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        //'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            //'template' => "{label}\n<div class=\"col-lg-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
            //'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?=$form->errorSummary($model);?>

    <?php
    $model->subject = Yii::t('page', 'You have requested to call back.');
    ?>
    <?=Html::activeHiddenInput($model, 'subject')?>
    <?= $form->field($model, 'name')->textInput(['autofocus' => true,]) ?>
    <?= $form->field($model, 'phone') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php
Modal::end();
?>
