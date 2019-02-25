<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 11/5/16
 * Time: 11:46 AM
 */

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use page\models\HelpForm;
use yii\helpers\Html;
use page\assets\PageAsset;


/* @var $this \yii\web\View */

PageAsset::register($this);
?>


<?=Html::a('Help', ['/page/help'],
    ['class'=>'btn btn-default btn-lg helpLinkModal' ])?>

<?php
Modal::begin([
    'id'=>'helpModal',
    'header' => '<h4 style="display:inline;">'.Yii::t('page', 'Help').'</h4>',
    'clientOptions' => ['show' => false]
]);
?>

<?=$this->render('_form', ['model'=>new HelpForm])?>

<?php
Modal::end();
?>
