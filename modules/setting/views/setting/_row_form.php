<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use richardfan\widget\JSRegister;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use setting\models\JsonRow;

/* @var $this yii\web\View */
/* @var $model setting\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
$i=0;
$form->beginField($model, 'jsonRows');
echo GridView::widget(
    [
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->jsonRows,
            'pagination'=>false,
        ]),
        'columns'=>[
            [
                'attribute'=>'json_key',
                'format'=>'raw',
                'value'=>function(JsonRow $data) use ($form, &$i, $model){
                    return $form->field($data, "[$i]json_key", ['template'=>'{input}{error}',
                        'options'=>['style'=>'display:inline-block; width:150px;']])
                        ->error(['style'=>'font-size:10px;white-space:normal;'])
                        ->label(false);
                },
            ],
            [
                'attribute'=>$model->getAttributeLabel('json_value'),
                'format'=>'raw',
                'value'=>function(JsonRow $data) use ($form, &$i, $model){
                    return $form->field($data, "[$i]json_value", ['template'=>'{input}{error}',
                        'options'=>['style'=>'display:inline-block; width:200px; vertical-align:top;']])
                        ->error(['style'=>'font-size:10px;white-space:normal;'])->label(false)->textarea();
                },
            ],
            [
                'header'=>'Actions '.Html::a('Add', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs addRow']),
                'format'=>'raw',
                'value'=>function(JsonRow $data) use (&$i){
                    $buttons = '';
                    //if(Yii::$app->user->can('deleteRow', ['model'=>$data]))
                        $buttons.= Html::a('Remove', 'javascript:void(0)', ['class'=>'btn btn-danger btn-xs removeRow', 'data-i'=>$i]);
                    $buttons.= ' '.Html::a('Add', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs addRow', 'data-i'=>$i]);
                    //$buttons.=Html::activeHiddenInput($data, "[$i]id");
                    $i++;
                    return $buttons;
                },
            ],
        ]
    ]
);

//echo Html::error($model, 'jsonRows');
$form->endField();


?>


<?php JSRegister::begin(); ?>
<script>



    $(document).on('click', '.removeRow', function () {
        var i = $(this).data('i');
        $('#rowForm').yiiActiveForm('remove', 'jsonrow-'+i+'-json_key');
        $('#rowForm').yiiActiveForm('remove', 'jsonrow-'+i+'-json_value');
        $(this).parents('tr').remove();
    });

    $('body').on('click', '.addRow', function () {

        var $table = $('.grid-view table');

        var i = $table.find(' > tbody > tr').length;
        $.ajax({
            url: baseUrlWithLanguage+'/setting/setting/row-tr',
            data:{index:i},
            success:function(template)
            {
                $table.find(' > tbody > tr:last').after(template);
            }
        });
        return false;
    });

</script>
<?php JSRegister::end(); ?>
