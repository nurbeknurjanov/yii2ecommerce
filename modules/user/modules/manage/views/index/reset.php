<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Messages;
use user\models\User;

/* @var $this yii\web\View */
/* @var $model user\models\User */

$this->title = Yii::t('common', 'Reset password: ') . ' ' . $model->fullName;

$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="user-update box">


    <div class="user-form box-body">

        <?php
        if(Yii::$app->session->hasFlash('successMessage'))
            echo \yii\bootstrap\Alert::widget([
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
                //'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
                    //'labelOptions' => ['class' => 'col-lg-4 control-label'],
                ],
            ]
        ); ?>

            <?=$form->errorSummary($model);?>

            <?= $form->field($model, 'password_new')->passwordInput(['maxlength' => 200]) ?>
            <?= $form->field($model, 'password_new_repeat')->passwordInput(['maxlength' => 200]) ?>


            <div class="form-group">
                <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        <?php
        }
        ?>

    </div>

</div>
