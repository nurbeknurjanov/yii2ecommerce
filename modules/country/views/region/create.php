<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model country\models\Region */

$this->title = Yii::t('country', 'Create State/Province');
$this->params['breadcrumbs'][] = ['label' => Yii::t('country', 'States/Provinces'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
