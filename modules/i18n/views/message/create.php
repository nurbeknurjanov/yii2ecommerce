<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model i18n\models\I18nMessage */

$this->title = Yii::t('common', 'Create I18n Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'I18n Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-message-create box">

    <div class="box-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
