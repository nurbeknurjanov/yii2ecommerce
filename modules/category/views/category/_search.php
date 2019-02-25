<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use extended\helpers\Helper;

/* @var $this yii\web\View */
/* @var $model category\models\search\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search advancedSearch" style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    $this->params['form'] = $form;
    ?>

    <div class="row">
        <div class="col-lg-4">
            <?php echo $form->field($model, 'title') ?>
        </div>
        <div class="col-lg-4">
            <?php echo $form->field($model, 'depth') ?>
        </div>
        <div class="col-lg-4">
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('common', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>