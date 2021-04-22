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
use yii\helpers\Url;
use user\models\User;
use country\models\Country;
use country\models\Region;
use country\models\City;


/* @var $this yii\web\View */
/* @var $model order\models\search\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search advancedSearch"  style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >

    <?php $form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'phone') ?>
            <?php echo $form->field($model, 'delivery_id')->radioList($model->deliveryValues,
                ['prompt'=>'Select', 'separator'=>'<br>',]) ?>
            <?php echo $form->field($model, 'description') ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($model, 'country_id',['parts'=>['{input}'=>
                (new Country)->getWidgetSelectPicker($model, 'country_id', null, ['class'=>'selectpicker country_id',])]]) ?>
            <?=$form->field($model, 'region_id',['parts'=>['{input}'=>
                (new Region)->getWidgetSelectPicker($model, 'region_id', Region::find()->countryQuery($model->country_id),
                    ['class'=>'selectpicker region_id',
                        'data-url'=>Url::to(['/country/region/select-picker', 'country_id'=>$model->country_id])])]]) ?>
            <?=$form->field($model, 'city_id',['parts'=>['{input}'=>
                (new City)->getWidgetSelectPicker($model, 'city_id', City::find()->regionQuery($model->region_id),
                    ['class'=>'selectpicker city_id',
                        'data-url'=>Url::to(['/country/city/select-picker', 'region_id'=>$model->region_id])
                        /*'multiple'=>true,*/])]]) ?>
            <?php echo $form->field($model, 'address') ?>
        </div>
        <div class="col-lg-4">
            <?=$form->field($model, 'created_at',['parts'=>[
                '{input}'=> $model->getBehavior('dateSearchCreatedAt')->getWidgetFilter(true)
            ]])?>
            <?=$form->field($model, 'updated_at',['parts'=>[
                '{input}'=> $model->getBehavior('dateSearchUpdatedAt')->getWidgetFilter(true)
            ]])?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>