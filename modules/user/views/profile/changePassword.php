<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model user\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('user', 'Change password');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="user-form">

    <?php
    if(Yii::$app->session->hasFlash('successMessage'))
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::$app->session->getFlash('successMessage', null, true),
        ]);
    else
    {
    ?>
        <?php $form = ActiveForm::begin(
            [
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 control-label'],
                ],
            ]
        ); ?>

        <?=$form->errorSummary($model);?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 200]) ?>
        <?= $form->field($model, 'password_new')->passwordInput(['maxlength' => 200]) ?>
        <?= $form->field($model, 'password_new_repeat')->passwordInput(['maxlength' => 200]) ?>


        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-8">
                <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    <?php
    }
    ?>

</div>
