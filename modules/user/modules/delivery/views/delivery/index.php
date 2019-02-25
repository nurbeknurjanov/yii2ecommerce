<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model delivery\models\DeliveryForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use user\models\User;
use user\assets\UserAsset;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;


UserAsset::register($this);


$this->title = 'Send email messages to users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact box">

   <div class="box-body">
       <div class="row">
           <div class="col-lg-12">
               <?php $form = ActiveForm::begin([
                   'id' => 'delivery-form',
                   'enableAjaxValidation'=>true,
                   'enableClientValidation'=>true,
               ]);
               ?>
               <?php
               echo $form->field($model, 'role')
                   ->checkboxList((new User())->rolesValues);
               ?>

               <?php
               echo $form->field($model, 'subscribe')
                   ->checkboxList((new User())->subscribeValues);
               ?>

               <?= $form->field($model, 'recipients')
                   ->dropDownList(ArrayHelper::map(User::find()->all(), function($user){
                       return $user->email.'|'.$user->fullName;
                   }, 'fullName'),
                       [
                           'multiple' => true,
                           'size' => 20,
                       ]); ?>


               <?= $form->field($model, 'subject') ?>

               <?= $form->field($model, 'body')->widget(CKEditor::className(),[
                   'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                       'preset' => 'basic',
                       'inline' => false,
                       'resize_enabled'=>true,
                       'height'=>400,
                       'toolbarGroups'=>[['name' => 'editing', 'groups' => [ 'tools']],]
                   ]),
               ]); ?>

               <?= $form->field($model, 'type')->radioList($model->typeValues)->hint("
            Immediately method sends messages directly to emails.
            Later method sends messages accroding to cron tasks.
            "); ?>

               <div class="form-group">
                   <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
               </div>

               <?php ActiveForm::end(); ?>
           </div>
       </div>
   </div>

</div>
<?php
