<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model i18n\models\I18nSourceMessage */

$this->title = Yii::t('common', 'Update {modelClass}: ', [
    'modelClass' => 'I18n Source Message',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'I18n Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="i18n-source-message-update box">

    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
