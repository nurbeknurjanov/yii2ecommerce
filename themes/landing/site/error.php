<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Alert;

$this->title = Yii::t('common', 'Feedback');
//$this->params['breadcrumbs'][] = $this->title;

/*$this->beginBlock('sidebar');
echo 'это мой сайдбар';
$this->endBlock();*/
?>

<!-- About Section Start -->
<section id="main_opportunity" class="section">
    <div class="container">
        <div class="section-header">

            <h2 class="section-title wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?=$name?>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="300ms">
                <?= nl2br(Html::encode($message)) ?>
            </div>
        </div>
    </div>
    <div class="img-about-out">
    </div>
</section>
<!-- About Section End -->



