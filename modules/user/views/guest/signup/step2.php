<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \user\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use user\models\User;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

?>
    <h1 class="title"><?= Html::encode($this->title) ?></h1>


<?php
$form = ActiveForm::begin([
    'id' => 'form-signup',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>false,
    //'options' => ['class' => 'form-horizontal', /*'enctype' => 'multipart/form-data'*/],
    'fieldConfig' => [
        //'template' => "{label}\n<div class=\"col-lg-4\">{input}{hint}</div>\n<div class=\"col-lg-4\">{error}</div>",
        //'labelOptions' => ['class' => 'col-lg-4 control-label'],
    ],
]); ?>

    <div id="waitAlert" class="alert-success alert fade in" style="display: none">
        We are creating your account <img src="<?=Yii::$app->request->baseUrl;?>/images/ajax-loader.gif" >
    </div>

    <?php
    $form->encodeErrorSummary = false;
    echo  $form->errorSummary($model) ?>

    <?php
    $termText = nl2br(Yii::t('user', "Agreement_text"));
    ?>
    <?= $form->field($model, 'accept_terms', ['template'=>"
        {$termText}<br>
        {input}{label}
        <div class=\"col-lg-12\">{error}</div>
    ",
    'labelOptions' => ['class' => 'control-label', 'style'=>'margin:0 0 0 5px;',],
    'errorOptions'=>['encode'=>false],
    ])->checkbox([], false); ?>

    <div class="form-group">
            <?php echo Html::a(Yii::t('common', 'Back'), ['/user/guest/signup'],['class' => 'btn btn-success']) ?>
            <?= Html::submitButton(Yii::t('common', 'Finish'), ['class' => 'btn btn-success finishButton']) ?>
    </div>

<?php ActiveForm::end(); ?>