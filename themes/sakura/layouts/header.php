<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * Date: 3/19/19
 * Time: 4:05 PM
 */

/* @var $this \extended\view\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use order\models\Basket;
use favorite\models\FavoriteLocal;
use category\models\Category;
use product\models\Compare;
use product\models\search\ProductSearchFrontend;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use \extended\helpers\Helper;
use common\assets\CommonAsset;
use frontend\assets\FrontendAppAsset;
use yii\web\JsExpression;


?>

<?=$this->render('_menu_top')?>

<div class="container">
    <div class="row header-content" >
        <div class="col-lg-2 col-sm-2 col-xs-2 left-block">
            <a class="logo" href="<?=Url::to(['/'])?>">LOGO</a>
            <a class="min-logo" href="<?=Url::to(['/']);?>" >L</a>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-10 middle-block">
            <div id="slogan"><?=Yii::t('common', Yii::$app->params['slogan'])?></div>
            <?php
            if(isset($this->params['searchModel']))
                $searchModel = $this->params['searchModel'];
            else{
                $searchModel = new ProductSearchFrontend;
                $searchModel->load(Yii::$app->request->queryParams);
            }
            ?>
            <?php
            $action = ['/product/product/list'];
            /*if($searchModel->category){
                $action['category_id'] = $searchModel->category->id;
                $action['category_title_url'] = $searchModel->category->title_url;
            }*/
            $form = ActiveForm::begin([
                'id'=>'textSearchForm',
                'action' => $action,
                'method' => 'get',
                'options' => ['data' => ['pjax' => true]],//если будет внутри Pjax тогда имеет смысл

            ]);
            ?>
            <div class="input-group search-block ">

                <?php //echo Html::activeTextInput($searchModel, 'q', ['class'=>'form-control','placeholder'=>'Search for...']);?>

                <?php echo AutoComplete::widget([
                    'model' => $searchModel,
                    'attribute' => 'q',
                    'options'=>['class'=>'form-control', 'placeholder'=>Yii::t('common', 'Type the search value...')],
                    'clientOptions' => [
                        'source' =>Url::to(['/product/product/select']),
                        'select' =>new JsExpression("function(event, ui) {
                                        //alert(ui.item.label + ui.item.value);
                                        $(this).val(ui.item.value);
                                        $(this).parents('form').submit();
                                    }"),
                    ],
                ]);?>
                <span class="input-group-btn">
                            <?=Html::submitButton('<i class="glyphicon glyphicon-search"></i>', ['class'=>'btn btn-default',]);?>
                        </span>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12 right-block">
            <div class="phone">
                <i class="glyphicon glyphicon-phone-alt"></i>
                <?=Yii::$app->params['supportPhone']?>
            </div>
            <div class="basket-block">
                <div><?=Yii::t('order', 'In Shopping cart');?></div>
                <a href="<?=Url::to(['/order/order/create1']);?>" class="btn <?=Basket::getCount()>0 ? 'basketActive':'btn-default';?>">
                    <i class="glyphicon glyphicon-shopping-cart"></i>
                    <?=Html::tag('span', Basket::getNProductsForAmount() , ['id'=>'basketCountSpan',]);?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
//@themes/sakura/layouts/
?>
<?=$this->render('_menu_categories')?>