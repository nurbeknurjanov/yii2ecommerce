<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model i18n\models\I18nSourceMessage */

$this->title = Yii::t('common', 'Create I18n Source Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'I18n Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-source-message-create box">


    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
