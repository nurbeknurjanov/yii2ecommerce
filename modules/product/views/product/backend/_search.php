<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use user\models\User;
use category\models\Category;
use yii\helpers\Url;
use extended\helpers\Helper;
        
/* @var $this yii\web\View */
/* @var $model product\models\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advancedSearch" style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >
    <?php $form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]);
    $this->params['form'] = $form;
    ?>

    <div class="row">
        <div class="col-lg-4">
            <?=$form->field($model, 'category_id')->dropDownList(
                    ArrayHelper::map(Category::find()
                        ->defaultFrom()->defaultOrder()
                        ->selectTitle()->all(), 'id', 'title'),
                    ['prompt'=>'Select',
                        'class'=>'form-control eavSelectForSearchInBackend',
                        'encode'=>false,]) ?>
            <div class="well eavFields">
                <?php
                foreach ($model->valueModels as $field_id=>$valueModel)
                {
                    $fieldModel=$model->fieldModels[$field_id];
                    echo $form->field($valueModel, "[$fieldModel->id]value",
                        ['parts'=>['{input}'=>$fieldModel->getFieldWithUnit($valueModel, "[$fieldModel->id]value") ]]);
                }
                ?>
            </div>
            <?= $form->field($model, 'enabled')->radioList(Helper::$booleanValues); ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'description') ?>

            <?php $this->beginBlock('sku') ?>
            <?= $form->field($model, 'sku') ?>
            <?php $this->endBlock() ?>
            {{sku}}
        </div>
        <div class="col-lg-4">
            <?php $this->beginBlock('dateSearch') ?>
                <?=$form->field($model, 'created_at',['parts'=>[
                    '{input}'=> $model->getBehavior('dateSearchCreatedAt')->getWidgetFilter(true)
                ]])?>
                <?=$form->field($model, 'updated_at',['parts'=>[
                    '{input}'=> $model->getBehavior('dateSearchUpdatedAt')->getWidgetFilter(true)
                ]])?>
            <?php $this->endBlock() ?>
            {{dateSearch}}
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('product', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('product', 'Reset'), ['class' => 'btn btn-default',
            'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>