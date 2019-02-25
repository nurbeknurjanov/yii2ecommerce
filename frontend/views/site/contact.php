<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Alert;
use \himiklab\yii2\recaptcha\ReCaptcha;

$this->title = Yii::t('common', 'Feedback');
$this->params['breadcrumbs'][] = $this->title;

/*$this->beginBlock('sidebar');
echo 'это мой сайдбар';
$this->endBlock();*/
?>
<div class="site-contact">
    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <?php
    if(Yii::$app->session->hasFlash('success'))
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::$app->session->getFlash('success', null, true),
        ]);
    else{
        ?>
        <p>
            <?=Yii::t('common', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.');?>
        </p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'enableAjaxValidation'=>true,
                    'enableClientValidation'=>true,
                    //'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
                    'fieldConfig' => [
                        //'template' => "{label}\n<div class=\"col-lg-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
                        //'labelOptions' => ['class' => 'col-lg-2 control-label'],
                    ],
                ]); ?>

                <?=$form->errorSummary($model);?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'phone') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

                <?php
                if(YII_ENV_PROD)
                {
                    ?>
                    <?php
                    echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className()) ?>
                    <?php
                }
                ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('common', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php
    }
    ?>

</div>