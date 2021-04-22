<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">

            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>

            <p>
                The above error occurred while the Web server was processing your request.
                Please contact us if you think this is a server error. Thank you.
            </p>

        </div>
    </div>

</section>
<?php
if($this->context->layout=='//../not_logged_layouts/main'){
    $this->registerCss("
.content{
    padding:0;
}
.error-page{
    width: auto;
}
.error-page>.headline {
    font-size: 50px;
}
.error-page>.error-content {
    margin-left: 70px;
    display: block;
}
    ");
}