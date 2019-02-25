<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use user\models\User;
use yii\grid\GridView;
use order\models\OrderProduct;
use common\widgets\Alert;



/* @var $this yii\web\View */
/* @var $model order\models\Order */

$this->title = Yii::t('order', 'Shopping cart');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="title"><?= Html::encode($this->title) ?></h1>

<p>
    <?= Alert::widget() ?>
</p>

<?php
if($model->basketProducts)
{
    ?>
    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>
    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal', /*'enctype' => 'multipart/form-data'*/],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 control-label'],
        ],
    ]);
    ?>
        <?=$this->render('_products_form', ['form'=>$form, 'model'=>$model]);?>
        <div class="form-group" >
            <div class="col-lg-12">
                <?= Html::submitButton(Yii::t('order', 'Issue the order').' <i class=\'glyphicon glyphicon-chevron-right\'></i>', ['class' =>  'btn btn-success btn-lg' ]) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <?php
}
?>
