<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model country\models\Country */

$this->title = Yii::t('common', 'Create Country');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Countries'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create box">

    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
