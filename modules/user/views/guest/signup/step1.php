<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \user\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use user\models\User;
use yii\helpers\ArrayHelper;
use himiklab\yii2\recaptcha\ReCaptcha;

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

?>
    <h1 class="title"><?= Html::encode($this->title) ?></h1>

<?php
$form = ActiveForm::begin([
    'id' => 'form-signup',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'options' => ['class' => 'form-horizontal', /*'enctype' => 'multipart/form-data'*/],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-4 control-label'],
    ],
]); ?>

    <?php
    $form->encodeErrorSummary = false;
    echo $form->errorSummary($model);?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'email',[
    'errorOptions'=>[
        'class'=>'help-block',
        'encode'=>false,
    ],
]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?php
    if(YII_ENV_PROD)
        echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className()) ?>

    <div class="form-group">
        <div class="col-lg-offset-4 col-lg-8">
            <?= Html::submitButton(Yii::t('common', 'Next'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>