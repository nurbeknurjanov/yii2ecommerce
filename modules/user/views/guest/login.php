<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \user\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('common', 'Login');
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="site-login">
    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
            ]); ?>

                <?php
                $form->encodeErrorSummary = false;
                echo $form->errorSummary($model);
                ?>

                <?= $form->field($model, 'username', [
                    'errorOptions' => ['encode' => false]
                ]) ?>

                <?= $form->field($model, 'password',  [
                    'errorOptions' => ['encode' => false]
                ])->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <?php
            if(Yii::$app->id=='app-frontend' || Yii::$app->id=='app-frontend-test'){
                ?>
              <div style="color:#999;margin:1em 0">
                  <?= Yii::t('user','If you have forgotten your password, you can {link}', ['link'=>Html::a(Yii::t('user','reset it'), ['/user/guest/request-password-reset'])]); ?>.
              </div>
                <?php
            }
            ?>
          <div style="color:#999;margin:1em 0">
              login: admin<br>
              password: 123123
          </div>


                <div class="form-group">
                    <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    &nbsp;
                    <?php
                    if(Yii::$app->id=='app-frontend' || Yii::$app->id=='app-frontend-test')
                      echo Html::a(Yii::t('user','Sign up'), ['/user/guest/signup']);
                    ?>
                </div>

            <?php ActiveForm::end(); ?>

            <?php
            if(Yii::$app->id=='app-frontend')
              echo yii\authclient\widgets\AuthChoice::widget([ 'baseAuthUrl' => ['/user/guest/auth'], 'options'=>[
                  'style'=>'padding:0;',
              ] ]);
            ?>
            
        </div>
    </div>
</div>
