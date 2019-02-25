<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model setting\models\Setting */

$this->title = Yii::t('common', 'Create setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Settings'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create box">


    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>


</div>
