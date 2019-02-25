<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use page\models\HelpForm;
use yii\helpers\Html;
use page\assets\PageAsset;

/* @var HelpForm $model */
?>

<?=Yii::t('page', 'Please leave your name and phone number, and we will recall you as soon as possible.');?>
<?php
$form = ActiveForm::begin([
    'action'=>['/page/help'],
    'id' => 'help-form',
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
$model->subject = Yii::t('page', 'You have requested for help.');
?>
<?=Html::activeHiddenInput($model, 'subject')?>
<?= $form->field($model, 'name') ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'phone') ?>
        </div>
    </div>
<?= $form->field($model, 'body')->textarea() ?>

<?php
$model->page_url = Yii::$app->urlManager->createAbsoluteUrl(
    array_merge([Yii::$app->request->resolve()[0]], Yii::$app->request->resolve()[1]));
?>
<?=Html::activeHiddenInput($model, 'page_url');?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

<?php ActiveForm::end(); ?>