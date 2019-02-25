<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model delivery\models\CronEmailMessage */

$this->title = Yii::t('common', 'Create Cron Email Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Cron Email Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cron-email-message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
