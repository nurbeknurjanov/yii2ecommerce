<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use order\models\OrderProduct;
use yii\helpers\Html;

?>


<?php
Modal::begin([
    'id'=>'basketModal',
    'header' => '<h4 style="display:inline;">'.Yii::t('order', 'Shopping cart').'</h4>',
    'clientOptions' => ['show' => false]
]);
?>

    <?php
    $model = new OrderProduct;
    $form = ActiveForm::begin([
        'action'=>['/order/order-product/create'],
        'id' => 'basketForm',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8 col-xs-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4 col-xs-8 col-xs-offset-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 col-xs-4 control-label'],
        ],
    ]);
        ?>
        <?=$form->errorSummary($model);?>
        <?php
        echo $form->field($model, 'product_id', [
            'parts'=>[
                '{input}'=>
                    Html::activeHiddenInput($model, 'product_id').
                    Html::tag("span", null,['class'=>'form-control spanBasketFieldStyle']),
            ],
        ]);
        ?>
        <?php echo $form->field($model, 'price', [
            'options'=>['style'=>'display:none1;', 'class'=>'form-group',],
            'parts'=>[
                '{input}'=>Html::activeHiddenInput($model, 'price').
                    Html::tag("span", null, ['class'=>'form-control spanBasketFieldStyle'])
                    .Yii::$app->formatter->currencySymbol,
            ]
        ]) ?>
        <?= $form->field($model, 'count', [
            'parts'=>[
                '{input}'=> Html::tag("div",
                                            Html::activeTextInput($model, "count", ['class'=>'form-control']).
                                            Html::tag("span", Html::tag("button", Yii::t('order', 'pc'), ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
                                            ['class'=>'input-group', 'style'=>'width:70%;'])
            ],
        ]); ?>

        <div class="form-group buttons">
            <div class="col-lg-8 col-lg-offset-4 col-xs-8 col-xs-offset-4">
                <?= Html::submitButton(Yii::t('order', 'Issue the order'),
                    ['class' => 'btn btn-warning', 'name' => 'buttonValue', 'value'=>'order',]) ?>
                <?= Html::submitButton(Yii::t('order', 'Continue shopping'),
                    ['class' => 'btn btn-default', 'name' => 'buttonValue', 'value'=>'next',]) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

<?php
Modal::end();
?>
