<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model setting\models\Setting */

$this->title = Yii::t('common', 'Update setting: ') . ' ' . $model->keyText;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Settings'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->keyText, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="setting-update box">

    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
