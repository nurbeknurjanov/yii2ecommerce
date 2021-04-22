<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model i18n\models\I18nMessage */

$this->title = Yii::t('common', 'Update {modelClass}: ', [
    'modelClass' => 'I18n Message',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'I18n Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="i18n-message-update card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
