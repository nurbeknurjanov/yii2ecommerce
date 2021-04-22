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
use order\models\Basket;
use yii\helpers\Url;
use country\models\Country;
use country\models\Region;
use country\models\City;
use order\assets\OrderAsset;
use order\models\Order;
use common\widgets\Alert;
use common\assets\GeoCompleteAsset;

GeoCompleteAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \order\models\Order */
/* @var $card \order\models\Card */

$this->title = Yii::t('order', 'Issue the order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('order', 'Shopping cart'), 'url' => ['/order/order/create1']];
$this->params['breadcrumbs'][] = $this->title;

$images[Order::ONLINE_PAYMENT_TYPE_CARD]=$this->assetManager->publish((new OrderAsset)->sourcePath."/images/".Order::ONLINE_PAYMENT_TYPE_CARD.".png")[1];
$images[Order::ONLINE_PAYMENT_TYPE_PAYPAL]=$this->assetManager->publish((new OrderAsset)->sourcePath."/images/".Order::ONLINE_PAYMENT_TYPE_PAYPAL.".png")[1];
?>

<h1 class="title"><?= Html::encode($this->title) ?></h1>

<p>
    <?= Alert::widget() ?>
</p>

<?php
if(!Basket::isEmpty()){
    ?>
    <?=Html::beginForm('', 'post',['id'=>'anotherForm']).Html::endForm()?>
    <?php
    $form = ActiveForm::begin([
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8 col-xs-8\">{input}</div>\n<div class=\"col-lg-8 col-lg-offset-4 col-xs-8 col-xs-offset-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 col-xs-4 control-label'],
        ],
    ]);
    ?>
    <?=$form->errorSummary($model);?>
    <div style="display: none">
        <?=$this->render('_products_form', ['form'=>$form, 'model'=>$model]);?>
    </div>
    <div class="row orderCreate2" >
        <div class="col-lg-6 col-xs-6" >
            <h3><?=Yii::t('order', 'Information about buyer');?></h3>

            <br>
            <?php
            if(YII_ENV_TEST)
                echo $form->field($model, 'userAction')->textInput(['value'=>$model::USER_ACTION_BIND]);

            if(Yii::$app->user->isGuest){
                ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                <?php
            }
            ?>


            <?= $form->field($model, 'address')->textInput(['class' => 'form-control geo-complete']) ?>

            <?=$form->field($model, 'country_id',['parts'=>['{input}'=>
                (new Country)->getWidgetSelectPicker($model, 'country_id', null, ['class'=>'selectpicker country_id',])]]) ?>

            <?=$form->field($model, 'region_id',['parts'=>['{input}'=>
                (new Region)->getWidgetSelectPicker($model, 'region_id', Region::find()->countryQuery($model->country_id),
                    ['class'=>'selectpicker region_id',
                        'data-url'=>Url::to(['/country/region/select-picker', 'country_id'=>$model->country_id])])]]) ?>
            <?=$form->field($model, 'city_id',['parts'=>['{input}'=>
                (new City)->getWidgetSelectPicker($model, 'city_id', City::find()->regionQuery($model->region_id),
                    ['class'=>'selectpicker city_id',
                        'data-url'=>Url::to(['/country/city/select-picker', 'region_id'=>$model->region_id])
                        /*'multiple'=>true,*/])]]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-lg-6 col-xs-6" >

            <div class="well" >
                <?=Yii::t('order', 'In order');?> <?=Basket::getNProducts();?>:
                <ul style="list-style-type: decimal;">
                    <?php
                    $n=1;
                    foreach ($model->basketProducts as $orderProduct){
                        ?>
                        <li>
                            <a href="<?=Url::to($orderProduct->product->url)?>" style="color: #333;">
                                <?=$orderProduct->product->title;?></a>
                            <br/>
                            <?=$orderProduct->count;?> <?=Yii::t('order', 'pc');?> × <?=$orderProduct->price;?> = <?=Yii::$app->formatter->asCurrency($orderProduct->amount);?>
                        </li>
                        <?php
                        $n++;
                    }
                    ?>
                </ul>
                <br/>
                <b><?=Yii::t('order', 'Total to pay')?>: <?=Yii::$app->formatter->asCurrency($model->amount)?></b>
                <br/>
                <br/>
                <?=Html::a("<i class='glyphicon glyphicon-chevron-left'></i> ".Yii::t('order', 'Back to shopping cart'), ['/order/order/create1']);?>
            </div>

            <h3 style="margin: 20px 0;" ><?=$model->getAttributeLabel('delivery_id');?></h3>
            <?= $form->field($model, 'delivery_id')->dropDownList($model->deliveryValues)->label(false); ?>

            <h3 style="margin: 40px 0 20px;" ><?=$model->getAttributeLabel('payment_type');?></h3>
            <?= $form->field($model, 'payment_type')->dropDownList($model->paymentTypeValues)->label(false); ?>

            <?= $form->field($model, 'online_payment_type',[
                'options' => ['class' => 'cardButtons', 'style'=>$model->isPaymentOnline ? '':'display:none'],
                'template' => "{input}\n{error}",
                //'errorOptions'=>['class'=>'help-block', 'style'=>'clear:both',],
            ])->radioList($model->onlinePaymentTypeValues,  [
                'class' => 'form-control btn-group',
                'data-toggle' => 'buttons',
                //'itemOptions'=>['class'=>'btn btn-default',],
                'item'=>function($index, $label, $name, $checked, $value) use($images)  {
                    $labelOptions['class'] = 'btn btn-default col-xs-5';
                    if($checked)
                        Html::addCssClass($labelOptions, 'active');
                    $return = Html::beginTag('label', $labelOptions);
                    $return .= Html::radio($name, $checked, ['value' => $value]);
                    //$return .= ' '.$label;
                    $return .= ' '.Html::img($images[$value], ['style'=>'height:30px;']);
                    if($value==Order::ONLINE_PAYMENT_TYPE_PAYPAL)
                        $return.='<div class="hint-block" style="font-size: 12px; text-align: left">
                                    Fake Paypal account:
                                    <br>Login:buyer@sakuracommerce.com
                                    <br>Password:3@Rz%V3Gy"t^ctuS
                                  </div>';
                    if($value==Order::ONLINE_PAYMENT_TYPE_CARD)
                        $return.='<div class="hint-block" style="font-size: 12px; text-align: left">
                                    Fake Visa account:
                                    <br>Card number:4032 0300 3777 5674
                                    <br>Expiration date:12/2023 &nbsp;&nbsp;&nbsp; CVV:123
                                  </div>';
                    $return .= '</label>';
                    return $return;
                },
            ]) ?>

            <br/>

            <div class="card" style="<?=$model->isPaymentOnline && $model->online_payment_type==$model::ONLINE_PAYMENT_TYPE_CARD ? '':'display:none'?>">
                <div class="cardWhite">
                    <?php
                    $cardOptions = ['template'=>'{label}{input}{error}', 'options'=>['class'=>'']];
                    $digitsOptions = ['template'=>'{input}', 'options'=>['class'=>'']];
                    $labelOptions = ['style'=>'padding-left:0; text-align:left;','class'=>'control-label'];
                    ?>
                    <?=Html::img($images[Order::ONLINE_PAYMENT_TYPE_CARD], ['style'=>'height:40px;'])?>


                    <?php
                    ob_start();
                    echo Html::activeHiddenInput($card, 'number');
                    ?>
                    <div class="digits">
                        <?= $form->field($card, 'digits1', $digitsOptions)->textInput(['maxlength'=>4,]) ?>
                        <?= $form->field($card, 'digits2', $digitsOptions)->textInput(['maxlength'=>4,]) ?>
                        <?= $form->field($card, 'digits3', $digitsOptions)->textInput(['maxlength'=>4,]) ?>
                        <?= $form->field($card, 'digits4', $digitsOptions)->textInput(['maxlength'=>4,]) ?>
                    </div>
                    <?php
                    $content = ob_get_clean();
                    ?>
                    <?= $form->field($card, 'number', array_merge($cardOptions, ['parts'=>['{input}'=>$content]]))->label(null, $labelOptions) ?>

                    <div class="row">
                        <div class="col-lg-7 col-sm-7 col-xs-12">
                            <?= $form->field($card, 'name', $cardOptions)
                                ->label(null, $labelOptions)
                            ?>
                        </div>
                        <div class="col-lg-5 col-sm-5 col-xs-12">
                            <?php
                            ob_start();
                            echo Html::activeHiddenInput($card, 'expire_date');
                            ?>
                            <div class="row">
                                <div class="col-xs-4" style="padding-right: 0">
                                    <?= $form->field($card, 'expire_date_month', $digitsOptions)->textInput(['maxlength'=>2]) ?>
                                </div>
                                <div class="col-xs-1" style="padding:3px 1px 0 1px;font-size: 20px; color: #878484; ">/</div>
                                <div class="col-xs-6" style="padding-left: 0">
                                    <?= $form->field($card, 'expire_date_year', $digitsOptions)->textInput(['maxlength'=>4]) ?>
                                </div>
                            </div>
                            <?php
                            $content = ob_get_clean();
                            ?>
                            <?= $form->field($card, 'expire_date', array_merge($cardOptions, ['parts'=>['{input}'=>$content]]))->label(null, $labelOptions) ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="cardBlack well">
                    <div class="ccv">
                        <?= $form->field($card, 'ccv')->textInput(['style'=>'width:40%', 'maxlength'=>3]) ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
            <br/>

            <div class="form-group" >
                <div class="col-lg-12">
                    <?= Html::submitButton(Yii::t('order', 'Make an order').' <i class=\'glyphicon glyphicon-send\'></i> ', ['class' =>  'btn btn-success btn-lg' ]) ?>
                </div>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php
}

