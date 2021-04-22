<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model country\models\Country */

$this->title = Yii::t('country', 'Create Country');
$this->params['breadcrumbs'][] = ['label' => Yii::t('country', 'Countries'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
