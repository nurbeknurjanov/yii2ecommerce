<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model delivery\models\CronEmailMessage */

$this->title = Yii::t('common', 'Update {modelClass}: ', [
    'modelClass' => 'Cron Email Message',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Report of cron email messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="cron-email-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
