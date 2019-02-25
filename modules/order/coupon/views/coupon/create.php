<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model coupon\models\Coupon */

$this->title = Yii::t('common', 'Create Coupon');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Coupons'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
