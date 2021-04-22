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

$this->title = 'Create dynamic field';
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Dynamic fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dynamic-field-create card">

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
