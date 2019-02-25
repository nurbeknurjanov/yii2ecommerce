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


<div class="helpBlock" >
    <?=Html::a('Help', ['/page/help'],
        ['class'=>'btn btn-default btn-lg rotate helpLink' ])?>
    <div>
        <?=$this->render('_form', ['model'=>new HelpForm])?>
    </div>
</div>