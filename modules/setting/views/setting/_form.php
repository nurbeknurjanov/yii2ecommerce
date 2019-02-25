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
            $valueField = $form->field($model, 'value');
            $valueField->label($model->keyText);
            if(!Yii::$app->request->isPost)
                $model->value = $model::getValue($model->key);
            switch ($model->fieldType){
                case 'textinput':$field = Html::activeTextInput($model, 'value',['class'=>'form-control']); break;
                case 'textarea':$field = Html::activeTextarea($model, 'value', ['class'=>'form-control','rows'=>6]); break;
                case 'ckeditor':
                    $field = CKEditor::widget([
                        'model'=>$model,
                        'attribute'=>'value',
                        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                            'preset' => 'basic',
                            'allowedContent'=>true,
                            'height'=>300,
                        ])
                    ]);
                    break;
                case 'checkbox':$field = Html::activeCheckbox($model, 'value',
                                            ['label'=>false, 'style'=>'display:block',]); break;
            }
            $valueField->parts['{input}'] = $field;
            if($model->key)
                echo $valueField;
            ?>
        </div>
    </div>



    <div class="form-group">
        <div style="text-align: right">
            <?= Html::submitButton(($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update')) . ' <i class="fas fa-chevron-right"></i>', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?= Html::a('<i class="fas fa-chevron-left"></i> Go back', ['/setting/setting/index'], ['class' => 'btn btn-default pull-left', 'style' => 'margin-right: 10px;']); ?>
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
