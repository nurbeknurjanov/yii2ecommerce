<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model eav\models\DynamicField */

$this->title = Yii::t('eav', 'Update dynamic field') . ' ' . $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('eav', 'Dynamic fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="dynamic-field-update card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
