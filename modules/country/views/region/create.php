<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model country\models\Region */

$this->title = Yii::t('common', 'Create region');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Regions'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create box">

    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
