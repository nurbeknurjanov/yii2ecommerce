<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model user\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('user', 'Change email');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="user-form">

    <?php
    if(Yii::$app->session->hasFlash('success'))
        echo Alert::widget();
    else
    {
    ?>
        <?php $form = ActiveForm::begin(
            [
                'id'=>'change-email-form',
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>false,
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-4 control-label'],
                ],
            ]
        ); ?>
        <?=$form->errorSummary($model);?>
        <?= $form->field($model, 'email_new') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-8">
                <?= Html::submitButton(Yii::t('common', 'Send') , ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php
    }
    ?>
</div>

<?php
ob_start();
?>
    <script>
        window.bootboxValue=false;
        $('#change-email-form').on('beforeSubmit', function () {
            if(window.bootboxValue)
                return true;
            bootbox.confirm("<?=Yii::t('user', 'Are you sure to change your email ?');?>", function(result) {
                if(result){
                    window.bootboxValue=true;
                    $('#change-email-form').submit();
                }
            });
            return false;
        });
    </script>
<?php
$content = ob_get_contents();
$content = strip_tags($content, 'script');
ob_end_clean();
$javascript = <<<javascript
        $content
javascript;
$this->registerJs($javascript);