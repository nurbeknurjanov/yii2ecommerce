<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model eav\models\search\DynamicFieldSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dynamic-field-search advancedSearch row" style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-lg-4">
        <?= $form->field($model, 'key') ?>
        <?= $form->field($model, 'enabled')->radioList($model->booleanValues) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'rule')->radioList($model->ruleValues, [
                'item' => function($index, $label, $name, $checked, $value) {
            $return = '<label>';
            $return .= Html::radio($name, $checked, ['value'=>$value,]);
            $return .= ' '.$label;
            $return .= '</label>';
            return $return;
        }, 'separator'=>'<br>',]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'default_value') ?>
    </div>

    <div class="clear"></div>
    <div class="form-group col-lg-12">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>