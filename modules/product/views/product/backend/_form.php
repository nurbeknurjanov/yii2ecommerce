<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use extended\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use user\models\User;
use category\models\Category;
use kartik\file\FileInput;
use file\models\FileImage;
use file\widgets\file_preview\FilePreview;
use product\models\Product;
use extended\vendor\BootstrapSelectAsset;
use eav\assets\EavAsset;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model \product\models\Product */
/* @var $form yii\widgets\ActiveForm */

$eavAsset = EavAsset::register($this);

?>

<div class="product-form">
    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>

    <?php
    $form = ActiveForm::begin([
        'id'=>'productForm',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\" >{input}</div>\n<div class=\"col-lg-9 col-lg-offset-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
            ],
        ]);
    $this->params['form'] = $form;
    ?>

    <?php $this->beginBlock('fields') ?>
        <?=$form->errorSummary($model);?>
        <div class="col-lg-6">

            <?=$form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?php $this->beginBlock('sku') ?>
                <?= $form->field($model, 'sku', [
                    'template' => "{label}\n<div class=\"col-lg-4\" >{input}{error}</div>",
                ]) ?>
            <?php $this->endBlock() ?>
            {{sku}}
            <?= $form->field($model, 'price', [
                'template' => "{label}\n<div class=\"col-lg-4\" >{input}{error}</div>",
                'parts'=>[  '{input}'=> Html::inputWithSymbol($model, 'price', Yii::$app->formatter->currencySymbol)],
            ]) ?>
            <?=$form->field($model, "discount")->begin(); ?>
                <?=Html::activeLabel($model, "discount", ['class'=>'col-lg-3 control-label',]) ?>
                <div class="col-lg-4">
                    <?=Html::inputWithSymbol($model, 'discount', '%')?>
                    <?= Html::error($model, "discount", ['class'=>'help-block']) ?>
                </div>
                <div class="col-lg-5">
                    <!--old price-->
                </div>
            <?=$form->field($model, "discount")->end(); ?>

            <?php
            if(!Yii::$app->request->isPost)
                $model->type = $model->typeArray;
            echo $form->field($model, 'type')->checkboxList($model->typeValues, ['style'=>'padding-top:7px']);
            ?>
            <?= $form->field($model, 'status')->radioList($model->statusValues, ['style'=>'padding-top:7px']) ?>
            <?= $form->field($model, 'description')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'full',
                    'inline' => false,
                    'resize_enabled'=>true,
                    'height'=>300,
                    'toolbarGroups'=>[
                        ['name' => 'clipboard', 'groups' => [
                            'mode',
                            'doctools'
                        ]],
                        ['name' => 'editing', 'groups' => [ 'tools']],]
                ]),
            ]); ?>

            <?=$form->field($model, 'buyWithThisAttribute',['parts'=>['{input}'=>
                (new Product)->getWidgetSelectPicker($model, 'buyWithThisAttribute',
                    Product::find()->notTheSame($model), ['multiple'=>true])]]) ?>

            <?php
            if($model->canBeParentOfGroup){
                ?>
                <?=$form->field($model, 'groupedProductsAttribute',['parts'=>['{input}'=>
                    (new Product)->getWidgetSelectPicker($model, 'groupedProductsAttribute',
                        Product::find()->not($model), ['multiple'=>true])]]) ?>
                <?php
            }
            ?>

        </div>
        <div class="col-lg-6">
            <?php $this->beginBlock('category_id') ?>
                <?=$form->field($model, 'category_id')->dropDownList(ArrayHelper::map(
                        Category::find()->defaultFrom()->defaultOrder()
                            ->selectTitle()->enabled()->all(), 'id', 'title'),
                [
                    'prompt'=>'Select',
                    'class'=>'form-control eavSelect',
                    'encode'=>false,
                'data'=>[
                    'object_id'=>$model->id,
                ],
            ]); ?>
            <?php $this->endBlock() ?>
            {{category_id}}
            <img src="<?=$eavAsset->baseUrl;?>/images/loading.gif" id="loading" style="display: none;" />
            <div class="well eavFields">
                <?php
                foreach ($model->valueModels as $field_id=>$valueModel){
                    $fieldModel=$model->fieldModels[$field_id];
                    echo $form->field($valueModel, "[$fieldModel->id]value",
                        ['parts'=>['{input}'=>$fieldModel->getFieldWithUnit($valueModel, "[$fieldModel->id]value") ]]);
                }
                ?>
            </div>

            <?php
            $imagesAttributeField = $form->field($model, 'imagesAttribute[]');//->fileInput(['hiddenOptions'=>['value'=>'123']]);
            $imagesAttributeField->parts['{input}'] =  FilePreview::widget(['images'=>$model->images]);
            $imagesAttributeField->parts['{input}'].=FileInput::widget([
                'model' => $model,
                'attribute' => 'imagesAttribute[]',
                'options' => ['multiple' => true, 'hiddenOptions'=>['value'=>'']],
            ]);
            $imagesAttributeField->template = "{label}\n<div class=\"col-lg-9\">{input}</div>\n
                        <div class=\"col-lg-9 col-lg-offset-3\">{error}</div>";
            $imagesAttributeField->labelOptions =  ['class' => 'col-lg-3 control-label'];
            echo $imagesAttributeField;
            ?>

            <?=$form->field($model,'enabled')->checkbox([], false)?>
        </div>
    <?php $this->endBlock() ?>
    {{fields}}


    <?php $this->beginBlock('additional-fields') ?>
    <?php $this->endBlock() ?>
    {{additional-fields}}


    <div class="clear"></div>
    <div class="form-group">
        <div class="col-lg-12" >
            <div class="col-lg-12" style="text-align: right">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('product', 'Create') : Yii::t('product', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
