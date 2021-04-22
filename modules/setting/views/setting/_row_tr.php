<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/5/17
 * Time: 8:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use item\models\Item;
use ingredient\models\Ingredient;
use yii\helpers\Json;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

?>


<?php


$form = new ActiveForm([
    'id' => 'rowForm',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
]);



$data = new \setting\models\JsonRow;
$i = $index;
?>

<tr data-key="<?= $i ?>">
    <td>
        <?= $form->field($data, "[$i]json_key", ['template' => '{input}{error}',
            'options' => ['style' => 'display:inline-block; width:150px;']])
            ->error(['style' => 'font-size:10px;white-space:normal;'])
            ->label(false)
        ?>
    </td>
    <td>
        <?= $form->field($data, "[$i]json_value", ['template'=>'{input}{error}',
            'options'=>['style'=>'display:inline-block; width:200px; vertical-align:top;']])
            ->error(['style'=>'font-size:10px;white-space:normal;'])->label(false)->textarea(); ?>
    </td>
    <td>
        <?php
        $buttons = '';
        //if(Yii::$app->user->can('deleteIngredient', ['model'=>$data]))
            $buttons.= Html::a('Remove', 'javascript:void(0)', ['class'=>'btn btn-danger btn-xs removeRow', 'data-i'=>$i]);
        $buttons.= ' '.Html::a('Add', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs addRow', 'data-i'=>$i]);
        $buttons.=Html::activeHiddenInput($data, "[$i]id");
        echo $buttons;
        ?>
    </td>
</tr>


    <script>
        <?php
        foreach ($form->attributes as $attribute) {
            $this->registerJs( "jQuery('#rowForm').yiiActiveForm('add', ".Json::encode($attribute)." );\n ", View::POS_READY, $attribute['id'] );
            echo $this->js[View::POS_READY][$attribute['id']];
        }
        ?>
    </script>
<?php

//$form->registerClientScript();




