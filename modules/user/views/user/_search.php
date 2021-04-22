<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridViewAsset;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model user\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */

GridViewAsset::register($this);
?>

<div class="advancedSearch" style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($model, 'email') ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($model, 'status')->dropDownList($model->statusOptions, ['prompt'=>'Select',]) ?>
        </div>
        <div class="col-lg-4">
            <?php echo $form->field($model, 'rolesAttribute')->dropDownList($model->rolesValues, ['prompt'=>'Select',]) ?>
        </div>
        <div class="col-lg-4">
            <?php
            $options = [
                'options' => ['placeholder' => 'Select time', 'style'=>'width:120px;',],
                'size' => 'sm',
                'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'yyyy-MM-dd H:i',
                    'todayHighlight' => true,
                ]
            ];
            ?>
            <?=$form->field($model, 'created_at', ['parts'=>[
                '{input}'=>\kartik\field\FieldRange::widget([
                        //'form' => $form,
                        //'model' => $model,
                        'template'=> '{widget}{error}',
                        'name1' => 'from',
                        'value1' => isset($_GET['from']) ? $_GET['from']:'',
                        'name2' => 'to',
                        'value2' => isset($_GET['to']) ? $_GET['to']:null,
                        'type' => \kartik\field\FieldRange::INPUT_WIDGET,
                        'widgetClass' => \kartik\datetime\DateTimePicker::classname(),
                        'widgetOptions1'=> \yii\helpers\ArrayHelper::merge($options, ['options'=>['placeholder'=>'From date'],]),
                        'widgetOptions2'=> \yii\helpers\ArrayHelper::merge($options, ['options'=>['placeholder'=>'To date'],]),
                        'widgetContainer'=>[
                            'class'=>'form-control',
                            'style'=>'box-shadow:none; border:inherit; padding:0; height:auto;',
                        ],
                    ])
            ],]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default',
            'onclick'=>"javascript:window.location.href='".Url::to(['/user/user'])."'",]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?>

