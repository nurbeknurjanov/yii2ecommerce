<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Alert;


//$this->title = 'Contact';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-12">
            <?php
            if(Yii::$app->session->hasFlash('errorMessage'))
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-danger',
                    ],
                    'body' => Yii::$app->session->getFlash('errorMessage', null, true),
                ]);

            /*foreach (Yii::$app->session->getAllFlashes() as $type => $message) {
                echo Alert::widget([
                    'options' => [
                        'class' => 'alert-'.($type=='error'?'danger':$type),
                    ],
                    'body' => Yii::$app->session->getFlash($type, null, true),
                ]);
                //$session->removeFlash($type);
            }*/
            echo \common\widgets\Alert::widget();
            ?>
        </div>
    </div>

</div>
