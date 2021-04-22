<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use richardfan\widget\JSRegister;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model setting\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<br>
<div class="setting-form">

    <?php
    $form = ActiveForm::begin([
        'id'=>'rowForm',
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

    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'key')->dropDownList($model->keyValues,['prompt'=>'Select']) ?>
        </div>
        <div class="col-lg-12">
            <?php
            if($model->key)
                echo $model->getField($form);
            ?>
        </div>
    </div>



    <div class="form-group">
        <div style="text-align: right">
            <?= Html::submitButton(($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update')), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php JSRegister::begin(); ?>
<script>
    var u = new Url();
    $(document).on('change', '[name="Setting[key]"]', function () {
        u.query.key = $(this).val();
        window.location.href=u.toString();
    });
</script>
<?php JSRegister::end(); ?>
