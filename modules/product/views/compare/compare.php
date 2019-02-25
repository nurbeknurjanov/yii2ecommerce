<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use user\models\User;
use category\models\Category;
use extended\view\View;
use eav\models\DynamicField;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel product\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('product', 'Comparing products');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="product-index">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Alert::widget() ?>
    </p>

    <div style="width: 100%; overflow: scroll">
        <?php
        if($models){
            ?>
            <table class="table table-striped compareTable">
                <thead>
                <tr>
                    <th></th>
                    <?php
                    foreach ($models as $model){
                        ?>
                        <th>
                            <?php echo $this->render("../product/frontend/list/_list/_list", ['model'=>$model]);?>
                            <a href="<?=Url::to(['/product/compare/remove', 'id'=>$model->id]);?>"
                               class="compare-remove"
                               data-confirm="<?=Yii::t('product', 'Do you want to remove the item from compare ?');?>"
                            ><i class="glyphicon glyphicon-remove"></i> <?=Yii::t('common', 'Remove');?></a>
                        </th>
                        <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $keys=[];
                foreach ($models as $model)
                    $keys = array_merge($keys, array_keys($model->valuesWithFields));
                $keys = array_unique($keys);
                foreach (DynamicField::find()->andWhere(['key'=>$keys])->all() as $field){
                    ?>
                    <tr>
                        <td>
                            <?=$field->label;?>
                        </td>
                        <?php
                        foreach ($models as $model){
                            ?>
                            <td>
                                <?=isset($model->valuesWithFields[$field->key])
                                    ? $model->valuesWithFields[$field->key]->valueText:
                                    '<span class="not-set">(not set)</span>';?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php
        }
        ?>
    </div>


